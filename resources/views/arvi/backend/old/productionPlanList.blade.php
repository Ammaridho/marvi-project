<div class="row">
    <div class="col-4">
        <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" type="button" id="reset-filter-day-order" onclick="exportTableToExcel('table_production_plan', 'table_production_plan_{{ $noww->format('d-m-Y') }}')">Export to XLS</button>
        </div>
    </div>
    <div class="scrollable">    
        <table id="table_production_plan" class="table table-bordered table-hover">
            <thead>
                <tr class="bg-dark text-white">
                    <th colspan="4"></th>
                    <th colspan="4">Last Update : {{ $noww->format('D, d-M-Y h:m') }}</th>
                </tr>
                <tr class="sticky-top bg-dark text-white">
                    <th class="align-self-center" rowspan="2">Product Name</th>
                    <th colspan="7">Delivery Date</th>
                </tr>
                <tr class="sticky-top bg-dark text-white">
                    @foreach ($dateH as $itemD)
                    <th>{{$itemD}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody >
                @foreach ($products as $itemP) {{-- id product --}}
                    <tr>
                        <td colspan="1">{{ $itemP->name }}</td>  {{-- print name product in row --}}
                        @foreach ($dateA as $key => $itemD) {{-- date deliver --}} 
                            <?php $aa = 'tgl-'.$key; ?> {{-- set class for angker total per day --}}
                            <td class="{{ $aa }}">{{ isset($productPlan[$itemP->id][$itemD]) ? array_sum($productPlan[$itemP->id][$itemD]) : 0 }}</td> {{-- print quantity product --}}
                        @endforeach
                    </tr>
                @endforeach
                {{-- Total Item --}}
                <tr>
                    <td>Total Item</td>
                    @foreach ($dateH as $key => $itemD)
                        <?php $aa = 'tgls-'.$key; ?> {{-- set class for angker total per day --}}
                        <td class="{{ $aa }}">0</td>
                    @endforeach
                </tr>
            </tbody>
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
</script>