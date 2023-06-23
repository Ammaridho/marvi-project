@auth

@include('arvi.backend.header')

    <!-- Layout container -->
    <div class="layout-page">

      <!-- set hide top button nav in tab resolution -->
      {{-- <div class="d-none d-lg-block"> --}}
        @include('arvi.backend.navbar')
      {{-- </div> --}}

      <!-- Content wrapper -->
      <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

          <!-- content -->
          <div id="contentDashboard"></div>

        </div>
        @include('arvi.backend.copyrights')
      </div>
      <!-- Content wrapper -->

    </div>
    <!-- / Layout page -->
  </div>

  <!-- Overlay -->
  <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

@include('arvi.backend.footer')

@else

@include('arvi.backend.index')

@endauth
