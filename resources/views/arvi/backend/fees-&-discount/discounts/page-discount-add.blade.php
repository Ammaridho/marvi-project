<!-- Content wrapper -->
<div class="content-wrapper">

    <form id="manageStore" method="" action="">
        <div class="row justify-content-start">
            <div class="col-lg-2 col-md-2 col-12 mb-3">
                &nbsp;
            </div>
            <div class="col-lg-7 col-md-8 col-12">
            
                <!-- -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><h4 class="m-0"><span class="text-muted">Discounts</span> / Add Discount</h4></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="inputCount1" class="form-label">Discount Name</label>
                                    <div class="form-text input-count me-3"><span>0</span> / 25</div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control input-counter" 
                                        name="name" id="inputCount1" autofocus maxlength="25">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="storeName" class="form-label">Message</label>
                                    <div class="form-text input-count me-3"><span>0</span> / 120</div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control input-counter" 
                                        name="message" id="inputCount2" autofocus maxlength="120">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="mb-3">
                                            <label for="storeName" class="form-label">Type</label>
                                            <div class="mt-1">
                                                <div class="form-check-inline mb-2">
                                                    <input class="form-check-input" type="radio" id="defaultCheck1" 
                                                    name="type" value="precentage">
                                                    <label class="form-check-label" for="defaultCheck1">Percectage </label>
                                                </div>
                                                <div class="form-check-inline mb-2">
                                                    <input class="form-check-input" type="radio" id="defaultCheck2" 
                                                    id="type" name="type" value="amount">
                                                    <label class="form-check-label" for="defaultCheck2"> Amount </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label for="storeName" class="form-label">Value</label>
                                            <input type="number" class="form-control noArrow numbers" id="" autofocus maxlength="25" value="value">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label for="storeName" class="form-label d-block">Minimum purchase  
                                                <div class="float-end">
                                                    <a href="javascript:void(0)" data-bs-trigger="focus" data-bs-container="body" 
                                                        data-bs-toggle="popover" data-bs-placement="left" data-bs-content="Field can be empty">
                                                        <i class="fas fa-question-circle text-secondary"></i>
                                                    </a>
                                                </div>
                                            </label>
                                            <input type="number" class="form-control noArrow numbers" id="" value="min_purchase">
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
                            <div class="fw-bold">Date</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="s-date" class="form-label">Start date</label>
                                    <input type="text" class="form-control single-date" id="s-date" name="start_date">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="e-date" class="form-label">End date</label>
                                <input type="text" class="form-control single-date" id="e-date" name="end_date">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- // -->

                <!-- -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Restrictions</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check mb-2">
                                    <input name="restriction" class="form-check-input option-discounts" 
                                    type="radio" value="no restriction" id="defaultRadio1" checked="">
                                    <label class="form-check-label" for="defaultRadio1"> No restriction </label>
                                </div>

                                <!-- discount model -->
                                <div class="form-check mb-2">
                                    <input name="restriction" class="form-check-input option-discounts" 
                                    type="radio" value="free-delivery" id="defaultRadio2">
                                    <label class="form-check-label" for="defaultRadio2"> Free product</label>
                                    <div class="hidden box free-delivery">
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="mb-3 mt-2">
                                                    <select class="form-select default-select-single" 
                                                    name="productDiscount" style="width: 100%;">
                                                        <option>Select</option>
                                                        <option value="">Nasi Ayam Sambal Ijo</option>
                                                        <option value="">Nasi Bebek Sambal Merah</option>
                                                        <option value="">Ayam Bakar Taliwang</option>
                                                        <option value="">Nasi Bebek Sambal Merah</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- //discount model -->

                                <!-- discount model -->
                                <div class="form-check mb-2">
                                    <input name="restriction" class="form-check-input option-discounts" 
                                    type="radio" value="delivery-discount" id="defaultRadio4">
                                    <label class="form-check-label" for="defaultRadio4"> Delivery Discount </label>
                                        
                                    <div class="box hidden delivery-discount">
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="mb-3 mt-2">
                                                    <div>
                                                        <select class="form-select default-select-single" 
                                                        name="delivertDiscount" style="width: 100%;">
                                                            <option>Select</option>
                                                            <option value="">GoSend</option>
                                                            <option value="">GrabExpress</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- //discount model -->

                            </div>
                        </div>
                    </div>
                </div>
                <!-- // -->

                <!-- -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Discount Code</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check mb-2">
                                    <input name="discount_code_type" class="form-check-input option-discounts" 
                                    type="radio" value="none" id="defaultRadio1" checked="">
                                    <label class="form-check-label" for="defaultRadio1"> No restriction </label>
                                </div>

                                <!-- promo code -->
                                <div class="form-check mb-2">
                                    <input name="discount_code_type" class="form-check-input option-promo-code" 
                                    type="radio" value="general" id="promo2">
                                    <label class="form-check-label" for="promo2"> General code</label>
                                        
                                    <div class="hidden box2 general">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="mb-3">
                                                    <label for="storeName" class="form-label">Discount Code</label>
                                                    <input type="text" class="form-control" id="">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-3">
                                                    <label for="storeName" class="form-label d-block">Maximum Code Used 
                                                        <div class="float-end">
                                                            <a href="javascript:void(0)" data-bs-trigger="focus" data-bs-container="body" 
                                                            data-bs-toggle="popover" data-bs-placement="left" data-bs-content="Field can be empty">
                                                                <i class="fas fa-question-circle text-secondary"></i>
                                                            </a>
                                                        </div>
                                                    </label>
                                                    <input type="number" class="form-control noArrow numbers" id="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- //promo code -->

                                <!-- promo code -->
                                <div class="form-check mb-2">
                                    <input name="discount_code_type" class="form-check-input option-promo-code" type="radio" value="unique" id="promo3">
                                    <label class="form-check-label" for="promo3"> Unique code</label>
                                        
                                    <div class="hidden box2 unique mt-2">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="mb-3">
                                                <label for="storeName" class="form-label d-block">codes <div class="float-end"><a href="#" 
                                                    class="text-primary small">Download template</a></div></label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" id="inputGroupFile02" accept=".xlsx, .xls, .csv" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-3">
                                                    <label for="storeName" class="form-label d-block">Maximum Code Used 
                                                        <div class="float-end">
                                                            <a href="javascript:void(0)" data-bs-trigger="focus" data-bs-container="body" 
                                                            data-bs-toggle="popover" data-bs-placement="left" data-bs-content="Field can be empty">
                                                                <i class="fas fa-question-circle text-secondary"></i>
                                                            </a>
                                                        </div>
                                                    </label>
                                                    <input type="number" class="form-control noArrow numbers" id="">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="alert alert-secondary small" role="alert">171 code uploaded.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- //promo code -->

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

</div>
<!-- Content wrapper -->

<script src="/arvi/backend-assets/js/demo.js"></script>