@foreach ($productss as $item)

    <div class="d-flex">
        <div class="p-2">
            <div class="thumbnail-cart" style="background-image: url('/arvi/assets/img/products/{{ $item->productImage }}.{{ $item->productImageType }}');"></div>
        </div>
        <div class="p-2 w-100">
            <div class="fw-bold">{{ $item->productName }}</div>
            <div>
                <div>{{ $item->productQuan }}<div class="float-end text-muted">{{ $item->productCurren }}{{ $item->productPrice }}</div></div>
            </div>
        </div>
    </div>

    <div class="border-top"></div>

@endforeach

<div class="d-flex">
  <div class="p-2">
      <div class="thumbnail-cart" style="background-image: url('/arvi/assets/img/truck.png');"></div>
  </div>
  <div class="p-2">
      <div class="fw-bold">Pickup Location</div>
      <div>{{ $date }}</div>
      <div class="small">{{ $defineDelivery->address }}</div>
  </div>
</div>
<div class="border-top"></div>
@if(isset($payment) && !empty($payment))
<div class="p-2">
    <div class="fw-bold">Payment:</div>
    <div>{{ $payment }}</div>
</div>
@endif
<div class="text-end mt-3">
  <h2 class="fw-bold">
      <div class="text-muted f-14">TOTAL</div>
      ${{ $qtot }}
  </h2>
</div>
