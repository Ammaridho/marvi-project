<!-- Content wrapper -->
<div class="content-wrapper">

    <form class="manageStore" method="" action="" onsubmit="return false;">
        @csrf
        <div class="container-xxl flex-grow-1 container-p-y">
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
                                        <span class="text-muted">Manage Extra Attributes</span> / Details
                                    </h4>
                                </div>
                                <div>
                                    <a href="javascript:void(0);" class="btnback">
                                        <i class="fas fa-chevron-left"></i> back
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <input type="hidden" name="id" value="{{$brandExtraAttribute->id}}">
                                <input type="hidden" name="brand_id" value="{{$brand_id}}">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="mb-3 container-count">
                                        <label for="extraName" class="form-label">
                                            Extra Attributes Name *
                                        </label>
                                        <div class="form-text input-count me-3">
                                            <span id="countNow">0</span> / 40
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="inputCount"
                                            name="name" value="{{$brandExtraAttribute->name}}" autofocus maxlength="40" required autocomplete="off">
                                            <div id="storeNamepHelp" class="form-text text-danger d-none">
                                                Error message here.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="extraPrice" class="form-label">Price * </label>
                                        <input type="text" class="form-control noArrow numbers"
                                        name="fee" value="{{$brandExtraAttribute->fee}}" id="extraPrice" autocomplete="off">
                                        <div id="storeNumberHelp" class="form-text text-danger
                                        d-none">Error message here.</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="extraPrice" class="form-label">SKU * </label>
                                        <input type="text" class="form-control text-uppercase"
                                        oninput="this.value =
                                        this.value.replace(/[^a-zA-Z0-9.-]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        name="sku" value="{{$brandExtraAttribute->sku}}">
                                        <div id="storeNumberHelp" class="form-text text-danger
                                        d-none">Error message here.</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="extraPrice" class="form-label">UOM * </label>
                                        <select class="form-select select2 uom"
                                        name="uom" style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach ($uomList as $item)
                                                <option value="{{$item->uom}}">{{$item->uom}}</option>
                                            @endforeach
                                        </select>
                                        <div id="storeNumberHelp" class="form-text text-danger
                                        d-none">Error message here.</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="extraPrice" class="form-label">Weight (Kg) *</label>
                                            <span data-bs-toggle="tooltip" data-bs-offset="0,4"
                                            data-bs-placement="left" data-bs-html="true"
                                            title="If you menu weight 600gr, input 0.6"
                                            class="text-light"><i class="fas fa-info-circle"></i></span>
                                            <input type="text" class="form-control"
                                            oninput="this.value =
                                            this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            name="weight" value="{{$brandExtraAttribute->weight}}" autocomplete="off">
                                        <div id="storeNumberHelp" class="form-text text-danger
                                        d-none">Error message here.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- // -->

                    <div class="my-3">
                        <div class="row justify-content-start">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="d-grid">
                                    <button type="button" class="btn btn-danger
                                    delete-extra-attribute" data-bs-toggle="modal"
                                     data-bs-target="#modaldDefaultDelete"
                                     data-id="{{$brandExtraAttribute->id}}">
                                        Remove extra attribute
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- THE BUTTON -->
        <div class="mt-5">&nbsp;</div>
        <div class="bg-primary fixed-bottom" style="z-index: 0 !important;
        display: none;" id="containerButton">
            <div class="d-flex justify-content-between align-items-center p-3">
                <div class="text-white"></div>
                <div>
                    <a href="#" class="btn btn-outline-light" id="btnCancelManageStore">Cancel</a>
                    <button type="submit" class="btn btn-light" >Save</button>
                </div>
            </div>
        </div>
        <!-- //THE BUTTON -->
    </form>

</div>
<!-- Content wrapper -->

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

{{-- script plugin --}}
<script type="text/javascript" src="/arvi/backend-assets/js/demo.js"></script>
<script>
    $( document ).ready(function() {
        // old uom
        let uom = "{{$brandExtraAttribute->uom}}";
        if (uom != '') {
            $(`.uom option[value="${uom}"]`).attr('selected','selected');
        }
    });

    // delete
    $(".delete-extra-attribute").on('click',function(){
        let id = $(this).data('id');
        $('#submit-delete').data('id',id);
        // show modal
        $('#modaldDefaultDelete').modal('show');
    });
    $('#submit-delete').on('click',function () {
        let id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'DELETE',
            url: "{{ route('brand-extra-attribute-destroy',['companyCode' => $companyCode]) }}",
            data: {
                "id": id,
                "_token": token,
            },
            success: function (){
                $(".btnback").trigger("click");
            },
            error: function () {
                console.log(data);
            }
        });
    })

    // button cancel
    $('#btnCancelManageStore, .btnback').on('click',function () {
        let id = $("input[name='brand_id']").val();
        $.get("{{ secure_url(route('brand-extra-attribute-list',['companyCode' => $companyCode])) }}",
        {id:id},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // submit form insert product
    $('.manageStore').on('submit',function () {
        event.preventDefault();
        $.ajax({
            type: 'PUT',
            url: "{{ route('brand-extra-attribute-update',['companyCode' => $companyCode]) }}",
            data: $(this).serialize(),
            success: function (data) {
                $('#btnCancelManageStore').trigger("click");
            },
            error: function (data) {
                console.log(data);
            }
        })
    });
</script>
