<html lang="en" data-assets-path="/arvi/backend-assets/">
  <head>
    <meta charset="utf-8" />
    <metaname="viewport" content="width=device-width, initial-scale=1.0, 
    user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>OOBE - Dashboard</title>
    <meta name="description" content="Oobe Bussiness Owners Platform" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('arvi/backend/plugin/header-plugin')
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="javascript:void(0);" class="app-brand-link">
              <span class="app-brand-logo demo">
                <img src="/arvi/backend-assets/img/logo/oobe-logo-horizontal-dt.png" />
              </span>
            </a>

            <a href="javascript:void(0);" 
            class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1 mt-3">
            @if (!(auth()->user()->role == 'superadmin' && $companyCode == 'superAdmin'))
            <!-- Dashboard -->
            <li class="menu-item active">
              <a href="javascript:void(0)" id="dashboard-button" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0)" class="menu-link menu-toggle" id="insight-button">
                <i class="menu-icon tf-icons bx bx-pie-chart"></i>
                <div data-i18n="Insights">Insights</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="javascript:void(0)" class="menu-link" id="insight-sales-button">
                    <div data-i18n="Sales">Sales</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="javascript:void(0)" class="menu-link" id="insight-qr-button">
                    <div data-i18n="QR Code">QR Code</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0)" class="menu-link" id="order-list-button">
                <i class="menu-icon tf-icons bx bx-line-chart"></i>
                <div data-i18n="Reports">Order List</div>
              </a>
            </li>
            <li class="menu-item"> 
              <a href="javascript:void(0)" class="menu-link" id="pos-button">
                <i class="menu-icon tf-icons bx bx-money"></i> 
                <div data-i18n="Reports">POS</div>
              </a>
            </li>


            {{-- Store --}}
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Store</span>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0)" id="manage-brand-button" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-medal"></i>
                <div data-i18n="Order">Manage Brand</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0)" id="manage-store-button" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-store"></i>
                <div data-i18n="Order">Manage Store</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0)" class="menu-link menu-toggle" id="tab-store-settings">
                <i class="menu-icon tf-icons bx bx-wrench"></i>
                <div data-i18n="Account Settings">Fee & Discount</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="javascript:void(0)" class="menu-link" id="fees-button">
                    <div data-i18n="Live Chat">Fees</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="javascript:void(0)" class="menu-link" id="discounts-button">
                    <i class="menu-icon tf-icons bx bx-purchase-tag"></i>
                    <div data-i18n="Discounts">Discounts</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0)" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-wallet-alt"></i> 
                <div data-i18n="Order">Billing & Payouts</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0)" class="menu-link" id="account-button">
                <i class="menu-icon tf-icons bx bxs-user-account"></i> 
                <div data-i18n="Order">Manage Accounts</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-help-circle"></i>
                <div data-i18n="Account Settings">Help Center</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item active">
                  <a href="javascript:void(0)" class="menu-link">
                    <div data-i18n="Help Center">Help Center</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="javascript:void(0)" class="menu-link">
                    <div data-i18n="Live Chat">Live Chat</div>
                  </a>
                </li>
              </ul>
            </li>
            @endif

            {{-- beckend --}}
            @if (auth()->user()->role == 'superadmin' && $companyCode == 'superAdmin')
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Backend</span>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-atom"></i>
                    <div data-i18n="Account Settings">Administration</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link" id="manage-company">
                        <div data-i18n="Help Center">Manage Company</div>
                    </a>
                    </li>
                    <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link" id="manage-account-admin">
                        <div data-i18n="Help Center">Manage Accounts</div>
                    </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link" id="manage-location-admin">
                    <i class="menu-icon tf-icons bx bxs-location-plus"></i>
                    <div data-i18n="Manage Location">Manage Location</div>
                </a>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-ghost"></i>
                <div data-i18n="Account Settings">Manage Squad</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="javascript:void(0)" class="menu-link">
                    <div data-i18n="Manage Squad">Squad Monitoring</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="javascript:void(0)" class="menu-link" id="manage-squad-account-admin">
                    <div data-i18n="Manage Squad">Squad Account</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="javascript:void(0)" class="menu-link" id="manage-squad-settlement-admin">
                    <div data-i18n="Manage Squad Settlement">Squad Settlement</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-heart-circle"></i>
                <div data-i18n="Account Settings">Marketing</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="javascript:void(0);" class="menu-link" id="manage-banner">
                    <div data-i18n="Manage Squad">Manage Banner</div>
                  </a>
                </li>
              </ul>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="javascript:void(0);" class="menu-link" id="manage-qr">
                    <div data-i18n="Manage Qr">Manage QR</div>
                  </a>
                </li>
              </ul>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="javascript:void(0);" class="menu-link" id="manage-ar">
                    <div data-i18n="Manage Ar">Manage AR</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div data-i18n="Account Settings">Fullfilment</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="javascript:void(0);" class="menu-link" id="manage-delivery">
                    <div data-i18n="Manage Squad">Delivery Method</div>
                  </a>
                </li>
              </ul>
            </li>
          @endif
          </ul>
        </aside>
        <!-- / Menu -->

