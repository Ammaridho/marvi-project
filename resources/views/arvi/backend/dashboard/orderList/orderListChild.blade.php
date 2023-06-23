@foreach ($joinForOrderDetails as $item)
  <tr class="border-bottom text-nowrap" id="data-order-details">
    <td class="text-center" >
      <a href="javascript:void(0)" data-bs-toggle="modal"
      data-bs-target="#modalOrderDetail" class="detail-order-list"
      data-id="{{$item->id}}">
        <i class='bx bx-receipt'></i> #OOBE-{{$item->id}}
      </a>
    </td>
    <td class="text-center">{{ $item->loc_tz }}</td>
    <td class="text-center">{{ Carbon\Carbon::parse($item->create_time)->setTimezone($item->loc_tz)->format('d M Y H:i:s') }}</td>
    <td class="text-center">{{ Carbon\Carbon::parse($item->day_deliver)->setTimezone($item->loc_tz)->format('d M Y H:i:s') }}</td>
    <td class="text-center">
      @if ($item->delivery_type > 1)
          @if ($item->delivery_type == 2)
            <span class="badge bg-label-secondary w-100">Take Away</span>
          @else
            <span class="badge bg-label-secondary w-100">Dine-in</span>
          @endif
      @else
        @if ($item->delivery_id > 0)
          <span class="badge bg-label-secondary w-100">Delivery ordering</span>
        @else
          <span class="badge bg-label-primary w-100">Pick-up ordering</span>
        @endif
      @endif
    </td>
    <td class="text-center">
      @if ($item->order_status == 0)
        <span class="badge bg-label-danger w-100">Canceled</span>
      @elseif($item->order_status == 1)
        <span class="badge bg-label-warning w-100">Waiting Confirmation</span>
      @elseif($item->order_status == 2)
        <span class="badge bg-label-warning w-100">Meal Preparation</span>
      @elseif($item->order_status == 3)
        <span class="badge bg-label-warning w-100">Waiting for pick up</span>
      @elseif($item->order_status == 4)
        <span class="badge bg-label-info w-100">Process Delivery</span>
      @else
        <span class="badge bg-label-success w-100">Completed</span>
      @endif
    </td>
    <td class="text-center">
      <a href="javascript:void(0)" class="text-primary customer-detail" 
      data-bs-toggle="modal" data-bs-target="#modalDetail" data-data="{{$item}}">
        <i class='bx bx-user'></i>{{$item->name}}
      </a>
    </td>
    <td class="text-center">{{$item->address?$item->address:'-'}}</td>
    <td class="text-center">{{$item->remarks_deliver?$item->remarks_deliver:'-'}}</td>
    <td class="text-center" class="text-end">
      @php
        $total = 0;
        $joinProductsOrders = DB::table('merchant_order_details')
          ->join('merchant_products','merchant_order_details.product_id','=',
          'merchant_products.id')
          ->select('merchant_order_details.qty')
          ->where('merchant_order_id',$item->id)
          ->get();
        foreach ($joinProductsOrders as $key => $value) {
            $total += $value->qty;
        }
      @endphp
      {{$total}}
    </td>
    <td class="text-center" class="text-end">
      {{$item->currency}}
      @php
        $totalPrice = 0;
        $joinProductsOrders = DB::table('merchant_order_details')
        ->join('merchant_products','merchant_order_details.product_id','=',
        'merchant_products.id')
        ->select(
        'merchant_order_details.selling_price',
        'merchant_order_details.qty',
        )
        ->where('merchant_order_id',$item->id)
        ->get();
        foreach ($joinProductsOrders as $key => $value) {
          $totalPrice += $value->selling_price;
        }
      @endphp
      {{number_format($totalPrice)}}
    </td>
    <td class="text-center" class="text-end">
      @if ($item->delivery_type > 1)
          @if ($item->delivery_type == 2)
            Take Away
          @else
            Dine-in
          @endif
      @else
        @if ($item->delivery_name)
          {{$item->delivery_name}} -
          {{$item->subDeliveryName}}
        @else
          Pick Up
        @endif
      @endif
     
    </td>
    <td class="text-center" class="text-end">
      @if ($item->delivery_name)
        {{$item->currency}} 
        <span>{{number_format($item->cost_delivery)}}</span>
      @else
        FREE
      @endif
    </td>
    <td class="text-center">{{$item->currency}}
      @php
        $totalFees = 0;
        if (isset($item->fees)) {
          foreach ($item->fees as $key => $value) {
            if ($value->type_value == 'fixed') {
              $totalFees +=  $value->value_fee;
            } else {
              if ($item->currency = 'IDR') {
                $totalFees +=  ceil($value->value_fee/100 * $totalPrice);
              } else {
                $totalFees +=  $value->value_fee/100 * $totalPrice;
              }
              
            }
          }
        }
      @endphp
      {{number_format($totalFees)}}
    </td>
    <td class="text-center">
      {{$item->currency}} 
      {{number_format($totalPrice+$totalFees+$item->cost_delivery)}}
    </td>
    <td class="text-center">{{$item->payment_methods}}</td>
    <td class="text-center">
      @if ($item->payment_status==0)
        <span class="badge bg-label-info w-100">PENDING</span>
      @elseif ($item->payment_status==1)
        <span class="badge bg-label-success w-100">SUCCESS</span>
      @else
        <span class="badge bg-label-danger w-100">FAILED</span>
      @endif
    </td>
    <td class="text-center">
      <div class="d-grid">
        @if ($item->order_status == 0 )
          <button class="btn btn-danger btn-sm disabled" data-bs-toggle="modal"
          data-bs-target="#modalConfirmCancel">Canceled <i class="fas fa-times"></i></button>
        @elseif($item->order_status == 1)
          @if ($item->payment_status == 0)
            <button class="btn btn-primary btn-sm update-status-order" data-bs-toggle="modal"
            data-bs-target="#modalUpdateOrder" data-id="{{$item->id}}">Confirm Payment</button>
            <button class="btn btn-danger btn-sm update-status-order" data-bs-toggle="modal"
            data-bs-target="#modalConfirmCancel" data-id="{{$item->id}}">Cancel</button>
          @else
            <button class="btn btn-primary btn-sm update-status-order" data-bs-toggle="modal"
            data-bs-target="#modalUpdateOrder" data-id="{{$item->id}}">Confirm Order</button>
            <button class="btn btn-danger btn-sm update-status-order" data-bs-toggle="modal"
            data-bs-target="#modalConfirmCancel" data-id="{{$item->id}}">Cancel</button>
          @endif
        @elseif($item->order_status == 2)
          <button class="btn btn-primary btn-sm update-status-order" data-bs-toggle="modal"
          data-bs-target="#modalUpdateOrder" data-id="{{$item->id}}">Ready Pickup</button>
          <button class="btn btn-danger btn-sm update-status-order" data-bs-toggle="modal"
          data-bs-target="#modalConfirmCancel" data-id="{{$item->id}}">Cancel</button>
        @elseif($item->order_status == 3)
          <button class="btn btn-primary btn-sm update-status-order" data-bs-toggle="modal"
          data-bs-target="#modalUpdateOrder" data-id="{{$item->id}}">Already Pickup</button>
          <button class="btn btn-danger btn-sm update-status-order" data-bs-toggle="modal"
          data-bs-target="#modalConfirmCancel" data-id="{{$item->id}}">Cancel</button>
        @elseif($item->order_status == 4)
          <button class="btn btn-info btn-sm disabled" data-bs-toggle="modal"
          data-bs-target="#modalConfirmCancel">Process Delivery..</button>
        @else
          <button class="btn btn-success btn-sm disabled" data-bs-toggle="modal"
          data-bs-target="#modalConfirmCancel">Completed <i class="fas fa-check"></i>
          </button>
        @endif
      </div>
    </td>
  </tr>
