<form id="manageStore" method="POST" action="" enctype="multipart/form-data">
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
                        <div><h4 class="m-0">
                            <span class="text-muted">Menu</span> / Add Product</h4>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <input type="hidden" name="merchant_id" value="{{$merchant_id}}">
                        <div class="col-lg-2 col-md-2 col-12">
                            <div class="mb-3">
                                <label for="storeName" class="form-label">Logo image</label>
                                <a class="upload-image" href="javascript:void(0)">
                                    <div class="border bg-light m-1 rounded d-flex 
                                        justify-content-center align-items-center form-control">
                                        <div class="merchant-logo-wrapper text-center" 
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
                                <p id="file" style="height: 80px;"></p>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-10 col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="storeName" class="form-label">Menu Name*</label>
                                        <div class="form-text input-count me-3">
                                            <span id="countNow">0</span> / 70
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="inputName" 
                                            name="name" autofocus maxlength="70" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label d-block">
                                            Description
                                            <span id="the-count">
                                                <span class="me-1 form-text float-end">
                                                    <span id="current">0</span> / 300
                                                </span>
                                            </span>
                                        </label>
                                        <textarea class="form-control" id="description" rows="2" 
                                        name="description" autofocus maxlength="300"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="storeName" class="form-label">SKU*</label>
                                        <div class="form-text input-count me-3">
                                            <span id="countNow">0</span> / 70
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="inputName" name="sku" 
                                            autofocus maxlength="70" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="storeCategories" class="form-label">Categories</label>
                                        <div>
                                            <select class="form-select store-avaibility" id="addNewProductCategory" 
                                            name="productCategories" style="width: 100%;">
                                                @foreach ($merchantCategories as $item)
                                                    <option value="{{$item->id}}">{{$item->category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
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
                        <div><h6 class="m-0">Menu Details</h6></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <label for="price" class="form-label">Price *</label>
                                    </div>
                                </div>
                                <input type="number" class="form-control noArrow numbers" 
                                name="retail_price" 
                                id="price" required autocomplete="off">
                                <div id="priceHelp" class="form-text text-danger d-none">
                                    Error message here.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <label for="pprice" class="form-label">Discount Price</label>
                                    </div>
                                    <div>
                                        <a href="#" data-bs-toggle="tooltip" data-bs-offset="0,4" 
                                            data-bs-placement="left" 
                                            data-bs-html="true" title="" 
                                            data-bs-original-title="If you filled, price will be 
                                            strokes in store's">
                                            <i class="fas fa-info-circle text-secondary"></i>
                                        </a>
                                    </div>
                                </div>
                                <input type="number" class="form-control noArrow numbers" 
                                name="discount_price" id="pprice">
                                <div id="ppriceHelp" class="form-text text-danger d-none">
                                    Error message here.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="mb-3">
                                <label for="prep" class="form-label">Preparation Time (Minutes) *</label>
                                <input type="number" class="form-control numbers" name="preparation_time" 
                                id="prep" required>
                                <div id="prepHelp" class="form-text text-danger d-none">
                                    Error message here.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="mb-3">
                                <label for="min" class="form-label">Minimum order *</label>
                                <input type="number" class="form-control numbers" name="min_order" 
                                id="min" min="1" required>
                                <div id="minpHelp" class="form-text text-danger d-none">
                                    Error message here.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="mb-3">
                                <label for="max" class="form-label">Maximum order</label>
                                <input type="number" class="form-control numbers" 
                                name="max_order" id="max">
                                <div id="maxpHelp" class="form-text text-danger d-none">
                                    Error message here.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="mb-3">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" 
                                    name="active" checked="checked">
                                    <label class="form-check-label" 
                                    for="flexSwitchCheckChecked">
                                    Available for sale
                                    </label>
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
                        <div>
                            <h6 class="m-0">Variant</h6>
                            <small>Use variants if an item has different sizes, colors or other options.</small>
                        </div>
                    </div>
                    <hr>
                    <div class="repeater">
                        <div data-repeater-list="variant">
                            <div class="row g-2 mb-4" data-repeater-item style="display:none;">
                                <div class="col-lg-6 col-md-6 col-11">
                                    <div class="mb-3">
                                        <label for="option1" class="form-label">Option name</label>
                                        <input type="text" class="form-control" id="option1" name="nameVariant">
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-11">
                                    <div class="mb-3">
                                        <label for="option2" class="form-label">Option price</label>
                                        <input type="text" 
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" 
                                        class="form-control numbers" id="option2" name="priceVariant">
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
                                <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" 
                                        id="blabla" name="bundleVariant">
                                        <label class="form-check-label" for="blabla">Bundle to menu </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" 
                                        id="blabla2" name="activeVariant">
                                        <label class="form-check-label" for="blabla2">Active </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="javascript:void(0)" class="btn btn-primary" data-repeater-create>
                                <i class="tf-icons bx bx-plus"></i> Add variants
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- // -->
            <!-- -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><h6 class="m-0">Attribute</h6><small>Use attribute if an 
                            item has different sizes, colors or other options.</small></div>
                    </div>
                    <hr>
                    <div class="repeater">
                        <div data-repeater-list="attribute">
                            <div class="row g-2 mb-4" data-repeater-item style="display:none;">
                                <div class="col-lg-6 col-md-6 col-11">
                                    <div class="mb-3">
                                        <label for="option1" class="form-label">Option name</label>
                                        <input type="text" class="form-control" id="option1" name="nameAttribute">
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-11">
                                    <div class="mb-3">
                                        <label for="option2" class="form-label">Option price</label>
                                        <input type="text" 
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" 
                                        class="form-control numbers" id="option2" name="priceAttribute">
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
                                <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" 
                                        id="blabla" name="bundleAttribute">
                                        <label class="form-check-label" for="blabla">Bundle to menu </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" 
                                        id="blabla2" name="activeAttribute">
                                        <label class="form-check-label" for="blabla2">Active </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="javascript:void(0)" class="btn btn-primary" data-repeater-create>
                                <i class="tf-icons bx bx-plus"></i> Add attributes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- // -->
            <!-- -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="m-0">Extra Attribute</h6>
                            <small>You can manage extra attributes 
                                <a href="javascript:void(0);" id="see-extra-attribute-list">
                                    <u>here</u>
                                </a>.
                            </small>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($extraAttributes as $item)
                                <div class="form-check mb-2 location-search">
                                    <input class="form-check-input" type="checkbox" value="{{$item->id}}" 
                                    id="{{$item->name}}{{$item->id}}" name="extra_attributes">
                                    <label class="form-check-label" for="{{$item->name}}{{$item->id}}">
                                            {{$item->name}}
                                    </label>
                                </div>
                                @if ($i == ceil(count($extraAttributes)/2))
                                    </div>
                                    <div class="col-12 col-md-6">
                                @endif
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- // -->
            <!-- -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="m-0">Available Days</h6>
                            <small>Use these feature to make your menu only available in 
                                certain day, default is available all days.</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" 
                                name="available_day" value="1" id="day2">
                                <label class="form-check-label" for="day2"> Monday</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" 
                                name="available_day" value="2" id="day3">
                                <label class="form-check-label" for="day3"> Tuesday</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" 
                                name="available_day" value="3" id="day4">
                                <label class="form-check-label" for="day4"> Wednesday</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" 
                                name="available_day" value="4" id="day5">
                                <label class="form-check-label" for="day5"> Thursday</label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox"
                                 name="available_day" value="5" id="day6">
                                <label class="form-check-label" for="day6"> Friday</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" 
                                name="available_day" value="6" id="day7">
                                <label class="form-check-label" for="day7"> Saturday</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" 
                                name="available_day" value="7" id="day1">
                                <label class="form-check-label" for="day1"> Sunday</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- // -->

        </div>
    </div>

    <!-- THE BUTTON -->
    <div class="mt-5">&nbsp;</div>
    <div class="bg-primary fixed-bottom" style="z-index: 0 !important; display: none;" id="containerButton">
        <div class="d-flex justify-content-between align-items-center p-3">
            <div class="text-white"></div>
            <div>
                <a href="#" class="btn btn-outline-light" id="btnCancelManageStore">Cancel</a>
                <button type="submit" class="btn btn-light">Save</button>
            </div>
        </div>
    </div>
    <!-- //THE BUTTON -->

</form>

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>

    //open list extra attribute
    $('#see-extra-attribute-list').on('click',function () {
        let id = $("input[name='merchant_id']").val();
        $.get("{{ secure_url(route('extra-attribute-list',['companyCode' => $companyCode])) }}",
        {id:id},function (data) {
            $('#contentDashboard').html(data);
        })
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

    $( document ).ready(function() {
        // hide form image
        $('.file').hide();
    });

    // submit form edit product
    $('#manageStore').on('submit',function () {
        event.preventDefault();

        arrayDataRepeater = $('.repeater').repeaterVal();
        arrayDataRepeater['attribute'].shift();
        arrayDataRepeater['variant'].shift();

        let productCategories = $("select[name='productCategories']").val();
        var extra_attributes = $("input[name='extra_attributes']:checked").map(function(){
            return this.value;
        }).get();
        var available_days = $("input[name='available_day']:checked").map(function(){
            return this.value;
        }).get();

        var formData = new FormData(this);
        formData.append("productCategories", JSON.stringify(productCategories));
        formData.append("extra_attributes", JSON.stringify(extra_attributes));
        formData.append("available_days", JSON.stringify(available_days));
        formData.append("productAttributes", JSON.stringify(arrayDataRepeater['attribute']));
        formData.append("productVariants", JSON.stringify(arrayDataRepeater['variant']));

        let merchant_id = '{{$merchant_id}}';
        $.ajax({
            type: 'POST',
            url: "{{ route('merchant-product-store',['companyCode' => $companyCode]) }}",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $.get("{{ secure_url(route('merchant-product-list',['companyCode' => $companyCode])) }}",
                {id:merchant_id},function (data) {
                    $('#contentDashboard').html(data);
                })
            },
            error: function (data) {
                console.log(data);
            }
        })
    });
</script>