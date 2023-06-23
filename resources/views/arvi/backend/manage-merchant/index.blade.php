<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div><h4 class="m-0">Manage Store</h4></div>
            <div><a href="javascript:void(0)" class="btn btn-primary" id="add-store">
                <i class="tf-icons bx bx-plus"></i> Add store</a>
            </div>
        </div>
        <hr>
        <div class="d-flex">
            <div class="me-2">
                <form class="search" onsubmit="return false">
                    <input class="form-control form-control-custom me-2" type="search" id="input-search"
                    placeholder="Name/Brand/Location.." aria-label="Search" autocomplete="off" />
                    <button type="reset">&times;</button>
                </form>
            </div>
            <div>
                <select class="dropdown nice filter-data" id="brand-data">
                    <option value="all" data-display="View all store">View all store</option>
                    @foreach ($brands as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row" id="merchant-list">
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
                                        @if (DB::table('brands')->find($item->brand_id) != null)
                                            <div class="small"> 
                                                {{DB::table('brands')->find($item->brand_id)->name}}
                                            </div>
                                            <div class="fw-bold">
                                                {{$item->name}}
                                            </div>
                                        @else
                                            <div class="fw-bold small my-3 p-3 alert alert-danger">
                                                'Please edit and choose brand!'
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
                                        data-data="{{$item}}"
                                        data-brand_active="{{DB::table('brands')->find($item->brand_id) != null?
                                        DB::table('brands')->find($item->brand_id)->active:''}}"
                                        {{DB::table('brands')->find($item->brand_id) == null?'disabled':''}}
                                        >
                                        <label class="form-check-label" 
                                        for="flexSwitchCheckChecked{{$item->id}}"></label>
                                      </div>
                                </div>
                                <div class="mt-2">
                                    Location : {{$item->address}}, {{$item->city}}, {{$item->state}}
                                </div>
                                <div class="mt-2">
                                    Code : {{$item->code}}
                                </div>
                                <div class="mt-2">
                                    <a href="{{route('index-store',['code'=>$item->code])}}" 
                                        target="_blank">Go to store..
                                    </a>
                                </div>
                                <hr />
                                <div class="disabled">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <a href="javascript:void(0)" 
                                            class="{{$item->active == 1 ? '' : 'disabled'}}
                                            d-block btn btn-outline-primary text-start 
                                            manage-hourse" data-id="{{$item->id}}">
                                                <i class='bx bx-time-five me-2'></i>
                                                Manage Store Hours
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="javascript:void(0)" 
                                            class="{{$item->active == 1 ? '' : 'disabled'}}
                                            d-block btn btn-outline-primary text-start 
                                            manage-categories" data-id="{{$item->id}}">
                                                <i class='bx bx-category-alt me-2'></i>
                                                Manage Store Categories
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="javascript:void(0)" 
                                            class="{{$item->active == 1 ? '' : 'disabled'}}
                                            d-block btn btn-outline-primary text-start 
                                            manage-product" data-id="{{$item->id}}"
                                            data-brand_id="{{$item->brand_id}}">
                                                <i class='bx bx-list-minus me-2'></i>
                                                Manage Menu
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="javascript:void(0)" 
                                            class="{{$item->active == 1 ? '' : 'disabled'}}
                                            d-block btn btn-outline-primary text-start 
                                            manage-extra-attribute" data-id="{{$item->id}}">
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
        </div>
    </div>
</div>

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
        <div class="modal-body border-bottom pb-3" id="modal-brand-inactive">
            <div>
                Failed to activate Store. <br>
                Please check your Brand status, before activating your store.
            </div>
        </div>
        <div id="modal-brand-active">
            <div class="modal-body border-bottom pb-3">
                <div>
                    Do you want to set <span id="active-status-to-change"></span>
                    this store "<span id="confirm-name-merchant"></span>"?
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
</div>

<script src="/arvi/backend-assets/js/dashboards-analytics.js"></script>
<script src="/arvi/backend-assets/js/demo.js"></script>

<script>

    // filter brand
    $('.filter-data').on('change',function () {
        let brand = $('#brand-data').val();
        $.get("{{route('store-list-table',['companyCode' => $companyCode])}}",
        {brand:brand},function (data) {
            $('#merchant-list').html(data);
        })
    })

    // search order
    $("#input-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#merchant-list #merchant-data").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // click check active inactive
    $('.flexSwitchCheckChecked').on('click',function () {
        let data = $(this).data('data');
        let brand_active = $(this).data('brand_active');
        $('#modal-brand-active').show();
        $('#modal-brand-inactive').show();
        if (brand_active == 0) {
            $('#modal-brand-active').hide();
        } else {
            $('#modal-brand-inactive').hide();
            $('#confirm-name-merchant').text(data['name']);
            $('#save-change-active').data('data',data);
            if (data['active'] == 1) {
                $('#active-status-to-change').html('<span class="fw-bold text-danger">inactive</span>');
            } else {
                $('#active-status-to-change').html('<span class="fw-bold text-success">active</span>');
            }
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
        $.get("{{route('manage-store-create',['companyCode' => $companyCode])}}",
        function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // button hours
    $('.manage-hourse').on('click',function () {
        let id = $(this).data('id');
        $.get("{{route('hours-list',['companyCode' => $companyCode])}}",
        {id:id},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // button fulfilment
    $('.manage-fulfilment').on('click',function () {
        $.get("{{route('fulfilment-list',['companyCode' => $companyCode])}}",
        function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // button custom categories
    $('.manage-categories').on('click',function () {
        let id = $(this).data('id');
        $.get("{{route('category-list',['companyCode' => $companyCode])}}",
        {id:id},function (data) {
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
        $.get("{{route('extra-attribute-list',['companyCode' => $companyCode])}}",
        {id:id},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // button edit store
    $('.edit-store').on('click',function () {
        let merchant_id = $(this).data('id');
        $.get("{{route('manage-store-edit',['companyCode' => $companyCode])}}",
        {merchant_id:merchant_id},function (data) {
            $('#contentDashboard').html(data);
        })
    })
</script>





