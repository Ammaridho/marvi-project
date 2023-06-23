<!-- Content wrapper -->
<div class="content-wrapper"> 
    <form id="manageStore" method="post" enctype="multipart/form-data">
    @csrf
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-start">
            <div class="col-lg-2 col-md-2 col-12 mb-3">
                <div class="fw-bold">Store profile</div>
                <div>Your store's details are shown on your online store, 
                allowing customers to know more about your business.</div>
            </div>
            <div class="col-lg-7 col-md-8 col-12">       
                <!-- -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="m-0">
                                    <span class="text-muted">Manage Store</span> / Store Details
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
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="brandSelect" class="form-label">Brand *</label>
                                    <div>
                                        <select class="form-select default-select-single" 
                                        name="brand_id" id="merchantBrand" style="width: 100%;"
                                        required>
                                            <option>Select</option>
                                            @foreach ($brands as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="brandHelp" class="Help form-text text-danger d-none">
                                        Please choose brand.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-12">
                                <div class="mb-3 container-count">
                                    <label for="storeName" class="form-label">Store Name * </label>
                                    <div class="form-text input-count me-3">
                                        <span id="countNow">0</span> / 40
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="name" 
                                        id="inputCount" autofocus maxlength="40" required 
                                        autocomplete="off">
                                        <div id="storeNamepHelp" class="Help form-text text-danger d-none">
                                            Error message here.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="storeNumber" class="form-label">Phone number *</label>
                                    <input type="text" class="form-control noArrow phone_with_ddd" 
                                    name="phone_number" id="storeNumber" required autocomplete="off">
                                    <div id="storeNumberHelp" class="Help form-text text-danger d-none">
                                        Error message here.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-12">
                                <div class="mb-3">
                                    <label for="storeName" class="form-label">Timezone *</label>
                                    <div>
                                        <select class="form-select default-select-single" 
                                        name="timezone" id="merchantTimezone" style="width: 100%;"
                                        required>
                                        <option>Select</option>
                                        @foreach ($timezonelist as $item)
                                            <option value="{{$item}}">
                                                {{$item}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="timezoneHelp" class="Help form-text text-danger d-none">
                                            Please choose timezone.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="storeName" class="form-label">Currency *</label>
                                    <div>
                                        <select class="form-select default-select-single" name="currency"
                                            id="merchantCurrencies" style="width: 100%;"
                                            required>
                                            <option>Select</option>
                                            @foreach ($currencies as $item)
                                                <option value="{{$item['iso']['code']}}">
                                                    {{$item['name']}}({{$item['iso']['code']}})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="currenciesHelp" class="Help form-text text-danger d-none">
                                            Please choose currencies.
                                        </div>
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
                                    <textarea class="form-control" name="description" id="description" 
                                    rows="2" autofocus maxlength="300" required></textarea>
                                    <div id="descriptionHelp" class="Help form-text text-danger d-none">
                                        Error message here.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="storeName" class="form-label">COVER IMAGE</label>
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
                                    <div id="imageHelp" class="Help form-text text-danger d-none">
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
                <!-- // -->

                <!-- -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><h6 class="m-0">Store Address *</h6></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 d-none">
                                <div class="mb-3 search-box">
                                    <div class="form-group has-search">
                                        <input type="text" class="form-control" id="location-store" 
                                        placeholder="Type to search a location" autocomplete="off" />
                                        <span class="fa fa-search form-control-feedback"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-none">
                                <div class="mb-3 text-center">
                                    -- or --
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <select class="form-select default-select-single" id="storeLocation"
                                        name="storeLocation" style="width: 100%;">
                                            <option value="Select">Select Location *</option>
                                            @foreach ($locations as $item)
                                                <option value="{{$item}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <div id="locationHelp" class="Help form-text text-danger d-none">
                                            Please choose location.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="storeAddr" class="form-label">Street Address</label>
                                    <input type="text" class="form-control" name="address" 
                                    id="storeAddr" autocomplete="off">
                                    <div id="storeAddrHelp" class="Help form-text text-danger d-none">
                                        Error message here.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="storeBulding" class="form-label">
                                        Building/suite
                                    </label>
                                    <input type="text" class="form-control" 
                                    name="building_suite" id="storeBulding" 
                                    autocomplete="off">
                                    <div id="storeBuldingHelp" class="Help form-text text-danger d-none">
                                        Error message here.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="storeCity" class="form-label">City</label>
                                    <input type="text" class="form-control" name="city" id="storeCity" 
                                    autocomplete="off">
                                    <div id="storeCityHelp" class="Help form-text text-danger d-none">
                                        Error message here.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="storeState" class="form-label">State</label>
                                    <input type="text" class="form-control" name="state" id="storeState" 
                                    autocomplete="off">
                                    <div id="storeStateHelp" class="Help form-text text-danger d-none">
                                        Error message here.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="storePostal" class="form-label">Postcode</label>
                                    <input type="number" class="form-control noArrow numbers" 
                                    name="postal_code" 
                                    id="storePostal" autocomplete="off">
                                    <div id="storePostalHelp" class="Help form-text text-danger d-none">
                                        Error message here.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="merchantCountry" class="form-label">Country *</label>                                            
                                    <select class="form-select" id="merchantCountry" 
                                    name="country" style="width: 100%;" required>
                                        <option>Select</option>
                                        @foreach ($countries as $country)
                                            <option value="{{$country}}">{{$country}}</option>
                                        @endforeach
                                    </select>
                                    <div id="countryHelp" class="Help form-text text-danger d-none">
                                        Please choose country.
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
                            <div><h6 class="m-0">Fulfilment</h6></div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            Set up and configure order types to suit the needs of your business.
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="fw-bold">Delivery ordering</div>
                                        <div id="message-delivery-status">
                                            <span class="badge bg-label-warning text-warning">
                                                disabled
                                            </span>
                                        </div>
                                    </div>
                                    Let customers place orders to be delivered to their address.
                                    <div class="d-grid mt-3">
                                        <button type="button" class="btn btn-outline-primary" 
                                        data-bs-target="#modalSetupDelivery" 
                                        data-bs-toggle="modal" data-bs-dismiss="modal">Configure</button>
                                    </div>
                                    <div id="delivery_optionHelp" class="Help form-text text-danger d-none">
                                        Please choose delivery method if you support delivery.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="fw-bold">Pick-up ordering</div>
                                        <div id="message-pickup-status">
                                            <span class="badge bg-label-warning text-warning">
                                                disabled
                                            </span>
                                        </div>
                                    </div>
                                    Let customers place orders that they pick up from your store.
                                    <div class="d-grid mt-3">
                                        <button type="button" class="btn btn-primary" 
                                        data-bs-target="#modalSetupPickup"
                                        data-bs-toggle="modal" data-bs-dismiss="modal">
                                            <i class="fas fa-cog"></i> Setup
                                        </button>
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
                            <div><h6 class="m-0">Integrations</h6></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <label for="flexSwitchCheckDefault" class="form-label">
                                    Sent Order to Lodi
                                </label>
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="sent_order_to_lodi" 
                                        value="1" type="checkbox" id="flexSwitchCheckDefault">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="mb-3">
                                    <label for="warehouseID" class="form-label">
                                        Warehouse ID
                                    </label>
                                    <input type="text" class="form-control text-uppercase regex-sku" 
                                    name="warehouse_id" id="warehouseID" autocomplete="off">
                                    <div id="storeBuldingHelp" class="form-text text-danger d-none">
                                        Error message here.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                                <div class="mb-3">
                                    <div class="mb-2 small">Get insights into the market and make smart 
                                        business decisions with Google’s next-generation measurement solution. 
                                        <a href="https://support.google.com/analytics/answer/10089681" target="_blank">
                                            Learn more about Google Analytics.
                                        </a>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="gaAppCredential" class="form-label" style="font-size: 10px">
                                                Google Application Credential (.json)
                                            </label>
                                            <input type="file" name="ga_app_credential_json" class="form-control" 
                                            id="gaAppCredential" autocomplete="off" accept=".json">
                                            <div id="storeBuldingHelp" class="form-text text-danger d-none">
                                                Error message here.
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <label for="gaCode" class="form-label">Google Analytics 4</label>
                                            <input type="text" name="ga_code" class="form-control text-uppercase" 
                                            id="gaCode" autocomplete="off" placeholder="G-">
                                            <div id="storeBuldingHelp" class="form-text text-danger d-none">
                                                Error message here.
                                            </div>
                                        </div>
                                        <div class="col-4"><label for="propertyId" class="form-label">Property Id</label>
                                            <input type="number" class="form-control noArrow numbers" name="ga_property_id"
                                            id="propertyId" autocomplete="off" placeholder="123...">
                                            <div id="storeBuldingHelp" class="form-text text-danger d-none">
                                                Error message here.
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
                <a href="#" class="btn btn-outline-light" id="btnCancelManageStore">
                    Cancel
                </a>
                <button type="submit" class="btn btn-light">Save</button>
            </div>
        </div>
    </div>
    <!-- //THE BUTTON -->


<!--
    =============================================
    Modals
    =============================================
-->

{{-- modal fulfilment --}}
<div class="modal fade right" id="modalSetupDelivery" tabindex="-1" 
aria-labelledby="modalSetupPickUp" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header border-bottom pb-3">
            <h5 class="modal-title">Manage store / Configure</h5>
        </div>
        <div class="modal-body ps-4 bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-bold">Enable delivery ordering</div>
                    <div>Allow customers to place orders for delivery to their preferred address.</div>
                </div>
                <div>
                    <div class="form-check form-switch">
                        {{-- toggle support_deliveries --}}
                        <input class="form-check-input toggle-delivery" type="checkbox" 
                        name="support_delivery" value="1">
                        <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                    </div>
                </div>
            </div>
            <div class="fw-bold text-muted my-3">Options</div>
                <div class="accordion" id="listOptions">
                    <div class="card accordion-item shadow-none border">
                        <h2 class="accordion-header" id="headingOne">
                            <button type="button" class="accordion-button justify-content-between 
                            collapsed" 
                            data-bs-toggle="collapse" data-bs-target="#accordionOne" 
                            aria-expanded="false" 
                            aria-controls="accordionOne">
                                <div>Delivery Method</div> 
                                {{-- <div class="me-2">In-house</div> --}}
                            </button>
                        </h2>
                        <div id="accordionOne" class="accordion-collapse collapse" 
                        data-bs-parent="#listOptions" style="">
                            <div class="accordion-body">
                                @foreach ($arvi_deliveries as $item)
                                @if ($item->name != 'Pick Up')
                                    
                                <div class="form-check mb-2">
                                    <input name="delivery_option" class="form-check-input delivery_option" 
                                    type="checkbox" value="{{$item->id}}" id="delivery{{$item->id}}">
                                    <label class="form-check-label" for="delivery{{$item->id}}">
                                        {{$item->name}}
                                        <div>Orders will be delivered by {{$item->name}}.</div>
                                    </label>
                                    <input type="text" name="delivery_option_id" 
                                    class="form-control form-control-sm 
                                    w-f120 delivery_option_id mb-2" placeholder="Transporter ID" >
                                    <label class="form-check-label">
                                        <div>Service type :</div>
                                    </label>
                                    @foreach ($item->arviSubDelivery as $sub)
                                    <div class="form-check mb-2 ms-4 sub_option">
                                        <label class="form-check-label text-nowrap" 
                                        for="sub-delivery{{$sub->id}}">
                                            <input name="sub_delivery_option" 
                                            class="form-check-input sub_delivery_option" 
                                            type="checkbox" value="{{$sub->id}}" 
                                            data-delivery="{{$item->id}}"
                                            id="sub-delivery{{$sub->id}}">
                                            {{$sub->name}}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                                <hr>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card accordion-item shadow-none border">
                        <h2 class="accordion-header" id="headingTwo">
                            <button type="button" class="accordion-button justify-content-between collapsed" 
                            data-bs-toggle="collapse" data-bs-target="#accordionTwo" aria-expanded="false" 
                            aria-controls="accordionTwo">
                                <div>Delivery Area</div> 
                                {{-- <div class="me-2">3 km</div> --}}
                            </button>
                        </h2>
                        <div id="accordionTwo" class="accordion-collapse collapse" 
                        data-bs-parent="#listOptions">
                            <div class="accordion-body">
                                <div>Set the maximum straight line distance that you will deliver orders to. 
                                    This distance forms the delivery area radius around your store.</div>
                                <div class="mt-3">
                                    <label for="km" class="form-label">Maximum delivery distances</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control noArrow" name="range_area"
                                        value="{{isset($merchantDelivery->range_area)?
                                        $merchantDelivery->range_area:''}}">
                                        <span class="input-group-text">km</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card accordion-item shadow-none border">
                        <h2 class="accordion-header" id="headingThree">
                            {{-- toggle support_delivery_min_order_amount --}}
                            <button type="button" class="accordion-button justify-content-between 
                            collapsed" data-bs-toggle="collapse" data-bs-target="#accordionThree" 
                            aria-expanded="false" aria-controls="accordionThree">
                                <div>Minimum order amount</div> 
                                {{-- <div class="me-2">Rp 50.000</div> --}}
                            </button>
                        </h2>
                        <div id="accordionThree" class="accordion-collapse collapse" 
                        data-bs-parent="#listOptions" style="">
                            <div class="accordion-body">
                                <div class="form-check">
                                    <input class="form-check-input toggle-minimum-order-delivery" 
                                    type="checkbox" name="support_delivery_min_order_amount" 
                                    value="1" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Require a minimum amount for orders to be eligible for delivery
                                    </label>
                                </div>
                                <div class="mt-2 hidden toggle-minimum-order-info-delivery">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp. </span>
                                        <input type="text" class="form-control noArrow numbers"
                                        name="min_order_amount" 
                                        value="{{isset($merchantDelivery->delivery_min_order_amount)?
                                        $merchantDelivery->delivery_min_order_amount:''}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card accordion-item shadow-none border">
                        <h2 class="accordion-header" id="headingFour">
                            <button type="button" 
                            class="accordion-button collapsed" data-bs-toggle="collapse" 
                            data-bs-target="#accordionFour" aria-expanded="false" 
                            aria-controls="accordionFour">
                                Delivery fee
                            </button>
                        </h2>
                        <div id="accordionFour" class="accordion-collapse collapse" 
                        data-bs-parent="#listOptions">
                            <div class="accordion-body">
                                <div>Cover the cost of delivery by adding a customisable fee 
                                    to delivery orders. 
                                    This fee only applied for 
                                    <span class="fw-bold">In-house delivery method</span>. 
                                    Others delivery method, the fee will be calculated by system.
                                </div>
                                <div class="d-grid mt-3">
                                    <button type="button" class="btn btn-outline-primary"
                                    id="fee-list">
                                        Add delivery fee
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-secondary" 
                data-bs-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade right" id="modalSetupPickup" tabindex="-1" 
