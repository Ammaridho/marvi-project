<div class="section" id="section">
    <div class="container wrap my-5">
      <div class="row justify-content-center align-items-center h-100 g-0">
        <div class="col-12 col-md-8 text-center">
          <div class="mb-2 px-4">
            <img src="/arvi/assets/img/product/Hero_Banner_sm.jpg" class="img-fluid img-thumbnail shadow-sm" />
          </div>
          <div class="socials mt-1 fs-4" id="socials">
            <ul class="list-inline">
              <li class="list-inline-item"><a target="_blank" href="https://www.facebook.com/BootstrapColdBrewSG"><div class="social-icon"><img src="/arvi/assets/img/icon-facebook.svg" type="image/svg+xml" /></div></a></li>
              <li class="list-inline-item"><a target="_blank" href="https://www.instagram.com/bootstrapcoldbrewsg/"><div class="social-icon"><img src="/arvi/assets/img/icon-instagram.svg" type="image/svg+xml" /></div></a></li>
              <!-- <li class="list-inline-item"><a href="/cdn-cgi/l/email-protection#a5cccbc3cae5c7cacad1d6d1d7c4d5c7c0d3c0d7c4c2c0d68bc6cac8"><div class="social-icon"><img src="/arvi/assets/img/icon-mail.svg" type="image/svg+xml" /></div></a></li> -->
            </ul>
          </div>
          <div class="fw-600 fs-4" id="pageTitle">{{$merchant->name}}</div>
          {!! $merchant->description !!}
          <div class="d-grid my-4">
            <a href="javascript: void(0);" class="btn btn-block btn-theme-secondary py-3 mb-2 arrowDownSm">Order Now</a>
            <a href="javascript: void(0);" state="open" class="btn btn-block btn-outline-secondary mb-2 btnOnModalFAQ">FAQ</a>
          </div>
          {{-- <div class="thumb-profile mb-2" style="background-image: url(/arvi/assets/img/profile-picture.jpg);">&nbsp;</div>
          <div class="socials mt-1 fs-4" id="socials">
            <ul class="list-inline">
              <li class="list-inline-item"><a href="https://www.facebook.com/BootstrapColdBrewSG"><div class="social-icon"><img src="/arvi/assets/img/icon-facebook.svg" type="image/svg+xml" /></div></a></li>
              <li class="list-inline-item"><a href="https://www.instagram.com/bootstrapcoldbrewsg/"><div class="social-icon"><img src="/arvi/assets/img/icon-instagram.svg" type="image/svg+xml" /></div></a></li>
              <li class="list-inline-item"><a href="/cdn-cgi/l/email-protection#a5cccbc3cae5c7cacad1d6d1d7c4d5c7c0d3c0d7c4c2c0d68bc6cac8"><div class="social-icon"><img src="/arvi/assets/img/icon-mail.svg" type="image/svg+xml" /></div></a></li>
            </ul>
          </div>
          <div class="fw-600 fs-4" id="pageTitle">{!! $merchant->name !!}</div>
          <div class="fs-6" id="pageDesc1"></div>

          <div class="d-grid my-4">

              <a href="javascript: void(0);" class="btn btn-block btn-theme-secondary py-3 mb-2 arrowDownSm">Order Now</a>
              <a href="javascript: void(0);" onclick="modalFAQ('open')" class="btn btn-block btn-outline-secondary mb-2">FAQ</a>
          </div> --}}

        </div>
      </div>
    </div>
</div>
