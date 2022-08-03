<table class="table table-bordered table-sm table-striped report">
  <thead>
    <tr class="table-primary">
      <th>No.</th>
      <th class="text-nowrap">Delivery Date</th>
      <th>Delivery Address</th>
      <th class="text-nowrap">Total Item</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody class="table-border-bottom-0" id="list-delivery-drop-point-list">

    @php
      $i = 1;
    @endphp

    @foreach ($dataPaginate as $key => $item)

      <tr id="list-delivery-drop-point-list" class="dd-{{ date("d-m-Y", strtotime($item['day_deliver'])) }}  
        all-list-delivery-drop-point" data-index="{{$key}}">
        <td class="text-center">{{ $i }}</td>
        <td>{{ $item['day_deliver'] }}</td>
        <td class="w-100">{{ $item['address'] }}</td>
        <td class="text-center" id="result-total-{{ $i }}">123</td>
        <td class="text-center">
          <button class="btn btn-sm btn-primary show-product" target="{{ $key }}">Detail</button>
        </td>
      </tr>

      <tr><td colspan="4" class="d-none"></td></tr>
      <tr class="more-product" id="blockProduct{{ $key }}" style="display: none;">
        <td colspan="9">
          <div class="m-2">
            <table class="table table-sm table-bordered report">
              <tr>
                @foreach ($products as $itemP)
                  <th>{{$itemP['name']}}</th>
                @endforeach
              </tr>
              <tr>
                @foreach ($item['dataProduct'] as $itemP)
                  <td class="total-{{ $i }}">
                    {{$itemP}}
                  </td>
                @endforeach
              </tr>
            </table>
          </div>
        </td>
      </tr>
      
      @php
        $i++;
      @endphp
    @endforeach

  </tbody>
</table>

@if ($dataPaginate instanceof \Illuminate\Pagination\LengthAwarePaginator)
<!-- paging -->
<div class="mx-3 mt-3 text-end">
  <div class="d-flex justify-content-between align-items-center">
    <div class="d-none d-sm-none d-md-block">Showing {{count($dataPaginate)}} from {{$countDeliveryDropPoint}}</div>
    <div class="d-none d-sm-none d-md-block">
      {!! $dataPaginate->links() !!}
    </div>
  </div>
</div>
<!-- //paging -->
@endif

<script>

  //View detail quantity product on drop point
  $('.show-product').click(function() {
    $('.more-product').not('#blockProduct' + $(this).attr('target')).hide('');
    $('#blockProduct' + $(this).attr('target')).toggle('');
  }); 

  // auto acumulation total
  for (let i = 1; i <= {{ count($dataPaginate) }}; i++) {
      var sum = 0;
      $(`td.total-${i}`).each(function () {
          sum += Number($(this).text());
      })
      $(`#result-total-${i}`).text(sum);
    }
</script>