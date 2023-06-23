@foreach ($merchantProducts as $item)
<tr>
  <td>
      <div class="d-flex">
          <div class="me-2">
            @if ($item->productImage->first())
              @if ($item->productImage->first() && $item->productImage->first()->url != 'url')
                <img class="lazy product-img-wrapper-sm rounded"
                src="/storage/arvi/backend-assets/img/products/brands/{{$item->productImage->first()->url}}">
              @elseif($item->productImage->first()->image_mime)
                <img class="lazy product-img-wrapper-sm rounded"
                src="/arvi/assets/img/products/{{$item->productImage->first()->image_mime.'.'.$item->productImage->first()->image_type}}">
              @endif
            @else
              <img class="lazy product-img-wrapper-sm rounded"
              src="/arvi/backend-assets/img/default/product.jpg">
            @endif
          </div>
          <div>
              <h5 class="fw-bold m-0">{{$item->name}}</h5>
              <div class="text-muted">
                @php
                  $categories = $item->productCategories->pluck('category_name');
                @endphp
                @foreach ($categories as $category)
                    {{$category.','}}
                @endforeach
              </div>
              <div class="text-muted">SKU: {{$item->sku}}</div>
          </div>
      </div>
  </td>
  <td>
    @if ($item->merchantInventory == null)
        0/0
    @else
      @php
        $available = $item->merchantInventory->total_available;
        $allocate = $item->merchantInventory->total_available;
      @endphp
      {{$available}}/{{$allocate}}
    @endif
  </td>
  <td>
    @if (isset($item->discount_price))
      <s class="text-danger">{{$item->currency}} {{$item->retail_price}}</s> 
      = {{$item->currency}} {{$item->discount_price}}
    @else
    {{$item->currency}} {{$item->retail_price}}
    @endif
  </td>
  <td>
    <script>
      var active = "{{$item->active}}";
      if (active == '1') {
        $("#flexSwitchCheckChecked{{$item->id}}").prop('checked', true);
      }else{
        $("#flexSwitchCheckChecked{{$item->id}}").prop('checked', false);
      }
    </script>
    <div class="form-check form-switch">
      <input class="form-check-input flexSwitchCheckChecked"
      type="checkbox" id="flexSwitchCheckChecked{{$item->id}}"
      data-data="{{$item}}">
      <label class="form-check-label" for="flexSwitchCheckChecked{{$item->id}}">
        {{$item->active=='1'?'Available':'Not Available'}}</label>
    </div>
  </td>
  <td>
    <a href="javascript:void(0);" class="btn btn-sm btn-primary edit-product"
    data-id="{{$item->id}}">
      <i class="fas fa-pen"></i>
    </a>
    <a href="javascript:void(0);" class="btn btn-sm btn-danger remove-product"
    data-id="{{$item->id}}">
      <i class="fas fa-trash"></i>
    </a>
  </td>
</tr>
@endforeach

{{-- modal confirmatin delete --}}
<div class="modal fade" id="modaldDefaultDelete" tabindex="-1" 
aria-labelledby="modaldDefaultDelete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title">Remove Confirmation</h5>
                <button type="button" class="btn-close" 
                data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body center p-3">
                <h4>You're about to <span class="text-danger">remove</span> this item.</h4>
                <div class="">By doing this action, 
                    you will removed the item and cannot be undone.</div>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submit-delete" 
                data-bs-dismiss="modal" data-id="">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
  // delete
  $(".remove-product").on('click',function(){
    let id = $(this).data('id');
    $('#submit-delete').data('id',id);
    // show modal
    $('#modaldDefaultDelete').modal('show');
  }); 
  $('#submit-delete').on('click',function () {
    let id = $(this).data("id");
    let brand_id = '{{$brand_id}}';
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
      type: 'DELETE',
      url: "{{ route('merchant-product-destroy',['companyCode' => $companyCode]) }}",
      data: {
          "id": id,
          "_token": token,
      },
      success: function (){
          $.get("{{route('merchant-product-list',['companyCode' => $companyCode])}}",
          {id:merchant_id,brand_id:brand_id},function (data) {
              $('#contentDashboard').html(data);
          })
      },
      error: function () {
          console.log(data);
      }
    });
  })

  // click check active inactive
  $('.flexSwitchCheckChecked').on('click',function () {
    let data = $(this).data('data');
    $('#confirm-name-merchant').text(data['name']);
    $('#save-change-active').data('data',data);
    if (data['active'] == 1) {
        $('#active-status-to-change').html('<span class="fw-bold text-danger">inactive</span>');
    } else {
        $('#active-status-to-change').html('<span class="fw-bold text-success">active</span>');
    }
    // show modal
    $('#modaldActiveInActive').modal('show');
    // check old status active
    // if not checked ============================================================
    if($(this).is(":checked")){
    $(this).prop('checked', false);
    // if checked ============================================================
    }else if($(this).is(":not(:checked)")){
    $(this).prop('checked', true);
    }
  })
  // save switch check active inactive
  $('#save-change-active').on('click',function () {
    let data = $(this).data('data');
    let active = data['active'] == '1' ? '0': '1' ;
    let id = data['id'];
    let brand_id = '{{$brand_id}}';
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
      type: 'PUT',
      url: "{{ route('merchant-product-update',['companyCode' => $companyCode]) }}",
      data: {statusActive:active,id:id,"_token": token},
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

  // button form edit category
  $('.edit-product').on('click',function () {
    let id = $(this).data('id');
    let merchant_id = '{{$merchant_id}}';
    $.get("{{route('merchant-product-edit',['companyCode' => $companyCode])}}",
    {id:id,merchant_id:merchant_id},function (data) {
        $('#contentDashboard').html(data);
    })
  })
</script>
