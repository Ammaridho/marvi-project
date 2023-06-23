<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div><h4 class="m-0">Manage QR</h4></div>
            <div>
                <a href="javascript:void(0);" class="btn
                btn-primary text-nowrap" id="add-ar">
                    <i class="tf-icons bx bx-plus"></i> Add QR
                </a>
            </div>
        </div>
        <hr>
        <div class="d-flex align-items-center">
            <div class="mb-3 me-3">
                <form class="search m-0" onsubmit="return false">
                    <input class="form-control form-control-custom
                    me-2 filter" id="search"
                    type="search" placeholder="Search ..." aria-label="Search"
                    autocomplete="off" />
                    <button type="reset">&times;</button>
                </form>
            </div>
            <div class="mb-3 me-3">
                <select class="dropdown nice filter" id="active">
                    <option data-display="Filter">Filter</option>
                    <option disabled>Status</option>
                    <option value="1">Active</option>
                    <option value="0">Not Active</option>
                </select>
            </div>
        </div>
        <div class="table-responsive text-nowrap pb-4 always-show" id="table-scroll">
            <table class="table table-borderless">
                <thead>
                    <tr class="table-primary text-nowrap border-0">
                        <th>Campaign Name</th>
                        <th>Ar File Name</th>
                        <th class="w-100">URL</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="data-ar">
                    @include('arvi.backend.marketing.ar.page-ar-child')
                </tbody>
            </table>
        </div>

        <div class="text-center text-muted mt-1">
            <i class="fas fa-exchange-alt"></i>
        </div>

        <div class="d-flex justify-content-end align-items-center mt-4">
            <div class="text-muted small me-3">Showing 25 from 143</div>
            <div class="">
                <select class="dropdown nice">
                    <option value="25" selected>Showing 25 rows</option>
                    <option value="50">Showing 50 rows</option>
                    <option value="100">Showing 100 rows</option>
                    <option value="150">Showing 150 rows</option>
                    <option value="all">Showing all rows</option>
                </select>
            </div>
        </div>

    </div>
</div>

{{-- modal view image --}}
<div class="modal fade" id="modalViewImage" tabindex="-1"
aria-labelledby="modalViewImage" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body" id="place-show-image">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link"
                data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>
    // filter
    $('.filter').on('keyup click change',function () {
        let search = $('#search').val();
        let active = $('#active').val();
        $.get("{{ route('ar-list-table') }}",
        {search:search,active:active},function (data) {
            $('#data-ar').html(data);
        })

    })

    // show image
    $('.show-image').on('click',function () {
        let image_url = $(this).data('image');
        $('#place-show-image').html(`
        <img src="/arvi/backend-assets/img/ars/${image_url}" class="img-fluid">`);
    })

    // button add product
    $("#add-ar").on('click',function () {
        $.get("{{ route('ar-create') }}",
        function (data) { $('#contentDashboard').html(data);})
    })
</script>
