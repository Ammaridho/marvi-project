<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Oobee Register</title>
    <meta name="description" content="Oobe Bussiness Owners Platform" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/arvi/backend-assets/img/fav/favicon.ico" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
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
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="/" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <img src="/arvi/backend-assets/img/logo/oobe-logo-horizontal-dt.png" />
                  </span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2">Confrimation Code</h4>
              <p class="mb-4">Enter the 6-digit OTP code that has been sent through you mobile to reset your password.</a></p>


              @if (is_string($data) && is_array(json_decode($data, true)))
                <form id="formAuthentication" class="mb-3" 
                action="{{route('sign-up-store')}}" method="POST">
              @else
                <form id="formAuthentication" class="mb-3" 
                action="{{route('store-new-password-dashboard')}}" method="GET">
              @endif

                @csrf
                <input type="hidden" name="data" value="{{$data}}">
                <div class="form-group mb-3 digit-group">
                    <div class="d-flex justify-content-between align-items-center">
                        <input type="text" id="digit-1" name="digit-1" 
                        data-next="digit-2" class="field" placeholder="" />
                        <input type="text" id="digit-2" name="digit-2" 
                        data-next="digit-3" class="field" data-previous="digit-1" placeholder="" />
                        <input type="text" id="digit-3" name="digit-3" 
                        data-next="digit-4" class="field" data-previous="digit-2" placeholder="" />
                        <input type="text" id="digit-4" name="digit-4" 
                        data-next="digit-5" class="field" data-previous="digit-3" placeholder="" />
                        <input type="text" id="digit-5" name="digit-5" 
                        data-next="digit-6" class="field" data-previous="digit-4" placeholder="" />
                        <input type="text" id="digit-6" name="digit-6" 
                        data-previous="digit-5" class="field" placeholder="" />
                    </div>
                </div>
                <div class="text-center my-4">
                    Haven't got the confirmation code yet? <u>
                      <a href="#" class="btn-resend">Resend</a></u>
                </div>
                <div class="d-grid my-2">
                     <button class="btn btn-primary w-100" 
                     id="btn-confirm-otp" type="submit" disabled>Confirm Otp</button>
                </div>
                <div class="d-grid mt-3 text-center">
                     <a href="javascript:void(0);" onclick="history.back()"  
                     class="btn btn-link w-100"  type="button">Back</a>
                </div>
              </form>

            </div>
          </div>
          <!-- /Register -->
          
          <div class="my-3 small text-center">
            Copyrights &copy; <?=date('Y');?> Oobe Indonesia. <br />
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
    <script type="text/javascript" src="/arvi/backend-assets/vendor/libs/jquery-mask/jquery.mask.min.js"></script>
    <script src="/arvi/backend-assets/vendor/js/menu.js"></script>
    <script src="/arvi/backend-assets/js/main.js"></script>
    <script>
        $(function(){

            //change to timer :)
            $('.btn-resend').click(function(){
                $(this).text('01:00');
            });
            
            //all clear
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

            //otp
            $('.digit-group').find('input').each(function() {
                $(this).attr('maxlength', 1);
                $(this).on('keyup', function(e) {
                var parent = $($(this).parent());
            
                if (e.keyCode === 8 || e.keyCode === 37) {
                    var prev = parent.find('input#' + $(this).data('previous'));
            
                    if (prev.length) {
                    $(prev).select();
                    }
                } else if ((e.keyCode >= 48 && e.keyCode <= 57) ||
                 (e.keyCode >= 65 && e.keyCode <= 90) ||
                  (e.keyCode >= 96 && e.keyCode <= 105) ||
                   e.keyCode === 39) {
                    var next = parent.find('input#' + $(this).data('next'));
            
                    if (next.length) {
                    $(next).select();
                    } else {
                    if (parent.data('autosubmit')) {
                        parent.submit();
                    }
                    }
                }
                });
            });

        });
    </script>
  </body>
</html>
