<!-- Content wrapper -->
<div class="content-wrapper">
    
    <form id="manageStore" autocomplete="off">
        @csrf
        <div class="container-xxl flex-grow-1 container-p-y">
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
                                    <span class="text-muted">Manage Company</span> / Company Details</h4>
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
                                    <div class="mb-3 container-count">
                                        <label for="companyName" class="form-label">
                                            Company Name * 
                                        </label>
                                        <div class="form-text input-count me-3">
                                            <span id="countNow">0</span> / 100
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="inputCount" 
                                            name="name" autofocus maxlength="100" required autocomplete="off">
                                            <div id="storeNamepHelp" class="form-text text-danger d-none">
                                                Error message here.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="companyEmail" class="form-label">
                                            Email Address *
                                        </label>
                                        <input type="email" class="form-control " id="companyEmail" 
                                        name="email" required autocomplete="false">
                                        <div id="storeNumberHelp" class="form-text text-danger d-none">
                                            Error message here.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="companyNumber" class="form-label">
                                            Phone number *
                                        </label>
                                        <input type="text" class="form-control noArrow phone_with_ddd" 
                                        name="phone_number" id="companyNumber" required autocomplete="off">
                                        <div id="storeNumberHelp" class="form-text text-danger d-none">
                                            Error message here.
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
                                <div><h6 class="m-0">Company Address </h6></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3 search-box">
                                        <div class="form-group has-search">
                                            <input type="text" class="form-control" id="location-store" 
                                            placeholder="Type to search a location" 
                                            autocomplete="off" />
                                            <span class="fa fa-search form-control-feedback"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="companyAddr" class="form-label">Street Address</label>
                                        <input type="text" class="form-control" id="companyAddr" 
                                        name="street_address" autocomplete="off" >
                                        <div id="companyAddrHelp" class="form-text text-danger d-none">
                                            Error message here.</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="companyBulding" class="form-label">Builidng/suite</label>
                                        <input type="text" class="form-control" id="companyBulding" 
                                        name="building_suite" autocomplete="off" >
                                        <div id="companyBuldingHelp" class="form-text text-danger d-none">
                                            Error message here.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="storeCity" class="form-label">City</label>
                                        <input type="text" class="form-control" id="storeCity" 
                                        name="city" autocomplete="off" >
                                        <div id="storeCityHelp" class="form-text text-danger d-none">
                                            Error message here.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="companyState" class="form-label">State</label>
                                        <input type="text" class="form-control" id="companyState" 
                                        name="state" autocomplete="off" >
                                        <div id="companytateHelp" class="form-text text-danger d-none">
                                            Error message here.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="companyPostal" class="form-label">Postcode</label>
                                        <input type="number" class="form-control noArrow numbers" 
                                        name="postal_code" id="companyPostal" autocomplete="off" >
                                        <div id="companyPostalHelp" class="form-text text-danger d-none">
                                            Error message here.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="companyCountry" class="form-label">Country</label>
                                        <div>
                                            <select class="form-select default-select-single" id="brand-country"
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
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- // -->
                    
                    <!-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div><h6 class="m-0">Status</h6></div>
                            </div>
                            <hr>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" 
                                id="status1" value="approved" name="status">
                                <label class="form-check-label" for="status1">Approved</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" 
                                id="status2" value="reject" name="status">
                                <label class="form-check-label" for="status2">Reject</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        
        <!-- THE BUTTON -->
        <div class="mt-5">&nbsp;</div>
        <div class="bg-primary fixed-bottom" style="z-index: 0 !important; 
        display: none;" id="containerButton">
            <div class="d-flex justify-content-between align-items-center p-3">
                <div class="text-white"></div>
                <div>
                    <a href="#" class="btn btn-outline-light" id="btnCancel">Cancel</a>
                    <button type="submit" class="btn btn-light" >Save</button>
                </div>
            </div>
        </div>
        <!-- //THE BUTTON -->
    </form>
</div>

<script src="/arvi/backend-assets/js/demo.js"></script>
<script>
    // button cancel
    $('#btnCancel, #btnback').on('click',function () {
        $('#manage-company').trigger("click");
    })

    // submit form
    $('#manageStore').on('submit',function () {
        event.preventDefault();

        if (!$('#countryHelp').hasClass('d-none')) {
            $('#countryHelp').addClass('d-none');
        } else {
            $.ajax({
                type: 'POST',
                url: "{{ route('company-store',['companyCode' => $companyCode]) }}",
                data: $(this).serialize(),
                success: function (data) {
                    $('#manage-company').trigger("click");
                },
                error: function (data) {
                    console.log(data.responseJSON.message);
                }
            })
        }
    });
</script>
