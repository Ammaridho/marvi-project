@foreach ($brandProducts as $item)
<tr>
  <td>
      <div class="d-flex">
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
              <h5 class="fw-bold m-0">{{$item->name}}</h5>
              <div class="text-muted">
                @php
                  $categories = $item->brandCategories->pluck('category_name');
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
  </td>
</tr>
@endforeach

<script>

  // click check active inactive
  $('.flexSwitchCheckChecked').on('click',function () {
    let data = $(this).data('data');
    $('#confirm-name-brand').text(data['name']);
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
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
      type: 'PUT',
      url: "{{ route('brand-product-update',['companyCode' => $companyCode]) }}",
      data: {statusActive:active,id:id,"_token": token},
      success: function (data) {
        $.get("{{ secure_url(route('brand-product-list',['companyCode' => $companyCode])) }}",
        {id:brand_id},function (data) {
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
    let brand_id = '{{$brand_id}}';
    $.get("{{route('brand-product-edit',['companyCode' => $companyCode])}}",
    {id:id,brand_id:brand_id},function (data) {
        $('#contentDashboard').html(data);
    })
  })
</script>