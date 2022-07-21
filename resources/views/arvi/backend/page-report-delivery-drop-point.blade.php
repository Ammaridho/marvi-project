<div class="card">
  <div class="d-flex justify-content-between flex-grow align-items-center">
    <div><h5 class="card-header">Delivery Drop Point</h5></div>
    <div>
      <div class="me-2">
          <div class="d-flex justify-content-end flex-sm-row flex-column">
            <div class="me-2 my-1"><input type="text" id="dateRange" name="dateRange" 
                class="form-control form-control-custom" /></div>
            <div class="me-2 my-1">
              <form class="d-flex" onsubmit="return false">
                <input class="form-control form-control-custom me-2" 
                id="input-search" type="search" placeholder="No/Delivery-Date/Delivery-Address/Total-Item" 
                aria-label="Search" autocomplete="off" />
              </form>
            </div>
            <div class=" my-1">
              <button class="btn btn-sm btn-outline-primary me-2" id="btnSubmitExport" onclick="exportExcel()">
                <i class="menu-icon tf-icons bx bx-download"></i> Export
              </button>
            </div>
          </div>
      </div>
    </div>
  </div>
  
  <div class="mx-3 pb-4 table-responsive">
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
        $temp_day_deliver = '';
        $temp_address = '';
        @endphp

        @foreach ($joinForDeliveryDropPoints as $key => $item)
        
          @if (!($temp_day_deliver == $item->day_deliver && $temp_address == $item->address))
            <tr id="list-delivery-drop-point-list" class="dd-{{ date("d-m-Y", strtotime($item->day_deliver)) }}  all-list-delivery-drop-point" data-id="{{ $item->id }}">
              <td class="text-center">{{ $i }}</td>
              <td>{{ $item->day_deliver }}</td>
              <td class="w-100">{{ $item->address }}</td>
              <td class="text-center" id="result-total-{{ $i }}">123</td>
              <td class="text-center">
                <button class="btn btn-sm btn-primary show-product" target="{{ $key }}">Detail</button>
              </td>
            </tr>

            <tr><td colspan="4" class="d-none"></td></tr><!-- this needed to make sure table stripped works-->
            <tr class="more-product" id="blockProduct{{ $key }}" style="display: none;">
              <td colspan="9">
                <div class="m-2">
                  <table class="table table-sm table-bordered report">
                    <tr>
                      <th>Black Coffee</th>
                      <th>Strong Black Coffee</th>
                      <th>Oat Milk Coffee</th>
                      <th>Milk & Manuka Honey</th>
                      <th>Coffee Hojicha Green Tea</th>
                      <th>Rooibos Orange Tea</th>
                    </tr>
                    <tr>
                      @foreach ($products as $itemP)
                        {{-- print quantity product --}}
                        <td class="total-{{ $i }}">
                          {{ isset( $deliveryDropPointNew[$item->day_deliver][$item->address][$itemP->id]) ? 
                          $deliveryDropPointNew[$item->day_deliver][$item->address][$itemP->id] : 0 }}
                        </td>
                      @endforeach
                    </tr>
                  </table>
                </div>
              </td>
            </tr>

            @php
                $i++;
                $temp_day_deliver = $item->day_deliver;
                $temp_address = $item->address;
            @endphp
          @endif

        @endforeach
      </tbody>
    </table>
  </div>

  <!-- paging -->
  <div class="mx-3 mt-3 text-end">
      <div class="d-flex justify-content-between align-items-center">
        <div class="d-none d-sm-none d-md-block">Showing 25 from 100</div>
        <div class="d-none d-sm-none d-md-block">
          <nav>
              <ul class="pagination justify-content-end">
                  <li class="page-item active" aria-current="page">
                    <span class="page-link">1</span></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">4</a></li>
                  <li class="page-item"><a class="page-link" href="#">5</a></li>
                  <li class="page-item"><a class="page-link p-2" href="#">
                    <i class="bx bx-chevron-left"></i></a></li>
                  <li class="page-item"><a class="page-link p-2" href="#">
                    <i class="bx bx-chevron-right"></i></a></li>
              </ul>
          </nav>
        </div>
        <div class="d-block d-sm-block d-md-none">
          <nav>
              <ul class="pagination justify-content-end">
                  <li class="page-item"><a class="page-link p-2" href="#">Previous</a></li>
                  <li class="page-item"><a class="page-link p-2" href="#">Next</a></li>
              </ul>
          </nav>
        </div>
      </div>
  </div>
  <!-- //paging -->