aria-labelledby="modalSetupPickup" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title">Manage store / Configure</h5>
            </div>
            <div class="modal-body ps-4 bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold">Enable pick-up ordering</div>
                        <div>Allow customers to place orders for collection from your store.</div>
                    </div>
                    <div>
                        <div class="form-check form-switch">
                            {{-- toggle support_pickup --}}
                            <input class="form-check-input toggle-pickup" type="checkbox"
                            name="support_pickup" value="1">
                            <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                        </div>
                    </div>
                </div>
                <div class="fw-bold text-muted my-3">Options</div>
                <div class="accordion" id="listOptions-2">
                    <div class="card accordion-item shadow-none border">
                        <h2 class="accordion-header" id="headingThree">
                            <button type="button" class="accordion-button 
                            justify-content-between collapsed" 
                            data-bs-toggle="collapse" data-bs-target="#accordionThree" 
                            aria-expanded="false" 
                            aria-controls="accordionThree">
                                <div>Minimum order amount</div> 
                                {{-- <div class="me-2">Rp 50.000</div> --}}
                            </button>
                        </h2>
                        <div id="accordionThree" class="accordion-collapse collapse" 
                        data-bs-parent="#listOptions-2" style="">
                            <div class="accordion-body">
                                <div class="form-check">
                                    {{-- toggle support_pickup_min_order_amount --}}
                                    <input class="form-check-input toggle-minimum-order-pickup" 
                                    type="checkbox" 
                                    name="support_pickup_min_order_amount" value="1" id="defaultCheck2">
                                    <label class="form-check-label" for="defaultCheck2">
                                        Require a minimum amount for orders to be eligible for delivery
                                    </label>
                                </div>
                                <div class="mt-2 hidden toggle-minimum-order-info-pickup">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp. </span>
                                        <input type="text" class="form-control noArrow numbers"
                                        name="pickup_min_order_amount">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-secondary" 
                data-bs-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>

