    @include('arvi/backend/plugin/footer-plugin')
    <script>

        // open settings on navbar
        $('#settingsAccount').on('click',function () {
            $.get("{{ secure_url(route('setting-account-dashboard',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })

        /**
         * Perfect Scrollbar
         */
        'use strict';
        document.addEventListener('DOMContentLoaded', function () {
        (function () {
            const  horizontalExample = document.getElementById('table-scroll');

            if (horizontalExample) {
            new PerfectScrollbar(horizontalExample, {
                wheelPropagation: false,
                suppressScrollY: true
            });
            }

        })();
        });

        $(document).ready(function () {
            $('#dashboard-button').click();
        })

        // update last update time
        $('button, a').on('click',function () {
            $.get("{{ secure_url(route('update-time', ['companyCode' => $companyCode], true)) }}",
            function (data) {
                $('.time-update').text(data);
            })
        })

        // DASHBOARD
        // Button home
        $('#dashboard-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('home-dashboard', ['companyCode' => $companyCode], true)) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // Button Insights Sales
        $('#insight-sales-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('insight-sales-dashboard', ['companyCode' => $companyCode], true)) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // Button Insights Qr
        $('#insight-qr-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('insight-qr-dashboard', ['companyCode' => $companyCode], true)) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // Button Order List
        $('#order-list-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('orderList-dashboard', ['companyCode' => $companyCode], true)) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // Button Order List
        $('#pos-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('pos-dashboard', ['companyCode' => $companyCode], true)) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })



        // STORE
        // button manage-brand
        $('#manage-brand-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('manage-brand-list',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button manage-store
        $('#manage-store-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('manage-store-list',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button fees
        $('#fees-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('fees-data',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button discounts
        $('#discounts-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('discount-list',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button account
        $('#account-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('account-list',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })

        // ADMINISTRATION
        // button company
        $('#manage-company').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('company-list',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button account
        $('#manage-account-admin').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('account-admin-list',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button location
        $('#manage-location-admin').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('location-list',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button squad-account
        $('#manage-squad-account-admin').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('squad-account-list',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button squad-settlement
        $('#manage-squad-settlement-admin').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('squad-settlement-list',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button manage banner
        $('#manage-banner').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('banner-list',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button manage qr
        $('#manage-qr').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('qr-list',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button manage ar
        $('#manage-ar').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('ar-list',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button manage delivery
        $('#manage-delivery').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('delivery-list',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })



        // REPORTING
        // button order
        $('#order-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('order-dashboard',['companyCode' => $companyCode], true)) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button product plan
        $('#product-plan-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('production-plan-dashboard',['companyCode' => $companyCode], true)) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button delivery drop point
        $('#delivery-drop-point-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('delivery-order-dashboard',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })

        // PRODUCTS
        // button product
        $('#product-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('product-dashboard',['companyCode' => $companyCode])) }}",
            function (data) {
                $('#contentDashboard').html(data);
            })
        })
    </script>
  </body>
</html>
