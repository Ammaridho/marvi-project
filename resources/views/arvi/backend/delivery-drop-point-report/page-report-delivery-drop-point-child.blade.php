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

    @foreach ($rows as $key => $item)
    
      <tr id="list-delivery-drop-point-list">
        <td class="text-center">{{ $key+1 }}</td>
        <td>{{ $item->day_deliver }}</td>
        <td class="w-100">{{ $item->address }}</td>
        <td class="text-center">{{ $item->total }}</td>
        <td class="text-center">
          <button class="btn btn-sm btn-primary show-product detail-quantity-product" 
          data-day_deliver="{{ $item->day_deliver }}" 
            data-address="{{ $item->address }}" target="{{ $key }}">Detail
          </button>
        </td>
      </tr>

      <tr class="more-product detail-product-as" id="blockProduct{{ $key }}" 
        style="display: none;">
      </tr>

    @endforeach

  </tbody>
</table>

@if (isset($page))
  <div class="mx-3 mt-3 text-end" id="pagination-ddp">
    <div class="d-flex justify-content-between align-items-center">
      <div class="d-none d-sm-none d-md-block">Showing {{count($rows)}} from {{$countAll}}</div>
        <div class="d-none d-sm-none d-md-block">
          <nav>
            <ul class="pagination justify-content-end">
              {{-- <li class="page-item active"><span class="page-link">1</span></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li> --}}
              @if ($page > 1)
                <li class="page-item"><a class="page-link p-2 page-navigation" 
                  data-action="back" href="javascript:void(0)">
                  <i class="bx bx-chevron-left"></i></a></li>
              @endif
              <li class="page-item active"><div class="page-link">{{$page}}</div></li>
              @if (!(count($rows) == $countAll || count($rows) < $limit))  
                <li class="page-item"><a class="page-link p-2 page-navigation" 
                  data-action="next" href="javascript:void(0)">
                  <i class="bx bx-chevron-right"></i></a></li>
              @endif
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <script>
    //button page
    $('.page-navigation').click(function () {
        action = $(this).data('action');
        page = parseInt("{{$page}}");
        if (action == 'next') {
          page += 1;
        } else {
          page -= 1;
        }
        $.get("{{route('delivery-order-dashboard',['companyCode' => $companyCode], true)}}"
              +'?page=' + JSON.stringify(page),
          function (data) {
            $('#paginate-page-report-order').html(data);
          }
        )
      })
  </script>

@endif

<script>
  //View detail quantity product on drop point
  $('.show-product').click(function() {
    $('.more-product').not('#blockProduct' + $(this).attr('target')).hide('');
    $('#blockProduct' + $(this).attr('target')).toggle('');
    $('.detail-product-as').html();
    $.get("{{ secure_url(route('detail-quantity-delivery-order-dashboard',['companyCode' => $companyCode], true)) }}"
          +'?day_deliver=' + JSON.stringify($(this).data('day_deliver'))
          +'&address=' + JSON.stringify($(this).data('address')),
      function (data) {
        $('.detail-product-as').html(data);
      }
    )
  })
</script>