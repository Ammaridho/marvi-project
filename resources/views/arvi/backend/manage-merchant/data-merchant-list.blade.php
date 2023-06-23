@foreach ($merchants as $key => $item)
    <!-- store -->
    <div class="col-lg-4 col-md-4 col-sm-12 mb-3" id="merchant-data">
        <div class="card border shadow-none h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-start flex-sm-row flex-column">
                    <div class="brand-logo-wrapper me-4">
                        @if (isset($item->logo))
                            <div class="lazy brand-logo-thumb-sm {{$item->active == 1 ? '' : 'isDisabled'}}" 
                            style="background-image: url('/storage/arvi/backend-assets/img/logo/brands/{{$item->logo}}')"></div>
                        @else
                            <div class="lazy brand-logo-thumb-sm {{$item->active == 1 ? '' : 'isDisabled'}}" 
                            style="background-image: url('/frontend-oobe-indonesia/assets/img/merchant/default-brand-logo.png')"></div>
                        @endif
                    </div>
                    <div class="w-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small"> {{$item->name}}</div>
                                @if ($item->brand_id != null)
                                    <div class="fw-bold">
                                        {{DB::table('brands')->find($item->brand_id)->name}}
                                    </div>
                                @endif
                            </div>
                            <script>
                                var itemActive = "{{$item->active}}";
                                if (itemActive == '1') {
                                    $("#flexSwitchCheckChecked{{$item->id}}").prop('checked', true);
                                }else{
                                    $("#flexSwitchCheckChecked{{$item->id}}").prop('checked', false);
                                }
                                </script>
                                <div class="form-check form-switch mt-1 ms-5">
                                <input class="form-check-input flexSwitchCheckChecked" 
                                type="checkbox" id="flexSwitchCheckChecked{{$item->id}}" 
                                data-data="{{$item}}">
                                <label class="form-check-label" 
                                for="flexSwitchCheckChecked{{$item->id}}"></label>
                                </div>
                        </div>
                        <div class="mt-2">
                            Location : {{$item->address}}, {{$item->city}}, {{$item->state}}
                        </div>
                        <div class="mt-2">Code : {{$item->code}}</div>
                        <div class="mt-2">
                            <a href="{{route('index-store',['code'=>$item->code])}}">
                                Go to store..
                            </a>
                        </div>
                        <hr />
                        <div class="disabled">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <a href="javascript:void(0)" 
                                    class="{{$item->active == 1 ? '' : 'disabled'}} 
                                    d-block btn btn-outline-primary text-start 
                                    manage-hourse" 
                                    data-id="{{$item->id}}">
                                        <i class='bx bx-time-five me-2'></i> 
                                        Manage Store Hours
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="javascript:void(0)" 
                                    class="{{$item->active == 1 ? '' : 'disabled'}} 
                                    d-block btn btn-outline-primary text-start 
                                    manage-custom-categories" 
                                    data-id="{{$item->id}}">
                                        <i class='bx bx-category-alt me-2'></i> 
                                        Manage Store Categories
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="javascript:void(0)" 
                                    class="{{$item->active == 1 ? '' : 'disabled'}} 
                                    d-block btn btn-outline-primary text-start 
                                    manage-custom-product" 
                                    data-id="{{$item->id}}"
                                    data-brand_id="{{$item->brand_id}}">
                                        <i class='bx bx-list-minus me-2'></i> 
                                        Manage Menu
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="javascript:void(0)" 
                                    class="{{$item->active == 1 ? '' : 'disabled'}} 
                                    d-block btn btn-outline-primary text-start 
                                    manage-extra-attribute" 
                                    data-id="{{$item->id}}">
                                        <i class='bx bx-list-plus me-2'></i> 
                                        Manage Extra Attributes
                                    </a>
                                </li>
                                <li class="mb-2 d-none">
                                    <a href="javascript:void(0)" 
                                    class="{{$item->active == 1 ? '' : 'disabled'}} 
                                    d-block btn btn-outline-primary text-start" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalGenerateQR" data-id="{{$item->id}}">
                                        <i class='bx bx-qr me-2'></i> Store QR Code
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="javascript:void(0)" 
                                    class="{{$item->active == 1 ? '' : 'disabled'}} 
                                    d-block btn btn-primary text-start edit-store" 
                                    data-id="{{$item->id}}">
                                        <i class='bx bx-edit-alt me-2'></i> Edit
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- store -->
@endforeach

<!--
=============================================
Modals
=============================================
-->
<!-- modal confirm -->
<div class="modal fade" id="modalConfirm" tabindex="-1" aria-labelledby="modalConfirm" 
aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-bottom pb-3">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body border-bottom pb-3">
        <div>Are you sure want to disabled "<span id="confirm-name-merchant"></span>" 
          Merchant? This will affected all store under this merchant will be 
          <span id="active-status-to-change"></span>.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-change-active" 
        data-bs-dismiss="modal" data-data="">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="/arvi/backend-assets/js/dashboards-analytics.js"></script>
<script src="/arvi/backend-assets/js/demo.js"></script>

<script>
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
        $('#modalConfirm').modal('show');
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
            url: "{{ route('manage-store-update',['companyCode' => $companyCode]) }}",
            data: {active:active,id:id,"_token": token},
            success: function (data) {
                $('#manage-store-button').trigger("click");
            },
            error: function (data) {
                console.log(data);
            }
        })
    })

   // button add store
   $('#add-store').on('click',function () {
        $.get("{{route('manage-store-create',['companyCode' => $companyCode])}}",function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // button hours
    $('.manage-hourse').on('click',function () {
        let id = $(this).data('id');
        $.get("{{route('hours-list',['companyCode' => $companyCode])}}",{id:id},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // button fulfilment
    $('.manage-fulfilment').on('click',function () {
        $.get("{{route('fulfilment-list',['companyCode' => $companyCode])}}",function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // button custom categories
    $('.manage-custom-categories').on('click',function () {
        let id = $(this).data('id');
        $.get("{{route('category-list',['companyCode' => $companyCode])}}",{id:id},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // button manage product
    $('.manage-product').on('click',function () {
        let id = $(this).data('id');
        let brand_id = $(this).data('brand_id');
        $.get("{{route('merchant-product-list',['companyCode' => $companyCode])}}",
        {id:id,brand_id:brand_id},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // button manage extra attribute
    $('.manage-extra-attribute').on('click',function () {
        let id = $(this).data('id');
        $.get("{{route('extra-attribute-list',['companyCode' => $companyCode])}}",{id:id},function (data) {
            $('#contentDashboard').html(data);
        })
    })
    
    // button edit store
    $('.edit-store').on('click',function () {
        let merchant_id = $(this).data('id');
        $.get("{{route('manage-store-edit',['companyCode' => $companyCode])}}",{merchant_id:merchant_id},function (data) {
            $('#contentDashboard').html(data);
        })
    })
    
</script>