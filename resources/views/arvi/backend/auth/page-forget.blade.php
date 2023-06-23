<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Oobee Login</title>
    <meta name="description" content="" />
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

  <body class="bg-login">
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Forgot Password -->
          <div class="card">
            <div class="card-body">
              <div class="app-brand justify-content-center">
                <a href="/" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                  <img src="/arvi/backend-assets/img/logo/oobe-logo-horizontal-dt.png" />
                  </span>
                </a>
              </div>
              <h4 class="mb-2">Request change password</h4>
              <p class="mb-4">Please enter your registered mobile number.</p>
              <form id="formAuthentication" class="mb-3" action="{{route('check-number-dashboard')}}" method="POST">
                @csrf
                <div class="mb-3">
                  <input type="text" class="form-control  noArrow phone_with_ddd" id="phone_number" 
                  name="phone_number" placeholder="Enter active mobile number" autocomplete="off" required />
                  @if($errors->has('phone_number'))
                      <div role="alert" class="form-text alert alert-danger p-2">
                          phone number not exist.
                      </div>
                  @endif
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit" 
                  id="btn-change-password" disabled>Request OTP</button>
                </div>
                <div class="d-grid mt-3 text-center">
                  <a href="{{route('index')}}" class="btn btn-link w-100" type="button">Back</a>
                </div>
              </form>
            </div>
          </div>
          <div class="my-3 small text-center">
            Copyrights &copy; 2022 Oobe Indonesia. <br />
            PT. Mulai Aja Dulu
          </div>
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
    <script type="text/javascript" src="/arvi/backend-assets/vendor/libs/jquery-mask/jquery.mask.min.js"></script>
  </body>

  <script>
    $(function(){
            //masking mobile phone 
            $('.phone_with_ddd').mask('(+00) 0000-0000-0000');

            //all clear
            $('.phone_with_ddd').keyup(function() {
                var empty = false;
                $('.phone_with_ddd').each(function() {
                    if ($(this).val().length == 0) {
                        empty = true;
                    };
                });                   
                if (empty) {
                    $('#btn-change-password').attr('disabled', 'disabled');
                } else {
                    $('#btn-change-password').removeAttr('disabled');
                }                
            });

        });
  </script>
</html>
