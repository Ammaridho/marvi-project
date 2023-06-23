<link rel="stylesheet" type="text/css"
href="/arvi/backend-assets/vendor/libs/datepicker/datepicker.css"/>
<form id="manageStore" method="POST">
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
                        <h4 class="m-0"><span class="text-muted">QR Management</span> / Add New QR Details</h4>
                        <div>
                            <a href="javascript:void(0);"
                                onclick="$('#manage-qr').trigger('click')">
                                <i class="fas fa-chevron-left"></i> back
                            </a>
                        </div>
                    </div>
                    <hr>
                    <input type="hidden" name="id" value="{{$qr->id}}">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3 container-count">
                                <label for="locName" class="form-label">
                                    Name *
                                </label>
                                <div class="form-text input-count me-3">
                                    <span id="countNow">0</span> / 60
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                    id="inputCount" name="name" value="{{$qr->name}}"
                                    autofocus maxlength="60" required autocomplete="off">
                                    <div id="nameHelp" class="form-text text-danger d-none HelpMes">
                                        Name is Required.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3 container-count">
                                <label for="locAddr" class="form-label">
                                    Select Store *
                                </label>
                                <select class="form-select default-select-single 
                                w-100" id="choose-store" name="store">
                                    <option>Select</option>
                                    @foreach ($merchantIds as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                <div id="storeHelp" class="form-text text-danger d-none HelpMes">
                                    Choose Store is Required.
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3 container-count">
                                <label for="locAddr" class="form-label">
                                    Select Type *
                                </label>
                                <select class="form-select default-select-single 
                                w-100" id="choose-type" name="type">
                                    <option>Select</option>
                                    <option value="0">Digital Menu</option>
                                    <option value="1">AR</option>
                                </select>
                                <div id="typeHelp" class="form-text text-danger d-none HelpMes">
                                    Choose type is Required.
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="url-input">
                            <div class="mb-3 container-count">
                                <label for="locBulding" class="form-label">URL *</label>
                                <input type="text" class="form-control" name="url" id="form-url"
                                 autocomplete="off" placeholder="https://" value="{{$qr->qr_url}}">
                                 <div class="mt-1">
                                     <small>"Note edit URL: Don’t forget to edit QR layout + click SAVE so the system will generate updated QR"</small>
                                 </div>
                                <div id="urlHelp" class="form-text text-danger d-none HelpMes">
                                    URL is Required.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- -->
            <div class="my-3">
                <div class="row justify-content-start">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="d-grid">
                            <button type="button" class="btn btn-danger"
                            id="delete-qr" data-id="{{ $qr->id }}">
                                Remove qr
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="mt-5">&nbsp;</div>
    <div class="bg-primary fixed-bottom" style="z-index: 0 !important; display: none;"
    id="containerButton">
        <div class="d-flex justify-content-between align-items-center p-3">
            <div class="text-white"></div>
                <div>
                    <a href="#" class="btn btn-outline-light"
                    onclick="$('#manage-qr').trigger('click')">Cancel</a>
                    <button type="submit" class="btn btn-light" >
                        Save
                    </button>
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
                <h4>You're about to <span class="text-danger">remove</span> this Brand.</h4>
                <div class="">
                    By doing this action, you will removed the Brand and cannot be undone.
                </div>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submit-delete"
                data-bs-dismiss="modal" data-id="">Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>
$( document ).ready(function() {

    // set old data
    let store_id = "{{$qr->merchant_id}}";
    if (store_id != '') {
        $(`#choose-store option[value="${store_id}"]`).attr('selected','selected');
        // set display old name selected
        $(`#choose-store option[value="${store_id}"]`).select2().val(store_id).trigger('change.select2');
    }
    let qr_type = "{{$qr->qr_type}}";
    if (qr_type != '') {
        $(`#choose-type option[value="${qr_type}"]`).attr('selected','selected');
        // if type == digital menu
        if (qr_type == 0) {
            $('#url-input').addClass('d-none');
        }
        $(`#choose-type option[value="${qr_type}"]`).select2().val(qr_type).trigger('change.select2');
    }

    // if digital menu
    $('#choose-type').on('change',function () {
        if ($(this).val() == 0) {
            $('#url-input').addClass('d-none');
            $('#form-url').prop('required',false);
        }else{
            $('#url-input').removeClass('d-none');
            $('#form-url').prop('required',true);
        }
    })

    // delete
    $("#delete-qr").on('click',function(){
        let id = $(this).data('id');
        $('#submit-delete').data('id',id);
        // show modal
        $('#modaldDefaultDelete').modal('show');
    });
    $('#submit-delete').on('click',function () {
        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'DELETE',
            url: "{{ route('qr-destroy') }}",
            data: {
                "id": id,
                "_token": token,
            },
            success: function (){
                $('#manage-qr').trigger('click');
            }
        });
    })

    // save
    $('#manageStore').on('submit',function () {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: "{{ route('qr-update') }}",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#manage-qr').trigger('click');
            },
            error: function (data) {

                $('.HelpMes').addClass('d-none');

                let em = JSON.parse(data.responseText)['errors'];
                Object.values(em).forEach(val => {
                    if (val[0] == 'The name field is required.') {
                        $('#nameHelp').removeClass('d-none');
                    }
                    if (val[0] == 'The store must be a number.') {
                        $('#storeHelp').removeClass('d-none');
                    }
                    if (val[0] == 'The type must be a number.') {
                        $('#typeHelp').removeClass('d-none');
                    }
                    if (val[0] == 'The url field is required.') {
                        $('#urlHelp').removeClass('d-none');
                    }
                });
            }
        })
    })
})
</script>