</form>

<!-- Modal upload -->
<div class="modal fade" id="modalUpload" tabindex="-1" 
aria-labelledby="modalUpload" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header border-bottom pb-3">
        <h5 class="modal-title">Add image</h5>
        </div>
        <div class="modal-body center">
        
        <div class="fw-bold">Upload from your computer</div>
        <div class="small">PNG or JPG. Recommended at least 1500 x 500 pixels (minimum 900 x 300). 
            Photo should be clear and original and does not contain your logo.</div>
        <div><input type="text" id="uploads" value="" /></div>
        
        </div>
        <div class="modal-footer border-top pb-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
        </div>
    </div>
    </div>
</div>

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
                    placeholder="Username" aria-label="Username" 
                    aria-describedby="basic-addon1">
                </div>

            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-link" 
                data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" 
                id="add-social-icon">Add social icon</button>
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

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>

    // storeLocation
    $("select[name='storeLocation']").on('click change',function () {
        if ($(this).val() != 'Select') {
            dataLocation = JSON.parse($(this).val());
            $("input[name='address']").val(dataLocation['address']);
            $("input[name='building_suite']").val(dataLocation['building_suite']);
            $("input[name='city']").val(dataLocation['city']);
            $("input[name='state']").val(dataLocation['state']);
            $("input[name='postal_code']").val(dataLocation['postal_code']);
            let country = dataLocation['country'];
            if (country != '') {
                $(`#merchantCountry option[value="${country}"]`).attr('selected','selected');
            }
        }
    })

    // check delivery support
    $('.toggle-delivery').on('click',function () {
        if($('.toggle-delivery').is(':checked')){
            $('#message-delivery-status').html(
                `<div class="small"><span class="badge bg-label-success text-secondary">
                <i class="fas fa-check"></i> Enabled</span></div>`);
        }else{
            $('#message-delivery-status').html(
                `<div class="small"><span class="badge bg-label-warning text-warning">
                disabled</span></div>`);
        }
    })
    $('.toggle-pickup').on('click',function () {
        if($('.toggle-pickup').is(':checked')){
            $('#message-pickup-status').html(
                `<div class="small"><span class="badge bg-label-success text-secondary">
                <i class="fas fa-check"></i> Enabled</span></div>`);
        }else{
            $('#message-pickup-status').html(
                `<div class="small"><span class="badge bg-label-warning text-warning">
                disabled</span></div>`);
        }
    })
    
    // fees click
    $('#fee-list').on('click',function () {
        $('#modalSetupDelivery').modal('hide');
        $('#fees-button').trigger('click')
    })

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
        $('#manage-store-button').trigger("click");
    })
    
    // submit form edit product
    $('#manageStore').on('submit',function () {
        if (!$('#modalSetupPickup,#modalSetupDelivery').is(':visible')) {
            event.preventDefault();
            $('.Help').addClass('d-none');
            if ($("select#merchantBrand").val() == 'Select') {
                $('#brandHelp').removeClass('d-none');
            }else if ($("select#merchantTimezone").val() == 'Select') {
                $('#timezoneHelp').removeClass('d-none');                
            }else if ($("select#merchantCurrencies").val() == 'Select') {
                $('#currenciesHelp').removeClass('d-none');                
            }else if ($("select#storeLocation").val() == 'Select') {
                $('#locationHelp').removeClass('d-none');                
            }else if ($("select#merchantCountry").val() == 'Select') {
                $('#countryHelp').removeClass('d-none');            
            } else {
                if($("input[name='support_delivery']").is(':checked')){
                    $('#delivery_optionHelp').addClass('d-none');

                    // get data delivery option
                    var delivery_options = $("input[name='delivery_option']:checked")
                    .map(function(){
                        return this.value;
                    }).get();
                    var delivery_option_ids = $("input[name='delivery_option']:checked")
                    .siblings(".delivery_option_id").map(function(){
                        return this.value;
                    }).get(delivery_option_ids);

                    // combine main delivery with transporter_id
                    const deliveries = [];
                    for (let index = 0; index < delivery_options.length; index++) {
                        deliveries.push({
                            'delivery_id':delivery_options[index],
                            'transporter_id':delivery_option_ids[index],
                        })
                    }

                    // get data service delivery option
                    const sub_deliveries = [];
                    $("input[name='delivery_option']:checked").siblings(".sub_option")
                    .find("input[name='sub_delivery_option']:checked").map(function () {
                        sub_deliveries.push({
                            'delivery_id':this.dataset.delivery,
                            'sub_delivery_id':this.value,
                            'transporter_id':deliveries.find((element) =>
                            element.delivery_id === this.dataset.delivery).transporter_id
                        });
                    });

                    if (sub_deliveries.length > 0) {
                        let locationId = JSON.parse($("select[name='storeLocation']")
                        .val())['id'];
                        var formData = new FormData(this);
                        formData.append("sub_deliveries", JSON.stringify(sub_deliveries));
                        formData.append("locationId", JSON.stringify(locationId));
                        $.ajax({
                            type:'POST',
                            url: "{{ route('manage-store-store',['companyCode' => $companyCode]) }}",
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data) {
                                $('#manage-store-button').trigger("click");
                            },
                            error: function (data) {
                                console.log(data);
                            }
                        })
                    }else{
                        $('#delivery_optionHelp').removeClass('d-none');
                    }
                }else{
                    let locationId = JSON.parse($("select[name='storeLocation']")
                    .val())['id'];
                    var formData = new FormData(this);
                    formData.append("locationId", locationId);
                    $.ajax({
                        type:'POST',
                        url: "{{ route('manage-store-store',['companyCode' => $companyCode]) }}",
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            $('#manage-store-button').trigger("click");
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    })
                }                
            }
        }
    })
</script>