</div>

<script>
  $(document).ready(function () {

    // auto acumulation total
    for (let i = 1; i <= {{ count($joinForDeliveryDropPoints) }}; i++) {
      var sum = 0;
      $(`td.total-${i}`).each(function () {
          sum += Number($(this).text());
      })
      $(`#result-total-${i}`).text(sum);
    }

  })

  // export excel
  function exportExcel() {
    let conf = confirm('export excel?');
    if(conf){
      // get all id visible data
      var ek=[];
      $('tr.all-list-delivery-drop-point:visible').each(function() { ek.push($(this).data('id')); });
      var urlJavascript = '{{ route('delivery-drop-point-export-excel',['qrCode' => $qrCode]) }}'+'?idData=' + JSON.stringify(ek);
      window.location.href = urlJavascript;
    }
  }

  // search delivery drop point
  $("#input-search").on("keyup click change", function() {
    var value = $(this).val().toLowerCase();
    $("#list-delivery-drop-point-list tr#list-delivery-drop-point-list").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  //View detail quantity product on drop point
  $('.show-product').click(function() {
    $('.more-product').not('#blockProduct' + $(this).attr('target')).hide('');
    $('#blockProduct' + $(this).attr('target')).toggle('');
  }); 
  
  // export table
  function exportTableToExcel(tableID, filename = ''){
      $a = confirm('Export Excel?');

      if ($a) {
      
          var downloadLink;
          var dataType = 'application/vnd.ms-excel';
          var tableSelect = document.getElementById(tableID);
          var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
          // tableHTML.outerHTML.replace('<button----View</button>', '');
          
          // Specify file name
          filename = filename?filename+'.xls':'excel_data.xls';
          
          // Create download link element
          downloadLink = document.createElement("a");
          
          document.body.appendChild(downloadLink);
          
          if(navigator.msSaveOrOpenBlob){
              var blob = new Blob(['\ufeff', tableHTML], {
                  type: dataType
              });
              navigator.msSaveOrOpenBlob( blob, filename);
          }else{
              // Create a link to the file
              downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
          
              // Setting the file name
              downloadLink.download = filename;
              
              //triggering the function
              downloadLink.click();
          }
      }
  }

  // // search drop point
  // $("#input-search").on("keyup click change", function() {
  //   var value = $(this).val().toLowerCase();
  //   $("#list-order tr#order-list").filter(function() {
  //     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
  //   });
  // });

  //Date range
  var start = moment().subtract(29, 'days');
  var end = moment();
  function cb(start, end) {
      $('#dateRange span').html(start.format('MMMM D, YYYY') + ' - ' + 
      end.format('MMMM D, YYYY'));
  }
  $('input[name="dateRange"]').daterangepicker({
      opens: "left",
      startDate: start,
      endDate: end,
      ranges: {
      'Today': [moment(), moment()],
      'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), 
        moment().subtract(1, 'month').endOf('month')]
      }
  });
  cb(start, end);

  // Reset filter
  $('#reset-filter-day-order').on('click',function () {
      $('tr.all-list-delivery-drop-point').show();
  })

  // when date pick on click
  $('input[name="dateRange"]').on('apply.daterangepicker', function(ev, picker) {
      getDatesInRange(new Date(picker.startDate.format('YYYY-MM-DD')), 
      new Date(picker.endDate.format('YYYY-MM-DD')));
  });
  function dateFormat(inputDate, format) {
      //parse the input date
      const date = new Date(inputDate);
      //extract the parts of the date
      const day = date.getDate();
      const month = date.getMonth() + 1;
      const year = date.getFullYear();    
      //replace the month
      format = format.replace("MM", month.toString().padStart(2,"0"));        
      //replace the year
      if (format.indexOf("yyyy") > -1) {
          format = format.replace("yyyy", year.toString());
      } else if (format.indexOf("yy") > -1) {
          format = format.replace("yy", year.toString().substr(2,2));
      }
      //replace the day
      format = format.replace("dd", day.toString().padStart(2,"0"));
      return format;
  }

  //show date if on sort data
  function getDatesInRange(startDate, endDate) {
      // hide all order
      $('tr.all-list-delivery-drop-point').hide();
      const date = new Date(startDate.getTime());
      const dates = [];
      while (date <= endDate) {
          // set date in choosed to display
          $(`tr.dd-${dateFormat(date, 'dd-MM-yyyy')}`).show();
          date.setDate(date.getDate() + 1);
      }
    
  }

</script>
