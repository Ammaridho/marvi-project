    <!-- Core JS -->
    <script src="/arvi/backend-assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/arvi/backend-assets/vendor/libs/popper/popper.js"></script>
    <script src="/arvi/backend-assets/vendor/js/bootstrap.js"></script>
    <script src="/arvi/backend-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="/arvi/backend-assets/vendor/js/menu.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="/arvi/backend-assets/js/main.js"></script>
    <script>
        
        $(document).ready(function () {
            $('#dashboard-button').click();
        })

        // Button home
        $('#dashboard-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('home-dashboard',['qrCode' => $qrCode])) }}",function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button order
        $('#order-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('order-dashboard',['qrCode' => $qrCode])) }}",function (data) {
                $('#contentDashboard').html(data);
            })
        })
        // button product plan
        $('#product-plan-button').on('click',function () {
            $('.menu-item.active').removeClass('active');
            $(this).parent().addClass('active');
            $.get("{{ secure_url(route('production-plan-dashboard',['qrCode' => $qrCode])) }}",function (data) {
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
    </script>
  </body>
</html>