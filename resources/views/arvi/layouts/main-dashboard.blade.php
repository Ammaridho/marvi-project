<!DOCTYPE html>
<html lang="en" data-assets-path="assets/">
  <head>
    <meta charset="utf-8" />
    <metaname="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>OOBE - Dashboard</title>
    <meta name="description" content="Oobe Bussiness Owners Platform" />
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/styles.css" />

    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="assets/vendor/js/helpers.js"></script>
    <script src="assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.php" class="app-brand-link">
              <span class="app-brand-text demo menu-text fw-bolder ms-2">OOBE</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item active">
              <a href="page-dashboard.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Reporting</span>
            </li>

            <li class="menu-item"> <a href="page-report-orders.php" class="menu-link"> <i class="menu-icon tf-icons bx bx-store-alt"></i> <div data-i18n="Order">Orders</div></a></li>
            <li class="menu-item"> <a href="page-report-production-plan.php" class="menu-link"> <i class="menu-icon tf-icons bx bx-calendar-check"></i> <div data-i18n="Order">Production Plans</div></a></li>
            <li class="menu-item"> <a href="page-report-delivery-drop-point.php" class="menu-link"> <i class="menu-icon tf-icons bx bx-package"></i> <div data-i18n="Order">Delivery Drop Point</div></a></li>
            
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Products</span>
            </li>
            <li class="menu-item"> <a href="page-product-list.php" class="menu-link"> <i class="menu-icon tf-icons bx bx-list-ul"></i> <div data-i18n="Order">List of Products</div></a></li>
          </ul>
        </aside>
        <!-- / Menu -->


        {{-- contents --}}
    

    
    <!-- Core JS -->
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="assets/vendor/js/menu.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        //jquery
        $(function(){
            //View product id
            $('.show-product').click(function() {
                /*
                if($(this).text() == 'View'){
                    $(this).text('Less');
                } else {
                    $(this).text('View');
                }*/
                $('.more-product').not('#blockProduct' + $(this).attr('target')).hide('');
                $('#blockProduct' + $(this).attr('target')).toggle('');
            });

            //Date range
            var start = moment().subtract(29, 'days');
            var end = moment();
            function cb(start, end) {
                $('#dateRange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
            $('#dateRange').daterangepicker({
                "opens": "left",
                startDate: start,
                endDate: end,
                ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);
            cb(start, end);

            //DEMO PURPOSE
            $("#btnSubmitExport").click(function() {
                $(this).prop("disabled", true);
                $(this).html(
                    'Exporting ... '
                );
            });
            $("#btnSubmitSearch").click(function() {
                $(this).prop("disabled", true);
                $(this).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                );
            });
        });
    </script>
  </body>
</html>