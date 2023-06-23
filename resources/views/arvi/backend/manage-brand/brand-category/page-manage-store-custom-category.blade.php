<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="m-0">
                    <span class="text-muted">
                        Manage Brand / {{$brandName}} /
                    </span> Brand Categories
                </h4>
                You can create Brand categories which will be available to all your store.
                </div>
            <div>
                <a href="javascript:void(0)" class="btn btn-primary" 
                    id="add-categories" data-brand_id="{{$brand_id}}">
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
                        <th class="w-100">Store Avaibility</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brandCategories as $item)                    
                        <tr>
                        <td>{{$item->category_name}}</td>
                        <td>
                            @if (isset($item->availability_store))
                                @foreach (json_decode($item->availability_store) as $items)
                                    <span class="badge bg-label-secondary mb-1">
                                        {{ isset($merchants->find($items)->name) ? $merchants->find($items)->name:''}}
                                    </span>
                                @endforeach
                            @else
                                <span class="badge bg-label-primary mb-1">
                                    Please set store!
                                </span>
                            @endif
                        </td>
                        <td>
                            <script>
                                var brandActive = "{{$item->active}}";
                                if (brandActive == '1') {
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
                              </div>
                        </td>
                            <td class="text-nowrap">
                                <a href="javascript:void(0)" class="btn btn-sm btn-primary modal-edit-store" 
                                data-bs-toggle="modal" data-bs-target="#modalStore" data-id="{{$item->id}}" 
                                data-name="{{$item->category_name}}" data-store="{{$item->availability_store}}">
                                    <i class='bx bx-store-alt'></i> Change store</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-primary edit-categories" 
                                data-id="{{$item->id}}">
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

<!-- Modal store avaibility -->
<div class="modal fade" id="modalStore" tabindex="-1" 
aria-labelledby="modalStore" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Store availability
                </h5>
                <button type="button" class="btn-close" 
                data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <h6><strong id="categoryName">Chicken menu</strong> is available in store :</h6>
                    <div class="">
                        <input type="hidden" name="modalEditStore" value="1">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="" id="selectAll">
                            <label class="form-check-label" for="selectAll"> All stores </label>
                        </div>
                        <hr />
                        @foreach ($merchants as $item)
                            <div class="form-check mb-2">
                                <input class="form-check-input store-option selectOne" type="checkbox" 
                                name="storeOption" value="{{$item->id}}" id="storeCheck{{$item->id}}">
                                <label class="form-check-label" for="storeCheck{{$item->id}}"> 
                                    {{$item->name}} 
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary" id="submit-modal-change-store">
                    Save changes
                </button>
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
    var brand_id = '{{$brand_id}}';

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
            url: "{{ route('brand-category-update',['companyCode' => $companyCode]) }}",
            data: {statusActive:active,id:id,"_token": token},
            success: function (data) {
                categoryList(brand_id);
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
            url: "{{ route('brand-category-update',['companyCode' => $companyCode]) }}",
            data: {
                "id": idCat,
                "_token": token,
                "selectStore": selectStore,
                "modalEditStore": modalEditStore
            },
            success: function (){
                $('#modalStore').modal('hide');
                categoryList(brand_id);
            },
            error: function () {
                alert('You have to choose one!');
            }
        });
    })
    
    // button form add category
    $('#add-categories').on('click',function () {
        let brand_id = $(this).data('brand_id');
        $.get("{{route('brand-category-create',['companyCode' => $companyCode])}}",
        {brand_id:brand_id},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // button form edit category
    $('.edit-categories').on('click',function () {
        let id = $(this).data('id');
        $.get("{{route('brand-category-edit',['companyCode' => $companyCode])}}",
        {id:id,brand_id:brand_id},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // reopen list category
    function categoryList(id) {
        $.get("{{ secure_url(route('brand-category-list',['companyCode' => $companyCode])) }}",
        {id:id},function (data) {
            $('#contentDashboard').html(data);
        })
    }
</script>