<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-start">
            <div class="col-lg-12 col-md-12 col-12">
                <!-- -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="m-0">
                                    <span class="text-muted">
                                        Manage Store / {{$merchantName}} /
                                    </span> Manage Extra Atributes
                                </h4>
                                You can create Store Extra Attribute which will be available to all your store.
                            </div>
                            
                            <div>
                                <a href="javascript:void(0);" class="btn btn-primary text-nowrap"
                                id="add-extra-attribute" data-id="{{$merchant_id}}">
                                    <i class="tf-icons bx bx-plus"></i> Add extra atribute
                                </a>
                            </div>
                        </div>
                        <hr>
                       <div class="mb-3">
                            <form class="search" onsubmit="return false">
                            <input class="form-control form-control-custom me-2" type="search" id="input-search"
                            placeholder="Name/price.." aria-label="Search" autocomplete="off" />
                            <button type="reset">&times;</button>
                            </form>
                        </div>
                        <div class="table-responsive text-nowrap pb-4 always-show" id="table-scroll">
                            <table class="table table-borderless">
                                <thead>
                                    <tr class="table-primary text-nowrap border-0">
                                        <th>type product</th>
                                        <th>Extra Atrribute Name</th>
                                        <th class="w-100">Price</th>
                                        <th class="w-100">SKU</th>
                                        <th class="w-100">UOM</th>
                                        <th class="w-100">Weight</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-extra-attribute-list">

                                    @foreach ($merchantExtraAttributes as $item)

                                    <!-- extra -->
                                    <tr class="text-nowrap" id="attribute-list">
                                        <td>store</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->currency}} {{$item->fee}}</td>
                                        <td>{{$item->sku}}</td>
                                        <td>{{$item->uom}}</td>
                                        <td>{{$item->weight}}</td>
                                        <td>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <script>
                                                    var merchantActive = "{{$item->active}}";
                                                    if (merchantActive == '1') {
                                                      $("#flexSwitchCheckCheckedMerchant{{$item->id}}").prop('checked', true);
                                                    }else{
                                                      $("#flexSwitchCheckCheckedMerchant{{$item->id}}").prop('checked', false);
                                                    }
                                                  </script>
                                                <div class="form-check form-switch mt-1 ms-5">
                                                    <input class="form-check-input flexSwitchCheckChecked"
                                                    type="checkbox" id="flexSwitchCheckCheckedMerchant{{$item->id}}"
                                                    data-data="{{$item}}">
                                                    <label class="form-check-label" for="flexSwitchCheckCheckedMerchant{{$item->id}}">
                                                    </label>
                                                </div>
                                                <div class="mx-2">
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-primary edit-extra-attribute"
                                                        data-id="{{$item->id}}"><i class="fas fa-pen"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- //extra -->

                                    @endforeach
                                    @foreach ($brandExtraAttribute as $item)

                                    <!-- extra -->
                                    <tr class="text-nowrap" id="attribute-list">
                                        <td>brand</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->currency}} {{$item->fee}}</td>
                                        <td>{{$item->sku}}</td>
                                        <td>{{$item->uom}}</td>
                                        <td>{{$item->weight}}</td>
                                        <td>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <script>
                                                    var merchantActive = "{{$item->active}}";
                                                    if (merchantActive == '1') {
                                                      $("#flexSwitchCheckCheckedBrand{{$item->id}}").prop('checked', true);
                                                    }else{
                                                      $("#flexSwitchCheckCheckedBrand{{$item->id}}").prop('checked', false);
                                                    }
                                                  </script>
                                                <div class="form-check form-switch mt-1 ms-5">
                                                    <input class="form-check-input flexSwitchCheckChecked"
                                                    type="checkbox" id="flexSwitchCheckCheckedBrand{{$item->id}}"
                                                    data-data="{{$item}}" disabled>
                                                    <label class="form-check-label" for="flexSwitchCheckCheckedBrand{{$item->id}}">
                                                    </label>
                                                </div>
                                                <div class="mx-2">
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-primary
                                                    edit-extra-attribute disabled"
                                                        data-id="{{$item->id}}"><i class="fas fa-pen"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- //extra -->

                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="text-center text-muted mt-1">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <!-- showing data -->
                        <div class="d-flex justify-content-end align-items-center mt-4">
                            <div class="text-muted small me-3">
                                Showing
                                <span id="much-display">
                                    {{DB::table('merchant_extra_attributes')->where('merchant_id',$merchant_id)->count() < 25 ?
                                    DB::table('merchant_extra_attributes')->where('merchant_id',$merchant_id)->count() : 25}}
                                </span>
                                from {{DB::table('merchant_extra_attributes')->where('merchant_id',$merchant_id)->count()}}
                            </div>
                            <div class="">
                                <select class="dropdown nice filter-data" id="much-data">
                                <option value="25" selected>Showing 25 rows</option>
                                <option value="50">Showing 50 rows</option>
                                <option value="100">Showing 100 rows</option>
                                <option value="150">Showing 150 rows</option>
                                <option value="all">Showing all rows</option>
                                </select>
                            </div>
                        </div>
                        <!-- //showing data -->
                    </div>
                </div>
                <!-- // -->
            </div>
        </div>
    </div>
</div>
<!-- Content wrapper -->

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

    // search
    $("#input-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tbody-extra-attribute-list tr#attribute-list").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // filter
    $('.filter-data').on('change',function () {
        let much = $('#much-data').val();
        $.get("{{route('extra-attribute-list-table',['companyCode' => $companyCode])}}",
        {merchant_id:merchant_id,much:much},function (data) {
            $('#tbody-extra-attribute-list').html(data);
        })
    })

    // button form edit category
    $('.edit-extra-attribute').on('click',function () {
        let id = $(this).data('id');
        $.get("{{route('extra-attribute-edit',['companyCode' => $companyCode])}}",
        {id:id,merchant_id:merchant_id},function (data) {
            $('#contentDashboard').html(data);
        })
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
        let merchant_id = (data['merchant_id']);
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'PUT',
            url: "{{ route('extra-attribute-update',['companyCode' => $companyCode]) }}",
            data: {statusActive:active,id:id,"_token": token},
            success: function (data) {
                $.get("{{ secure_url(route('extra-attribute-list',['companyCode' => $companyCode])) }}",
                {id:merchant_id},function (data) {
                    $('#contentDashboard').html(data);
                })
            },
            error: function (data) {
                console.log(data);
            }
        })
    })

    // button modal change store
    $('.modal-edit-store').on('click',function () {
        idCat = $(this).data('id');
        $('#categoryName').text($(this).data('name'));
        //uncheck all
        $("input[name='storeOption']").attr('checked',false);
        //old check
        let store = $(this).data('store');
        if (typeof store != 'string') {
            store.forEach(element => {
                $("input[value="+element+"].store-option").attr('checked',true);
            });
        }
        // select check box
        $('#selectAll').on('click', function () {
            if(!($('#selectAll').prop("checked"))){
                $('.selectOne').prop('checked', false);
            }else{
                $('.selectOne').prop('checked', true);
            }
            if($('.selectOne').on('click', function(){
                $('#selectAll').prop('checked',false);
            }));
        })
    })

    // button form add axtra-attribute
    $('#add-extra-attribute').on('click',function () {
        let merchant_id = $(this).data('id');
        $.get("{{route('extra-attribute-create',['companyCode' => $companyCode])}}",
        {merchant_id:merchant_id},function (data) {
            $('#contentDashboard').html(data);
        })
    })
</script>
