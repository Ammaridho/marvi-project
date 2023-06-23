   <div class="d-flex mb-2 align-items-top justify-content-start flex-wrap">
    <div class="me-4 mb-2 pe-3 border-end">
      <div class="text-uppercase small">Order id</div>
      <div>#OOBE-{{$joinForOrderDetails['id']}}</div>
    </div>
    <div class="me-4 mb-2 border-end pe-3">
      <div class="text-uppercase small">Order Date</div>
      <div class="flex-grow-1">
        {{Carbon\Carbon::parse($joinForOrderDetails['create_time'])
        ->setTimezone($joinForOrderDetails['loc_tz'])->format('d M Y H:i:s')}}
      </div>
    </div>
    <div class="me-4 mb-2 ps-2">
      <div class="text-uppercase small">Order For</div>
      <div class="flex-grow-1">
        {{Carbon\Carbon::parse($joinForOrderDetails['day_deliver'])
        ->setTimezone($joinForOrderDetails['loc_tz'])->format('d M Y H:i:s')}}
      </div>
    </div>
  </div>
  <div class="d-flex mb-4 align-items-top justify-content-start flex-wrap">
    <div class="me-4 mb-2 border-end pe-3">
      <div class="text-uppercase small">Fulfilment</div>
      <div>
        @if ($joinForOrderDetails['delivery_type'] > 1)
          @if ($joinForOrderDetails['delivery_type'] == 2)
            <span class="badge bg-label-secondary w-100">Take Away</span>
          @else
            <span class="badge bg-label-secondary w-100">Dine-in</span>
          @endif
        @else
          @if ($joinForOrderDetails['delivery_id'] > 0)
            <span class="badge bg-label-secondary w-100">Delivery ordering</span>
          @else
            <span class="badge bg-label-primary w-100">Pick-up ordering</span>
          @endif
        @endif
      </div>
    </div>
    @if ($joinForOrderDetails['delivery_id'] > 0)
      <div class="me-4 mb-2 border-end pe-3">
        <div class="text-uppercase small">Kurir</div>
        <div>
            <span class="badge bg-label-info w-100">
              {{$joinForOrderDetails['delivery_name']}}-
              {{$joinForOrderDetails['subDeliveryName']}}
            </span>
        </div>
      </div>
    @endif
    <div class="me-4 mb-2 border-end pe-3">
      <div class="text-uppercase small">Status</div>
      <div>
        @if ($joinForOrderDetails['order_status'] == 0)
          <span class="badge bg-label-danger w-100">Canceled</span>
        @elseif($joinForOrderDetails['order_status'] == 1)
          <span class="badge bg-label-warning w-100">Waiting Confirmation</span>
        @elseif($joinForOrderDetails['order_status'] == 2)
          <span class="badge bg-label-warning w-100">Meal Preparation</span>
        @elseif($joinForOrderDetails['order_status'] == 3)
          <span class="badge bg-label-warning w-100">Waiting for pick up</span>
        @elseif($joinForOrderDetails['order_status'] == 4)
          <span class="badge bg-label-info w-100">Process Delivery</span>
        @else
          <span class="badge bg-label-success w-100">Completed</span>
        @endif
      </div>
    </div>
    <div class="me-4 mb-2 border-end pe-3">
      <div class="text-uppercase small">Payment Type</div>
      <div>{{$joinForOrderDetails['payment_methods']}}</div>
    </div>
    <div class="me-4 mb-2">
      <div class="text-uppercase small">Payment Status</div>
      @if ($joinForOrderDetails['payment_status']==0)
        <span class="badge bg-label-info w-100">PENDING</span>
      @elseif ($joinForOrderDetails['payment_status']==1)
        <span class="badge bg-label-success w-100">SUCCESS</span>
      @else
        <span class="badge bg-label-danger w-100">FAILED</span>
      @endif
    </div>
  </div>
  @if ($joinForOrderDetails['delivery_id'] > 0)
  <div class="d-flex mb-4 align-items-top justify-content-start flex-wrap">
    <div class="me-4 mb-2 border-end pe-3">
      <div class="text-uppercase small">Delivery/Pickup Address</div>
      <div>{{$joinForOrderDetails['address']}}</div>
    </div>
    @if ($joinForOrderDetails['remarks_deliver'])
    <div class="me-4 mb-2">
      <div class="text-uppercase small">Notes</div>
      <div>{{$joinForOrderDetails['remarks_deliver']}}</div>
    </div>
    @endif
    <div>
      &nbsp;
    </div>
  </div>
  @endif
  <div class="table-responsive text-nowrap pb-2" id="table-scroll">
    <table class="table table-sm table-borderless">
      <thead>
        <tr class="table-primary text-nowrap text-center">
            <th>Menu Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
      </thead>
      <tbody id="detail-order">
        @php
            $i = 1;
            $subtotal = 0;
        @endphp

        @foreach ($reformJoinProductsOrder as $key => $item)
          @if ($item['product'])
          
            <tr class="border-top">
              <td class="font-weight-bold">{{$i++}}. 
                {{$item['product']['product_name']}} 
                @if (isset($item['variant']))
                  ({{$item['variant']['variant_name']}})
                @endif
              </td>
              <td class="text-end">
                {{$item['product']['product_currency']}}
                {{number_format($priceAll[$item['merchant_order_detail_id']]['price'])}}
              </td>
              <td class="text-center">x{{$item['qty']}}</td>
              <td class="text-end">
                @if ($priceAll[$item['merchant_order_detail_id']]['discount_price']>0)
                <s class="text-danger">{{$item['product']['product_currency']}} 
                  {{number_format($priceAll[$item['merchant_order_detail_id']]['total_price']+
                  $priceAll[$item['merchant_order_detail_id']]['discount_price'])}}</s>
                @endif
                {{$item['product']['product_currency']}} 
                <span class="all-price selling_price" 
                data-sp="{{$priceAll[$item['merchant_order_detail_id']]['total_price']}}">
                  {{number_format($priceAll[$item['merchant_order_detail_id']]['total_price'])}}
                </span>
                @php
                    $subtotal += $priceAll[$item['merchant_order_detail_id']]['total_price'];
                @endphp
              </td>
            </tr>

            @if (isset($item['attribute']))
              <tr>
                <td><small>Extra Condiments : </small></td>
              </tr>
              @foreach ($item['attribute'] as $attribute)
              <tr>
                <td>
                  <small>- {{$attribute['attribute_name']}} 
                  ({{$attribute['attribute_qty']}}x)</small>
                </td>
              </tr>
              @endforeach
            @endif
            
            @if (isset($item['extra_attribute']))
              <tr>
                <td><small>Extra Cutlary : </small></td>
              </tr>
              @foreach ($item['extra_attribute'] as $extra_attribute)  
              <tr>
                <td>
                  <small>- {{$extra_attribute['extra_attribute_name']}} 
                    ({{$extra_attribute['extra_attribute_qty']}}x)</small>
                </td>
              </tr>
              @endforeach
            @endif

            @if (isset($item['remarks_product']))
              <tr>
                <td><small>Notes : </small></td>
              </tr>
              <tr>
                <td>
                  <small>{{$item['remarks_product']}}</small>
                </td>
              </tr>
            @endif

          @endif

          @php
              $item = null;
          @endphp 
          
        @endforeach

        <tr class="border-top">
            <td></td>
            <td></td>
            <td class="text-end">Sub-Total</td>
            <td class="text-end">{{$joinForOrderDetails->currency}} {{number_format($subtotal)}}</td>
        </tr>
        <tr class="border-top">
            <td></td>
            <td></td>
            @if ($joinForOrderDetails['delivery_type'] == 1)
              <td class="text-end">{{$joinForOrderDetails['delivery_name']}}</td>
              <td class="text-end">{{$joinForOrderDetails->currency}} 
                <span class="all-price" data-sp="{{$joinForOrderDetails['cost_delivery']}}">
                  {{number_format($joinForOrderDetails['cost_delivery'])}}
                </span>
              </td>
            @elseif($joinForOrderDetails['delivery_type'] == 2)
              <td class="text-end">Take Away</td>
              <td class="text-end">FREE</td>
            @elseif($joinForOrderDetails['delivery_type'] == 3)
              <td class="text-end">Dine-in</td>
              <td class="text-end">FREE</td>
            @else
              <td class="text-end">Pick Up</td>
              <td class="text-end">FREE</td>
            @endif
        </tr>

        <tr class="border-top sum-all-product">
            <td></td>
            <td></td>
            <td></td>
            <td class="fw-bold text-end">{{$joinForOrderDetails->currency}}
                <span id="sum-all-product"></span>
            </td>
        </tr>

      </tbody>
    </table>
  </div>
  @if (isset($joinForOrderDetails['remarks_order']))
    <div class="alert alert-secondary small">
      <div class="text-uppercase">Notes</div>
      <div>{{$joinForOrderDetails['remarks_order']}}</div>
    </div>
  @endif

  <script>
    $( document ).ready(function() {
      let allPrice = 0;
      $('.all-price').each(function (a,b) {
        allPrice += parseFloat($(this).data('sp'));
      });

      let selling_price = 0;
      $('.selling_price').each(function (a,b) {
        selling_price += parseFloat($(this).data('sp'));
      });

      // fees
      let fees = <?php echo json_encode(json_decode($joinForOrderDetails->fees)); ?>;
      let valueFees = [];
      let htmlFees = [];
      let totalFees = 0;
      
      fees.forEach(function (data) {
        if (data['type_value'] == 'percentage') {
          if (data['currency'] == 'IDR') {
            valueFees[data['name']] = Math.ceil(selling_price * 
            data['value_fee'] / 100);
          }else{
            valueFees[data['name']] = selling_price * data['value_fee'] / 100;
          }
          $('.sum-all-product').before(`
            <tr>
              <td></td>
              <td></td>
              <td class="text-end">
                ${data['name']} (${data['value_fee']}%)
              </td>
              <td class="text-end">
                ${data['currency']} 
                ${thousands_separators(valueFees[data['name']])}
              </td>
            </tr>
          `);
        } else {
          valueFees[data['name']] = data['value_fee'];
          $('.sum-all-product').before(`
            <tr>
              <td></td>
              <td></td>
              <td class="text-end">
                ${data['name']}
              </td>
              <td class="text-end">
                ${data['currency']} 
                ${thousands_separators(valueFees[data['name']])}
              </td>
            </tr>
          `);
        }
        totalFees += parseFloat(valueFees[data['name']]);
      });

      $('#sum-all-product').text(thousands_separators(allPrice+totalFees));
    });

    function thousands_separators(num)
    {
      var num_parts = num.toString().split(".");
      num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return num_parts.join(".");
    }
    
  </script>
