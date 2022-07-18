

@auth
    
  @include('arvi.backend.header')

        {{-- @if (session()->has('success'))
        <div class="row">
            <div class="col">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
      @endif --}}

      <!-- Layout container -->
      <div class="layout-page">

        @include('arvi.backend.navbar')

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">

            <!-- content -->
            <div id="contentDashboard"></div>

            {{-- @include('arvi.backend.page-home') --}}


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
