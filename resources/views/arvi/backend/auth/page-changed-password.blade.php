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
              <h4 class="mb-2">Change password</h4>
              <p class="mb-4">Please enter your new password and confirm password to complete.</p>

              <form id="formAuthentication" class="mb-3" action="{{route('store-new-password-dashboard',
              ['phone_number' => $phone_number])}}" method="POST">
                @csrf
                <div class="form-group mb-3 password-group">
                    <label for="password1" class="form-label">New Password</label>
                    <input type="password" class="f-inputbox password-box 
                    form-control" required="required" 
                    autocomplete="off" id="password1" name="password"  
                    placeholder="New password" />
                    <a href="#!" class="password-visibility">
                      <i class="bx bx-hide text-light"></i>
                    </a>
                </div>
                <div class="form-group mb-3 password-group">
                    <label for="password2" class="form-label">
                      Confirm New Password
                    </label>
                    <input type="password" class="f-inputbox password-box form-control" required="required" 
                    autocomplete="off" id="password2" name="password_confirmation"  
                    placeholder="Confirm new password" />
                    <a href="#!" class="password-visibility"><i class="bx bx-hide text-light"></i></a>
                </div>
                @if($errors->has('password'))
                  <div role="alert" class="form-text alert alert-danger p-2">
                      your password not match.
                  </div>
                @endif
                
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit" 
                  id="btn-change-password" disabled>Change Password</button>
                </div>
                <div class="d-grid mt-3 text-center">
                     <a href="javascript:void(0);" onclick="history.back()" 
                     class="btn btn-link w-100" type="button">Back</a>
                </div>
              </form>

            </div>
          </div>
          
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
            //num only
            $(".numbers").on("keypress keyup blur",function (event) {
                //this.value = this.value.replace(/[^0-9\.]/g,'');
                $(this).val($(this).val().replace(/[^0-9\.]/g,''));
                if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });
            //eye of the tiger :)
            $('.password-group').find('.password-box').each(function(index, input) {
                var $input = $(input);
                $input.parent().find('.password-visibility').click(function() {
                    var change = "";
                    if ($(this).find('i').hasClass('bx-hide')) {
                        $(this).find('i').removeClass('bx-hide')
                        $(this).find('i').addClass('bx-show')
                        change = "text";
                    } else {
                        $(this).find('i').removeClass('bx-show')
                        $(this).find('i').addClass('bx-hide')
                        change = "password";
                    }
                    var rep = $("<input type='" + change + "' />")
                        .attr('id', $input.attr('id'))
                        .attr('name', $input.attr('name'))
                        .attr('class', $input.attr('class'))
                        .val($input.val())
                        .insertBefore($input);
                    $input.remove();
                    $input = rep;
                }).insertAfter($input);
            });

            //all clear
            $('.password-box').keyup(function() {
                var empty = false;
                $('.password-box').each(function() {
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
  </body>
</html>
