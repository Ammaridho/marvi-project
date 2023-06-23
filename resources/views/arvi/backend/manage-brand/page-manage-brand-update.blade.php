<!-- Content wrapper -->
<div class="content-wrapper">

    <form id="manageStore" enctype="multipart/form-data">
        @csrf
        {{ method_field('PUT') }}
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row justify-content-start">
                <div class="col-lg-2 col-md-2 col-12 mb-3">
                    <div class="fw-bold">Brand profile</div>
                    <div>Your brand's name and logo are shown on your online store,
                        allowing customers to know more about your brand business.</div>
                </div>
                <div class="col-lg-7 col-md-8 col-12">

                    <!-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="m-0">
                                        <span class="text-muted">Manage Brand</span>
                                        / {{$dataBrand->name}} / Brand Details
                                    </h4>
                                </div>
                                <div>
                                    <a href="javascript:void(0);" id="btnback">
                                        <i class="fas fa-chevron-left"></i> back
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <input type="hidden" name="id" value="{{$dataBrand->id}}">
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
                                            id="inputCount name" name="name" value="{{$dataBrand->name}}"
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
                                            <span class="" data-bs-toggle="tooltip" data-bs-placement="bottom" 
                                            title="Input LODI Client ID">
                                                <i class="far fa-question-circle"></i>
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control text-uppercase regex-sku" 
                                            id="inputCount" name="client_id" value="{{$dataBrand->client_id}}"
                                            maxlength="40" required>
                                            <div id="brandHelp" class="form-text text-danger d-none">
                                                Error message here.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="mb-3 container-count">
                                        <label for="brand-country" class="form-label">Country *</label>
                                        <select class="form-select default-select-single"
                                        id="brand-country" name="country" style="width: 100%;">
                                            <option selected="true" disabled="disabled">
                                                {{$dataBrand->country}}
                                            </option>
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
                                        name="description" rows="2" autofocus maxlength="300"
                                        required>{{$dataBrand->description}}</textarea>
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
                                            <a class="upload-image" href="javascript:void(0)">
                                                @if (isset($dataBrand->image_url))
                                                    <div class="border bg-light m-1 rounded d-flex
                                                    justify-content-center align-items-center form-control">
                                                        <div class="brand-logo-wrapper text-center">
                                                            <img src="/storage/arvi/backend-assets/img/logo/brands/{{$dataBrand->image_url}}"
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
                                            <div class="small">
                                                PNG or JPG. Recommended at least 600 x 600
                                                pixels (minimum 300 x 300). Logos with transparent
                                                background are strongly recommended.
                                            </div>
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
                                                <option selected="true" disabled="disabled">
                                                    {{$dataBrand->currency}}
                                                </option>
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
                            <select class="form-select fees-avaibility" name="brandFeeIds"
                            id="brandFeeId" style="width: 100%;">
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
                                        Add social media links to your brand navigation so
                                        customers can find and follow you on your preferred social channels.
                                    </div>

                                    <div id="display-all-social"></div>

                                    <input type="hidden" name="socialMedia" value="asd">

                                    <div class="mb-3 mt-4">
                                        <button type="button" class="btn btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalSocials" id="btn-modal-social">
                                            <i class="bx bx-plus"></i>
                                            Add social icon
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- // -->

                    <!-- -->
                    <div class="my-3">
                        <div class="row justify-content-start">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="d-grid">
                                    <button type="button" class="btn btn-danger delete-brand"
                                    data-id="{{$dataBrand->id}}">Remove brand</button>
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
        <div class="bg-primary fixed-bottom" style="z-index: 0 !important;" id="containerButton">
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
<div class="modal fade" id="modalSocials" aria-labelledby="modalSocials"
aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title">Add social icon</h5>
                </div>
            <div class="modal-body center">

                <div class="mb-3">
                    <span id="warning-social"></span>
                    <select class="form-select social-media-type" id="social-media-type"
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
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="add-social-icon">
                    Add social icon
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit social -->
<div class="modal fade" id="modalEditSocials" aria-labelledby="modalSocials" aria-hidden="true">
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
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="edit-social-icon">
                    Add social icon
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

    var arraySocialMedia = [];

    $( document ).ready(function() {
        // hide form image
        $('.file').hide();
        let country = "{{$dataBrand['country']}}";
        if (country != '') {
            $(`#brand-country option[value="${country}"]`).attr('selected','selected');
        }

        let currency = "{{$dataBrand['currency']}}";
        if (currency != '') {
            $(`#brandCurrencies option[value="${currency}"]`).attr('selected','selected');
        }
        let loc_tz = "{{$dataBrand['loc_tz']}}";
        if (loc_tz != '') {
            $(`#brandTimezone option[value="${loc_tz}"]`).attr('selected','selected');
        }

        //old social media
        var oldSocialMedia = <?php echo json_encode($dataSocialMedia); ?>;
        if (oldSocialMedia.length > 0) {
            oldSocialMedia.forEach(function callback(element, index) {
                arraySocialMedia[index] = [element['type'],element['name']];
            });

            printSocial(arraySocialMedia)
        }

        // check fees
        var jArray_id = <?php echo json_encode(json_decode($dataRelationFees)); ?>;
        if (jArray_id != null) {
            var aa = [];
            jArray_id.forEach(element => {
                aa.push(element);
            });
            $('.fees-avaibility').select2({
                multiple: true,
            });
            $('.fees-avaibility').select2().val(aa).trigger('change.select2');
            $("#brandFeeId").val(aa);
        }
    });

    // social media
    $('#add-social-icon').on('click',function () {
        let type = $('#social-media-type').val();
        if (type != 'select') {
            let name = $('#social-media-name').val();
            arraySocialMedia.push([type,name]);

            $('#warning-social').html('');
            printSocial(arraySocialMedia);

            if (arraySocialMedia.length >= 3) {
                $('#btn-modal-social').hide();
            }

            $(`.social-${type}`).hide();
            $(".social-media-type option[value='select']").attr('selected','selected');
            $('#modalSocials').modal("hide");

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

    // delete
    $(".delete-brand").on('click',function(){
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
            url: "{{ route('manage-brand-destroy',['companyCode' => $companyCode, 'brandId' => $dataBrand->id ]) }}",
            data: {
                "_token": token,
            },
            success: function (){
                $('#manage-brand-button').trigger("click");
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

    // button cancel
    $('#btnCancelManageStore, #btnback').on('click',function () {
        $('#manage-brand-button').trigger("click");
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
        }
        else if ($("select#brandTimezone").val() == 'Select') {
            $('#timezoneHelp').removeClass('d-none');
        } else {
            let brandFeeIds = $("select[name='brandFeeIds']").val();
            var formData = new FormData(this);
            formData.append("brandFeeIds", JSON.stringify(brandFeeIds));
            $.ajax({
                type:'POST',
                url: "{{ route('manage-brand-update',['companyCode' => $companyCode]) }}",
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
    });
</script>