@endforeach

 <!--
=============================================
Modals
=============================================
-->

<!-- Modal order details -->
<div class="modal fade" id="modalOrderDetail" tabindex="-1"
aria-labelledby="modalOrderDetail" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header border-bottom pb-3">
        <h5 class="modal-title">Orders Detail</h5>
        <button type="button" class="btn-close" 
        data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body center p-3" id="detail-data-order">
      </div>
      <div class="modal-footer border-top pb-2">
        <button type="button" class="btn btn-secondary" 
        data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- //Modal order details -->

<!-- Modal customer details -->
<div class="modal fade" id="modalDetail" tabindex="-1"
aria-labelledby="modalDetail" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-bottom pb-3">
        <h5 class="modal-title">Customer Detail</h5>
        <button type="button" class="btn-close"
        data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body center p-3">

        <div class="row g-0">
          <div class="col-4">
            <div class="mb-2">
                <label class="form-label">Fullname</label>
                <div id="set-customer-name"></div>
            </div>
          </div>
          <div class="col-4">
            <div class="mb-2">
                <label class="form-label">Mobile</label>
                <div id="set-customer-phone"></div>
            </div>
          </div>
          <div class="col-4">
            <div class="mb-2">
                <label class="form-label">Email</label>
                <div id="set-customer-email"></div>
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
<!-- // Modal customer details -->

