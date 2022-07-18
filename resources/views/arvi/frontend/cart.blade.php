<div class="modal-header border-0">
    <div class="fw-bold">Your Orders</div>
    <div>$<span id="totalPrice"></span> </div>
  </div>
  <div class="modal-body py-0">

    <form action="javascript:void(0);" method="post" id="formCart">
        @foreach ($dataCart as $item)
        <input type="hidden" name="idProduct[]" class="idProductt" value="{{$item['pid']}}">
            <div class="d-flex">
                <div class="p-1">
                <div class="thumbnail-cart" style="background-image: url('/arvi/assets/img/products/{{$item[$item['pid']]['productImage']}}.{{$item[$item['pid']]['productImageType']}}');"></div>
                </div>
                <div class="p-1 w-100">
                <div class="fw-bold">{{$item[$item['pid']]['productName']}}</div>
                <div class="d-flex justify-content-between">
                    <div>{{$item[$item['pid']]['productPrice']}}</div>
                    <div>
                    <div class="counter-sm number">
                        <span class="minuss mr-1" data-id="{{$item[$item['pid']]['productId']}}" data-name="{{$item[$item['pid']]['productName']}}"><i class="fa fa-minus" aria-hidden="true"></i></span>
                        <input type="number" name="qtyProduct[]" value="{{$item[$item['pid']]['productQuan']}}" class="input-numberr tc-qty-prod" max="99" min="1" readonly />
                        <span class="pluss ml-2"><i class="fa fa-plus" aria-hidden="true"></i></span>
                    </div>
                    </div>
                </div>
                </div>
            </div>

        @endforeach

    </form>

  </div>
  <div class="modal-footer">
    <div class="tests"></div>
    <button type="button" class="btn btn-theme-secondary col arrowDownSmC inputData" id="btnProceedCheckout" data-bs-dismiss="modal" aria-label="Close">Proceed to Checkout</button>
  </div>

<script>
    //count
    function displayTotal() {
        let qty = $('.input-numberr');
        let total = 0;
        for(let i = 0; i < qty.length; i++){
            total += parseFloat($(qty[i]).val());
        }
        let totalPrice = total * 3.8;
        let totalFixed = totalPrice.toFixed(2);
        $('#totalPrice').text(totalFixed);
    }

    $(document).ready(function () {
        //move down after Procceed to Checkout
        $('.arrowDownSmC').click(function(){
            $.fn.fullpage.moveSectionDown();
        });

        $('.tc-qty-prod').on('change', function () {
            displayTotal();
        });

        $('#btnProceedCheckout').on('click', function () {
            gUpdateCart();
        });

    });
    gButtonPlusMinus('pluss','minuss','input-numberr');
    displayTotal();
</script>
