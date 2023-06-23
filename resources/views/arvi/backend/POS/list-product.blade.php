@if (!isset($dataProducts))
    @foreach ($listProduct as $category => $products)

        @foreach ($products as $item)
            <div class="col-12 col-sm-4">
                <a href="javascript: void(0);" class="choose-product" data-id="{{$item['merchant_product_id']}}">
                    <div class="border rounded h-100">
                        @if (isset($item['url']))
                            @if ($item['url'] != 'url')
                            <img class="lazy product-img-wrapper-pos rounded"
                            src="/storage/arvi/backend-assets/img/products/brands/{{$item['url']}}">
                            @elseif(isset($item['image_mime']))
                            <img class="lazy product-img-wrapper-pos rounded"
                            src="/arvi/assets/img/products/{{$item['image_mime'].'.'.$item['image_type']}}">
                            @endif
                        @else
                        <img class="lazy product-img-wrapper-pos rounded"
                        src="/arvi/backend-assets/img/default/product.jpg">
                        @endif
                        <h6 class="fw-bold small m-0 p-2 text-center text-truncate">
                            {{$item->name}}
                        </h6>
                    </div>
                </a>
            </div>
        @endforeach

    @endforeach
@else
    @foreach ($dataProducts as $item)
        <div class="col-12 col-sm-4">
            <a href="javascript: void(0);" class="choose-product" data-id="{{$item['merchant_product_id']}}">
                <div class="border rounded h-100">
                    @if (isset($item['url']))
                        @if ($item['url'] != 'url')
                        <img class="lazy product-img-wrapper-pos rounded"
                        src="/storage/arvi/backend-assets/img/products/brands/{{$item['url']}}">
                        @elseif(isset($item['image_mime']))
                        <img class="lazy product-img-wrapper-pos rounded"
                        src="/arvi/assets/img/products/{{$item['image_mime'].'.'.$item['image_type']}}">
                        @endif
                    @else
                    <img class="lazy product-img-wrapper-pos rounded"
                    src="/arvi/backend-assets/img/default/product.jpg">
                    @endif
                    <h6 class="fw-bold small m-0 p-2 text-center text-truncate">
                        {{$item->name}}
                    </h6>
                </div>
            </a>
        </div>
    @endforeach
@endif

<script>
    $('.choose-product').on('click',function () {
        let productId = $(this).data('id');

        $.get("{{route('pos-dashboard-add-product',['companyCode'=>$companyCode])}}",
        {productId:productId},function (data) {
            $('#modalMenu').find('.modal-content').html(data);
        })

        $('#modalMenu').modal('show');
    })
</script>