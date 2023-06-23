<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h4 class="m-0"><span class="text-muted">Manage Store / {{$merchant['name']}} /</span> Menus</h4>
        You can create Merchant menu which will be available only on {{$merchant['name']}} store.
      </div>
    </div>
    <hr />

    <div class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
    href="#collapseBox" role="button" aria-expanded="false" aria-controls="collapseBox">
    <h6 class="m-2">Available menu</h6>
    <div><i class='bx bx-chevrons-left'></i></div>
  </div>
  @if ($merchant['currency'] != $merchant->brand->currency)
    <div class="row g-2">
      <small class="m-2 text-danger">Note : Brand and Store have different currency, please check price product after add product</small>
    </div>
  @endif
  <div class="row g-2 collapse show" id="collapseBox">

    {{-- brand product --}}
    @foreach ($brandProducts as $item)
    <div class="col-3">
      <div class="p-2 border rounded h-100">
        <div class="d-flex justify-content-around">
          <div class="me-2">
            @if ($item->brandImage->first() && $item->brandImage->first()->url != 'url')
              <img class="lazy product-img-wrapper-sm rounded"
              src="/storage/arvi/backend-assets/img/products/brands/{{$item->brandImage->first()->url}}">
            @elseif($item->image_mime)
              <img class="lazy product-img-wrapper-sm rounded"
              src="/arvi/assets/img/products/{{$item->image_mime.'.'.$item->image_type}}">
            @else
              <img class="lazy product-img-wrapper-sm rounded"
              src="/arvi/backend-assets/img/default/product.jpg">
            @endif
          </div>
          <div>
            <h6 class="fw-bold m-0">{{$item->name}}</h6>
            <div class="text-muted small">
              @php
                $categories = $item->brandCategories->pluck('category_name');
              @endphp
              @foreach ($categories as $category)
                  {{$category.','}}
              @endforeach
            </div>
            <div class="text-muted small">SKU: {{$item->sku}}</div>
            <div class="small">
              @if (isset($item->discount_price))
                <s class="text-danger">{{$item->currency}} {{$item->retail_price}}</s> 
                = {{$item->currency}} {{$item->discount_price}}
              @else
                {{$item->currency}} {{$item->retail_price}}
              @endif
            </div>
          </div>
          <div class="ms-2 text-end">
            <button type="button" class="btn btn-sm btn-primary add-products"
            data-id="{{$item->id}}" value="{{ csrf_token() }}">
              add
            </button>
          </div>
        </div>
      </div>
    </div>
    @endforeach
    {{-- end brand product --}}

  </div>
  
 

  <hr />

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
          @foreach ($productCategories as $item)
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
                <th>Inventory</th>
                <th>Price</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="result-search">
          @include('arvi.backend.manage-merchant.merchant-product.page-product-list-child')
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
  var merchant_id = '{{$merchant_id}}';

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // insert product from brand
  $(".add-products").on('click',function () {
    let id = $(this).data('id');
    let merchant_id = "{{$merchant['id']}}";
    let brand_id = '{{$brand_id}}';
    $.ajax({
        type: 'POST',
        url: "{{ route('merchant-product-store',['companyCode' => $companyCode]) }}",
        data: {id:id,merchant_id:merchant_id},
        success: function (data) {
          $.get("{{route('merchant-product-list',['companyCode' => $companyCode])}}",
          {id:merchant_id,brand_id:brand_id},function (data) {
              $('#contentDashboard').html(data);
          })
        },
        error: function (data) {
          console.log(data);
        }
    })
  })

  // search order
  $(".sort-data").on("keyup change", function() {
    let keySearch = $('#search-data').val();
    let filter = $('#filter-data').val();
    $.get("{{ route('merchant-product-list',['companyCode' => $companyCode, 'action' => 'search']) }}",
      {keySearch:keySearch,id:merchant_id,filter:filter},function (data) {
      $('#result-search').html(data)
    })
  });

  // button add product
  $("#add-product").on('click',function () {
    let merchant_id = '{{$merchant_id}}';
    $.get("{{ route('merchant-product-create',['companyCode' => $companyCode]) }}",
    {merchant_id:merchant_id},function (data) {
      $('#contentDashboard').html(data);
    })
  })
</script>


