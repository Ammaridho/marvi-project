<div class="section" id="section-1">
    <div class="container wrap my-5">
      <div class="row justify-content-center align-items-center g-0 h-100">
        <div class="col-12">
          <h4 class="mb-4">Which option of Cold Brew Coffee & Tea would you like?</h4>
          <div class="row g-2">

            @foreach ($pjis as $item)

            <div class="col-4 col-sm-4 col-md-3 text-center mb-2">
              <a  href="#" class="text-dark productList" data-bs-toggle="modal" 
              data-bs-target="#modalOptions" data-data="{{ $item }}">
                  <div class="card custom shadow h-100">
                      <div class="card-body p-1">
                          <div class="row">
                              <div class="col-12">
                                @if ($item->productImage->first()->url != 'url')
                                  <img src="/arvi/backend-assets/img/products/brands/{{$item->productImage->first()->url}}" 
                                  class="img-fluid" />
                                @else
                                  <img src="/arvi/assets/img/products/{{$item->image_mime.'.'.$item->image_type}}" 
                                  class="img-fluid" />
                                @endif
                              </div>
                              <div class="col-12">
                                  <div class="text-center small lh-1">
                                    {{$item->name}}
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="card-footer border-0">
                          <div class="fw-bold text-center">
                            {{$item->currency}}{{$item->retail_price}}
                          </div>
                      </div>
                  </div>
              </a>
            </div>

              {{-- <div class="col-12 text-center mb-2">
                <a href="#" class="text-dark productList" data-bs-toggle="modal" 
                data-bs-target="#modalOptions" data-data="{{ $item }}">
                  <div class="card custom shadow h-100">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-3">
                          <div class="img-wrapper" 
                          style="background: url(/arvi/assets/img/products/{{$item->image_mime}}.
                          {{$item->image_type}});"></div>
                        </div>
                        <div class="col-9">
                          <div class="fw-bold">{{$item->name}}</div>
                          <div class="fw-bold">{{$item->currency}}{{$item->retail_price}}</div>
                          <div class="small">{{$item->description}}</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div> --}}

            @endforeach

            <div class="col-12 text-center mb-2" style="height: 120px;">

              &nbsp;&nbsp;

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>