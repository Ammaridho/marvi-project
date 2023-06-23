<form id="form-categories" method="post">
    @csrf
    <div class="row justify-content-start">
        <div class="col-lg-2 col-md-2 col-12 mb-3">
            &nbsp;
        </div>
        <div class="col-lg-7 col-md-8 col-12">
            <!-- -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="m-0">
                                <span class="text-muted">Manage Brand</span> / Brand Details
                            </h4>
                        </div>
                        <div>
                            <a href="javascript:void(0);" id="btnback">
                                <i class="fas fa-chevron-left"></i> back
                            </a>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <input type="hidden" name="brand_id" value="{{$brand_id}}">
                        <div class="col-12">
                            <div class="mb-3 container-count">
                                <label for="storeName" class="form-label">Categories Name</label>
                                <div class="form-text input-count me-3"><span id="countNow">0</span> / 15</div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="inputCount" 
                                    name='name' autofocus maxlength="15">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <div>
                                    <label for="storeName" class="form-label">
                                        Avaibility in store
                                    </label>
                                    <select class="form-select store-avaibility" 
                                    name="storeAvaibility" style="width: 100%;">
                                        @foreach ($merchants as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- -->

        </div>
    </div>
    

    <div class="mt-5">&nbsp;</div>
    <div class="bg-primary fixed-bottom" style="z-index: 0 !important; " id="containerButton">
        <div class="d-flex justify-content-between align-items-center p-3">
            <div class="text-white"></div>
            <div>
                <a href="javascript:void(0)" class="btn btn-outline-light" 
                id="btnCancelManageStore">Cancel</a>
                <button type="submit" class="btn btn-light">Save</button>
            </div>
        </div>
    </div>

</form>

<script src="/arvi/backend-assets/js/demo.js"></script>
<script>
    // button cancel
    $('#btnCancelManageStore, #btnback').on('click',function () {
        let id = $("input[name='brand_id']").val();
        $.get("{{ secure_url(route('brand-category-list',['companyCode' => $companyCode])) }}",
        {id:id},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // submit form edit product
    $('#form-categories').on('submit',function () {
        event.preventDefault();

        storeAvaibilityData = JSON.stringify($("select[name='storeAvaibility']").val());
        $.ajax({
            type: 'POST',
            url: "{{ route('brand-category-store',['companyCode' => $companyCode]) }}",
            data: $(this).serialize() + `&storeAvaibilityData=${storeAvaibilityData}`,
            success: function (data) {
                $('#btnCancelManageStore').trigger("click");
            },
            error: function (data) {
                console.log(data);
            }
        })
    });
</script>