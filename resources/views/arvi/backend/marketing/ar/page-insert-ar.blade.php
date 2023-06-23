<link rel="stylesheet" type="text/css"
href="/arvi/backend-assets/vendor/libs/datepicker/datepicker.css"/>
<form id="manageStore" method="post">
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
                        <h4 class="m-0"><span class="text-muted">AR Management</span> / Add New AR Details</h4>
                        <div>
                            <a href="javascript:void(0);"
                                onclick="$('#manage-ar').trigger('click')">
                                <i class="fas fa-chevron-left"></i> back
                            </a>
                        </div>
                    </div>
                    <hr>
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
                                    id="inputCount" name="name"
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
                                        <div class="border bg-light m-1 rounded d-flex
                                            justify-content-center align-items-center form-control">
                                            <div class="brand-logo-wrapper text-center" id="image-preview">
                                                <div class="m-4">
                                                    Drop files here or click to upload
                                                </div>
                                            </div>
                                        </div>
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

        </div>
    </div>

    <div class="mt-5">&nbsp;</div>
    <div class="bg-primary fixed-bottom"
    style="z-index: 0 !important; display: none;" id="containerButton">
    <div class="d-flex justify-content-between align-items-center p-3">
    <div class="text-white"></div>
    <div>
        <a href="#" class="btn btn-outline-light"
        onclick="$('#manage-ar').trigger('click')">Cancel</a>
        <button type="submit" class="btn btn-light">
            Save
        </button>
    </div>

</form>

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>

    $(document).ready(function () {
        $('.file').hide();
    })

    // form image
    $('.upload-image').on("click", function() {
        $('#file-image-form').trigger("click");
    });
    $('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#file").text(fileName);
        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
        $('#image-preview').html('<img src="" id="preview" class="img-thumbnail">');
    });

    // save
    $('#manageStore').on('submit',function () {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: "{{ route('ar-store') }}",
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
</script>
