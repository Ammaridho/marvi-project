<!DOCTYPE html>
<html lang="en" data-assets-path="/arvi/backend-assets/">
  <head>
    <meta charset="utf-8" />
    <metaname="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>OOBE - Dashboard</title>
    <meta name="description" content="Oobe Bussiness Owners Platform" />
    <link rel="icon" type="image/x-icon" href="/arvi/backend-assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/arvi/backend-assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="/arvi/backend-assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/arvi/backend-assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/arvi/backend-assets/css/styles.css" />

    <link rel="stylesheet" href="/arvi/backend-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="/arvi/backend-assets/vendor/js/helpers.js"></script>
    <script src="/arvi/backend-assets/js/config.js"></script>
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
              <a href="javascript:void(0)" id="dashboard-button" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Reporting</span>
            </li>

            <li class="menu-item"> <a href="javascript:void(0)" class="menu-link" id="order-button"> <i class="menu-icon tf-icons bx bx-store-alt"></i> <div data-i18n="Order">Orders</div></a></li>
            <li class="menu-item"> <a href="javascript:void(0)" class="menu-link" id="product-plan-button"> <i class="menu-icon tf-icons bx bx-calendar-check"></i> <div data-i18n="Order">Production Plans</div></a></li>
            <li class="menu-item"> <a href="javascript:void(0)" class="menu-link" id="delivery-drop-point-button"> <i class="menu-icon tf-icons bx bx-package"></i> <div data-i18n="Order">Delivery Drop Point</div></a></li>
            
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Products</span>
            </li>
            <li class="menu-item"> <a href="javascript:void(0)" id="product-button" class="menu-link"> <i class="menu-icon tf-icons bx bx-list-ul"></i> <div data-i18n="Order">List of Products</div></a></li>
          </ul>
        </aside>
        <!-- / Menu -->

        