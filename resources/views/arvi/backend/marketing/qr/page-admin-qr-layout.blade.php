<!-- Content wrapper -->
<div class="content-wrapper">
     <div class="container-xxl flex-grow-1 container-p-y">
          <div class="row justify-content-start">
               <div class="col-lg-12 col-md-12 col-12">
                    <!-- -->
                    <div class="card mb-3">
                         <div class="card-body">
                              <div class="d-flex justify-content-between 
                              align-items-center">
                                   <h4 class="m-0">Manage QR Layout</h4>
                                   <div>
                                        <a href="javascript:void(0);"
                                             onclick="$('#manage-qr').trigger('click')">
                                             <i class="fas fa-chevron-left"></i> back
                                        </a>
                                   </div>
                              </div>
                              <hr>
                              <form id="manageStore" method="post" enctype="multipart/form-data">
                                   @csrf
                                   <div class="row">
                                        <div class="col-12 col-md-5">

                                             <input type="hidden" name="id" value="{{$qr->id}}">

                                             <div class="mb-3">
                                                  <label for="btnInserLogo" 
                                                  class="form-label">Upload Logo</label>
                                                  <div class="mb-3">
                                                       <input class="form-control file" 
                                                       type="file" id="btnInserLogo" 
                                                       name="image_logo_poster" accept="image/*">
                                                       <div id="storeNamepHelp" 
                                                       class="form-text text-danger d-none"> 
                                                            Error message here.
                                                       </div>
                                                       <small>
                                                            Image dimension should be 
                                                            120px x 120px and less than 1MB. 
                                                            File format png or transparent.
                                                       </small>
                                                  </div>
                                             </div>

                                             <div class="mb-3">
                                                  <label for="btnInserbackground" class="form-label">
                                                       Upload Background Image
                                                  </label>
                                                  <div class="mb-3">
                                                       <input class="form-control file" type="file" 
                                                       name="image_background_poster" 
                                                       id="btnInserbackground" accept="image/*">
                                                       <div id="storeNamepHelp" 
                                                       class="form-text text-danger d-none"> 
                                                            Error message here.
                                                       </div>
                                                       <small>
                                                            Image dimension should be 
                                                            1200px x 800px and less than 10MB
                                                       </small>
                                                  </div>
                                             </div>

                                             <div class="mb-0">
                                                  <div class="d-flex">
                                                       <div class="position-relative w-100 me-2">
                                                            <label for="inputTitle" class="form-label">
                                                                 Title
                                                            </label>
                                                            <div class="form-text input-count me-3">
                                                                 <span id="countNow">0</span> / 50
                                                            </div>
                                                            <div class="mb-3">
                                                                 <input type="text" class="form-control
                                                                 input-counter" name="title_poster" 
                                                                 @if (isset($qr->title_poster))
                                                                      value="{{$qr->title_poster}}" 
                                                                 @else
                                                                      value="YOUR MENU TITLE"
                                                                 @endif
                                                                 id="inputTitle" 
                                                                 maxlength="50" required autocomplete="off">
                                                                 <div id="inputTitle" class="form-text 
                                                                 text-danger d-none"> Error message here.</div>
                                                            </div>
                                                       </div>
                                                       <div style="height: 25px">
                                                            <label for="color1" class="form-label 
                                                            text-nowrap">&nbsp;</label>
                                                            <input type="color" class="form-control 
                                                            form-control-color" name="title_color_poster"
                                                            @if (isset($qr->title_color_poster))
                                                                 value="{{$qr->title_color_poster}}" 
                                                            @else
                                                                 value="#ffffff" 
                                                            @endif
                                                            id="color1"title="Choose font color">
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="mb-0">
                                                  <div class="d-flex">
                                                       <div class="position-relative w-100 me-2">
                                                            <label for="inputSubTitle" class="form-label">
                                                                 Sub Title
                                                            </label>
                                                            <div class="form-text input-count me-3">
                                                                 <span id="countNow">0</span> / 60
                                                            </div>
                                                            <div class="mb-3">
                                                                 <input type="text" class="form-control input-counter" 
                                                                 name="sub_title_poster"
                                                                 @if (isset($qr->sub_title_poster))
                                                                      value="{{$qr->sub_title_poster}}" 
                                                                 @else
                                                                      value="Subtitle"
                                                                 @endif
                                                                 id="inputSubTitle" 
                                                                 maxlength="60" autocomplete="off">
                                                                 <div id="storeNamepHelp" class="form-text 
                                                                 text-danger d-none"> Error message here.</div>
                                                            </div>
                                                       </div>
                                                       <div style="height: 25px">
                                                            <label for="color2" class="form-label text-nowrap">&nbsp;</label>
                                                            <input type="color" class="form-control form-control-color" 
                                                            name="sub_title_color_poster" 
                                                            @if (isset($qr->sub_title_color_poster))
                                                                 value="{{$qr->sub_title_color_poster}}" 
                                                            @else
                                                                 value="#ffffff" 
                                                            @endif
                                                            id="color2" title="Choose font color">
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="mb-2">
                                                  <div class="d-flex">
                                                       <div class="position-relative w-100 me-2">
                                                            <label for="shortdesc" 
                                                            class="form-label d-block">
                                                                 Short Description *
                                                                 <span id="the-count">
                                                                      <span class="me-1 form-text float-end">
                                                                           <span id="current">0</span> / 200
                                                                      </span>
                                                                 </span>
                                                            </label>
                                                            <textarea class="form-control" id="shortdesc" 
                                                            name="description_poster" rows="2" maxlength="200"
                                                            >{{isset($qr->description_poster)?$qr->description_poster:'Short description.'}}</textarea>
                                                            <div id="descriptionHelp" class="form-text text-danger 
                                                            d-none">Error message here.</div>
                                                       </div>
                                                       <div style="height: 25px">
                                                            <label for="color3" class="form-label text-nowrap">&nbsp;</label>
                                                            <input type="color" class="form-control 
                                                            form-control-color" name="description_color_poster" 
                                                            id="color3" 
                                                            @if (isset($qr->description_color_poster))
                                                                 value="{{$qr->description_color_poster}}"
                                                            @else
                                                                 value="#ffffff"
                                                            @endif
                                                            title="Choose font color">
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="mb-3">
                                                  <div class="d-flex">
                                                       <div class="position-relative w-100 me-2">
                                                            <label for="inputHelper" class="form-label">Helper</label>
                                                            <div class="mb-3">
                                                                 <input type="text" class="form-control input-counter" 
                                                                 id="inputHelper" name="helper_poster" 
                                                                  maxlength="70" autocomplete="off" 
                                                                 @if (isset($qr->helper_poster))
                                                                      value="{{$qr->helper_poster}}"
                                                                 @else
                                                                      value="To view the menu, simply scan the QR code with your mobile camera."
                                                                 @endif
                                                                 >
                                                                 <div id="storeNamepHelp" 
                                                                 class="form-text text-danger d-none"> 
                                                                      Error message here.
                                                                 </div>
                                                            </div>
                                                       </div>
                                                       <div style="height: 25px">
                                                            <label for="color4" class="form-label 
                                                            text-nowrap">&nbsp;</label>
                                                            <input type="color" class="form-control 
                                                            form-control-color" name="helper_color_poster"
                                                            @if (isset($qr->helper_color_poster))
                                                                 value="{{$qr->helper_color_poster}}"
                                                            @else
                                                                 value="#ffffff" 
                                                            @endif
                                                             id="color4" title="Choose font color">
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="form-check mb-3">
                                                  <input class="form-check-input 
                                                  locationShow" type="checkbox" 
                                                  name="show_store_loc_poster" 
                                                  value="1" id="show_store_loc_poster">
                                                  <label class="form-check-label" 
                                                  for="show_store_loc_poster">
                                                       Show store location
                                                  </label>
                                             </div>

                                             <div class="form-check mb-3">
                                                  <input class="form-check-input 
                                                  socialShow" type="checkbox" 
                                                  name="show_social_icons_poster" 
                                                  value="1" id="show_social_icons_poster">
                                                  <label class="form-check-label" 
                                                  for="show_social_icons_poster">
                                                       Show social icons
                                                  </label>
                                             </div>

                                             <div class="mb-3">
                                                  <label for="color1" class="form-label">
                                                       Customize template
                                                  </label>
                                                  <div class="mb-3 d-flex">
                                                       <div class="me-3 border-end pe-3">
                                                            <label for="colorText" class="form-label">
                                                                 Global text
                                                            </label>
                                                            <input type="color" class="form-control 
                                                            form-control-color" name="global_text_color_poster"
                                                            @if (isset($qr->global_text_color_poster))
                                                                 value="{{$qr->global_text_color_poster}}"
                                                            @else
                                                                 value="#ffffff" 
                                                            @endif
                                                            id="colorText" style="height: 40px" 
                                                            title="Choose font color">
                                                       </div>
                                                       <div class="me-3 border-end pe-3">
                                                            <label for="colorBackground" 
                                                            class="form-label">Background</label>
                                                            <input type="color" class="form-control 
                                                            form-control-color" name="backgrount_color_poster"
                                                            @if (isset($qr->backgrount_color_poster))
                                                                 value="{{$qr->backgrount_color_poster}}"
                                                            @else
                                                                 value="#ff5500" 
                                                            @endif
                                                            id="colorBackground" style="height: 40px" 
                                                            title="Choose primary color">
                                                       </div>     
                                                  </div>
                                             </div>

                                             <div class="mb-3 mt-5">
                                                  <button class="btn btn-primary w-100" 
                                                  type="submit">Save</button>
                                             </div>

                                        </div>
                                        <div class="col-12 col-md-7">
                                             
                                             <div class="theme-one" id="theme-one" style="width:740px;">

                                                  

                                                  <div class="d-flex align-items-end imgBackground" id="imageName" 
                                                  @if ($qr->image_background_poster)
                                                       style="background: url('/storage/arvi/backend-assets/img/qr-posters/backgrounds/{{$qr->image_background_poster}}');"
                                                  @else
                                                       style="background: url('/arvi/backend-assets/img/default/qr-poster/image-sample.jpg');"
                                                  @endif
                                                  >
                                                       
                                                       <svg style="position: relative; z-index: 80;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill-opacity="1" d="M0,0L48,26.7C96,53,192,107,288,117.3C384,128,480,96,576,96C672,96,768,128,864,170.7C960,213,1056,267,1152,293.3C1248,320,1344,320,1392,320L1440,320L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
                                                       
                                                       <div class="text-center text-end" style="position: relative; z-index: 100; right:15px; bottom: 270px;">
                                                            <div class="d-flex justify-content-center 
                                                            align-items-center text-center logos">
                                                                 <img class="viewLogo" alt="Your logo" 
                                                                 @if ($qr->image_logo_poster)
                                                                      src="/storage/arvi/backend-assets/img/qr-posters/logos/{{$qr->image_logo_poster}}" 
                                                                 @else
                                                                      src="/arvi/backend-assets/img/default/qr-poster/logo-poster.jpeg" 
                                                                 @endif
                                                                 onerror="this.src=`data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg'></svg>`;"/>
                                                            </div>
                                                       </div>
                                                       
                                                  </div>
                                             
                                                  <div class="p-5 spacerTop">
                                                       
                                                       <h1 id="wtitle" class="display-1 fw-bold m-0 p-0 mt-5">
                                                            @if ($qr->title_poster)
                                                                {{$qr->title_poster}}
                                                            @else
                                                                 YOUR MENU TITLE
                                                            @endif 
                                                       </h1>
                                                       
                                                       <h2 id="wsubtitle" class="fw-bold m-0 p-0">
                                                            @if ($qr->sub_title_poster)
                                                                {{$qr->sub_title_poster}}
                                                            @else
                                                                 Subtitle
                                                            @endif 
                                                       </h2>
                                                       
                                                       <h4 id="wdesc" class="m-0 p-0 mt-2 lh-lg">
                                                            @if ($qr->description_poster)
                                                                {{$qr->description_poster}}
                                                            @else
                                                                 Short description.
                                                            @endif 
                                                       </h4>

                                                       <div class="d-flex align-items-center my-5">
                                                            <div class="bg-white p-2 rounded mt-4 qrsize">
                                                                 <div class="img-fluid" id="qrcode"></div>
                                                            </div>
                                                            <div class="ms-4 helperContainer">
                                                                 <span class="fw-bolder h4" id="whelper">
                                                                      @if ($qr->helper_poster)
                                                                           {{$qr->helper_poster}}
                                                                      @else
                                                                      To view the menu, simply scan the QR code with your mobile camera.
                                                                      @endif 
                                                                 </span>
                                                            </div>
                                                       </div>

                                                       <div class="socialCon mt-3">
                                                            <div class="text-center text-nowrap d-flex 
                                                            justify-content-center align-items-center">
                                                                 @foreach ($qr->merchant->merchantSocialReference as $item)
                                                                      <div class="d-flex align-items-center me-3">
                                                                           <i class="fab fa-{{$item->type}}-square fa-2x me-2"></i>
                                                                           @if($item->type == 'facebook')
                                                                                {{$item->name}}
                                                                           @else
                                                                                <span>@</span>{{$item->name}}
                                                                           @endif
                                                                      </div>
                                                                 @endforeach
                                                            </div>
                                                       </div>
                                                       
                                                       <div class="mt-4 footer d-flex justify-content-between 
                                                       align-items-center border-top pt-3 footer-desc">
                                                            <div class="fw-bold h5 m-0 text-white">
                                                                 <span class="locationCon p-2 p-3 rounded 
                                                                 bg-white text-black">
                                                                      #{{$qr->merchant->location->first()->name}}
                                                                 </span>
                                                            </div>
                                                            <div class="text-center text-end">
                                                                 <img src="/arvi/backend-assets/img/logo/oobe-logo-horizontal-white.png" class="oobe" />
                                                                 <div class="small">Get your digital menu with Oobe.id</div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="my-2 text-nowrap">
                                                  <button type="button" class="btn 
                                                  btn-outline-secondary w-100" id="download-poster">
                                                       <i class="fas fa-download"></i> Download Poster
                                                  </button>
                                             </div>

                                        </div>
                                   </div>
                              </form>
                         </div>
                    </div>
                    <!-- // -->
               </div>
          </div>

     </div>
