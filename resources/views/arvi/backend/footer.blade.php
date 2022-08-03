    <!-- Core JS -->
    <script src="/arvi/backend-assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/arvi/backend-assets/vendor/libs/popper/popper.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="/arvi/backend-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/arvi/backend-assets/vendor/js/menu.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
    
    <script src="/arvi/backend-assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="/arvi/backend-assets/vendor/libs/nice-select/jquery.nice-select.min.js"></script>
    <script src="/arvi/backend-assets/js/jquery.uploader.min.js"></script>
    <script src="/arvi/backend-assets/js/jquery-sortable.js"></script>
    <script src="/arvi/backend-assets/vendor/libs/datepicker/datepicker.min.js"></script>
    <script src="/arvi/backend-assets/vendor/libs/jquery-mask/jquery.mask.min.js"></script>

    <script src="/arvi/backend-assets/js/dashboards-analytics.js"></script>
    <script src="/arvi/backend-assets/js/main.js"></script>
    <script src="/arvi/backend-assets/js/demo.js"></script>
    <script>
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

        // Button home
        $('#dashboard-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('home-dashboard', ['qrCode' => $qrCode], true)) }}",function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button order
        $('#order-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('order-dashboard',['qrCode' => $qrCode], true)) }}",function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button product plan
        $('#product-plan-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('production-plan-dashboard',['qrCode' => $qrCode], true)) }}",function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button delivery drop point
        $('#delivery-drop-point-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('delivery-order-dashboard',['qrCode' => $qrCode])) }}",function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button product
        $('#product-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('product-dashboard',['qrCode' => $qrCode])) }}",function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button store-settings account
        $('#account-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('account-list',['qrCode' => $qrCode])) }}",function (data) {
                $('#contentDashboard').html(data);
            })
        })
    </script>
  </body>
</html>