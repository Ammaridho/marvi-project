@extends('sushimoo.layouts.main')

@section('content')

    <!-- Cart -->
    <section class="wrapper">
        <div class="container-mobile">
            <div class="container-cart">
                <div class="subSummary p-3 text-gray">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex">
                            <a href="javascript:void(0);" onclick="history.back()" class="text-dark"><div class="btn-back"><i class="fas fa-angle-left"></i></div></a>
                            <div class="mx-3 mt-2">
                                <strong>PESANAN</strong></div>
                        </div>
                        <div>
                            <a href="{{ route('homeSushimoo') }}" class="btn btn-sm btn-outline-danger mt-1"><i class="fas fa-plus"></i> Tambah menu</a>
                        </div>
                    </div>
                </div>
                <div class="mt-3 mx-3">

                    {{-- {{dd($item[])}} --}}
                    
                    @foreach ($cart as $key => $item)
                    
                        <!-- item -->
                        <div class="card p-2 my-2">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">

                                    <div class="cart-qty">
                                        <input type="text" name="quant[2]" data-idCart="{{ $key }}" class="input-number bg-light" value="1x" min="1" max="99" disabled="disabled">
                                    </div>

                                    <div class="px-2">
                                        {{$item['product']->name}}
                                        <div class="fw-bold price">Rp {{$item['product']->retail_price}}</div><!-- changed when counter up and down -->
                                        <ul class="list-unstyled m-0 text-muted small">

                                            {{-- condimant --}}
                                            @foreach ($item['extraCon'] as $key => $value)
                                                <li> {{$item['extraCon'][$key]}} x {{$item['extraConData'][$key]->name}} </li>
                                            @endforeach

                                            {{-- cut --}}
                                            @foreach ($item['extraCut'] as $key => $value)
                                                <li> {{$item['extraCut'][$key]}} x {{$item['extraCutData'][$key]->name}} </li>
                                            @endforeach

                                            <li> <i>- {{$item['remarks']}}</i></li>
                                        </ul>
                                        <div class="cart-links small"><a href="page-item.php">Ubah</a></div>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="input-group counter">
                                        <button type="button" class="counter-btn btn-number" data-type="minus" data-field="quant[2]" data-idCart="{{ $key }}"><i class="fas fa-minus"></i></button>
                                        <button type="button" class="counter-btn btn-number" data-type="plus" data-field="quant[2]" data-idCart="{{ $key }}"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- // item -->
                        
                    @endforeach


                    <div class="cart-line"></div>
                    <div class="d-flex justify-content-between mt-1">
                        <div class="text-muted small p-2">
                            <span id="inputFromModalNotes"><i>Catatan pelanggan<!-- replace with user notes --></i></span>
                        </div>
                        <div class="nowrap">
                            <a href="{{ route('cart.') }}" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalNotes"><i class="fas fa-plus"></i>  Catatan</a>
                        </div>
                    </div>
                    <div class="cart-line"></div>

                </div>
            </div>
        </div>
    </section>
    

    <!-- total payment -->
    <div>
        <div class="container-mobile">
            <div class="container-cart">

                <div class="mt-3 mx-3">
                    <div class="fw-bold">Rincian Pembayaran</div>

                    <!-- select courier -->
                    <!-- hide this when delivery courier selected -->
                    <div class="mt-2 d-grid">
                        <a href="javascript: void(0);" class="btn btn-block btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalDelivery">Pilih metode pengiriman</a>
                    </div>

                    <!-- show this when delivery courier selected -->
                    <div class="d-flex justify-content-between mt-2">
                        <div><img src="/sushimoo/assets/img/icon-grabexpress.png" /></div> 
                        <div class="text-muted">Rp. 0</div>
                    </div>
                    <!-- //select courier -->

                    <div class="d-flex justify-content-between mt-2">
                        <div class="fw-bold">Total</div>
                        <div class="fw-bold text-theme-secondary">Rp. 456.000</div>
                    </div>

                </div>

                <div class="mt-3 mx-3">
                    <a href="page-payment.php" class="no-underline">
                        <div class="d-flex justify-content-between align-items-center status-payment shadow">
                            <div>
                                <div class="f-12 text-uppercase">Lanjutkan<br />ke pembayaran</div>
                            </div>
                            <div class="btn btn-theme-secondary">Rp. 456.000 <i class="fas fa-angle-right"></i> </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- //total payment -->
    <!-- // Cart -->

    <!--
    =================================
    MODALS
    =================================
    -->

    <!-- Modal remove item -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDelete" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h4 class="mt-4">Apakah Anda yakin untuk menghapus menu ini?</h4>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-theme-secondary">Ya</button>
                </div>
            </div>
        </div>
    </div>
    <!-- //Modal notes -->

    <!-- Modal notes -->
    <div class="modal fade" id="modalNotes" tabindex="-1" aria-labelledby="modalNotes" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Tambah catatan</h6>
                    <button type="button" class="btn-close fs-10" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea placeholder="Example: Make my dish awesome like always!" class="area-notes"></textarea>
                    <span class="rchars small text-muted"></span>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-theme-secondary">Tambah</button>
                </div>
            </div>
        </div>
    </div>
    <!-- //Modal notes -->

    <!-- Modal delivery -->
    <div class="modal fade" id="modalDelivery" tabindex="-1" aria-labelledby="modalNotes" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Pilih Metode Pengiriman</h6>
                    <button type="button" class="btn-close fs-10" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                <div class="form-group mb-2">
                        <label class="radio-selection"><input type="radio" name="delivery" value="delivery-01" />
                            <div><i class="fas fa-shopping-bag"></i> Self Pickup <div class="float-end text-muted">Rp. 0</div></div>
                        </label>
                    </div>
                    <div class="form-group mb-2">
                        <label class="radio-selection"><input type="radio" name="delivery" value="delivery-01" />
                            <div><img src="/sushimoo/assets/img/icon-gosend.png" /> <div class="float-end text-muted">Rp. 20.000</div></div>
                        </label>
                    </div>
                    <div class="form-group mb-2">
                        <label class="radio-selection"><input type="radio" name="delivery" value="delivery-02" />
                            <div><img src="/sushimoo/assets/img/icon-grabexpress.png" /> <div class="float-end text-muted">Gratis <strike>Rp. 18.000</strike></div></div>
                        </label>
                    </div>

                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-theme-secondary">Pilih</button>
                </div>
            </div>
        </div>
    </div>
    <!-- //Modal delivery -->   

@endsection