<form id="manageStore" autocomplete="off">
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
                    <h4 class="m-0">
                        <span class="text-muted">Manage Location</span> / Location Details
                    </h4>
                    <div>
                        <a href="javascript:void(0);" id="btnback">
                            <i class="fas fa-chevron-left"></i> back
                        </a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3 container-count">
                            <label for="locName" class="form-label">Location Name * </label>
                            <div class="form-text input-count me-3"><span id="countNow">0</span> / 40</div>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="name" id="inputCount" 
                                autofocus maxlength="40" required autocomplete="off">
                                <div id="storeNamepHelp" class="form-text text-danger d-none">
                                    Error message here.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-none">
                        <div class="mb-3 search-box">
                            <div class="form-group has-search">
                                <input type="text" class="form-control" id="location-store" 
                                placeholder="Type to search a location" autocomplete="off" />
                                <span class="fa fa-search form-control-feedback"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="mb-3">
                            <label for="locAddr" class="form-label">Street Address *</label>
                            <input type="text" class="form-control" name="street_address" 
                            id="locAddr" required autocomplete="off" >
                            <div id="locAddrHelp" class="form-text text-danger d-none">
                                Error message here.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="mb-3">
                            <label for="locBulding" class="form-label">Building/suite *</label>
                            <input type="text" class="form-control" name="building_suite" 
                            id="locBulding" required autocomplete="off" >
                            <div id="locBuldingHelp" class="form-text text-danger d-none">
                                Error message here.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="mb-3">
                            <label for="locCity" class="form-label">City *</label>
                            <input type="text" class="form-control" name="city" id="locCity" 
                            required autocomplete="off" >
                            <div id="locCityHelp" class="form-text text-danger d-none">
                                Error message here.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="mb-3">
                            <label for="logState" class="form-label">State</label>
                            <input type="text" class="form-control" name="state" id="logState" 
                            autocomplete="off" >
                            <div id="logStateHelp" class="form-text text-danger d-none">
                                Error message here.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="mb-3">
                            <label for="logPostal" class="form-label">Postcode *</label>
                            <input type="number" class="form-control noArrow numbers" 
                            name="postal_code" id="logPostal" required autocomplete="off" >
                            <div id="logPostalHelp" class="form-text text-danger d-none">
                                Error message here.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="mb-3">
                            <label for="locationCountry" class="form-label">Country *</label>                                            
                            <select class="form-select default-select-single" id="locationCountry" 
                            name="country" style="width: 100%;" required>
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
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="mb-3">
                            <label for="latLat" class="form-label">Latitude *</label>
                            <input type="text" class="form-control noArrow number-lat-lon" 
                            name="lat" required autocomplete="off" >
                            <div id="latLatHelp" class="form-text text-danger d-none">
                                Error message here.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="mb-3">
                            <label for="logLat" class="form-label">Longitude *</label>
                            <input type="text" class="form-control noArrow number-lat-lon" 
                            name="lon" required autocomplete="off" >
                            <div id="logLatHelp" class="form-text text-danger d-none">
                                Error message here.
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
                            <textarea class="form-control" id="description" name="description" 
                            rows="2" autofocus maxlength="300"></textarea>
                            <div id="descriptionHelp" class="form-text text-danger d-none">
                                Error message here.
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="storeCategories" class="form-label">Location Type *</label>
                            <div>
                                <select class="form-select store-categories" name="storeCategories" 
                                style="width: 100%;" required>
                                    <optgroup label="Location type">
                                        <option>Office Building</option>
                                        <option>Hospital</option>
                                        <option>Mall</option>
                                        <option>Restaurant</option>
                                        <option>Cloud Kitchen</option>
                                        <option>Pop-ups</option>
                                        <option>Food Truck</option>
                                        <option>Cafe</option>
                                        <option>Fast Food</option>
                                        <option>Food Court</option>
                                        <option>School/College</option>
                                        <option>Public Area</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div id="storeCategories" class="form-text">
                                Select up to a maximum of 5 location type.
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div>Maximum accept orders radius *</div> 
                        <div class="me-2" id="set-radius"></div>
                        <div style="font-size: 13">Set the maximum straight line distance that you will accept orders to. 
                            This distance forms the accepted area radius around location.</div>
                        <div class="input-group">
                            <input type="text" class="form-control noArrow numbers" 
                            name="loc_aware_tolerance" aria-label="" required>
                            <span class="input-group-text">meters</span>
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

{{-- script plugin --}}
<script type="text/javascript" src="/arvi/backend-assets/js/demo.js"></script>

<script>
    
    // button cancel
    $('#btnCancelManageStore, #btnback').on('click',function () {
        $('#manage-location-admin').trigger("click");
    })

    // submit form
    $('#manageStore').on('submit',function () {
        event.preventDefault();
        $('#countryHelp').addClass('d-none');
        if ($("select#locationCountry").val() == 'Select') {
            $('#countryHelp').removeClass('d-none');
        } else {
            storeCategoriesData = JSON.stringify($("select[name='storeCategories']").val());
            $.ajax({
                type: 'POST',
                url: "{{ route('location-store',['companyCode' => $companyCode]) }}",
                data: $(this).serialize() + `&storeCategoriesData=${storeCategoriesData}`,
                success: function (data) {
                    $('#manage-location-admin').trigger("click");
                },
            })
        }
    });
</script>