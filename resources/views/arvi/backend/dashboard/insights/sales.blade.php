<!-- filter -->
<div class="row mb-3">
  <div class="col-lg-3 order-0">
    <div class="card h-100">
      <div class="card-body m-0 p-2">
        <input type="text" id="dateFilter" class="form-control form-control-custom" />                  
      </div>
    </div>
  </div>
  <div class="col-lg-3 order-1">
    <div class="card h-100">
      <div class="card-body m-0 p-2">
        <select class="default-select-single" name="select-store" style="width: 100%;">
          <option>Select Store</option>
          <option value="ACI">Ayam Cabe Ijo - Kuningan</option>
          <option value="ACI2">Ayam Cabe Ijo - Mall Ambasador</option>
        </select>
      </div>
    </div>
  </div>
</div>
<!-- //filter -->

<div class="row">
  <div class="col-lg-6 mb-4 order-0">
    
      <!-- Hello -->
      <div class="card h-100">
        <div class="d-flex align-items-end row">
          <div class="col-sm-7">
            <div class="card-body">
              <h5 class="card-title text-primary">Congratulations! 🎉</h5>
              <p class="mb-4">
                So far you have <span class="fw-bold">135</span> orders for today!
              </p>

              <a href="page-report.php" class="btn btn-sm btn-outline-primary">View orders</a>
            </div>
          </div>
          <div class="col-sm-5 text-center text-sm-left">
            <div class="pb-0 px-0">
              <img src="/arvi/backend-assets/img/illustrations/man-with-laptop-light.png" height="130" />
            </div>
          </div>
        </div>
      </div>
      <!-- //Hello -->

    </div>
    <div class="col-lg-2 mb-4 order-0">

      <!-- Order plan -->
      <div class="card h-100">
        <div class="card-body">
          <span class="fw-semibold d-block mb-1">Sales Today</span>
          <h4 class="card-title mb-2">$ 2.628</h4>
          <small class="fw-semibold">
            <div class="text-success"><i class="bx bx-up-arrow-alt"></i> +22%</div>
            <div>from yesterday</div>
          </small>
        </div>
      </div>
      <!-- //Order plan -->

    </div>
    <div class="col-lg-4 mb-4 order-0">

      <!-- site visit -->
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
              <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                <div class="card-title">
                  <h6 class="text-nowrap mb-2">Site Visit</h6>
                  <span class="badge bg-label-warning rounded-pill">TODAY</span>
                </div>
                <div class="mt-sm-auto">
                  <small class="text-success text-nowrap fw-semibold"><i class="bx bx-chevron-up"></i> 68.2%</small>
                  <h6 class="mb-0 text-nowrap">341 Views</h6>
                </div>
              </div>
              <div id="salesReportChart"></div>
            </div>
        </div>
      </div>
      <!-- //site visit -->

    </div>
    <div class="col-lg-4 mb-4 order-0">

      <!-- Production plan -->
      <div class="card h-100">
        <div class="card-body">
          <h5 class="m-0 me-2">Orders Statistics</h5>
          <small class="text-muted">Rp 410.000 Total Sales</small>
          <div id="incomeChart"></div>
        </div>
      </div>
      <!-- //Production plan -->

    </div>
    <div class="col-lg-4 mb-4 order-0">

      <!-- Production plan -->
      <div class="card h-100">
        <div class="card-body text-center">
          <h5 class="m-0 me-2">Favorite Menu Categories</h5>
          <small class="text-muted">&nbsp;</small>
          <div class="d-flex justify-content-center align-items-center">
            <div id="orderStatisticsChart"></div>
          </div>
        </div>
      </div>
      <!-- //Production plan -->

    </div>

  </div>
</div>

<script src="/arvi/backend-assets/js/demo.js"></script>
<script src="/arvi/backend-assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="/arvi/backend-assets/js/dashboards-analytics.js"></script>