<section class="section">
    <div class="wrap">
      <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center" id="id-payment-pane">
            <div class="col-12 col-md-8">
              <h4>How would you like to make payment?</h4>
              <div class="mt-3">
                @foreach ($payments as $item)
                  <div class="form-group">
                      <!-- <label class="option-radio-selection shadow-sm mb-3">
                        <input class="pay-m submit" type="radio" name="pay" value="{{$item->id}}" /> -->
                      <label class="option-radio-selection shadow-sm mb-3">
                          <input class="pay-m arrowDownSmS" type="radio" 
                          name="{{ \App\Http\Controllers\Arvi\FrontEnd\Bootstrap\OTFController::PARAM_MERCHANT_PAYMENT_METHOD }}" 
                          value="{{$item->id}}" />
                      <div>{{$item->method}}</div>
                      </label>
                  </div>
                @endforeach
              </div>
            </div>
        </div>
        <div class="row h-100 justify-content-center align-items-center" 
        id="id-payment-loading">
          <div class="col-12 col-md-8">
              <h4>Processing payment...</h4>
              <div class="mt-3">
                  <img src="/img/loading.gif">
              </div>
          </div>
        </div>
      </div>
    </div>
</section>
<script>
    const __pPym = "{{ \App\Http\Controllers\Arvi\FrontEnd\Bootstrap\OTFController::PARAM_MERCHANT_PAYMENT_METHOD }}";
</script>
