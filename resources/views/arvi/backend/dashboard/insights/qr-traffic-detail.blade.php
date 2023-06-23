<div class="row">
     <div class="ol-12 col-md-12 mb-4 order-0">
          <div class="card h-100">
               <div class="card-body">

                    <div class="row">
                         <div class="col-12 col-md-2">
                              <h5 class="card-title m-0 mb-1">Total QR Access</h5>
                              <h1 class="card-title m-0">{{array_sum($totalAccess['user'])}}</h1>
                              <span>Users</span>
                         </div>
                         <div class="col-12 col-md-10">
                              <h5 class="card-title m-0 mb-4">Site Visit</h5>
                              <div id="siteTraffic"></div>
                         </div>
                    </div>
                    
               </div>
          </div>
     </div>
     <div class="col-12 col-md-12 mb-4">
          <div class="card h-100">
               <div class="card-body">
                    <div class="row">
                         <div class="col-12">
                              <h5 class="card-title m-0 mb-4">Engagement</h5>
                         </div>
                         <div class="col-12 col-md-6">
                              <div class="table">
                                   <table class="table">
                                        <thead>
                                             <tr>
                                                  <th class="w-100">Event name</span>
                                                  </th>
                                                  <th class="text-nowrap">Event count</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             @foreach ($events as $item)
                                             <tr>
                                                  <td>{{$item->getDimensionValues()[0]->getValue()}}</td>
                                                  <td>{{$item->getMetricValues()[0]->getValue()}}</td>
                                             </tr>
                                             @endforeach
                                        </tbody>
                                   </table>
                              </div>

                         </div>
                         <div class="col-12 col-md-6">
                              <div class="table">
                                   <table class="table">
                                        <thead>
                                             <tr>
                                                  <th class="w-100">User acquisition</th>
                                                  <th class="text-nowrap">Users</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             @foreach ($userAcquisition as $item)
                                             <tr>
                                                  <td>{{$item->getDimensionValues()[0]->getValue()}}</td>
                                                  <td>{{$item->getMetricValues()[0]->getValue()}}</td>
                                             </tr>
                                             @endforeach
                                        </tbody>
                                   </table>
                              </div>

                         </div>
                    </div>
               </div>
          </div>
     </div>
     <div class="col-12 col-md-4 mb-4">
          <div class="card h-100">
               <div class="card-body">
                    <div class="table">
                         <table class="table">
                              <thead>
                                   <tr>
                                        <th class="w-100">Landing Page</th>
                                        <th class="text-nowrap">Sessions</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   @foreach ($landingPage as $item)
                                   <tr>
                                        <td>{{$item->getDimensionValues()[0]->getValue()}}</td>
                                        <td>{{$item->getMetricValues()[0]->getValue()}}</td>
                                   </tr>
                                   @endforeach
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
     <div class="col-12 col-md-4 mb-4">
          <div class="card h-100">
               <div class="card-body">
                    <div class="table">
                         <table class="table">
                              <thead>
                                   <tr>
                                        <th class="w-100">Page Title</th>
                                        <th class="text-nowrap">Views</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   @foreach ($titlePage as $item)
                                   <tr>
                                        <td>{{$item->getDimensionValues()[0]->getValue()}}</td>
                                        <td>{{$item->getMetricValues()[0]->getValue()}}</td>
                                   </tr>
                                   @endforeach
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
     <div class="col-12 col-md-4 mb-4">
          <div class="card h-100">
               <div class="card-body">
                    <div class="table">
                         <table class="table">
                              <thead>
                                   <tr>
                                        <th class="w-100">Demographics by country</th>
                                        <th class="text-nowrap">Users</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   @foreach ($demographic as $item)
                                   <tr>
                                        <td>{{$item->getDimensionValues()[0]->getValue()}}</td>
                                        <td>{{$item->getMetricValues()[0]->getValue()}}</td>
                                   </tr>
                                   @endforeach
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
     <div class="col-12 col-md-4 mb-4">
          <div class="card h-100">
               <div class="card-body">

                    <h5 class="card-title m-0 mb-4">Operating System</h5>
                    <div id="os"></div>

               </div>
          </div>
     </div>
     <div class="col-12 col-md-4 mb-4">
          <div class="card h-100">
               <div class="card-body">

                    <h5 class="card-title m-0 mb-4">By Device Category</h5>
                    <div id="device"></div>

               </div>
          </div>
     </div>
     <div class="col-12 col-md-8 mb-4 order-0">
          <div class="card h-100">
               <div class="card-body">

                    <div class="row g-0">
                         <div class="col-12 col-md-6">
                              <h5 class="card-title m-0 mb-4">Claim</h5>
                              <div id="claimStat"></div>
                         </div>
                         <div class="col-12 col-md-6">
                              <h5 class="card-title m-0 mb-4">Redeem</h5>
                              <div id="redeemStat"></div>
                         </div>
                    </div>

               </div>
          </div>
     </div>
</div>

<script>
     var totalAccess = <?php echo json_encode($totalAccess); ?>;
     var deviceCategory = <?php echo json_encode($deviceCategory); ?>;
     var operatingSystem = <?php echo json_encode($operatingSystem); ?>;
</script>

<script src="/arvi/backend-assets/js/demo.js"></script>
<script src="/arvi/backend-assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="/arvi/backend-assets/js/dashboards-analytics.js"></script>
<script type="text/javascript" src="/arvi/backend-assets/js/insights.js"></script>