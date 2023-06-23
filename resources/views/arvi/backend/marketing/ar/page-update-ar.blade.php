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
                        <h4 class="m-0"><span class="text-muted">AR Management</span> / Add New AR Details</h4>
                        <div>
                            <a href="javascript:void(0);"
                                onclick="$('#manage-ar').trigger('click')">
                                <i class="fas fa-chevron-left"></i> back
                            </a>
                        </div>
                    </div>
                    <hr>
                    <input type="hidden" name="id" value="{{ $ar->id }}">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3 container-count">
                                <label for="locName" class="form-label">
                                    Campaign Name *
                                </label>
                                <div class="form-text input-count me-3">
                                    <span id="countNow">0</span> / 60
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                    id="inputCount" name="name" value="{{$ar->name}}"
                                    autofocus maxlength="60" required autocomplete="off">
                                    <div id="nameHelp" class="form-text text-danger d-none HelpMes">
                                        Campaign Name is Required.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3 container-count">
                                <label for="locName" class="form-label">
                                    UPLOAD FBX FILE *
                                </label>
                                <div class="mb-3">
                                    <a class="upload-image" href="javascript:void(0)">
                                        @if (isset($ar->file_name))
                                            <div class="border bg-light m-1 rounded d-flex
                                            justify-content-center align-items-center form-control">
                                                <div class="brand-logo-wrapper text-center">
                                                    <img src="/storage/arvi/backend-assets/img/ars/{{$ar->file_name}}"
                                                    id="preview" class="img-thumbnail">
                                                </div>
                                            </div>
                                        @else
                                            <div class="lazy store-cover border bg-light m-1 rounded d-flex
                                            justify-content-center align-items-center" style="height: 120px;">
                                            <div class=""><i class='bx bx-image-add fs-1 text-muted'></i></div>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                <input type="file" name="image_url" class="file" id="file-image-form"
                                accept="image/*">
                                <p id="file"></p>
                                <div id="imageHelp" class="mb-2 text-danger d-none small HelpMes">
                                    <span id="imageMessage"></span>
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
                            id="delete-ar" data-id="{{ $ar->id }}">
                                Remove ar
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
                    onclick="$('#manage-ar').trigger('click')">Cancel</a>
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
    $('.file').hide();
    // set old data
    let store_id = "{{$ar->merchant_id}}";
    if (store_id != '') {
        $(`#choose-store option[value="${store_id}"]`).attr('selected','selected');
        // set display old name selected
        $(`#choose-store option[value="${store_id}"]`).select2().val(store_id).trigger('change.select2');
    }
    let ar_type = "{{$ar->ar_type}}";
    if (ar_type != '') {
        $(`#choose-type option[value="${ar_type}"]`).attr('selected','selected');
        $(`#choose-type option[value="${ar_type}"]`).select2().val(ar_type).trigger('change.select2');
    }

    // delete
    $("#delete-ar").on('click',function(){
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
            url: "{{ route('ar-destroy') }}",
            data: {
                "id": id,
                "_token": token,
            },
            success: function (){
                $('#manage-ar').trigger('click');
            }
        });
    })

    // form image
    $('.upload-image').on("click", function() {
        $('#file-image-form').trigger("click");
    });
    $('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#file").text(fileName);
        var reader = new FileReader();
        $('.upload-image').html(`<div class="border bg-light m-1 rounded d-flex
                                    justify-content-center align-items-center form-control">
                                    <div class="brand-logo-wrapper text-center" id="image-preview">
                                        <img src="" id="preview" class="img-thumbnail">
                                    </div>
                                </div>`);
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });

    // save
    $('#manageStore').on('submit',function () {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: "{{ route('ar-update') }}",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#manage-ar').trigger('click');
            },
            error: function (data) {

                $('.HelpMes').addClass('d-none');

                let em = JSON.parse(data.responseText)['errors'];
                Object.values(em).forEach(val => {
                    if (val[0] == 'The name field is required.') {
                        $('#nameHelp').removeClass('d-none');
                    }
                });
            }
        })
    })
})
</script>
