<form id="manageStore" method="post" enctype="multipart/form-data">
    @csrf
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-start">
            <div class="col-lg-2 col-md-2 col-12 mb-3">
            &nbsp;
            </div>
            <div class="col-lg-7 col-md-8 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><h4 class="m-0"><span class="text-muted">
                                Manage Delivery Method</span> / Add Delivery Method</h4>
                            </div>
                            <div>
                                <a href="javascript:void(0);"
                                onclick="$('#manage-delivery').trigger('click')">
                                <i class="fas fa-chevron-left"></i> back
                            </a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3 container-count">
                                    <label for="feeValue" class="form-label">
                                        Courier name *
                                    </label>
                                    <div class="form-text input-count me-3">
                                        <span id="countNow">0</span> / 25
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" 
                                        id="inputCount" name="method_name" 
                                        autofocus maxlength="25" required autocomplete="off">
                                        <div id="nameHelp" class="form-text text-danger d-none">
                                            please fill.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-4">
                                    <label for="feeName" class="form-label">LOGO </label>
                                    <div class="mb-2 position-relative upload-bulk">
                                        <a class="upload-image" href="javascript:void(0)">
                                            <div class="border bg-light m-1 rounded d-flex
                                                justify-content-center align-items-center form-control">
                                                <div class="brand-logo-wrapper text-center" id="image-preview">
                                                    <div class="">
                                                        <i class='bx bx-image-add fs-1 text-muted'></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <input type="file" name="image_url" 
                                    class="file" id="file-image-form"
                                    accept="image/*">
                                    <p id="file"></p>
                                    <div class="mb-2 small">
                                        Supported image format png, jpg, jpeg only.
                                        File size less than 200kb.
                                    </div>
                                    <div id="imageHelp" class="mb-2 text-danger d-none small HelpMes">
                                        <span id="imageMessage"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                </div>
                                <div class="repeater">
                                    <div data-repeater-list="service">
                                        <div class="row g-2 mb-4 border rounded p-2" 
                                        data-repeater-item style="display:none;">
                                            <div class="col-11">
                                                <div class="mb-11">
                                                    <label for="option1" class="form-label">
                                                        Service type
                                                    </label>
                                                    <input type="text" class="form-control" 
                                                    id="option1" name="nameService">
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div>
                                                    <label for="option2" class="form-label">&nbsp;</label>
                                                    <button type="button" class="btn" data-repeater-delete>
                                                        <i class='bx bx-trash-alt' ></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="form-check form-switch me-3">
                                                        <input class="form-check-input" type="checkbox" 
                                                        name="activeService">
                                                        <label class="form-check-label">Active </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="javascript:void(0)" class="btn btn-primary" 
                                        data-repeater-create>
                                            <i class="tf-icons bx bx-plus"></i> Add Services
                                        </a>
                                    </div>
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
        onclick="$('#manage-delivery').trigger('click')">Cancel</a>
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
        
        // get data service from repeater
        arrayDataRepeater = $('.repeater').repeaterVal();
        arrayDataRepeater['service'].shift();
        
        var formData = new FormData(this);
        formData.append("services", JSON.stringify(arrayDataRepeater['service']));

        $.ajax({
            type: 'POST',
            url: "{{ route('delivery-store') }}",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#manage-delivery').trigger('click')
            },
            error: function (data) {

                $('.HelpMes').addClass('d-none');

                let em = JSON.parse(data.responseText)['errors'];
                Object.values(em).forEach(val => {
                    if (val[0] == 'The name field is required.') {
                        $('#nameHelp').removeClass('d-none');
                    }
                    if (val[0] == 'image dimension') {
                        $('#imageHelp').removeClass('d-none');
                        $('#imageMessage').text('image dimension.');
                    }
                    if (val[0] == 'image max') {
                        $('#imageHelp').removeClass('d-none');
                        $('#imageMessage').text('image size more than 200kb.');
                    }
                });
            }
        })
    })
</script>