</div>
<!-- Content wrapper -->

<div id='my-node'></div>

<script src="/arvi/backend-assets/js/demo.js"></script>
<script src="/arvi/backend-assets/js/easy.qrcode.js"></script>
<script src="/arvi/backend-assets/js/dom-to-image.js"></script>
<script src="/arvi/backend-assets/js/FileSaver.js"></script>

<script>
     $( document ).ready(function() {

          // set qr code based on link qr
          var qrcode = new QRCode(document.getElementById("qrcode"), {
               width: 155,
               height: 155,
               text: "{{$qr->qr_url}}",
               logo: "/arvi/backend-assets/img/default/qr-poster/oobe-logo-wordmark-orange.svg",
               logoWidth: undefined,
               logoHeight: undefined,
               logoBackgroundColor: '#ffffff',
               logoBackgroundTransparent: false
          });

          $(".socialCon").hide();
          $(".locationCon").hide();

          // old color
          $("#wtitle").css('color', '{{$qr->title_color_poster}}');
          $("#wsubtitle").css('color', '{{$qr->sub_title_color_poster}}');
          $("#wdesc").css('color', '{{$qr->description_color_poster}}');
          $("#whelper").css('color', '{{$qr->helper_color_poster}}');
          $(".socialCon, .footer-desc").css('color', '{{$qr->global_text_color_poster}}');
          $("#theme-one").css('background', '{{$qr->backgrount_color_poster}}');
          $(".imgBackground svg").css({ fill: '{{$qr->backgrount_color_poster}}' });

          // old data
          let gtcp = "{{$qr->show_store_loc_poster}}";
          if (gtcp == 1) {
               $(`#show_store_loc_poster`).trigger( "click" );
          }
          let gcp = "{{$qr->show_social_icons_poster}}";
          if (gcp == 1) {
               $(`#show_social_icons_poster`).trigger( "click" );
          }
     });
          
     // save
    $('#manageStore').on('submit',function () {
          event.preventDefault();

          var data = new FormData(this);
          
          domtoimage.toBlob(document.getElementById('theme-one'))
          .then(function (blob) {
               data.append('image_poster', blob);
               $.ajax({
                    type: 'POST',
                    url: "{{ route('poster-qr-update-layout') }}",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                         $('#manage-qr').trigger('click')
                    },
                    error: function (data) {
                         console.log(data);
                    }
               })
          });
    })

     // download poster     
     $('#download-poster').on('click',function () {
          // dom poster
          domtoimage.toBlob(document.getElementById('theme-one'))
          .then(function (blob) {
               window.saveAs(blob, 'poster-qr-{{$qr->name}}.png');
          });
     })

</script>
