<h4 class="fw-bold py-1"><span class="text-muted fw-light">Insights /</span> QR Code</h4>

<!-- filter -->
<div class="card mb-4">
     <div class="card-body m-0 p-2">
          <div class="row g-1">
               <div class="col-12 col-md-3 col-lg-3 order-0">
                    <input type="text" id="dateFilter" class="form-control form-control-custom" />
               </div>
               <div class="col-12 col-md-4 col-lg-3 order-1">
                    <select class="form-control default-select-single" id="select-store" style="width: 100%;">
                         <option value="0">Select Store</option>
                         @foreach ($merchants as $item)
                              <option value="{{$item->id}}">{{$item->name}} - {{$item->address}}</option>
                         @endforeach
                    </select>
               </div>
               <div class="col-12 col-md-4 col-lg-3 order-3">
                    <button class="form-control-custom btn btn-primary" id="submit-filter-insight-qr">Submit</button>
               </div>
          </div>
     </div>
</div>
<!-- //filter -->

<div id="show-detail-qr-traffic"></div>

<script src="/arvi/backend-assets/js/demo.js"></script>
<script>
     // open chart
     $('#submit-filter-insight-qr').on('click',function () {

          // date filter
          let dateFilter = $('#dateFilter').val();
          let startDate = new Date(dateFilter.substring(0, 10));
          startDate = moment(startDate).format('YYYY-MM-D');
          let endDate = new Date(dateFilter.substring(13));
          endDate = moment(endDate).format('YYYY-MM-D');

          let merchantId = $('#select-store').val();

          $('#show-detail-qr-traffic').html('Please wait...');

          if (merchantId > 0) {
               $.get("{{ secure_url(route('insight-qr-dashboard-show', ['companyCode' => $companyCode], true)) }}",
               {id:merchantId,startDate:startDate,endDate:endDate},function (data) {
                    $('#show-detail-qr-traffic').html(data);
               }).fail(function(data) {
                    $('#show-detail-qr-traffic').html('Please check configuration GA4 on manage store!');
               });
          } else {
               $('#show-detail-qr-traffic').html('Please choose store!');
          }
     });
</script>