<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Oobee Login</title>
    <meta name="description" content="Oobe Bussiness Owners Platform"/>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/arvi/backend-assets/img/favicon/favicon.ico" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/arvi/backend-assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="/arvi/backend-assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/arvi/backend-assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/arvi/backend-assets/css/styles.css" />
    <link rel="stylesheet" href="/arvi/backend-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/arvi/backend-assets/vendor/css/pages/page-auth.css" />

    <script src="/arvi/backend-assets/vendor/js/helpers.js"></script>
    <script src="/arvi/backend-assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    
                  </span>
                  <span class="app-brand-text demo text-body fw-bolder">Oobe</span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2">Welcome to oobe! 👋</h4>
              <p class="mb-4">Please sign-in to your account</p>

              <form action="{{secure_url(route('login',['qrCode' => $qrCode]))}}" method="POST" id="formAuthentication" class="mb-3">
                
                @csrf
                
                @if (session()->has('error'))
                  <div class="row">
                      <div class="col">
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              {{ session('error')}}
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                      </div>
                  </div>
                @endif
    

                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" 
                  placeholder="Enter your email or username" autofocus autocomplete="off" required/>
                  {{-- <div class="mt-2 badge bg-label-danger d-block text-start">Please input correct email.</div> --}}
                  @error('email')
                      <div class="invalid-feedback">
                          {{$message}}
                      </div>
                  @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                    <a href="{{ secure_url(route('forget-password',['qrCode' =>  $qrCode])) }}">
                      <small>Forgot Password?</small>
                    </a>
                  </div>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control" name="password" 
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" 
                    aria-describedby="password" required />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                  {{-- <div class="mt-2 badge bg-label-danger d-block text-start">Your password incorrect.</div> --}}
                </div>
                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                </div>
              </form>

            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <script src="/arvi/backend-assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/arvi/backend-assets/vendor/libs/popper/popper.js"></script>
    <script src="/arvi/backend-assets/vendor/js/bootstrap.js"></script>
    <script src="/arvi/backend-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/arvi/backend-assets/vendor/js/menu.js"></script>
    <script src="/arvi/backend-assets/js/main.js"></script>
  </body>
</html>
