pipeline {
   agent any
   environment {
        ENV_NAME = getEnvName(env.GIT_BRANCH)
        DOCKER_REGISTRY_PATH = "idlodi/arvi-builder"
        DOCKER_REGISTRY_CREDENTIAL = 'dockerhub-devopslodi'
        dockerImage = ''
   }

   stages {
        stage('Build Laravel') {
            steps {
                script {
                    // Clean before build
                    //cleanWs()

                    def name = "${env.ENV_NAME}"
                    echo "Building for branch: ${env.ENV_NAME}"
                    echo 'Apply configuration...'
                    if(name == "prod") {
                        configFileProvider([configFile(fileId: 'ArviProdEnv',
                                            targetLocation: '.env')]) {
                            sshagent(credentials: ['fbc00c3f-1293-4d35-a374-277d9753a1a3']){
                                sh 'rm composer.lock'
                                sh 'composer install'
                                sh 'composer dump-autoload'
                                sh 'yes | php artisan key:generate'
                            }
                        }
                    } else if(name == "dev") {
                        configFileProvider([configFile(fileId: 'ArviDevEnv',
                                            targetLocation: '.env')]) {
                            sshagent(credentials: ['fbc00c3f-1293-4d35-a374-277d9753a1a3']){
                                sh 'rm composer.lock'
                                sh 'composer install'
                                sh 'composer dump-autoload'
                                sh 'yes | php artisan key:generate'
                            }
                        }
                    } else {
                        echo 'Nothing to build'
                    }
                }
            }
        }

        //stage('Running Migration') {
        //    steps {
        //        script {
        //            def name = "${env.ENV_NAME}"
        //            echo "Running migration on branch: ${env.ENV_NAME}"
        //            if(name == "prod") {
        //                echo 'Nothing to run yet'
        //            } else if(name == "dev") {
        //                echo 'Running migration...'
        //                //sh 'php artisan migrate'
        //                //sh 'php artisan db:seed'
        //            } else {
        //                echo 'Nothing to run'
        //            }
        //        }
        //    }
        //}

        stage('Build Frontend (npms)') {
            steps {
                nodejs(nodeJSInstallationName: 'node-14.7.4') {
                    sh 'npm install'
                    sh 'npm run prod'
                }
                echo 'Not compiling frontend at the moment'
            }
        }

	    //stage('Test') {
        //    steps {
        //        sh 'mvn test'
        //    }
        //    post {
        //        always {
        //            junit 'target/surefire-reports/*.xml'
        //        }
        //    }
        //}

        stage('Package builds') {
            steps {
                script {
                    def name = "${env.ENV_NAME}"
                    echo "Delivering for branch: ${env.ENV_NAME}"
                    if(name == "prod") {
                        sh 'rm -f arvi-builder.zip'
                        echo 'Creating zip of current workspace'
                        zip zipFile: "arvi-builder.zip", archive: false,
                            exclude: "node_modules/**,storage/logs/**,.git/**",
                            overwrite: true
                    } else if(name == "dev") {
                        sh 'rm -f arvi-builder-dev.zip'
                        echo 'Creating zip of current workspace'
                        zip zipFile: "arvi-builder-dev.zip", archive: false,
                            exclude: "node_modules/**,storage/logs/**,.git/**",
                            overwrite: true
                    }
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    def name = "${env.ENV_NAME}"
                    echo "Delivering for branch: ${env.ENV_NAME}"
                    if(name == "prod") {
                        //echo 'OK Its going to be delivered through Ansible'
                        ansiblePlaybook credentialsId: 'gcp-arvi', disableHostKeyChecking: true,
                                        installation: 'ansible-2.5.1', inventory: 'ansible/hosts',
                                        playbook: 'ansible/deploy.prod.yml',
                                        extraVars: [
                                            build: env.BUILD_NUMBER,
                                            project: 'arvi-builder'
                                        ]
                    }
                    else if(name == "dev") {
                        echo "Delivering to DEV machine"
                        ansiblePlaybook credentialsId: 'gcp-arvi', disableHostKeyChecking: true,
                                        installation: 'ansible-2.5.1', inventory: 'ansible/hosts',
                                        playbook: 'ansible/deploy.dev.yml',
                                        extraVars: [
                                            build: env.BUILD_NUMBER,
                                            project: 'arvi-builder-dev'
                                        ]
                    }
                }
            }
            post {
                success {
                    slackSend (
                    color: "good",
                    message: "[arvi-builder] WEB ONLY Deploy Success @${env.ENV_NAME} - ${env.JOB_NAME} ${env.BUILD_NUMBER} (<${env.BUILD_URL}|Open>)",
                    channel: '#deployment'
                )
                }
                failure {
                    slackSend (
                        color: "danger",
                        message: "[arvi-builder] WEB ONLY Deploy Failed @${env.ENV_NAME} - ${env.JOB_NAME} ${env.BUILD_NUMBER} (<${env.BUILD_URL}|Open>)",
                        channel: '#deployment'
                    )
                }
            }
        }

    }

    post {
        // Clean after build
        always {
            cleanWs(cleanWhenNotBuilt: false,
                    deleteDirs: true,
                    disableDeferredWipeout: true,
                    notFailBuild: true,
                    patterns: [[pattern: '.gitignore', type: 'INCLUDE'],
                               [pattern: '.propsfile', type: 'EXCLUDE']])
        }
    }
}

def getEnvName(branchName) {
    echo "Current branch name: ${branchName}"
    //echo "Current BRANCH_NAME: ${env.BRANCH_NAME}"
    //echo "Current GIT_BRANCH: ${env.GIT_BRANCH}"
    def b = branchName
    if (b.contains("origin/")) {
        b = b.replace("origin/","")
    }
    if ("master".equals(b)) {
        return "prod";
    } else if("develop".equals(b)) {
        return "dev";
    } else {
        return "NONE"
    }
}
