<link rel="stylesheet" type="text/css"
href="/arvi/backend-assets/vendor/libs/datepicker/datepicker.css"/>
<form id="manageStore" method="POST" enctype="multipart/form-data">
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
                            <span class="text-muted">Manage Banner</span>
                             / Add New Banner</h4>
                        </div>
                        <div>
                            <a href="javascript:void(0);"
                                onclick="$('#manage-banner').trigger('click')">
                                <i class="fas fa-chevron-left"></i> back
                            </a>
                        </div>
                    </div>
                    <hr>
                    <input type="hidden" name="id" value="{{ $banner->id }}">
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
                                    id="inputCount" name="name" value="{{ $banner->name }}"
                                    autofocus maxlength="60" required autocomplete="off">
                                    <div id="nameHelp" class="form-text text-danger d-none HelpMes">
                                        Name is Required.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-m4-2 col-12">
                            <div>
                                <label for="locAddr" class="form-label">
                                    Order *
                                </label>
                                <select class="form-select w-100"
                                id="choose-order" name="order">
                                    <option>Select</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-10 col-12">
                            <div>
                                <label for="locBulding" class="form-label">URL</label>
                                <input type="text" class="form-control" name="url"
                                value="{{ $banner->url }}" autocomplete="off" placeholder="https://">
                                <div id="locBuldingHelp" class="form-text text-danger d-none HelpMes">
                                    Error message here.
                                </div>
                            </div>
                        </div>
                        <div id="orderHelp" class="form-text text-danger d-none HelpMes">
                            Choose order banner.
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 mt-3">
                            <div class="mb-3">
                                <label for="locCity" class="form-label">Date Start *</label>
                                <input type="text" class="form-control date-pick"
                                name="date_start"
                                value="{{ isset($banner->date_start)?
                                date("d/m/Y", strtotime($banner->date_start)):'' }}" autocomplete="off">
                                <div id="dateStartHelp" class="form-text text-danger d-none HelpMes">
                                    The date start is required.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 mt-3">
                            <div class="mb-3">
                                <label for="logState" class="form-label">Date End *</label>
                                <input type="text" class="form-control date-pick"
                                name="date_end" value="{{ isset($banner->date_end)?
                                date("d/m/Y", strtotime($banner->date_end)):'' }}" autocomplete="off">
                                <div id="dateEndHelp" class="form-text text-danger d-none HelpMes">
                                    The date end is required.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><h6 class="m-0">Image *</h6></div>
                    </div>
                    <hr>
                    <div class="mb-2 position-relative p-2 upload-bulk">
                        <a class="upload-image" href="javascript:void(0)">
                            @if (isset($banner->image_url))
                                <div class="border bg-light m-1 rounded d-flex
                                justify-content-center align-items-center form-control">
                                    <div class="brand-logo-wrapper text-center">
                                        <img src="/storage/arvi/backend-assets/img/banners/{{$banner->image_url}}"
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
                    <input type="file" name="image_url" class="file"
                    id="file-image-form" accept="image/*">
                    <p id="file"></p>
                    <div class="mb-2 small">
                        Supported image format png, jpg, jpeg only.
                        File dimension 900 x 400 (px) and file size less than 200kb.
                    </div>
                    <div id="imageHelp" class="mb-2 text-danger d-none small HelpMes">
                        <span id="imageMessage"></span>
                    </div>
                </div>
            </div>

            <!-- -->
            <div class="my-3">
                <div class="row justify-content-start">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="d-grid">
                            <button type="button" class="btn btn-danger"
                            id="delete-banner" data-id="{{ $banner->id }}">
                                Remove banner
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
                    onclick="$('#manage-banner').trigger('click')">Cancel</a>
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
    $('.date-pick').datepicker({format:'dd/mm/yyyy',autoclose:true,});
    let order = "{{$banner['order']}}";
    if (order != '') {
        $(`#choose-order option[value="${order}"]`).attr('selected','selected');
    }

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

    // delete
    $("#delete-banner").on('click',function(){
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
            url: "{{ route('banner-destroy') }}",
            data: {
                "id": id,
                "_token": token,
            },
            success: function (){
                $('#manage-banner').trigger('click');
            }
        });
    })

    // save
    $('#manageStore').on('submit',function () {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: "{{ route('banner-update') }}",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#manage-banner').trigger('click');
            },
            error: function (data) {

                $('.HelpMes').addClass('d-none');

                let em = JSON.parse(data.responseText)['errors'];
                Object.values(em).forEach(val => {
                    if (val[0] == 'The name field is required.') {
                        $('#nameHelp').removeClass('d-none');
                    }
                    if (val[0] == 'image required'){
                        $('#imageHelp').removeClass('d-none');
                        $('#imageMessage').text('image required.');
                    }
                    if (val[0] == 'image dimension') {
                        $('#imageHelp').removeClass('d-none');
                        $('#imageMessage').text('image dimension.');
                    }
                    if (val[0] == 'image max') {
                        $('#imageHelp').removeClass('d-none');
                        $('#imageMessage').text('image size.');
                    }
                    if (val[0] == 'The date start field is required.') {
                        $('#dateStartHelp').removeClass('d-none');
                    }
                    if (val[0] == 'The date end field is required.') {
                        $('#dateEndHelp').removeClass('d-none');
                    }
                    if (val[0] == 'The order must be an integer.') {
                        $('#orderHelp').removeClass('d-none');
                    }
                });
            }
        })
    })
})
</script>
