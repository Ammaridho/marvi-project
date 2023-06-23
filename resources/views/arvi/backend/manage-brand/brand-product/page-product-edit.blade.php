<form id="manageStore" method="POST" action="" enctype="multipart/form-data">
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
                        <div><h4 class="m-0">
                            <span class="text-muted">Menu</span> / Edit Product</h4>
                        </div>
                        <div>
                            <a href="javascript:void(0);" id="btnback">
                                <i class="fas fa-chevron-left"></i> back
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <input type="hidden" name="brand_id" value="{{$brand_id}}">
                        <input type="hidden" name="id" value="{{$brandProduct->id}}">
                        <div class="col-lg-2 col-md-2 col-12">
                            <div class="mb-3">
                                <label for="storeName" class="form-label">Logo image</label>
                                <a class="upload-image" href="javascript:void(0)">
                                    <div class="border bg-light m-1 rounded d-flex
                                        justify-content-center align-items-center form-control">
                                        <div class="brand-logo-wrapper text-center"
                                        id="image-preview">
                                            @if (count($brandImage) > 0)
                                                <img src="/storage/arvi/backend-assets/img/products/brands/{{$brandImage[0]}}"
                                                id="preview" class="img-thumbnail">
                                            @else
                                                <div class="">
                                                    <i class='bx bx-image-add fs-1 text-muted'></i>
                                                </div>
                                            @endif
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
                                    <div class="mb-3 container-count">
                                        <label for="storeName" class="form-label">Menu Name*</label>
                                        <div class="form-text input-count me-3">
                                            <span id="countNow">0</span> / 70
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="inputCount"
                                            name="name" value="{{$brandProduct->name}}" autofocus
                                            maxlength="70" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3 container-count">
                                        <label for="storeName" class="form-label">SKU*</label>
                                        <div class="form-text input-count me-3">
                                            <span id="countNow2">0</span> / 70
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control text-uppercase regex-sku"
                                            id="inputCount2" name="sku" value="{{$brandProduct->sku}}" 
                                            autofocus maxlength="70" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="sku" class="form-label">Uom *</label>
                                        <div class="mb-3">
                                            <select class="form-select default-select-single" 
                                            id="uom" name="uom" style="width: 100%;" required>
                                                <option>{{$brandProduct->uom}}</option>
                                                @foreach ($uomList as $item)
                                                    <option value="{{$item->uom}}">{{$item->uom}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label for="weight" class="form-label">Weight (Kg) *</label>
                                            <div>
                                                <span data-bs-toggle="tooltip" data-bs-offset="0,4" 
                                                data-bs-placement="left" data-bs-html="true" 
                                                title="If you menu weight 600gr, input 0.6" class="text-light">
                                                <i class="fas fa-info-circle"></i></span>
                                            </div>
                                        </div>
                                        <div>
                                            <input type="text" class="form-control regex-number" id="weight"
                                            name="weight" autocomplete="off" 
                                            value="{{$brandProduct->weight}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3 container-count">
                                        <label for="description" class="form-label d-block">
                                            Description
                                            <span id="the-count">
                                                <span class="me-1 form-text float-end">
                                                    <span id="current">0</span> / 300
                                                </span>
                                            </span>
                                        </label>
                                        <textarea class="form-control" id="description" rows="2"
                                        name="description" autofocus
                                        maxlength="300">{{$brandProduct->description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="addNewProductCategory" class="form-label">
                                                Categories
                                            </label>
                                            <div>
                                                <a href="javascript: void(0);" id="clearExtraCat">Clear</a>
                                            </div>
                                        </div>
                                        <div>
                                            <select class="form-select category-avaibility" 
                                            id="addNewProductCategory" multiple="multiple" 
                                            name="productCategories" style="width: 100%;">
                                                @foreach ($brandCategories as $item)
                                                    <option value="{{$item->id}}">
                                                        {{$item->category_name}}
                                                    </option>
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
                                name="retail_price" value="{{$brandProduct->retail_price}}"
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
                                name="discount_price" value="{{$brandProduct->discount_price}}"
                                id="pprice">
                                <div id="ppriceHelp" class="form-text text-danger d-none">
                                    Error message here.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="mb-3">
                                <label for="prep" class="form-label">Preparation Time (Minutes) *</label>
                                <input type="number" class="form-control numbers"
                                name="preparation_time"
                                value="{{$brandProduct->preparation_time}}" id="prep" required>
                                <div id="prepHelp" class="form-text text-danger d-none">
                                    Error message here.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="mb-3">
                                <label for="min" class="form-label">Minimum order *</label>
                                <input type="number" class="form-control numbers" name="min_order"
                                value="{{$brandProduct->min_order}}" id="min" min="1" required>
                                <div id="minpHelp" class="form-text text-danger d-none">
                                    Error message here.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="mb-3">
                                <label for="max" class="form-label">Maximum order</label>
                                <input type="number" class="form-control numbers"
                                name="max_order" value="{{$brandProduct->max_order}}" id="max">
                                <div id="maxpHelp" class="form-text text-danger d-none">
                                    Error message here.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="mb-3">
                                <script>
                                    var active = "{{$brandProduct->active}}";
                                    if (active == '1') {
                                      $("#flexSwitchCheckChecked{{$brandProduct->id}}").prop('checked', true);
                                    }else{
                                      $("#flexSwitchCheckChecked{{$brandProduct->id}}").prop('checked', false);
                                    }
                                  </script>
                                  <div class="form-check form-switch">
                                    <input class="form-check-input flexSwitchCheckChecked" name="active"
                                    type="checkbox" id="flexSwitchCheckChecked{{$brandProduct->id}}"
                                    data-data="{{$brandProduct}}">
                                    <label class="form-check-label"
                                    for="flexSwitchCheckChecked{{$brandProduct->id}}">
                                      Available</label>
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
                            <small>Use variants if an item has different sizes,
                                colors or other options.</small>
                        </div>
                    </div>
                    <hr>
                    <div class="repeaterVariant">
                        <div data-repeater-list="variant">
                            <div class="row g-2 mb-4 border rounded p-2" 
                            data-repeater-item style="display:none;">
                                <div class="col-lg-6 col-md-6 col-11">
                                    <div class="mb-1">
                                        <label for="option1" class="form-label">
                                            Option name *
                                        </label>
                                        <input type="text" class="form-control" 
                                        id="option1" name="name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-11">
                                    <div class="mb-1">
                                        <label for="option2" class="form-label">
                                            Option price *
                                        </label>
                                        <input type="text" class="form-control numbers"
                                        oninput="this.value = 
                                        this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" 
                                        name="retail_price">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-11">
                                    <div class="mb-1">
                                        <label for="sku" class="form-label">SKU *</label>
                                        <input type="text" class="form-control numbers text-uppercase"
                                        oninput="this.value = 
                                        this.value.replace(/[^a-zA-Z0-9.-]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        id="sku" name="sku">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="sku" class="form-label">Uom *</label>
                                        <div class="mb-3">
                                            <select class="form-select select2" id="" 
                                            name="uom" style="width: 100%;">
                                                <option value="">Select</option>
                                                @foreach ($uomList as $item)
                                                    <option value="{{$item->uom}}">{{$item->uom}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-bottom mb-1">
                                            <label for="weight" class="form-label">Weight (Kg)</label>
                                            <div>
                                                <span data-bs-toggle="tooltip" data-bs-offset="0,4" 
                                                data-bs-placement="left" data-bs-html="true" 
                                                title="If you menu weight 600gr, input 0.6" 
                                                class="text-light"><i class="fas fa-info-circle"></i></span>
                                            </div>                                                
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control"
                                            oninput="this.value = 
                                            this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            name="weight" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="form-check form-switch me-3">
                                            <input class="form-check-input" type="checkbox" 
                                            name="active" value="1">
                                            <label class="form-check-label">Active </label>
                                        </div>
                                        <div class="form-check form-switch me-3">
                                            <input class="form-check-input" type="checkbox" 
                                            name="mandatory" value="1">
                                            <label class="form-check-label">Mandatory</label>
                                        </div>
                                        <div class="form-check form-switch me-3">
                                            <input class="form-check-input" type="checkbox" 
                                            name="bundle_to_menu" value="1">
                                            <label class="form-check-label">Bundle to menu </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-end">
                                    <div>
                                        <label for="option2" class="form-label">&nbsp;</label>
                                        <button type="button" class="btn" data-repeater-delete>
                                            <i class='bx bx-trash-alt' ></i>
                                        </button>
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
                    <div class="repeaterAttribute">
                        <div data-repeater-list="attribute">
                            <div class="row g-2 mb-4 border rounded p-2" 
                            data-repeater-item style="display:none;">
                                <div class="col-lg-6 col-md-6 col-11">
                                    <div class="mb-1">
                                        <label for="option1" class="form-label">
                                            Option name *
                                        </label>
                                        <input type="text" class="form-control" 
                                        id="option1" name="name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-11">
                                    <div class="mb-1">
                                        <label for="option2" class="form-label">
                                            Option price *
                                        </label>
                                        <input type="text" class="form-control numbers" 
                                        oninput="this.value = 
                                        this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        name="retail_price">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-11">
                                    <div class="mb-1">
                                        <label for="sku" class="form-label">SKU *</label>
                                        <input type="text" class="form-control numbers text-uppercase"
                                        oninput="this.value = 
                                        this.value.replace(/[^a-zA-Z0-9.-]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        id="sku" name="sku">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="sku" class="form-label">Uom *</label>
                                        <div class="mb-3">
                                            <select class="form-select select2" id="" 
                                            name="uom" style="width: 100%;">
                                                <option value="">Select</option>
                                                @foreach ($uomList as $item)
                                                    <option value="{{$item->uom}}">{{$item->uom}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-bottom mb-1">
                                            <label for="weight" class="form-label">Weight (Kg)</label>
                                            <div>
                                                <span data-bs-toggle="tooltip" data-bs-offset="0,4" 
                                                data-bs-placement="left" data-bs-html="true" 
                                                title="If you menu weight 600gr, input 0.6" 
                                                class="text-light"><i class="fas fa-info-circle"></i></span>
                                            </div>                                                
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" 
                                            oninput="this.value = 
                                            this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            name="weight" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="form-check form-switch me-3">
                                            <input class="form-check-input" type="checkbox" 
                                            name="active" value="1">
                                            <label class="form-check-label">Active </label>
                                        </div>
                                        <div class="form-check form-switch me-3">
                                            <input class="form-check-input" type="checkbox" 
                                            name="mandatory" value="1">
                                            <label class="form-check-label">Mandatory</label>
                                        </div>
                                        <div class="form-check form-switch me-3">
                                            <input class="form-check-input" type="checkbox" 
                                            name="bundle_to_menu" value="1">
                                            <label class="form-check-label">Bundle to menu </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-end">
                                    <div>
                                        <label for="option2" class="form-label">&nbsp;</label>
                                        <button type="button" class="btn" data-repeater-delete>
                                            <i class='bx bx-trash-alt' ></i>
                                        </button>
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
                                    <input class="form-check-input extra_attributes" type="checkbox"
                                    value="{{$item->id}}" id="{{$item->name}}{{$item->id}}"
                                    name="extra_attributes">
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
                                <input class="form-check-input days" type="checkbox"
                                name="available_day" value="1" id="day2">
                                <label class="form-check-label" for="day2"> Monday</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input days" type="checkbox"
                                name="available_day" value="2" id="day3">
                                <label class="form-check-label" for="day3"> Tuesday</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input days" type="checkbox"
                                name="available_day" value="3" id="day4">
                                <label class="form-check-label" for="day4"> Wednesday</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input days" type="checkbox"
                                name="available_day" value="4" id="day5">
                                <label class="form-check-label" for="day5"> Thursday</label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input days" type="checkbox"
                                    name="available_day" value="5" id="day6">
                                <label class="form-check-label" for="day6"> Friday</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input days" type="checkbox"
                                name="available_day" value="6" id="day7">
                                <label class="form-check-label" for="day7"> Saturday</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input days" type="checkbox"
                                name="available_day" value="7" id="day1">
                                <label class="form-check-label" for="day1"> Sunday</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- // -->

            {{-- trigger repeater --}}
            <div class="repeaterPancingan">
                <div data-repeater-list="group-test">
                  <div data-repeater-item>
                    <input class="d-none" type="text" name="text-input" value="A"/>
                  </div>
                </div>
            </div>

            <!-- -->
            <div class="my-3">
                <div class="row justify-content-start">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="d-grid">
                            <button type="button" class="btn btn-danger delete-product"
                            data-id="{{$brandProduct->id}}">
                                Remove product
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- // -->

        </div>
    </div>

    <!-- THE BUTTON -->
    <div class="mt-5">&nbsp;</div>
    <div class="bg-primary fixed-bottom" style="z-index: 0 !important; display: none;"
    id="containerButton">
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

<script src="/arvi/backend-assets/js/demo.js"></script>


<script>
    // add new category
    $('#addNewProductCategory')
        .select2({
        })
        .on('select2:open', () => {
            $(".select2-results:not(:has(a))")
            .append('<a href="#" id="see-product-category" class="text-center p-2" style="background: #e7e7e7; display: block;">Create New Category</a>');
            
        // button custom categories
        $('#see-product-category').on('click',function () {
            $('.select2-dropdown').addClass('d-none');
            let id = '{{$brand_id}}';
            $.get("{{route('brand-category-list',['companyCode' => $companyCode])}}",
            {id:id},function (data) {
                $('#contentDashboard').html(data);
            })
        })
    });

    // checked old data
    $( document ).ready(function() {

        // old uom
        let uom = "{{$brandProduct->uom}}";
        if (uom != '') {
            $(`#uom option[value="${uom}"]`).attr('selected','selected');
        }

        // set old data variants
        var $repeater = $(".repeaterVariant").repeater();
        var jArray_id = <?php echo $dataRelationVariants ?>;
        var myJson = {"variant":jArray_id};
        $repeater.setList(myJson["variant"]);

        // // set old data attributes
        var $repeater = $(".repeaterAttribute").repeater();
        var jArray_id = <?php echo $dataRelationAttributes ?>;
        var myJson = {"attribute":jArray_id};
        $repeater.setList(myJson["attribute"]);

        // check categories
        var jArray_id = <?php echo json_encode(json_decode($dataRelationCategories)); ?>;
        if (jArray_id != null) {
            var aa = [];
            jArray_id.forEach(element => {
                aa.push(element);
            });
            $('.category-avaibility').select2({
                multiple: true,
            });
            $('.category-avaibility').select2().val(aa).trigger('change.select2');
            $("#addNewProductCategory").val(aa);
        }

        // extra attributes
        var jArray_id = <?php echo json_encode(json_decode($dataRelationExtraAttributes)); ?>;
        if (jArray_id != null) {
            //set checkbox merchants
            jArray_id.forEach(element => {
                $(".extra_attributes:input[value="+element+"]").trigger('click');
            });
        }

        // available days
        var jArray_id = <?php echo json_encode(json_decode($brandProduct['available_days'])); ?>;
        if (jArray_id != null) {
            //set checkbox merchants
            jArray_id.forEach(element => {
                $(".days:input[value="+element+"]").trigger('click');
            });
        }

    });

    // button cancel
    $('#btnCancelManageStore, #btnback').on('click',function () {
        let brand_id = '{{$brand_id}}';
        $.get("{{ secure_url(route('brand-product-list',['companyCode' => $companyCode])) }}",
        {id:brand_id},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // delete
    $(".delete-product").on('click',function(){
        let id = $(this).data('id');
        $('#submit-delete').data('id',id);
        // show modal
        $('#modaldDefaultDelete').modal('show');
    });
    $('#submit-delete').on('click',function () {
        let id = $(this).data("id");
        let brand_id = '{{$brand_id}}';
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'DELETE',
            url: "{{ route('brand-product-destroy',['companyCode' => $companyCode]) }}",
            data: {
                "id": id,
                "_token": token,
            },
            success: function (){
                $.get("{{ secure_url(route('brand-product-list',['companyCode' => $companyCode])) }}",
                {id:brand_id},function (data) {
                    $('#contentDashboard').html(data);
                })
            },
            error: function () {
                console.log(data);
            }
        });
    })

    //open list extra attribute
    $('#see-extra-attribute-list').on('click',function () {
        let id = $("input[name='brand_id']").val();
        $.get("{{ secure_url(route('brand-extra-attribute-list',['companyCode' => $companyCode])) }}",
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

        // get all data from repeater jquery
        let repeaterData = $('.repeaterVariant,.repeaterAttribute,.repeaterPancingan').repeaterVal();

        // get all data
        let productCategories = $("select[name='productCategories']").val();
        var extra_attributes = $("input[name='extra_attributes']:checked").map(function(){
            return this.value;
        }).get();
        var available_days = $("input[name='available_day']:checked").map(function(){
            return this.value;
        }).get();

        // reform data to formData
        var formData = new FormData(this);
        formData.append("productCategories", JSON.stringify(productCategories));
        formData.append("extra_attributes", JSON.stringify(extra_attributes));
        formData.append("available_days", JSON.stringify(available_days));
        formData.append("productAttributes", JSON.stringify(repeaterData['attribute']));
        formData.append("productVariants", JSON.stringify(repeaterData['variant']));

        // update data
        let brand_id = '{{$brand_id}}';
        $.ajax({
            type: 'POST',
            url: "{{ route('brand-product-update',['companyCode' => $companyCode]) }}",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $.get("{{ secure_url(route('brand-product-list',['companyCode' => $companyCode])) }}",
                {id:brand_id},function (data) {
                    $('#contentDashboard').html(data);
                })
            },
            error: function (data) {
                alert('Gagal, Isi data dengan lengkap!');
            }
        })
    });
</script>
