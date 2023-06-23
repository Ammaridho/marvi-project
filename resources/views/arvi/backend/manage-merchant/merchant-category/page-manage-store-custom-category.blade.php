<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="m-0">
                    <span class="text-muted">
                        Manage Store / {{$merchantName}} /
                    </span> Product Categories
                </h4>
                You can create Brand categories which will be available to all your store.
                </div>
            <div>
                <a href="javascript:void(0)" class="btn btn-primary" 
                    id="add-categories" data-merchant_id="{{$merchant_id}}">
                    <i class="tf-icons bx bx-plus"></i> Add categories
                </a>
            </div>
        </div>
        <hr>
        <div class="table-responsive text-nowrap table-scroll">
            <table class="table table-borderless">    
                <thead>    
                    <tr>    
                        <th class="text-nowrap">Categories Name</th>    
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($merchantCategories as $item)       
                        <tr>
                            <td class="w-100">{{$item->category_name}}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <script>
                                        var merchantActive = "{{$item->active}}";
                                        if (merchantActive == '1') {
                                            $("#flexSwitchCheckChecked{{$item->id}}").prop('checked', true);
                                        }else{
                                            $("#flexSwitchCheckChecked{{$item->id}}").prop('checked', false);
                                        }
                                    </script>
                                    <div class="form-check form-switch mt-1 ms-5">
                                        <input class="form-check-input flexSwitchCheckChecked" 
                                        type="checkbox" id="flexSwitchCheckChecked{{$item->id}}" 
                                        data-data="{{$item}}">
                                        <label class="form-check-label" for="flexSwitchCheckChecked{{$item->id}}"></label>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">
                                            {{$item->active==1?'Active':'Inactive'}}
                                        </label>
                                    </div>
                                </div>
                            </td>
                            <td class="text-nowrap">
                                <a href="javascript:void(0)" class="btn btn-sm btn-primary edit-categories" 
                                data-id="{{$item->id}}">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @foreach ($brandCategories as $item)       
                        <tr>
                            <td class="w-100">{{$item->category_name}}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <script>
                                        var merchantActive = "{{$item->active}}";
                                        if (merchantActive == '1') {
                                            $("#flexSwitchCheckChecked{{$item->id}}").prop('checked', true);
                                        }else{
                                            $("#flexSwitchCheckChecked{{$item->id}}").prop('checked', false);
                                        }
                                    </script>
                                    <div class="form-check form-switch mt-1 ms-5">
                                        <input class="form-check-input flexSwitchCheckChecked disabled" 
                                        type="checkbox" id="flexSwitchCheckChecked{{$item->id}}" 
                                        data-data="{{$item}}" disabled>
                                        <label class="form-check-label" for="flexSwitchCheckChecked{{$item->id}}"></label>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">
                                            {{$item->active==1?'Active':'Inactive'}}
                                        </label>
                                    </div>
                                </div>
                            </td>
                            <td class="text-nowrap">
                                <a href="javascript:void(0)" class="btn btn-sm btn-primary edit-categories disabled" 
                                data-id="{{$item->id}}" disabled>
                                    <i class="fas fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
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

<script>
    var merchant_id = '{{$merchant_id}}';

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
            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            type: 'PUT',
            url: "{{ route('category-update',['companyCode' => $companyCode]) }}",
            data: {statusActive:active,id:id,"_token": token},
            success: function (data) {
                categoryList(merchant_id);
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
    
    // modal change store data
    $('#submit-modal-change-store').on('click',function () {
        var selectStore = [];
        $.each($("input[name='storeOption'].selectOne:checked"), function(){
            selectStore.push($(this).val());
        });
        modalEditStore = $("input[name='modalEditStore']").val();
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'PUT',
            url: "{{ route('category-update',['companyCode' => $companyCode]) }}",
            data: {
                "id": idCat,
                "_token": token,
                "selectStore": selectStore,
                "modalEditStore": modalEditStore
            },
            success: function (){
                $('#modalStore').modal('hide');
                categoryList(merchant_id);
            },
            error: function () {
                console.log(data);
            }
        });
    })
    
    // button form add category
    $('#add-categories').on('click',function () {
        let merchant_id = $(this).data('merchant_id');
        $.get("{{route('category-create',['companyCode' => $companyCode])}}",
        {merchant_id:merchant_id},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // button form edit category
    $('.edit-categories').on('click',function () {
        let id = $(this).data('id');
        $.get("{{route('category-edit',['companyCode' => $companyCode])}}",
        {id:id,merchant_id:merchant_id},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // reopen list category
    function categoryList(id) {
        $.get("{{ secure_url(route('category-list',['companyCode' => $companyCode])) }}",
        {id:id},function (data) {
            $('#contentDashboard').html(data);
        })
    }
</script>