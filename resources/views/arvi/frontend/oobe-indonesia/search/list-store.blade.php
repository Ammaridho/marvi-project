@if (count($dataProducts)>0)
    @foreach ($dataProducts as $item)
        <div class="card shadow-sm">
            <div class="card-body listitem">
                <a href="{{route('show-store-order',['productId' => $item['merchant_products_id'] ])}}">
                    <div class="d-flex align-items-center">
                        <div>
                            @if ($item['url'] != 'url')
                                <div class="img-wrapper-sm" 
                                    style="background-image: 
                                    url('/arvi/backend-assets/img/products/brands/{{$item['url']}}');">
                                </div>
                            @elseif($item['image_mime'])
                                <div class="img-wrapper-sm" 
                                    style="background-image: url('/arvi/assets/img/products/{{
                                    $item['image_mime'].'.'.$item['image_type']}}');">
                                </div>
                            @else
                            <div class="img-wrapper-sm" 
                                    style="background-image: 
                                    url('/arvi/backend-assets/img/default/product.jpg');">
                                </div>
                            @endif
                        </div>
                        <div class="px-3">
                            <div class="fw-bold">
                                <?=strlen($item->merchant_name) > 25 ?
                                substr($item->merchant_name,0,25)."..." : $item->merchant_name;?>
                            </div>
                            <div class="fw-bold">
                                <?=strlen($item->name) > 25 ?
                                substr($item->name,0,25)."..." : $item->name;?>
                            </div>
                            <div class="fs-6">
                                <?=strlen($item->description) >
                                    50 ? substr($item->description,0,50)."..." :
                                    $item->description;?>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="small">
                                        <i class="fas fa-star text-theme-primary"></i> 4.4
                                    </div>
                                </div>
                            </div>
                            <div class="fs-6 py-1 text-muted">Delivery in 20 min &#9642; 1.5 km</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endforeach
@else
    <!-- no data in menu 
    Seach  by typing on input menu min 3 letters
    -->
    <div class="text-center text-muted my-3">
        <img src="/frontend-oobe-indonesia/assets/img/not-available-menu.png" class="mb-2 img-fluid">
        <h2 class="m-0">Oh no!</h2>
        Your search seems to be missing from our kitchen. Please try something else :)
    </div>
    <!-- //no data in menu -->
@endif


