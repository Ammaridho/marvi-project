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
              <h4 class="mb-2">Welcome to oobe! 👋</h4>
              <p class="mb-4">Please choose Company</p>

              @if (auth()->user()->role == 'superadmin')
                <div class="mb-3">
                  <a href="{{secure_url(route('super-admin-main-dashboard',['companyCode' => 'superAdmin']))}}">
                    <button class="btn btn-warning d-grid w-100" type="button">
                      Administration
                    </button>
                  </a>
                </div>
              @endif

              @foreach ($companies as $item)
                <div class="mb-3">
                  <a href="{{secure_url(route('main-dashboard',['companyCode' => $item->code ]))}}">
                    <button class="btn btn-primary d-grid w-100" type="button">
                      {{$item->name}}
                    </button>
                  </a>
                </div>
              @endforeach

              <div class="mt-4 text-center d-none">
                Don't have an account? <a href="page-registration.php">Sign up now</a>
              </div>

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
    <script src="/arvi/backend-assets/vendor/js/menu.js"></script>
    <script src="/arvi/backend-assets/js/main.js"></script>
  </body>
</html>
