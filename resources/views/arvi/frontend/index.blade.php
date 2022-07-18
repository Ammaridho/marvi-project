@extends('arvi.layouts.main')

@section('content')

<body class="wheel theme-default">

  <div class="fixed-bottom text-center bg-nav border-top ">
    <div class="container mb-3">
      <div class="row justify-content-center align-items-center g-0">
        <div class="col-12 col-md-8 text-center">
          <div class="d-flex justify-content-between">
            <div class="f-10 mt-3">Powered by Oobe.ai</div>
            <div>
              <span class="arrowUp"><i class="fas fa-angle-up"></i></span>
              <span class="arrowDown"><i class="fas fa-angle-down"></i></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <form action="javascript:void(0);" method="POST" id="arviForm">
    @csrf
    <input type="hidden" name="merchant_id" value="{{ $merchant->id }}">

    <div class="fixed-bottom text-center shopping-cart" id="previewCart" data-bs-toggle="modal" data-bs-target="#modalCart">
      <div class="container">
        <a href="javascript:void(0)" id="cartListbutton">
          <div class="d-flex justify-content-between">
            <div><span class="badge bg-light text-dark" id="cartQ"></span></div>
              <div class="fw-bold">View Cart</div>
            <div>$<span id="cartP"></span></div>
          </div>
        </a>
      </div>
    </div>


    <!-- CONTENT -->
    <div id="fullpage">

        <!-- .section -->
        @include('arvi.frontend.section.landing-page')

        <!-- .section product -->
        @include('arvi.frontend.section.product')

        <!-- .section name -->
        @include('arvi.frontend.section.name')

        <!-- .section phone -->
        @include('arvi.frontend.section.phone')

        <!-- .section -->
        @include('arvi.frontend.section.email')

        <!-- .section (where to deliver) -->
        @include('arvi.frontend.section.recor')

        <!-- .section -->
        @include('arvi.frontend.section.order-date')

        <!-- .section -->
        @include('arvi.frontend.section.review')

        <!-- .section -->
        @include('arvi.frontend.section.payment')
    </div>

      {{-- modal question --}}
      <div class="modal__wrapper" id="modalFAQ">
        <div class="modal__content modal__content__full">
          <div class="mb-4 pb-3">
            <button type="button" class="btn-close-custom btnOnModalFAQ" state="close"><i class="fas fa-times"></i></button>
          </div>
          <div class="accordion mt-4" id="accordionFAQ">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                  Are your products halal-certified ?
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionFAQ">
                <div class="accordion-body">
                  Our products do not have any halal-certification. However, we are happy to share that our cold brews do not contain any meat or alcohol and are brewed in a meat-free and alcohol-free facility. We have also been supplying our products to halal-certified establishments under a halal-exemption waiver.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Does the cold brews need to be refrigerated ?
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionFAQ">
                <div class="accordion-body">
                  Yes, please refrigerate them upon arrival! Bootstrap cold brews are made fresh, contains zero preservatives and are unpasteurised (that's the literal definition of cold brew :P). For optimal storage, please refrigerate between 3 - 5 degrees celsius.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Where do I collect my orders ?
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionFAQ">
                <div class="accordion-body">
                  You may head over to the respective collection points that you have selected when you placed the order to collect your cold brews.
                  <ul>
                    <li>Collection Point 1: Khoo Teck Puat Hospital, Basement 1 Loading Bay @ 1030AM</li>
                    <li>Collection Point 2: Admiralty Medical Centre, #03-01, Reception Desk @ 1000AM</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  What is this program about ?
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionFAQ">
                <div class="accordion-body">
                  In recognition of the contributions from the medical community over the past 2 years, Bootstrap has launched an exciting program for all YHC staff. Under this program, staff can enjoy Bootstrap’s cold brews delivered to YHC locations daily at an exclusive rate of $3.50 per bottle (50% off U.P.)
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- addCart product --}}
      <div class="modal fade" id="modalOptions" tabindex="-1" aria-labelledby="modalOptions" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">

              <div class="modal-header border-0 image-full-wrap" style="background-image: url(/arvi/assets/img/product/Hero_Banner_sm.jpg);">
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
              </div>
              <div class="modal-body">
                <div class="text-center mt-5 p-2">
                  <h2 id="addCartProductName">{{--name product--}}</h2>
                  <h5><span id="addCartProductCurrency">{{--currency product--}}</span><span id="addCartProductPrice">{{--price product--}}</span></h5>
                  <div id="addCartProductDesc">
                    {{-- desc product --}}
                  </div>
                  <div class="mt-4">

                    <div class="counter number">
                      <span class="minus mr-1"><i class="fa fa-minus" aria-hidden="true"></i></span>
                      <input type="number"  class="input-number" id="productQuantity" max="99" min="1" readonly/>
                      <span class="plus ml-2"><i class="fa fa-plus" aria-hidden="true"></i></span>
                    </div>

                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-theme-secondary col addToChart" id="addToChart"  data-bs-toggle="modal" data-bs-target="#modalOptions">Add to Cart</button>
              </div>

          </div>
        </div>
      </div>

      {{-- cart --}}
      <div class="modal fade bottom" id="modalCart" tabindex="-1" aria-labelledby="modalCart" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
            <div class="modal-content page-xs" id="cartDetail">

            </div>
        </div>
      </div>
      {{-- <div class="modal fade modal-custom" id="modalCart" tabindex="-1" aria-labelledby="modalCart" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
          <div class="modal-content"  id="cartDetail">

          </div>
        </div>
      </div> --}}

      <!-- Modal Shopping Cart  -->
      {{-- <div class="modal fade modal-custom" id="modalCart" tabindex="-1" aria-labelledby="modalCart" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
          <div class="modal-content">
            <div class="modal-header border-0">
                <div class="fw-bold">Your Orders</div>
                <div>$90.00</div>
            </div>
            <div class="modal-body py-0">

                <div class="d-flex">
                    <div class="p-1">
                        <div class="thumbnail-cart" style="background-image: url('assets/img/product/BS-Black.jpg');"></div>
                    </div>
                    <div class="p-1 w-100">
                        <div class="fw-bold">Black Cold Brew Coffee</div>
                        <div class="d-flex justify-content-between">
                            <div>3.50</div>
                            <div>
                                <div class="counter-sm number">
                                    <span class="minus mr-1"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    <input type="number" value="1" class="input-number" max="99" min="1" disabled="">
                                    <span class="plus ml-2"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex">
                    <div class="p-1">
                        <div class="thumbnail-cart" style="background-image: url('assets/img/product/BS-Rooibos_Orange_Tea.jpg');"></div>
                    </div>
                    <div class="p-1 w-100">
                        <div class="fw-bold">Rooibos Orange Tea</div>
                        <div class="d-flex justify-content-between">
                            <div>3.50</div>
                            <div>
                                <div class="counter-sm number">
                                    <span class="minus mr-1"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    <input type="number" value="1" class="input-number" max="99" min="1" disabled="">
                                    <span class="plus ml-2"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-theme-secondary col" data-bs-dismiss="modal" aria-label="Close" id="rollCheckout">Procceed to Checkout</button>
            </div>
          </div>
        </div>
      </div> --}}

      <!-- Modal Calendar -->
      <div class="modal fade bottom" id="modalCalendar" tabindex="-1" aria-labelledby="modalCalendar" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
            <div class="modal-content page-xs">
                <div class="modal-body">

                    <div class="text-center">
                      <div class="pickDate"></div>
                    </div>

                </div>
            </div>
        </div>
      </div>
  </form>

  @include('arvi.frontend.section.i18n')
  <script>
    let locMAware = false;
    @if ($allowLocation == 1 )
    locMAware = true;
    @endif
    let dFut = "{{$futureDate}}";
    let dTom = "{{$tomorrowDate}}";
    let urlVC = "{{ route('view-cart',[],false) }}";
    let urlRevw = "{{ route('review-otf',[],false) }}";
    let urlPayBook = "{{ route('payment-book',[],false) }}";
</script>
</body>

@endsection
