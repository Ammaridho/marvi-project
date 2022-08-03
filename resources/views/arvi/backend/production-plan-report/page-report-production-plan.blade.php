<div class="card">
  <div class="d-flex justify-content-between flex-grow align-items-center">
    <div>
      <h5 class="card-header">Production Plans</h5>
    </div>
    <div>
      <div class="me-2">
          <div class="d-flex justify-content-end flex-sm-row flex-column">
            {{-- <div class=" my-1"><button class="btn btn-sm btn-outline-primary me-2" id="btnSubmitExport" onclick="exportTableToExcel('table_production_plan', 'table_production_plan_{{ $noww->format('d-m-Y') }}')"><i class="menu-icon tf-icons bx bx-download"></i> Export</button></div> --}}
            <div class=" my-1"><button class="btn btn-sm btn-outline-primary me-2" id="btnSubmitExport" onclick="fnExcelReport();"><i class="menu-icon tf-icons bx bx-download"></i> Export</button></div>
            {{-- <div class=" my-1">
              <a href="{{ route('production-plan-export-excel',['qrCode' => $qrCode]) }}">
                <button class="btn btn-sm btn-outline-primary me-2" id="btnSubmitExport" onclick="return confirm('export excel?')">
                  <i class="menu-icon tf-icons bx bx-download"></i> Export
                </button>
              </a>
            </div> --}}
          </div>
      </div>
    </div>
  </div>
  
  <div class="mx-3 pb-4 table-responsive">
    <table class="table table-bordered table-sm table-striped report" id="table_production_plan">
      <thead>
      <tr class="table-primary">
          <th class="align-self-center" rowspan="2">Product Name</th>
          <th colspan="7">Delivery Date</th>
      </tr>
      <tr class="table-primary">
          @foreach ($dateH as $itemD)
          <th class="text-center">{{$itemD}}</th>
          @endforeach
      </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($products as $itemP) {{-- id product --}}
            <tr>
                <td colspan="1">{{ $itemP->name }}</td>  {{-- print name product in row --}}
                @foreach ($dateA as $key => $itemD) {{-- date deliver --}} 
                    <?php $aa = 'tgl-'.$key; ?> {{-- set class for angker total per day --}}
                    <td class="{{ $aa }} text-center">{{ isset($productPlan[$itemP->id][$itemD]) ? array_sum($productPlan[$itemP->id][$itemD]) : 0 }}</td> {{-- print quantity product --}}
                @endforeach
            </tr>
        @endforeach
        
      </tbody>
      <tfooter>{{-- Total Item --}}
        <tr class="table-warning">
            <td>Total Item</td>
            @foreach ($dateH as $key => $itemD)
                <?php $aa = 'tgls-'.$key; ?> {{-- set class for angker total per day --}}
                <td class="{{ $aa }} text-center">0</td>
            @endforeach
        </tr>
      </tfooter>
    </table>
  </div>
</div>
<script>
  $(document).ready(function () {
      for (let i = 0; i < 7; i++) {
          var sum = 0;
          $(`td.tgl-${i}`).each(function() {
              sum += Number($(this).text());
          });
          $(`td.tgls-${i}`).text(sum);   
      }
  })
  function fnExcelReport()
  {
    $a = confirm('Export Excel?');

      if ($a) {
        var date = "{{ $noww->format('D, d-M-Y h:m:s') }}";
        var tab_text=`<table border='2px'><tr>Last update : ${date}`;
        var textRange; var j=0;
        tab = document.getElementById('table_production_plan'); // id of table

        for(j = 0 ; j < tab.rows.length ; j++) 
        {     
            tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
            //tab_text=tab_text+"</tr>";
        }

        tab_text=tab_text+"</table>";
        tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
        tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
        tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE "); 

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open("txt/html","replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus(); 
            sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xlsx");
        }  
        else                 //other browser not tested on IE 11
            sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

        return (sa);
      }
    }
</script>