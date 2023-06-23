<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div><h4 class="m-0">Manage Delivery Method</h4></div>
            <div>
                <a href="javascript:void(0);" class="btn btn-primary text-nowrap" 
                id="add-delivery">
                    <i class="tf-icons bx bx-plus"></i> Add Delivery Method
                </a>
            </div>
        </div>
        <hr>
        <div class="d-flex align-items-center">
            <div class="mb-3 me-3">
                <form class="search m-0" onsubmit="return false">
                    <input class="form-control form-control-custom me-2 filter" 
                    id="search" type="search" placeholder="Search ..." 
                    aria-label="Search" autocomplete="off" />
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
                    <th>Name</th>
                    <th class="w-100">Sub</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="data-delivery">
                @include('arvi.backend.fulfilment.delivery.page-delivery-child')
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

{{-- modal --}}
<div class="modal fade" id="modaldDefaultDelete" tabindex="-1" 
aria-labelledby="modaldDefaultDelete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title">Remove Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body center p-3">
                <h4>You're about to <span class="text-danger">remove</span> this item.</h4>
                <div class="">By doing this action, you will removed the item and cannot be undone.</div>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Delete</button>
            </div>
        </div>
    </div>
</div>

{{-- modal --}}
<div class="modal fade" id="modaldActiveInActive" tabindex="-1" 
aria-labelledby="modaldActiveInActive" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body center p-3">
                <div class="">You're about to set to <span class="fw-bold text-primary">Active </span>/ 
                <span class="fw-bold text-warning">Inactive</span> to this item. Are you sure?</div>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Proceed</button>
            </div>
        </div>
    </div>
</div>

{{-- modal --}}
<div class="modal fade" id="modaldAvailableUnavailable" 
tabindex="-1" aria-labelledby="modaldAvailableUnavailable" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body center p-3">
                <div class="">You're about to set to <span class="fw-bold text-primary">Available</span> / 
                    <span class="fw-bold text-warning">Unavailable</span> to this item. Are you sure?</div>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Proceed</button>
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
        console.log(active);
        $.get("{{ route('delivery-list-table') }}",
        {search:search,active:active},function (data) {
            $('#data-delivery').html(data);
        })

    })

    // show image
    // $('.show-image').on('click',function () {
    //     let image_url = $(this).data('image');
    //     $('#place-show-image').html(`
    //     <img src="/arvi/backend-assets/img/banners/${image_url}" class="img-fluid">`);
    // })

    // button add delivery
    $("#add-delivery").on('click',function () {
        $.get("{{ route('delivery-create') }}",
        function (data) { $('#contentDashboard').html(data);})
    })
</script>