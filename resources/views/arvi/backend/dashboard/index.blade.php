<div class="row mb-3 justify-content-center">
  <div class="col-lg-6 col-md-7 col-sm-12 order-0">
    <!-- Check list -->
    <div class="card mb-3">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <h6 class="fw-bold">Launch checklist</h6>
          <div class="small"><span id="percentage-success"></span>% complete</div>
        </div>
      </div>
      <div class="card-body">
        <div class="text-center mb-3">
          <img src="/arvi/backend-assets/img/illustrations/ill_baording.svg" 
          class="img-onboarding" />
        </div>
        <div class="onboarding">
          <ol class="m-0">
            <li>
              <a href="javascript:void(0)" class="d-block" id="create-brand">
                Create you first Brand! 
                <i class='bx bx-check 
                {{$first_brand_exist?'text-success':'text-gray'}} 
                float-end'></i>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)" class="d-block" id="create-merchant">
                Create your store 
                <i class='bx bx-check 
                {{$first_merchant_exist?'text-success':'text-gray'}} 
                float-end'></i>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)" class="d-block" id="create-hours"> 
                Set your trading hours 
                <i class='bx bx-check 
                {{$first_hours_exist?'text-success':'text-gray'}} 
                float-end' ></i>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)" class="d-block" id="create-menu">
                Create your first menu item 
                <i class='bx bx-check 
                {{$first_brand_product_exist?'text-success':'text-gray'}} 
                float-end' ></i>
              </a>
            </li>
          </ol>
        </div>

        <hr />
        <div class="d-flex justify-content-between small">
          <div><span id="much-success"></span> tasks remaining</div>
        </div>
      </div>
    </div>
    <!-- //Check list -->

    <!-- improvement -->
    <div class="card mb-3">
      <div class="card-body">
        <h6 class="fw-bold">Want to suggest a feature or improvement?</h6>
        <hr />
        <div>Feedback from hospitality businesses is what shapes the future of the 
          Oobe platform. If you have an idea, we'd love to hear it.</div>
        <div class="mt-3">
          <a href="#" class="btn btn-sm btn-outline-primary">Make a suggestion 
            <i class='bx bx-link-external' ></i>
          </a>
        </div>
      </div>
    </div>
    <!-- //improvement -->

  </div>
  <div class="col-lg-3 col-md-5 col-sm-12 order-1">
    <!-- store status  -->
    <div class="card mb-3">
      <div class="card-body">
        <h6 class="fw-bold">Store status</h6>
        
        <div class="fs-4 mt-3">Not available</div>
        <hr />
        <div class="small">Follow the launch checklist to 
          prepare your store for customers.</div>
      </div>
    </div>
    <!-- //store status -->
    <!-- Share -->
    <div class="card mb-3 d-none">
      <div class="card-body">
        <div>
          <h6 class="fw-bold">QR codes</h6>
          <div>Streamline menu access for your customers with QR codes that 
            can be scanned with a phone camera.</div>
          <div class="d-grid my-3">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" 
              data-bs-target="#modalGenerateQR">
              <i class="tf-icons bx bx-qr-scan"></i> Open QR code
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- //Share -->
   
  </div>
</div>

