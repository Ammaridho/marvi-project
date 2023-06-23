{{-- <div id="delop"> --}}
    <section class="section deliverOption" id="section-1">
        <div class="wrap">
          <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-12 col-md-8">

                  <div id="lertRec">
                    <h4 class="text-center">Please choose receive method!</h4>
                  </div>

                  <!--
                    Show this section where user ask for delivery
                  -->
                  <div id="pod" class="d-none">
                    <h4>What's the delivery address?</h4>
                    <div class="f-14">Delivery fee is $10. Free delivery for orders above $75.</div>
                    <div class="mt-3">
                      <input type="text" autocomplete="off" class="inline-form vf-em-el" 
                      id="addr" name="addr" placeholder="Enter here">
                    </div>
                    <div class="mt-3">
                      <a id="submitDel" class="btn btn-theme-secondary text-white 
                      inputAddress inputData arrowDownSm">Next</a>
                    </div>
                    <div id="alertDel" class="muted text-danger mt-3 d-none">Please fill address</div>
                  </div>

                  <!--
                    Show this section where user ask for pickup
                  -->
                  <div id="pop" class="d-none">
                    <h4>Where will you pickup this package?</h4>
                    <div class="mt-3">
                      <div class="form-group choosePickup">
                          <label id="submitPickUp" class="option-radio-selection 
                          pickup shadow-sm mb-3 inputData">
                          <input class="inputData arrowDownSm" type="radio" name="pickup" 
                          value="{{ $merchant->name }} at {{$merchant->address}}" />
                          <div>{{ $merchant->name }}<br />{{$merchant->address}}</div>
                          </label>
                      </div>
                    </div>
                  </div>

                </div>
            </div>
          </div>
        </div>
      </section>
    {{-- </div> --}}