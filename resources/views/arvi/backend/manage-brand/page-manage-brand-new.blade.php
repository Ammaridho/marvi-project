
<!-- Content wrapper -->
<div class="content-wrapper">
    
    <form id="manageStore" method="post" enctype="multipart/form-data">
        @csrf
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row justify-content-start">
                <div class="col-lg-2 col-md-2 col-12 mb-3">
                    <div class="fw-bold">Brand profile</div>
                    <div>Your brand's name and logo are shown on your online store, 
                        allowing customers to know more about your brand business.
                    </div>
                </div>
                <div class="col-lg-7 col-md-8 col-12">
            
                    <!-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="m-0">
                                        <span class="text-muted">Manage Brand</span>
                                        / Brand Details
                                    </h4>
                                </div>
                                <div>
                                    <a href="javascript:void(0);" id="btnback">
                                        <i class="fas fa-chevron-left"></i> back
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <div class="row">

                                <div class="col-lg-8 col-md-8 col-12">
                                    <div class="mb-3 container-count">
                                        <label for="brandName" class="form-label">
                                            Brand Name * 
                                        </label>
                                        <div class="form-text input-count me-3">
                                            <span id="countNow">0</span> / 40
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" 
                                            id="inputCount name" name="name" 
                                            autofocus maxlength="40" required>
                                            <div id="brandHelp" class="form-text text-danger d-none">
                                                Submitted Brand name is already registered.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="mb-3 container-count">
                                        <div class="d-flex justify-content-between align-items-top">
                                            <label for="brandName" class="form-label">Client ID</label>
                                            <span class="" data-bs-toggle="tooltip" 
                                            data-bs-placement="bottom" 
                                            title="Input LODI Client ID">
                                                <i class="far fa-question-circle"></i>
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control text-uppercase regex-sku"
                                            id="inputCount" name="client_id" maxlength="40" required>
                                            <div id="brandHelp" class="form-text text-danger d-none">
                                                Error message here.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="mb-3 container-count">
                                        <label for="brandCountry" class="form-label">Country *</label>                                            
                                        <select class="form-select default-select-single" id="brandCountry" 
                                        name="country" style="width: 100%;">
                                            <option>Select</option>
                                            @foreach ($countries as $country)
                                                <option value="{{$country}}">{{$country}}</option>
                                            @endforeach
                                        </select>
                                        <div id="countryHelp" class="form-text text-danger d-none">
                                            Please choose country.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label d-block">
                                            Description *
                                            <span id="the-count">
                                                <span class="me-1 form-text float-end">
                                                    <span id="current">0</span> / 300
                                                </span>
                                            </span>
                                        </label>
                                        <textarea class="form-control" id="description" 
                                        name="description" 
                                        rows="2" autofocus maxlength="300" required></textarea>
                                        <div id="descriptionHelp" class="form-text text-danger d-none">
                                            Error message here.
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="storeName" class="form-label">
                                                Logo image
                                            </label>
                                            <div class="small">PNG or JPG. Recommended at least 600 x 
                                                600 pixels (minimum 300 x 300). 
                                            Logos with transparent background are strongly recommended.</div>
                                            <a class="upload-image" href="javascript:void(0)">
                                                <div class="border bg-light m-1 rounded d-flex 
                                                    justify-content-center align-items-center 
                                                    form-control">
                                                    <div class="brand-logo-wrapper text-center" 
                                                    id="image-preview">
                                                        <div class="">
                                                            <i class='bx bx-image-add fs-1 text-muted'></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <div id="imageHelp" class="form-text text-danger d-none">
                                                Please choose image.
                                            </div>
                                            <input type="file" name="image_url" class="file" 
                                            id="file-image-form" accept="image/*">
                                            <p id="file"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- // -->

                    <!-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div><h6 class="m-0">Store locale</h6></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="storeName" class="form-label">Currency *</label>
                                        <div>
                                            <select class="form-select default-select-single" name="currency" 
                                            id="brandCurrencies" style="width: 100%;">
                                                <option>Select</option>
                                                @foreach ($currencies as $item)
                                                    <option value="{{$item['iso']['code']}}">
                                                        {{$item['name']}}({{$item['iso']['code']}})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div id="currenciesHelp" class="form-text text-danger d-none">
                                                Please choose currencies.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 d-none">
                                    <div class="mb-3">
                                        <label for="storeName" class="form-label">Timezone *</label>
                                        <div>
                                            <select class="form-select" name="timezone" 
                                            id="brandTimezone" style="width: 100%;">
                                            <option>Select</option>
                                            @foreach ($timezonelist as $item)
                                                <option value="{{$item}}">
                                                    {{$item}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="timezoneHelp" class="form-text text-danger d-none">
                                                Please choose timezone.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- // -->

                    <!-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div><h6 class="m-0">Fee</h6></div>
                            </div>
                            <hr>
                            <select class="form-select store-categories" 
                            name="brandFeeIds" style="width: 100%;">
                                <optgroup>
                                    @foreach ($fees as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            <div class="mt-2">No fee availabe. You can create fee's 
                                <a href="javascript:void(0);" 
                                onclick="$('#fees-button').trigger('click')">here<a>
                            </div>
                        </div>
                    </div>
                    <!-- // -->

                    <!-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div><h6 class="m-0">Social icons</h6></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <div class="my-2">
                                        Add social media links to your brand navigation so customers 
                                        can find and follow you on your preferred social channels.
                                    </div>

                                    <div id="display-all-social"></div>

                                    <input type="hidden" name="socialMedia" value="asd">
                                    
                                    <div class="mb-3 mt-4">
                                        <button type="button" class="btn btn-outline-primary" 
                                        data-bs-toggle="modal" data-bs-target="#modalSocials" 
                                        id="btn-modal-social">
                                            <i class="bx bx-plus"></i> Add social icon
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- // -->

                </div>
            </div>

        </div>
        
        <!-- THE BUTTON -->
        <div class="mt-5">&nbsp;</div>
        <div class="bg-primary fixed-bottom" style="z-index: 0 !important; display: none;" 
        id="containerButton">
            <div class="d-flex justify-content-between align-items-center p-3">
                <div class="text-white"></div>
                <div>
                    <a href="javascript:void(0);" class="btn btn-outline-light" 
                    id="btnCancelManageStore">Cancel</a>
                    <button type="submit" class="btn btn-light">Save</button>
                </div>
            </div>
        </div>
        <!-- //THE BUTTON -->
        
    </div>
        <!-- Content wrapper -->

    </div>
    <!-- / Layout page -->
</div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<!--
=============================================
Modals
=============================================
-->

<!-- Modal add social -->
<div class="modal fade" id="modalSocials" 
aria-labelledby="modalSocials" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title">Add social icon</h5>
                </div>
            <div class="modal-body center">             
                <div class="mb-3">
                    <span id="warning-social"></span>
                    <select class="form-select social-media-type" 
                    id="social-media-type" 
                    name="default-select-single" style="width: 100%;">
                        <option value="select">Select social icon</option>
                        <option class="social-instagram">instagram</option>
                        <option class="social-facebook">facebook</option>
                        <option class="social-twitter">twitter</option>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">@</span>
                    <input type="text" class="form-control" id="social-media-name" 
                    placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" id="add-social-icon">
                    Add social icon
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal edit social -->
<div class="modal fade" id="modalEditSocials" 
aria-labelledby="modalSocials" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title">Add social icon</h5>
                </div>
            <div class="modal-body center">                
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">@</span>
                    <input type="text" class="form-control" id="social-media-edit-name" 
                    placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-link" 
                data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" 
                id="edit-social-icon">Add social icon</button>
            </div>
        </div>
    </div>
</div>
</form>

<script src="/arvi/backend-assets/js/demo.js"></script>
<script>   

    // social media
    var arraySocialMedia = [];
    $('#add-social-icon').on('click',function () {
        let type = $('#social-media-type').val();
        if (type != 'select') {
            let name = $('#social-media-name').val();
            arraySocialMedia.push([type,name]);
            $('#btn-modal-social').click();
            $('#warning-social').html('');
            $('#display-all-social').html('');
            printSocial(arraySocialMedia);
            if (arraySocialMedia.length >= 3) {
                $('#btn-modal-social').hide();
            }
            $(`.social-${type}`).hide();
            $(".social-media-type option[value='select']").attr('selected','selected');
        }else{
            $('#warning-social').html('<p>Please choose social media!</p>');
        }
    })
    
    function printSocial(arraySocialMedia) {
        if (arraySocialMedia.length > 0) {
            $('#display-all-social').html('');
            arraySocialMedia.forEach(function callback(element, index) {
                $('#display-all-social').append(
                    `<div class="d-flex justify-content-between mb-2">
                        <div class="">
                            <i class="fab fa-${element[0]} me-1"></i>
                            ${element[1]}
                        </div>
                        <div class="">
                            <a href="javascript:void(0)" class="ms-3 text-secondary edit-social" 
                            data-bs-toggle="modal" data-bs-target="#modalEditSocials" 
                            data-index='${index}'>
                                <i class='bx bx-edit-alt'></i>
                            </a>
                            <a href="javascript:void(0)" class="ms-3 text-secondary delete-social"
                            data-index='${index}' data-type='${element[0]}'>
                                <i class='bx bx-trash-alt'></i>
                            </a>
                        </div>
                    </div>`
                );
            });
            // edit social
            $('.edit-social').on('click',function () {
                index = $(this).data('index');
                $('#social-media-edit-name').val(arraySocialMedia[index][1]);

                // store to array
                $('#edit-social-icon').on('click',function () {
                    arraySocialMedia[index][1] = $('#social-media-edit-name').val();
                    printSocial(arraySocialMedia);
                    $('#modalEditSocials').modal("hide");
                })
            })
            // delete social
            $('.delete-social').on('click',function () {
                index = $(this).data('index');
                type = $(this).data('type');
                arraySocialMedia.splice(index, 1);
                printSocial(arraySocialMedia);
                $(`.social-${type}`).show();
                if (arraySocialMedia.length < 3) {
                    $('#btn-modal-social').show();
                }
            })
        } else {
            $('#display-all-social').html('');
        }
        $("input[name='socialMedia']").val(JSON.stringify(arraySocialMedia));
    }

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

    $( document ).ready(function() {
        // hide form image
        $('.file').hide();
    });

    // button cancel
    $('#btnCancelManageStore, #btnback').on('click',function () {
        $('#manage-brand-button').trigger("click");
    })
    
    // submit form edit product
    $('#manageStore').on('submit',function () {
        event.preventDefault();
        $('#countryHelp').addClass('d-none');
        $('#currenciesHelp').addClass('d-none');
        $('#timezoneHelp').addClass('d-none');
        if ($("select#brandCountry").val() == 'Select') {
            $('#countryHelp').removeClass('d-none');
        }
        else if ($("select#brandCurrencies").val() == 'Select') {
            $('#currenciesHelp').removeClass('d-none');
        } else {
            let brandFeeIds = $("select[name='brandFeeIds']").val();
            var formData = new FormData(this);
            formData.append("brandFeeIds", JSON.stringify(brandFeeIds));
            $.ajax({
                type:'POST',
                url: "{{ route('manage-brand-store',['companyCode' => $companyCode]) }}",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#manage-brand-button').trigger("click");
                },
                error: function (data) {
                    var err = JSON.parse(data.responseText).errors;
                    if (!$('#brandHelp').hasClass('d-none')) {
                        $('#brandHelp').addClass('d-none');
                    }
                    if (err != undefined) {
                        Object.keys(err).forEach(function(key) {
                            if (key == 'name') {
                                $('#brandHelp').removeClass('d-none');
                            } 
                        });
                    }
                }
            })
        }
    })
</script>
    
