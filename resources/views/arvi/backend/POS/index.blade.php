
<div class="row">
     <div class="col-12 col-md-6">
          <!-- lefty -->
          <div class="card h-100">
               <div class="card-body p-3">
                    <div class="row g-2 posList">
                         <div class="col-12 col-sm-6">
                              <div class="d-grid mb-2">
                                   <input type="radio" class="btn-check product-category-pos" name="product-category-pos" 
                                   id="optionAllp" value="2" autocomplete="off" data-id="All Items"/>
                                   <label class="btn btn-outline-primary" for="optionAllp">All Items</label>
                              </div>
                         </div>
                         @foreach ($categories as $key => $category)
                              <!-- list item in category -->
                              @if ($category != 'noCategory')
                                   <div class="col-12 col-sm-6">
                                        <div class="d-grid mb-2">
                                             <input type="radio" class="btn-check product-category-pos" name="product-category-pos" 
                                             id="option{{$key}}p" value="2" autocomplete="off" data-id="{{$category}}"/>
                                             <label class="btn btn-outline-primary" for="option{{$key}}p" >{{$category}}</label>
                                        </div>
                                   </div>
                              @endif
                         @endforeach
                    </div>

                    <div class="row g-2 mt-2 posList" id="display-product-pos">
                         @include('arvi.backend.POS.list-product')
                    </div>
               </div>
          </div>
          <!-- /lefty -->
     </div>
     <div class="col-12 col-md-6">
          <!-- right -->
          <div class="card">
               <div class="card-body p-0">
                    <div class="d-flex justify-content-between align-items-center">
                         <h6 class="m-3 mb-0">Current Order</h6>
                         <a href="javascript: void(0);" class="text-gray m-3 mb-0" data-bs-toggle="modal"
                              data-bs-target="#modalOption">
                              <span id="name-seles-type">Dine-in</span>
                              <i class='bx bxs-chevron-down'></i>
                         </a>
                    </div>

                    <hr />

                    <!--- if order has been made --->
                    <div id="detail-order-pos">
                    </div>

                    <div class="d-grid gap-2 mt-2 m-2">
                         <button class="btn btn-sm btn-outline-gray text-gray act-pos" 
                         id="clear-pos-cart">Clear sale</button>
                    </div>
                    
                    <!--- // if order has been made --->
                    <div class="d-grid gap-2 mt-5 m-2">
                         <button class="btn btn-primary fw-bold act-pos"
                         id="submit-charge" data-bs-toggle="modal" 
                         data-bs-target="#modalCharge">
                              ...
                         </button>
                    </div>

               </div>
          </div>
          <!-- /right -->
     </div>
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

     <!--
     =============================================
     Modals
     =============================================
     -->

     <!-- Modal options -->
     <div class="modal fade" id="modalMenu" tabindex="-1" aria-labelledby="modalMenu" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
               <div class="modal-content">
                    
               </div>
          </div>
     </div>
     <!-- // Modal options -->

     <!-- Modal options -->
     <div class="modal fade" id="modalOption" tabindex="-1" aria-labelledby="modalOption" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
               <div class="modal-content">
                    <div class="modal-header border-bottom pb-3">
                         <h5 class="modal-title">Sales Type</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body center p-3">
                         <div class="row">
                              <div class="col-6">
                                   <div class="d-grid mb-2">
                                        <input type="radio" class="btn-check seles-type" name="seles-type" 
                                        id="option1" value="2" autocomplete="off" />
                                        <label class="btn btn-outline-primary" for="option1">Take Away</label>
                                   </div>
                              </div>
                              <div class="col-6">
                                   <div class="d-grid mb-2">
                                        <input type="radio" class="btn-check seles-type" name="seles-type" 
                                        id="option2" value="3" autocomplete="off" checked/>
                                        <label class="btn btn-outline-primary" for="option2">Dine-in</label>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="modal-footer border-top pb-2">
                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                    </div>
               </div>
          </div>
     </div>
     <!-- // Modal options -->
     
     <!-- Modal charge -->
     <div class="modal fade" id="modalCharge" tabindex="-1" aria-labelledby="modalCharge" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-centered modal-simple">
               <div class="modal-content">
                    
               </div>
          </div>
     </div>
     <!-- // Modal charge -->

     <!-- Modal done -->
     <div class="modal fade" id="modalDone" tabindex="-1" aria-labelledby="modalDone" aria-hidden="true">
          <div class="modal-dialog modal-fullscreen">
               <div class="modal-content">
                    
               </div>
          </div>
     </div>
     <!-- // Modal done -->

<script>
     $( document ).ready(function() { 
          refreshPOSCart();
     });

     // select category
     $('.product-category-pos').on('click',function () {
          let cat = $(this).data('id');
          $.get("{{route('pos-dashboard-category',['companyCode'=>$companyCode])}}",{cat:cat},function (data) {
               $('#display-product-pos').html(data);
          })
     })

     // clear cart
     $('#clear-pos-cart').on('click',function () {
          sessionStorage.removeItem('cart-pos-cashier');
          refreshPOSCart();
     })

     // seles type
     $('.seles-type').on('change',function () {
          $('#name-seles-type').text($(this).siblings().text());
     })

     // refresh
     function refreshPOSCart() {
          if (sessionStorage.getItem("cart-pos-cashier") !== null) {
               $('.act-pos').prop('disabled', false);
          }else{
               $('.act-pos').prop('disabled', true);
               $('#submit-charge').text('...');
          }
          
          $.ajax({
               type: "GET",
               url: "{{route('pos-dashboard-detail-order',['companyCode'=>$companyCode])}}",
               data: { 
                    cart:JSON.parse(sessionStorage.getItem('cart-pos-cashier')),
                    merchantId:'{{$merchantId}}'
                },
               success: function (data) {
                    $('#detail-order-pos').html(data);
               },
               error: function (response) {
                    sessionStorage.removeItem('cart-pos-cashier');
               }
          });
     }

     // charge go to payment
     $('#submit-charge').on('click',function () {
          let selesType = $('.seles-type:checked').val();
          let totalPrice = $('#total-price').data('total');
          let merchantId = '{{$merchantId}}';
          $.get("{{route('pos-choose-payment',['companyCode'=>$companyCode])}}",
               {
                    cart:JSON.parse(sessionStorage.getItem('cart-pos-cashier')),
                    merchantId:merchantId,
                    selesType:selesType,
                    totalPrice:totalPrice,
               },function (data) {
               $('#modalCharge').find('.modal-content').html(data);
          })

          $('#modalCharge').modal('show');
     });

</script>