<!--
  ================================================
  MODAL's
  ================================================
  -->
  <!-- modal generate QR -->
  <div class="modal fade" id="modalGenerateQR" tabindex="-1" 
  aria-labelledby="modalGenerateQR" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">QR codes</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" 
          aria-label="Close"></button>
        </div>
        <div class="modal-body pt-2">
        
          <ul class="nav nav-tabs small" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="default-tab" data-bs-toggle="tab" 
                  data-bs-target="#default" type="button" role="tab" aria-controls="default" 
                  aria-selected="true">Default</button>
              </li>
              <li class="nav-item" role="presentation">
                  <button class="nav-link" id="store2-tab" data-bs-toggle="tab" 
                  data-bs-target="#store2" type="button" role="tab" aria-controls="store2" 
                  aria-selected="false">Store 2</button>
              </li>
              <li class="nav-item" role="presentation">
                  <button class="nav-link" id="store3-tab" data-bs-toggle="tab" 
                  data-bs-target="#store3" type="button" role="tab" aria-controls="store3" 
                  aria-selected="false">Store 3</button>
              </li>
          </ul>
          <div class="tab-content mt-3 p-1" id="myTabContent">
              <!-- QR code default -->
              <div class="tab-pane fade show active" id="default" role="tabpanel" 
              aria-labelledby="default-tab">
                  <div class="fw-bold small">Preview</div>
                  <div class="text-center">
                      <div class="fs-4">Try scanning your QR code</div>
                      <div class="mb-2 small">Point your phone camera at the code, 
                        then tap on the link that appears.</div>
                      <div class="" style="background: url('/arvi/backend-assets/img/samples/bg-phone.jpg') 
                      top center no-repeat; height: 280px; border: 1px solid #fff;">
                          <div class="" style="margin-top: 96px">
                              <img src="/arvi/backend-assets/img/samples/qr-code.png" class="" 
                              style="max-width:120px">
                          </div>
                      </div>
                  </div>
              </div>
              <!-- //QR code default -->

              <!-- QR code store 2 -->
              <div class="tab-pane fade" id="store2" role="tabpanel" aria-labelledby="store2-tab">
                  <div class="fw-bold small">Preview</div>
                  <div class="text-center">
                      <div class="fs-4">Try scanning your QR code</div>
                      <div class="mb-2 small">Point your phone camera at the code, 
                        then tap on the link that appears.</div>
                      <div class="" style="background: url('/arvi/backend-assets/img/samples/bg-phone.jpg') 
                      top center no-repeat; height: 280px; border: 1px solid #fff;">
                          <div class="" style="margin-top: 96px">
                              <img src="/arvi/backend-assets/img/samples/qr-code.png" class="" 
                              style="max-width:120px">
                          </div>
                      </div>
                  </div>
              </div>
              <!-- //QR code store 2 -->

              <!-- QR code store 3 -->
              <div class="tab-pane fade" id="store3" role="tabpanel" aria-labelledby="store3-tab">
                  <div class="fw-bold small">Preview</div>
                  <div class="text-center">
                      <div class="fs-4">Try scanning your QR code</div>
                      <div class="mb-2 small">Point your phone camera at the code, 
                        then tap on the link that appears.</div>
                      <div class="" style="background: url('/arvi/backend-assets/img/samples/bg-phone.jpg') 
                      top center no-repeat; height: 280px; border: 1px solid #fff;">
                          <div class="" style="margin-top: 96px">
                              <img src="/arvi/backend-assets/img/samples/qr-code.png" class="" 
                              style="max-width:120px">
                          </div>
                      </div>
                  </div>
              </div>
              <!-- //QR code store 3 -->
          </div>

        </div>
        <div class="modal-footer justify-content-between border-top px-2 py-2">
          <button type="button" class="btn btn-outline-secondary flex-fill" data-bs-dismiss="modal">
            <i class="menu-icon tf-icons bx bx-printer"></i> Print
          </button>
          <button type="button" class="btn btn-outline-secondary flex-fill">
            <i class="menu-icon tf-icons bx bx-download"></i> Download
          </button>
        </div>
      </div>
    </div>
  </div>

<script>
  $( document ).ready(function() {
    // off click
    if ('{{$first_brand_exist}}' == true) {
      $("#create-brand").off('click');
    } 
    if ('{{$first_merchant_exist}}' == true) {
      $("#create-merchant").off('click');
    } 
    if ('{{$first_hours_exist}}' == true) {
      $("#create-hours").off('click');
    } 
    if ('{{$first_brand_product_exist}}' == true) {
      $("#create-menu").off('click');
    } 

    // task success
    $('#much-success').text($('.text-success').length);
    $('#percentage-success').text(25 * $('.text-success').length);
  });

  // button brand
  $('#create-brand').on('click',function () {
    $.get("{{route('manage-brand-create',['companyCode' => $companyCode])}}",
    function (data) {
        $('#contentDashboard').html(data);
    })
  })

  // button store
  $('#create-merchant').on('click',function () {
    $.get("{{route('manage-store-create',['companyCode' => $companyCode])}}",
    function (data) {
        $('#contentDashboard').html(data);
    })
  })

  // button hours
  $('#create-hours').on('click',function () {
    let first_hours = 1;
    $.get("{{route('hours-list',['companyCode' => $companyCode])}}",
    {first_hours:first_hours},function (data) {
        $('#contentDashboard').html(data);
    })
  })

  // button menu
  $('#create-menu').on('click',function () {
    let first_product = 1;
    $.get("{{route('brand-product-create',['companyCode' => $companyCode])}}",
    {first_product:first_product},function (data) {
        $('#contentDashboard').html(data);
    })
  })
</script>