@if ($fromOutSide == 1)
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
            <title>OOBE - Dashboard</title>
            <meta name="description" content="Oobe Bussiness Owners Platform" />
            <!-- Favicon -->
            <link rel="icon" type="image/x-icon" href="/arvi/backend-assets/img/fav/favicon.ico" />
            <!-- Fonts -->
            <link rel="preconnect" href="https://fonts.googleapis.com" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
            <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
            <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
        
        <body>
        
@endif
        <!-- payment succsess -->
        <div class="d-flex align-items-center justify-content-center vh-100">
            <div class="text-center">
                <div class="mb-3 text-success">
                    <span class="material-icons md-48">verified</span>
                </div>
                <h2 class="text-theme-primary">Payment Successful</h2>
                <hr>
        
                <button class="btn btn-sm btn-outline-primary mt-3" type="button"
                id="new-order">
                    New Order
                </button>
            </div>
        </div>    
        <!-- //payment succsess -->
    
        <section class="fixed-bottom text-center p-2 mb-3">
            <img src="/frontend-oobe-indonesia/assets/img/logo/oobe-logo-horizontal-dt.png" class="img-80">
        </section>

@if ($fromOutSide == 1)
        </body>
    </html>
    <script type="text/javascript" src="/arvi/backend-assets/vendor/libs/jquery/jquery.js"></script>
    <script>
        $('#new-order').on('click',function () {
            window.location.href = "{{route('main-dashboard',['companyCode'=>$companyCode])}}";
        })
    </script>
@else
    <script>
        $('#new-order').on('click',function () {
            $('#modalDone').find('.modal-content').html('<h1>Loading...</h1>');
            $('#modalDone').modal('toggle'); 
            $('#pos-button').trigger('click'); 
        })
    </script>

@endif
