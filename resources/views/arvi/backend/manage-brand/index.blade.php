<div class="card">
  <div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
          <div><h4 class="m-0">Manage Brand</h4></div>
          <div>
            <a href="javascript:void(0)" class="btn btn-primary text-nowrap manage-brand">
              <i class="tf-icons bx bx-plus"></i> Add brand
            </a>
          </div>
      </div>
      <hr>

      <div class="row">
        
        @foreach ($brands as $brand)
          <!-- brand -->
          <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
            <div class="card border shadow-none h-100">
              <div class="card-body p-3">
                
                <div class="d-flex align-items-start flex-sm-row flex-column">
                    <div class="brand-logo-wrapper me-4">
                      @if (isset($brand->image_url))
                        <div class="lazy brand-logo-thumb {{$brand->active == 1 ? '' : 'isDisabled'}}" 
                          data-src="/storage/arvi/backend-assets/img/logo/brands/{{$brand->image_url}}"
                          onerror="this.onerror=null;this.src='/arvi/backend-assets/img/logo/brands/logo-brand-ayam.jpg';">
                        </div>
                      @else
                        <div class="lazy brand-logo-thumb {{$brand->active == 1 ? '' : 'isDisabled'}}" 
                          data-src="/frontend-oobe-indonesia/assets/img/merchant/default-brand-logo.png">
                        </div>
                      @endif
                    </div>
                    <div class="w-100">
                      
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-bold"> {{$brand->name}}
                          <div class="small text-muted">{{DB::table('companies')->find($brand->company_id)->name}}</div>
                        </div>
                        <script>
                          var brandActive = "{{$brand->active}}";
                          if (brandActive == '1') {
                            $("#flexSwitchCheckChecked{{$brand->id}}").prop('checked', true);
                          }else{
                            $("#flexSwitchCheckChecked{{$brand->id}}").prop('checked', false);
                          }
                        </script>
                        <div class="form-check form-switch mt-1 ms-5">
                          <input class="form-check-input flexSwitchCheckChecked" 
                          type="checkbox" id="flexSwitchCheckChecked{{$brand->id}}" 
                          data-data="{{$brand}}">
                          <label class="form-check-label" for="flexSwitchCheckChecked{{$brand->id}}"></label>
                        </div>
                      </div>
                  
                      <hr />
                      <div>
                        <ul class="list-unstyled">
                          <li class="mb-2">
                            <a href="javascript:void(0)" 
                            class="d-block btn btn-outline-primary text-start menu-categories 
                            {{$brand->active == 1 ? '' : 'disabled'}}" data-id="{{$brand->id}}">
                              <i class='bx bx-category-alt me-2' ></i> Manage Brand Categories
                            </a>
                          </li>
                          <li class="mb-2">
                            <a href="javascript:void(0)" 
                            class="d-block btn btn-outline-primary text-start menu-products 
                            {{$brand->active == 1 ? '' : 'disabled'}}" data-id="{{$brand->id}}">
                              <i class='bx bx-list-minus me-2' ></i> Manage Brand Menu
                            </a>
                          </li>
                          <li class="mb-2">
                            <a href="javascript:void(0)" 
                            class="d-block btn btn-outline-primary text-start menu-extra-attributes 
                            {{$brand->active == 1 ? '' : 'disabled'}}" data-id="{{$brand->id}}">
                              <i class='bx bx-list-plus me-2' ></i> Manage Extra Attributes
                            </a>
                          </li>
                          <li class="mb-2">
                            <a href="javascript:void(0)" 
                            class="d-block btn btn-primary text-start manage-brand 
                            {{$brand->active == 1 ? '' : 'disabled'}}" data-id="{{$brand->id}}">
                              <i class='bx bx-edit-alt me-2'></i> Edit Brand
                            </a>
                          </li>
                          <li class="mb-2">
                            <a href="javascript:void(0)" 
                            class="d-block btn btn-danger text-start delete-brand 
                            {{$brand->active == 1 ? '' : 'disabled'}}" data-id="{{$brand->id}}">
                              <i class='bx bx-trash me-2'></i> Remove Brand
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                    
                </div>
            </div>
          </div>
          <!-- //brand -->
        @endforeach          

      </div>
  </div>
</div>

