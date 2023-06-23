{{-- script plugin --}}
<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/jquery/jquery.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/popper/popper.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/vendor/js/menu.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/jquery-lazy/jquery.lazy.min.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/jquery-lazy/jquery.lazy.plugins.min.js"></script>

<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/nice-select/jquery.nice-select.min.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/js/jquery.uploader.min.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/js/jquery-sortable.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/datepicker/datepicker.min.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/jquery-mask/jquery.mask.min.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/autofill/autofill.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/multi-select/jquery.multi-select.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/vendor/libs/dropzone/dropzone.js"></script>

<script type="text/javascript" src="/arvi/backend-assets/js/dashboards-analytics.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/js/main.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/js/demo.js"></script>

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
</script>
