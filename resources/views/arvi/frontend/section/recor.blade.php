<section class="section">
    <div class="wrap">
      <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-12 col-md-8">
              <h4>How would you like to receive your order?</h4>
              <div class="mt-3">
                @foreach ($revor as $item)
                  <div class="form-group">
                    <label class="option-radio-selection courier shadow-sm mb-3 inputData">
                        <input class="inputData arrowDownSm" type="radio" name="{{ \App\Http\Controllers\Arvi\OTFController::PARAM_DELIVERY_POINT }}" value="{{$item->id}}" />
                      <div class="d-flex">
                        <div>{{$item->address}}</div>
                        <div class="text-muted ps-4"></div>
                      </div>
                    </label>
                  </div>
                @endforeach
            </div>
        </div>
      </div>
    </div>
  </section>