<!-- Modal cancel order -->
<div class="modal fade" id="modalConfirmCancel" tabindex="-1" 
aria-labelledby="modalConfirmCancel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-bottom pb-3">
        <h5 class="modal-title">Cancel order</h5>
        <button type="button" class="btn-close" 
        data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body center p-3">
        <h4>You're about to <span class="text-danger">cancel</span> the order</h4>
        <div class="">
          By doing this action, you will cancel the order and the funds will refunded to the customer.
        </div>
        <div class="my-3">
          <label for="confirmPassword" class="form-label">
            Please confirmed by filled the password
          </label>
          <input type="password" class="form-control" id="confirmPassword">
        </div>
      </div>
      <div class="modal-footer border-top pb-2">
        <button type="button" class="btn btn-link" 
        data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary submit-update" 
        data-bs-dismiss="modal" data-id="">Cancel order</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal cancel order -->

<!-- Modal error password -->
<div class="modal fade" id="modalErrorPassword" tabindex="-1" 
aria-labelledby="modalErrorPassword" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-bottom pb-3">
        <h5 class="modal-title">Cancel order</h5>
        <button type="button" class="btn-close" 
        data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body center p-3 pb-2">
        <h4 class="text-center">Password not match!</h4>
      </div>
      <div class="modal-footer border-top pb-2">
        <button type="button" class="btn btn-link" 
        data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal cancel order -->

<!-- Modal confirm Order-->
<div class="modal fade" id="modalUpdateOrder" tabindex="-1"
aria-labelledby="modalUpdateOrder" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-bottom pb-3">
        <h5 class="modal-title">Change the order status to 
        <span class="status-update"></span> ?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
        aria-label="Close"></button>
      </div>
      <div class="modal-body p-3">
        <div class="">By doing this action, you
          <span class="fw-bold">can not</span> change the status again.
        </div>
      </div>
      <div class="modal-footer border-top pb-2">
        <button type="button" class="btn btn-link" 
        data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary submit-update" 
        data-bs-dismiss="modal"><span class="status-update"></span></button>
      </div>
    </div>
  </div>
</div>
<!-- //Modal confirm -->

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>

  // open modal update status
  $('.update-status-order').on('click',function () {
    let id      = $(this).data('id');
    let status  = $(this).text();
    $('#confirmPassword').val('');
    $('.status-update').text(status);
    $('.submit-update').data('id',id);
    $('.submit-update').data('status',status);
  })

  // submit update
  $('.submit-update').on('click',function () {
    let id = $(this).data('id');
    let status = $(this).data('status');
    let password = $('#confirmPassword').val();
    $.ajax({
      type: 'PUT',
      url: "{{ route('update-status-order',['companyCode' => $companyCode]) }}",
      data: {"_token": "{{ csrf_token() }}",
        id:id,password:password,status:status},
      success: function (data) {
        $('#order-list-button').trigger('click');
      },
      error: function (data) {
        $('#modalErrorPassword').modal('show'); 
      }
    })
  })

  // detail-customer
  $('.customer-detail').on('click',function(){
    // all data
    let data = $(this).data('data');
    $('#set-customer-name').text(data['name']);
    $('#set-customer-phone').text(data['mobile_number']);
    if (data['email']) {
      $('#set-customer-email').text(data['email']);
    } else {
      $('#set-customer-email').text('-');
    }
  })

  // detail-order-list
  $('.detail-order-list').on('click',function(){
    // all data
    let id = $(this).data('id');
    $.get("{{route('order-detail-dashboard',['companyCode' => $companyCode])}}",
    {id:id},function (data) {
      $('#detail-data-order').html(data);
    })
  })
</script>
