<?php include('header.php');?>

    <!-- Cart -->
    <form action="" method="POST" id="payments">
    <section class="wrapper mb-4">
        <div class="container-mobile">
            <div class="container-cart">
                <div class="subSummary p-3 text-gray">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex">
                            <a href="page-cart.php" class="text-dark"><div class="btn-back"><i class="fas fa-angle-left"></i></div></a>
                            <div class="mx-3 mt-2">
                                <strong>RINCIAN PEMBAYARAN</strong></div>
                        </div>
                    </div>
                </div>
                <div class="mt-3 mx-3">

                    <div class="d-flex justify-content-between my-2">
                        <div>
                            <div class="small text-muted">Biaya pengiriman</div>
                            <img src="assets/img/icon-gosend.png" />
                        </div> 
                        <div class="text-muted">Rp. 30.000</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="small text-muted">Harga sudah termasuk PB1</div> 
                        <div class="text-muted">Rp. 0</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="small text-muted">Harga sudah termasuk SC</div> 
                        <div class="text-muted">Rp. 0</div>
                    </div>

                    <div class="d-flex justify-content-between my-2 border-top pt-2">
                        <div class="fw-bold">Total</div> 
                        <div class="fw-bold text-theme-secondary">Rp. 456.000</div>
                    </div>
                    <div class="cart-line"></div>
                </div>
                
                <div class="mt-4 mx-3">
                    <div class="fw-bold mb-3">Lengkapi data Anda</div>

                    <div class="form-group mb-3">
                        <textarea class="f-textbox" rows="2" id="address" name="address"></textarea>
                        <label class="f-label">Alamat Pengiriman *</label>
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="f-inputbox" required="required" autocomplete="off" id="fname" name="fname" />
                        <label class="f-label">Nama *</label>
                    </div>
                    <div class="form-group mb-3">
                        <input type="email" class="f-inputbox" autocomplete="off" id="email" name="email" />
                        <label class="f-label">Email</label>
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" class="f-inputbox numbers ibacor_fi" required="required" autocomplete="off" id="phone" name="phone" />
                        <label class="f-label">Nomor Handphone *</label>
                    </div>
                </div>

                <div class="mt-4 mx-3">
                    <div class="fw-bold mb-3">Pilih metode pembayaran</div>

                    <div class="form-group mb-2">
                        <label class="radio-selection"><input type="radio" name="pay" value="pay-01" />
                        <div class="d-flex justidy-content-between">
                            <div class="align-self-center"><img src="assets/img/icon-gopay.png" alt="Gopay" class="p-2"></div>
                            <div class="align-self-center f-12">
                                <div class="icon hidden"><i class="fas fa-check-circle text-success f-20"></i></div>
                                Pembayaran ini akan mengarahkan ke aplikasi gojek anda.
                            </div>
                        </div>
                        </label>
                    </div>
                    <div class="form-group mb-2">
                        <label class="radio-selection"><input type="radio" name="pay" value="pay-02" />
                        <div class="d-flex justidy-content-between">
                            <div class="align-self-center"><img src="assets/img/icon-ovo.png" alt="OVO" class="p-2"></div>
                            <div class="align-self-center f-12">
                                <div class="icon hidden"><i class="fas fa-check-circle text-success f-20"></i></div>
                                Penagihan akan diarahkan ke nomor telepon yang anda masukkan.
                            </div>
                        </div>
                        </label>
                    </div>
                    <div class="form-group mb-2">
                        <label class="radio-selection"><input type="radio" name="pay" value="pay-03" />
                        <div class="d-flex justidy-content-between">
                            <div class="align-self-center"><img src="assets/img/icon-shopeepay.png" alt="ShopeePay" class="p-2"></div>
                            <div class="align-self-center f-12">
                                <div class="icon hidden"><i class="fas fa-check-circle text-success f-20"></i></div>
                                Penagihan akan diarahkan ke nomor telepon yang anda masukkan.
                            </div>
                        </div>
                        </label>
                    </div>
                    <div class="form-group mb-2">
                        <label class="radio-selection"><input type="radio" name="pay" value="pay-03" />
                        <div class="d-flex justidy-content-between">
                            <div class="align-self-center"><img src="assets/img/icon-credircard.png" alt="Kredit Card" class="p-2"></div>
                            <div class="align-self-center f-12">
                                <div class="icon hidden"><i class="fas fa-check-circle text-success f-20"></i></div>
                                Pembayaran ini akan mengarahkan ke aplikasi kartu kredit.
                            </div>
                        </div>
                        </label>
                    </div>

                    <div class="cart-line"></div>
                    <div class="form-group mt-2 d-grid">
                        <button type="submit" class="btn btn-theme-secondary py-3"> Proses pembayaran | Rp. 456.000</button>
                    </div>

                    <div class="mt-2 mx-1 f-12 text-muted">
                        <i class="far fa-check-square"></i> By submitting this order, you are agree to our <a href="javascript: void(0);" class="text-theme-based">Terms and Condition.</a>
                    </div>
                </div>

            </div>
        </div>
    </section>
    </form>
    
    <!-- // Cart -->

    <!--
    =================================
    MODALS
    =================================
    -->



    <?php include('footer.php');?>          