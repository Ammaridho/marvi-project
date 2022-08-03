<!-- row data -->  
{{-- <div class="data-order" id="data-order"> --}}
  <table class="table table-bordered table-sm table-striped report" id="table_order">
    <thead>
      <tr class="table-primary">
        <th>Order ID</th>
        <th>Order Date</th>
        <th>Delivery Date</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Delivery Type</th>
        <th>Address</th>
        <th>Orders</th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0" id="list-order">

      @foreach ($joinForOrderDetails as $key => $item)
    
      <tr id="order-list" class="od-{{ date("d-m-Y", strtotime($item->create_time)) }} dd-{{ date("d-m-Y", strtotime($item->day_deliver)) }}  all-order" data-id="{{ $item->id }}">
        <td>{{ $item->id }}</td>
        <td>{{ date("d-m-Y h:m:s", strtotime($item->create_time)) }}</td>
        <td>{{ date("d-m-Y", strtotime($item->day_deliver)) }}</td>
        <td class="text-nowrap">{{ $item->name }}</td>
        <td>{{ $item->email }}</td>
        <td class="text-nowrap">+65 {{ $item->mobile_number }}</td>
        <td class="text-center">Pickup</td>
        <td>{{ $item->address }}</td>
        <td class="text-center">
          <button class="btn btn-sm btn-primary show-product" target="{{ $key }}">View</button>
        </td>
      </tr>
      <tr><td colspan="9" class="d-none"></td></tr><!-- this needed to make sure table stripped works-->
      <tr class="more-product" id="blockProduct{{ $key }}" style="display: none;">
        <td colspan="9">
          <div class="m-2">
            <table class="table table-sm table-bordered report">
              <tr>
                @foreach ($products as $itemP)
                  <th>{{$itemP->name}}</th>
                @endforeach
                <th class="table-warning">Total Item</th>
              </tr>
              <tr>
                {{-- set itteration for print quantity product --}}
                @for ($i = 1; $i <= $countProduct; $i++) 
                  <td class="text-end qty{{$i}}">{{!empty($productsOrder[$item->id][$i]) ? (int)$productsOrder[$item->id][$i] : (int)0}}</td>
                @endfor
                <td class="fw-bold text-end table-warning">{{array_sum($productsOrder[$item->id])}}</td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
      
      
      @endforeach
      <!-- //row data -->
      
      
      {{-- </div> --}}
      
    </tbody>
    
  </table>

 
  @if ($joinForOrderDetails instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <!-- paging -->
    <div class="mx-3 mt-3 text-end">
      <div class="d-flex justify-content-between align-items-center">
        <div class="d-none d-sm-none d-md-block">Showing 
          {{count($joinForOrderDetails)}} from {{$countOrder}}</div>
        <div class="d-none d-sm-none d-md-block">
          {!! $joinForOrderDetails->links() !!}
        </div>
      </div>
    </div>
    <!-- //paging -->
  @endif


<script>
  //View product id
  $('.show-product').click(function() {
    $('.more-product').not('#blockProduct' + $(this).attr('target')).hide('');
    $('#blockProduct' + $(this).attr('target')).toggle('');
  });
</script>
  
  
  



