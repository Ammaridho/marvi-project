<section class="section">
    <div class="wrap">
      <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-12 col-md-8">

              <h4 class="">When would you like to order for?</h4>
              <div class="d-flex justify-content-between">
                  <div class="small">Showing next available dates</div>
                  <div class="small"><a href="javascript: void(0)" class="text-dark" 
                    data-bs-toggle="modal" data-bs-target="#modalCalendar">
                    <u>More dates</u></a>
                  </div>
              </div>

              <div class="row g-2 mt-3">
                @for ($i = 0; $i < count($dates['dmY']); $i++)
                  <div class="col-3 col-sm-3 col-md-3 text-center mb-2">
                    {{-- print data dates --}}
                    <div class="form-group shadow">
                      <label class="date-radio-selection">
                            <input class="chooseDate setDate" type="radio" 
                            name="date" value="{{$dates['dmY'][$i]}}" />
                            <div class="order-select-date arrowDownSmS">
                              <div class="cal-days">{{strtoupper($dates['D'][$i])}}</div>
                              <div class="cal-date">{{strtoupper($dates['d'][$i])}}</div>
                              <div class="cal-month">{{strtoupper($dates['M'][$i])}}</div>
                            </div>
                      </label>
                    </div>
                  </div>

                @endfor

              </div>

            </div>

        </div>
      </div>
    </div>
</section>
