<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Oobe - Personal delivery assistant</title>
        <meta name="description" content="Hello there">
        <meta name="keywords" content="food delivery">
        <meta name='viewport' content='initial-scale=1, viewport-fit=cover'>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0"/>
        <link rel="icon" type="image/x-icon" href="/frontend-oobe-indonesia/assets/img/fav/favicon.ico" />
       
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <link rel="stylesheet" href="/frontend-oobe-indonesia/assets/css/style.css?<?=date('dmyhis')?>">
    </head>

    <body class="mobile theme-default body-login">

        <div class="mx-4 mt-3 fixed-top">
            <a href="javascript: history.back();" class="text-white">
                <i class="fas fa-chevron-left fa-2x"></i>
            </a>
        </div>

        <section>
            <div class="container-fluid container-xs">
                <div class="d-flex align-items-center justify-content-center vh-100">
                    <div class="login-page form w-100">
                        <div class="text-center logo-login ">
                            <img src="/frontend-oobe-indonesia/assets/img/logo/oobe-logo-horizontal-white.png">
                        </div>
                        <!-- otp -->
                        <form class="token-form mb-4" 
                        action="{{route('store-oobe-indonesia',['data' => $data])}}" method="POST">
                            @csrf
                            <div class="form-group mb-3 digit-group">
                                <div class="mb-4 text-white text-center">
                                    Enter the 6-digit OTP code that has been sent through you mobile to complete your account registration.
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <input type="text" id="digit-1" name="digit-1" data-next="digit-2" 
                                    class="otp field" placeholder="" />
                                    <input type="text" id="digit-2" name="digit-2" data-next="digit-3" 
                                    class="otp field" data-previous="digit-1" placeholder="" />
                                    <input type="text" id="digit-3" name="digit-3" data-next="digit-4" 
                                    class="otp field" data-previous="digit-2" placeholder="" />
                                    <input type="text" id="digit-4" name="digit-4" data-next="digit-5" 
                                    class="otp field" data-previous="digit-3" placeholder="" />
                                    <input type="text" id="digit-5" name="digit-5" data-next="digit-6" 
                                    class="otp field" data-previous="digit-4" placeholder="" />
                                    <input type="text" id="digit-6" name="digit-6" data-previous="digit-5" 
                                    class="otp field" placeholder="" />
                                </div>
                            </div>
                            <div class="text-white text-center small my-4">
                                Haven't got the confirmation code yet? 
                                <u><a href="#" class="text-white btn-resend">Resend</a></u>
                                <div>
                                    <div id="timer" class="hidden"></div>
                                </div>
                            </div>
                            <div class="d-grid my-2">
                                <button class="btn btn-theme-secondary py-2 text-theme-primary-dark text-white" 
                                id="btn-confirm-otp" type="submit" disabled>Confirm</button>
                            </div>
                        </form>

                    </div>
                </div>    
            </div>
        </section>

        <!-- =================================================================
        MODAL
        ================================================================== -->

        <!-- core -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

        <!-- app -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
        <script type="text/javascript" src="/frontend-oobe-indonesia/assets/js/app.js"></script>

        <script>
            $(function(){

                $('.field').keyup(function() {
                    var empty = false;
                    $('.field').each(function() {
                        if ($(this).val().length == 0) {
                            empty = true;
                        };
                    });                   
                    if (empty) {
                        $('#btn-confirm-otp').attr('disabled', 'disabled');
                    } else {
                        $('#btn-confirm-otp').removeAttr('disabled');
                    }                
                });
                
                $(".btn-resend").click(function(event){
                    $('#timer').show();
                    $('.btn-resend').hide();
                });

                // Set the date we're counting down to
                var countDownDate = new Date("Sept 5, 2022 17:51:00").getTime();

                // Update the count down every 1 second
                var x = setInterval(function() {

                // Get today's date and time
                var now = new Date().getTime();
                    
                // Find the distance between now and the count down date
                var distance = countDownDate - now;
                    
                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                // Output the result in an element with id="demo"
                //document.getElementById("timer").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                document.getElementById("timer").innerHTML = minutes + "m " + seconds + "s ";
                    
                // If the count down is over, write some text 
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("timer").innerHTML = "";
                }
                }, 1000);

            });
        </script>
    </body>
</html>  