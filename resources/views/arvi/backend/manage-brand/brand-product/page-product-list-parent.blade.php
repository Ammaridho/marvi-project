<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h4 class="m-0"><span class="text-muted">Manage Brand / {{$brandName}} /</span> Menus</h4>
        You can create Brand menu which will be available to all your store.
      </div>
      <div>
        <a href="javascript:void(0);" class="btn btn-primary" id="add-product">
          <i class="tf-icons bx bx-plus"></i> 
          Add product
        </a>
      </div>
    </div>
    <hr>
    <div class="d-flex mb-3">
      <div class="me-2">
        <form class="search" onsubmit="return false">
          <input class="form-control form-control-custom me-2 sort-data" id="search-data"
          type="search" placeholder="Type product name" aria-label="Search" autocomplete="off"/>
          <button type="reset">&times;</button>
        </form>
      </div>
      <div>
        <select class="dropdown nice sort-data" id="filter-data">
          <option value="all">All</option>
          <option disabled>Menu Category</option>
          @foreach ($brandCategories as $item)
            <option value="{{$item->category_name}}">{{$item->category_name}}</option>
          @endforeach
          <option disabled>Status</option>
          <option value="1">Available for sale</option>
          <option value="0">Not available for sale</option>
        </select>
      </div>
    </div>
    <div class="table-responsive text-nowrap pb-4 always-show" id="table-scroll">
      <table class="table table-borderless text-nowrap">
          <thead>
              <tr class="border-bottom">
                  <th class="w-100">Menu Info</th>
                  <th>Price</th>
                  <th>Status</th>
                  <th></th>
              </tr>
          </thead>
          <tbody id="result-search">
            @include('arvi.backend.manage-brand.brand-product.page-product-list-child')
        </tbody>
      </table>
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
            <button type="button" class="btn-close" data-bs-dismiss="modal" 
            aria-label="Close"></button>
            </div>
            <div class="modal-body center p-3">
                <div class="">You're about to set to 
                    <span class="fw-bold text-primary" id="active-status-to-change">
                        Active 
                    </span> 
                    to this item. Are you sure?
                </div>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-change-active" 
                data-bs-dismiss="modal" data-data="">Proceed</button>
            </div>
        </div>
    </div>
</div>

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>
  var brand_id = '{{$brand_id}}';

  // search order
  $(".sort-data").on("keyup change", function() {
    let keySearch = $('#search-data').val();
    let filter = $('#filter-data').val();
    $.get("{{ route('brand-product-list',['companyCode' => $companyCode, 'action' => 'search']) }}",
      {keySearch:keySearch,id:brand_id,filter:filter},function (data) {
      $('#result-search').html(data)
    })
  });
  
  // button add product
  $("#add-product").on('click',function () {
    let brand_id = '{{$brand_id}}';
    $.get("{{ route('brand-product-create',['companyCode' => $companyCode]) }}",
    {brand_id:brand_id},function (data) {
      $('#contentDashboard').html(data);
    })
  })
</script>


