<form id="form-categories" method="post">
    @csrf
    {{ method_field('PUT') }}
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
                                <span class="text-muted">Menu</span> / Add Categories
                            </h4>
                        </div>
                        <div>
                            <a href="javascript:void(0);" id="btnback"><i class="fas fa-chevron-left"></i> back</a>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <input type="hidden" name="id" value="{{$productCategory->id}}">
                            <div class="col-12">
                                <div class="mb-3 container-count">
                                    <label for="storeName" class="form-label">Categories Name</label>
                                    <div class="form-text input-count me-3"><span id="countNow">0</span> / 15</div>
                                    <div class="mb-3">
                                        @if ($productCategory->category_type == 'fixed')
                                            <input type="text" class="form-control" id="inputCount" name='name' 
                                            value="{{$productCategory->category_name}}" autofocus maxlength="15" readonly required>
                                        @else
                                            <input type="text" class="form-control" id="inputCount" name='name' 
                                            value="{{$productCategory->category_name}}" autofocus maxlength="15" required>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- -->
                <!-- -->
                <div class="my-3">
                    <div class="row justify-content-start">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="d-grid">
                                <button type="button" class="btn btn-danger delete-category"
                                data-id="{{$productCategory->id}}">Remove category</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- // -->
            </div>
        </div>
    </div>
    <div class="mt-5">&nbsp;</div>
        <div class="bg-primary fixed-bottom" style="z-index: 0 !important; " 
        id="containerButton">
            <div class="d-flex justify-content-between align-items-center p-3">
                <div class="text-white"></div>
                <div>
                    <a href="javascript:void(0)" class="btn btn-outline-light" 
                    id="btnCancelManageStore">Cancel</a>
                    <button type="submit" class="btn btn-light">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

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
                <div class="">By doing this action, you will removed the item and cannot be undone.</div>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary" id="submit-delete" 
                data-bs-dismiss="modal" data-id="">Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="/arvi/backend-assets/js/demo.js"></script>
<script>
    $( document ).ready(function() {
        var jArrayAvaibility_store = <?php echo json_encode(json_decode($productCategory->availability_store)); ?>;
        
        if (jArrayAvaibility_store != null) {
            var aa = [];
            jArrayAvaibility_store.forEach(element => {
                aa.push(element);
            });
            $("#multiple").val(aa);
        }
    });

    // delete
    $(".delete-category").on('click',function(){
        let id = $(this).data('id');
        $('#submit-delete').data('id',id);
        // show modal
        $('#modaldDefaultDelete').modal('show');
    }); 
    $('#submit-delete').on('click',function () {
        var id = $(this).data("id");
        var merchant_id = '{{$merchant_id}}';
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'DELETE',
            url: "{{ route('category-destroy',['companyCode' => $companyCode]) }}",
            data: {
                "id": id,
                "_token": token,
            },
            success: function (){
                $.get("{{ secure_url(route('category-list',['companyCode' => $companyCode])) }}",
                {id:merchant_id},function (data) {
                    $('#contentDashboard').html(data);
                })
            }
        });
    })

    var id = '{{$merchant_id}}';
    // button cancel
    $('#btnCancelManageStore, #btnback').on('click',function () {
        $.get("{{ secure_url(route('category-list',['companyCode' => $companyCode])) }}",
        {id:id},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // submit form edit product
    $('#form-categories').on('submit',function () {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: "{{ route('category-update',['companyCode' => $companyCode]) }}",
            data: $(this).serialize(),
            success: function (data) {
                $.get("{{ secure_url(route('category-list',['companyCode' => $companyCode])) }}",
                {id:id},function (data) {
                    $('#contentDashboard').html(data);
                })
            },
            error: function (data) {
                console.log(data);
            }
        })
    });
</script>