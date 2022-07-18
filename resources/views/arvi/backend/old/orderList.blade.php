<style>
    .sticky-top {
        z-index: 2;
    }
</style>
<div class="row">
    {{-- set fillter date --}}
    <div class="col-6">
        <div class="input-group mb-3">
            <div class="col-3">
                <select class="form-select applyClass" id="typeDate" aria-label="Example select with button addon">
                    <option value="1" selected>Order Date</option>
                    <option value="2">Deliver Date</option>
                </select>
            </div>
            <div class="col-4">
                <input name="daterange" class="form-control" type="text">
            </div>
            <button class="btn btn-outline-secondary" type="button" id="reset-filter-day-order">Reset</button>
            <button class="btn btn-outline-secondary" type="button" id="reset-filter-day-order" onclick="exportTableToExcel('table_order', 'table_order_{{ $noww->format('d-m-Y') }}')">Export to XLS</button>
        </div>
    </div>
    <div class="scrollable">
        <table id="table_order" class="table table-bordered table-hover">
            <thead>
                <tr class="bg-dark text-white">
                    <th colspan="12"></th>
                    <th colspan="3">Last Update : {{ $noww->format('D, d-M-Y h:m') }}</th>
                </tr>
                <tr class="sticky-top bg-dark text-white">
                    <th>Order Date</th>
                    <th>Delivery Date</th>
                    <th>Order Id</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Customer Phone</th>
                    <th>Delivery Type</th>
                    <th>Address</th>
                    <th>Black Coffee</th>
                    <th>Strong Black Coffee</th>
                    <th>Oat Milk Coffee</th>
                    <th>Milk & Manuka Honey</th>
                    <th>Coffee	Hojicha Green Tea</th>
                    <th>Rooibos Orange Tea</th>
                    <th>Total Item</th>
                </tr>
            </thead>
            <tbody >
                @foreach ($joinForOrderDetails as $item)
                    <tr class="od-{{ date("d-m-Y", strtotime($item->create_time)) }} dd-{{ date("d-m-Y", strtotime($item->day_deliver)) }}  all-order">
                        <td>{{ date("d-m-Y", strtotime($item->create_time)) }}</td>
                        <td>{{ date("d-m-Y", strtotime($item->day_deliver)) }}</td>
                        <td>{{ $item->id }}</td>
                        <td class="align-left">{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->mobile_number }}</td>
                        <td>Pickup</td>
                        <td class="align-left">{{ $item->address }}</td>
                        @for ($i = 1; $i <= $countProduct; $i++) {{-- set itteration for print quantity product --}}
                        <td class="qty{{$i}}">{{!empty($productsOrder[$item->id][$i]) ? (int)$productsOrder[$item->id][$i] : (int)0}}</td>
                        @endfor
                        <td class="qtyTotal">{{array_sum($productsOrder[$item->id])}}</td>
                    </tr>
                @endforeach       
                    {{-- sum --}}
                    <tr>
                        <td colspan="7"></td>
                        <td>Total</td>
                        <td id="result1">0</td>
                        <td id="result2">0</td>
                        <td id="result3">0</td>
                        <td id="result4">0</td>
                        <td id="result5">0</td>
                        <td id="result6">0</td>
                        <td id="resultTotal">0</td>
                    </tr>
            </tbody>
        </table>
        {{-- <button >Export Table Data To Excel File</button> --}}
    </div>
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    
    // export table
    function exportTableToExcel(tableID, filename = ''){
        $a = confirm('Export Excel?');

        if ($a) {
        
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById(tableID);
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
            
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

    $(document).ready(function () {


        countAll();
        // Reset filter
        $('#reset-filter-day-order').on('click',function () {
            $('tr.all-order').show();
        })
        // custom datepicker
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        });
        // when date pick on click
        $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            getDatesInRange(new Date(picker.startDate.format('YYYY-MM-DD')), new Date(picker.endDate.format('YYYY-MM-DD')));
        });
        // if type change
        // $('.applyClass').on('change','apply.daterangepicker', function(ev, picker) {
        //     getDatesInRange(new Date(picker.startDate.format('YYYY-MM-DD')), new Date(picker.endDate.format('YYYY-MM-DD')));
        // });
        //a simple date formatting function
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
        function getDatesInRange(startDate, endDate) {
            // hide all order
            $('tr.all-order').hide();
            const date = new Date(startDate.getTime());
            const dates = [];

            switch ($('#typeDate').find(":selected").text()) {
                case 'Order Date':
                    // alert('Order Date');
                    var angkerDate = 'od';
                    break;
                case 'Deliver Date':
                    // alert('Deliver Date');
                    var angkerDate = 'dd';
                    break;
            }

            while (date <= endDate) {
                // set date in choosed to display
                $(`tr.${angkerDate}-${dateFormat(date, 'dd-MM-yyyy')}`).show();
                date.setDate(date.getDate() + 1);
            }
            countAll();
        }
        // count all product
        function countAll() {
            for (let i = 1; i <= 6; i++) {
                var sum = 0;
                $(`td.qty${i}`).each(function() {
                    if(!($(this).is(":hidden"))){
                    sum += Number($(this).text());
                    }
                });
                $(`#result${i}`).text(sum);
            }
            // count all product total
            var sum = 0;
            $(`td.qtyTotal`).each(function() {
                if(!($(this).is(":hidden"))){
                    sum += Number($(this).text());
                }
            });
            $(`#resultTotal`).text(sum);
        }
    })
</script>