<!--
=============================================
Modals
=============================================
-->
<!-- modal confirm -->
<div class="modal fade" id="modalConfirm" tabindex="-1" aria-labelledby="modalConfirm" 
aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-bottom pb-3">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body border-bottom pb-3">
        <div>Do you want to set 
          <span id="active-status-to-change"></span> brand 
          "<span id="confirm-name-brand"></span>"? 
          <br>
          <br>
          <span class="text-warning" id="note-message"></span> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-change-active" 
        data-bs-dismiss="modal" data-data="">Save changes</button>
      </div>
    </div>
  </div>
</div>

{{-- modal confirmatin delete --}}
<div class="modal fade" id="modaldDefaultDelete" tabindex="-1" 
aria-labelledby="modaldDefaultDelete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title">Remove Confirmation</h5>
                <button type="button" class="btn-close" 
                data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body center p-3">
                <h4>You're about to <span class="text-danger">remove</span> this Brand.</h4>
                <div class="">By doing this action, you will removed the Brand and cannot be undone.</div>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submit-delete" 
                data-bs-dismiss="modal" data-id="">Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="/arvi/backend-assets/js/dashboards-analytics.js"></script>
<script src="/arvi/backend-assets/js/demo.js"></script>

<script>
  // delete
  $(".delete-brand").on('click',function(){
    let id = $(this).data('id');
    $('#submit-delete').data('id',id);
    // show modal
    $('#modaldDefaultDelete').modal('show');
  }); 
  $('#submit-delete').on('click',function () {
    var id = $(this).data("id");
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
        type: 'DELETE',
        url: "{{ route('manage-brand-destroy',['companyCode' => $companyCode, 'brandId' => 0]) }}",
        data: {
            "brandId": id,
            "_token": token,
        },
        success: function (){
            $('#manage-brand-button').trigger("click");
        }
    });
  })

  // click check active inactive
  $('.flexSwitchCheckChecked').on('click',function () {
    let data = $(this).data('data');
    $('#confirm-name-brand').text(data['name']);
    $('#save-change-active').data('data',data);
    if (data['active'] == 1) {
      $('#active-status-to-change').html('<span class="fw-bold text-danger">inactive</span>');
      $('#note-message').text('Note: All store under this brand, also will be set inactive');
    } else {
      $('#active-status-to-change').html('<span class="fw-bold text-success">active</span>');
      $('#note-message').text('Note: Each store under this brand need to be activated manually');
    }
    // show modal
    $('#modalConfirm').modal('show');
    // check old status active
    // if not checked ============================================================
    if($(this).is(":checked")){
      $(this).prop('checked', false);
    // if checked ============================================================
    }else if($(this).is(":not(:checked)")){
      $(this).prop('checked', true);
    }
  })

  // save switch check active inactive
  $('#save-change-active').on('click',function () {
    let data = $(this).data('data');
    let active = data['active'] == '1' ? '0': '1' ;
    let id = data['id'];
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
      type: 'PUT',
      url: "{{ route('manage-brand-update',['companyCode' => $companyCode]) }}",
      data: {active:active,id:id,"_token": token},
      success: function (data) {
        $('#manage-brand-button').trigger("click");
      },
      error: function (data) {
        console.log(data);
      }
    })  
  })

  // add or edit brand
  $('.manage-brand').on('click',function () {
    let id = $(this).data('id');
    if (id == undefined) {
      $.get("{{ secure_url(route('manage-brand-create',['companyCode' => $companyCode])) }}",
      function (data) {
          $('#contentDashboard').html(data);
      })
    } else {
      $.get("{{ secure_url(route('manage-brand-edit',['companyCode' => $companyCode])) }}",
      {id:id},function (data) {
          $('#contentDashboard').html(data);
      })
    }
  })

  // button menu categories
  $('.menu-categories').on('click',function () {
    let id = $(this).data('id');
    $.get("{{ secure_url(route('brand-category-list',['companyCode' => $companyCode])) }}",
    {id:id},function (data) {
        $('#contentDashboard').html(data);
    })
  })
  // button menu products
  $('.menu-products').on('click',function () {
    let id = $(this).data('id');
    $.get("{{ secure_url(route('brand-product-list',['companyCode' => $companyCode])) }}",
    {id:id},function (data) {
        $('#contentDashboard').html(data);
    })
  })

  // button menu extra-attributes
  $('.menu-extra-attributes').on('click',function () {
    let id = $(this).data('id');
    $.get("{{ secure_url(route('brand-extra-attribute-list',['companyCode' => $companyCode])) }}",
    {id:id},function (data) {
        $('#contentDashboard').html(data);
    })
  })
</script>