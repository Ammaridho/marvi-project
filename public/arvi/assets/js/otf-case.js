//OTF Case
let dateInp;
$('#id-payment-loading').hide();

function hideBtnCart() {
    let cartr = JSON.parse(sessionStorage.getItem('cart'));
    // hide button view cart
    if (jQuery.isEmptyObject(cartr)) { //check cart empty
        $('.shopping-cart#previewCart').addClass('d-none');
    } else {
        $('.shopping-cart#previewCart').removeClass('d-none');
    }
}

export function buttonPlusMinus(buttonPlus, buttonMinus, text) {
    //count button
    $(`.${buttonMinus}`).click(function () {

        //if cart less than 1 product
        //why check buttonplus?
        if (buttonPlus === 'pluss') {
            if ($(this).parent().find('input').val() == 1) {

                // ganti icon sampah
                let confi = confirm("Remove " + $(this).data('name') + " from cart?");
                let id = $(this).data('id');

                if (confi) {
                    // update session cart
                    let cart = JSON.parse(sessionStorage.getItem('cart'));
                    for(let __i = 0; __i < cart.length; __i++ ) {
                        let _v = cart[__i];
                        if (_v.pid === id) {
                            cart.splice(__i,1);
                            break;
                        }
                    }

                    sessionStorage.setItem('cart', JSON.stringify(cart));

                    hideBtnCart();
                    if (Object.keys(cart).length !== 0) {
                        cartView();
                    }
                    $('#previewCart').click();
                }
            }
        }

        let $input = $(this).parent().find('input');
        let count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        if (buttonPlus == 'pluss') {
            updateCart();
        }
        return false;
    });


    $(`.${buttonPlus}`).click(function () {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        if (buttonPlus === 'pluss') {
            updateCart();
        }
        return false;
    });


    $(`.${text}`).keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    $(`.${text}`).change(function () {
        var max = parseInt($(this).attr('max'));
        var min = parseInt($(this).attr('min'));
        if ($(this).val() > max) {
            $(this).val(max);
        } else if ($(this).val() < min) {
            $(this).val(min);
        }
    });
}

window.gButtonPlusMinus = buttonPlusMinus

// set button viewchart
function cartView() {
    let cart = JSON.parse(sessionStorage.getItem('cart'));
    if (cart != null && cart != undefined) {

        let totalQu = 0;
        for(let __i = 0; __i < cart.length; __i++ ) {
            let _v = cart[__i];
            totalQu += _v[_v.pid]['productQuan']
        }

        // total product
        $('#cartQ').text(totalQu);

        // total price
        let tq = parseFloat(totalQu) * 3.8;
        $('#cartP').text(tq.toFixed(2));
    }
}

function reformDate(date) {
    let options = {weekday: 'short', year: 'numeric', month: 'short', day: 'numeric'};
    let today = new Date(date);
    return today.toLocaleDateString("en-US", options);
}


//UPDATE CART
export function updateCart() {

    // get all data
    let idProduct = $('.idProductt');
    let qtyProduct = $('.input-numberr');

    // mapping to array
    let arrayP = [];
    let arrayQ = [];
    for(let i = 0; i < idProduct.length; i++){
        arrayP.push($(idProduct[i]).val());
    }
    for(let i = 0; i < qtyProduct.length; i++){
        arrayQ.push($(qtyProduct[i]).val());
    }

    // update session cart
    let cart = JSON.parse(sessionStorage.getItem('cart'));

    if (Object.keys(cart).length !== 0) {
        let i = 0
        arrayP.forEach(element => {
            let existing;
            for(let __i = 0; __i < cart.length; __i++ ) {
                let _v = cart[__i];
                if (String(_v.pid) === String(element)) {
                    existing = _v;
                    break;
                }
            }
            if (existing) {
                existing[element].productQuan = parseInt(arrayQ[i]);
                i++;
            }
        });
        sessionStorage.setItem('cart',JSON.stringify(cart));
    }

    cartView();
}

window.gUpdateCart = updateCart

$(document).ready(function () {

    $('.pickDate').calendar({
        //https://www.jqueryscript.net/time-clock/powerful-calendar.html
        showTodayButton: false,
        enableYearView: false,
        highlightSelectedWeekday: false,
        highlightSelectedWeek: false,
        howYearDropdown: false,
        showThreeMonthsInARow: true,
        onClickDate: function (date) {
            $('#modalCalendar').modal('hide');
            dateInp = reformDate(date);
            console.log(typeof dateInp);
            console.log(dateInp);
            updateReview();
            //$.fn.fullpage.moveSectionDown();
            onReviewForPurchase();
        },
        min: dTom, //tommowrow date + cut off 8.00pm (GMT +8)
        max: dFut, // max order date set if needed
    });

    $('.setDate').on('click', function () {
        dateInp = $('input[name="date"]:checked').val();
    })

    $("#mobileNumber").intlTelInput({
        onlyCountries: ['sg'],
        separateDialCode: true,
    });

    window.onload = function () {
        hideBtnCart();
        buttonPlusMinus('plus', 'minus', 'input-number');
        cartView();
        $('#buttonSubmitArvi').hide();
        $('#buttonSubmitArvi').attr('disabled', '');
        $(".ibacor_fi").focus(function () {
            var a = $(this).data("prefix"), ibacor_currentId = $(this).attr('id'), ibacor_val = $(this).val();
            if (ibacor_val == '') {
                $(this).val(a)
            }
            ibacor_fi(a.replace('ibacorat', ''), ibacor_currentId);
            return false
        });

        function ibacor_fi(d, e) {
            $('#' + e).keydown(function (c) {
                setTimeout(function () {
                    var a = bcr_riplis($('#' + e).val()), qq = bcr_riplis(d), ibacor_jumlah = qq.length,
                        ibacor_cek = a.substring(0, ibacor_jumlah);
                    if (a.match(new RegExp(qq)) && ibacor_cek == qq) {
                        $('#' + e).val(bcr_unriplis(a))
                    } else {
                        if (c.key == 'Control' || c.key == 'Backspace' || c.key == 'Del') {
                            $('#' + e).val(bcr_unriplis(qq))
                        } else {
                            var b = bcr_unriplis(qq) + c.key;
                            $('#' + e).val(b.replace("undefined", ""))
                        }
                    }
                }, 50)
            })
        }

        function bcr_riplis(a) {
            var f = ['+', '$', '^', '*', '?'];
            var r = ['ibacorat', 'ibacordolar', 'ibacorhalis', 'ibacorkali', 'ibacortanya'];
            $.each(f, function (i, v) {
                a = a.replace(f[i], r[i])
            });
            return a
        }

        function bcr_unriplis(a) {
            var f = ['+', '$', '^', '*', '?'];
            var r = ['ibacorat', 'ibacordolar', 'ibacorhalis', 'ibacorkali', 'ibacortanya'];
            $.each(f, function (i, v) {
                a = a.replace(r[i], f[i])
            });
            return a
        }
    }

    const REGEXSG = /^\D*(?:\d\D*){4,}$/g;
    //const REGEXSG_MOB_TWO = /\+65(6|8|9)\d{7}/g;
    //const REGEXSG_MOB_THREE = /(6|8|9)\d{7}/g;
    const REGEX_EMAIL = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Z]{2}|com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/i;

    // validation form
    $('.vf-em-el').on('focusout keyup', function () {
        let data = $(this).val();
        if ($(this).attr("name") === 'email' || $(this).attr("name") === 'telephone') {
            //default email
            let regex = REGEX_EMAIL;
            let idAlert = 'alert-email';
            //SG
            let btn = 'submit-name';
            if ($(this).attr("name") === 'email') { //validation email (regex)
                let btn = 'submit-email';
            } else {      //validation phone (regex)
                //let regexInd = /\+62\s\d{3}[-\.\s]??\d{3}[-\.\s]??\d{3,4}|\(0\d{2,3}\)\s?\d+|0\d{2,3}\s?\d{9}|\+62\s?361\s?\d+|\+62\d+|\+62\s?(?:\d{3,}-)*\d{3,5}/i;
                regex = REGEXSG; //choose regex format number phone
                idAlert = 'alert-telephone';
            }
            let result = data.match(regex);
            if (data === result) {   //checking
                $(`#${idAlert}`).addClass('d-none');
                $(`#${btn}`).show();
            }
        } else {
            let idAlert = 'alert-name';
            let btn = 'submit-name';
            if ($(this).attr("name") === 'name') {  //validation name
                //idAlert = 'alert-name';
                //btn = 'submit-name';
            }
            if (data !== '') { //checking
                $(`#${idAlert}`).addClass('d-none');
                $(`#${btn}`).show();
            }
        }
    });

    // form
    let mid = '';
    let cart = {};
    $('.inputData').on('click', function () {
        updateReview();
    });

    // on selected-date
    $('.order-select-date').on('click', function () {
        onReviewForPurchase();
    });

    function onReviewForPurchase() {
        let _iname = $('input[name="name"]').val();
        if (typeof _iname === 'undefined' || _iname.trim() === '') {
            let ___alName = $("#alert-name");
            ___alName.html(INAME_NOT_VALID);
            setTimeout(function () {
                ___alName.html("");
            }, 5000);
            $.fn.fullpage.moveTo('section-name',1);
            return;
        }
        /* --- end validate name --- */
        let _itelp = $('input[name="telephone"]').val().trim();
        //BUG!
        //let _ivalph = (REGEXSG_MOB_THREE.test(_itelp));
        const myReEx = new RegExp('(6|8|9)\\d{7}', 'g');
        let _ivalph = (myReEx.test(_itelp));
        //console.log('>>InvalidPh >: ' + _ivalph);

        if ( _ivalph !== true ) {
            let ___alName = $("#alert-telephone");
            //console.log('>>InvalidPhD: ' + _itelp);
            ___alName.html(IPHONE_NOT_VALID);
            setTimeout(function () {
                ___alName.html("");
            }, 5000);
            $.fn.fullpage.moveTo('section-telephone',1);
            return;
        }
        /* --- end validate phone --- */
        let _email = $('input[name="email"]').val();
        if (typeof _email === 'undefined' || _email.trim() === '' || !REGEX_EMAIL.test(_email)) {
            let ___alName = $("#alert-email");
            ___alName.html(IEMAIL_NOT_VALID);
            setTimeout(function () {
                ___alName.html("");
            }, 5000);
            $.fn.fullpage.moveTo('section-email',1);
            return;
        }
        /* --- end validate email --- */

        // id merchant
        mid = $('input[name="merchant_id"]').val();
        cart = JSON.parse(sessionStorage.getItem('cart'));
        displayReview(mid, cart, dateInp);
        $.fn.fullpage.moveTo('section-review',1);
    }

    function updateReview() {
        // id merchant
        mid = $('input[name="merchant_id"]').val();

        // get all data input
        let ar = [];//get product session
        cart = JSON.parse(sessionStorage.getItem('cart'));

        ar[0] = cart;
        ar[1] = $('input[name="name"]').val();
        ar[2] = `+65` + $('input[name="telephone"]').val();
        ar[3] = $('input[name="email"]').val();
        ar[4] = $('input[name="revor"]:checked').val();
        ar[5] = dateInp;

        // cek data review on console
        //ar.forEach(e => {
        //    console.log(e);
        //});

        // review (check all data input complete)
        if (!(ar.includes(undefined)) && !(ar.includes(null))) {
            $('#buttonSubmitArvi').show();
            $('#buttonSubmitArvi').removeAttr('disabled');

            displayReview(mid, cart, dateInp);
        } else {
            $('#buttonSubmitArvi').hide();
            $('#buttonSubmitArvi').attr('disabled', '');
        }
    }

    function displayReview(mid, cart, dateInp) {
        $.post(urlRevw, $('#arviForm').serialize() + `&mid=${mid}` +
            `&products=${encodeURIComponent(JSON.stringify(cart))}` + `&datej=${dateInp}`, function (data) {
            $("#displayReview").html(data);

            //Enable proceed
            let btnSubmtRV = $('#buttonSubmitArvi');
            btnSubmtRV.show();
            btnSubmtRV.removeAttr('disabled');
        });
    }

    // Always
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    //DEPRECATED
    $('.submit').on('click', function (e) {
        e.preventDefault();
        let a = 1;
        const konfirm = confirm('Continue Payment?');
        if (konfirm) {
            $.ajax({
                type: 'POST',
                url: "{{ route('storeArvi') }}",
                data: $('#arviForm').serialize() + `&mid=${mid}` + `&products=${JSON.stringify(cart)}` + `&datej=${dateInp}`,
                success: function (data) {
                    alert('Order Success!');
                    let cart = {}; //reset cart
                    sessionStorage.setItem('cart', JSON.stringify(cart));
                    window.location.href = '/proceedToPay/';
                },
                error: function (data) {
                    alert('Order failed!');
                    console.log(data);
                }
            })
        }
    });


    // on taking to payment
    $('.pay-m').on('click', function () {
        //Disable ALL
        $('#id-payment-pane').hide();
        $('#id-payment-loading').show();
        bookSlotForPayment();
    });

    function showErrorOnPayment() {
        alert(ERR_FAILED_PAYMENT);
    }

    function bookSlotForPayment(){
        $.ajax({
            type: 'POST',
            url: urlPayBook,
            data: $('#arviForm').serialize() + `&mid=${mid}` + `&products=${encodeURIComponent(JSON.stringify(cart))}` + `&datej=${dateInp}`,
            success: function (data) {
                if (!data.slot) {
                    showErrorOnPayment();
                    return;
                }
                //alert('Order Success!');
                let cart = []; //reset cart
                sessionStorage.setItem('cart', JSON.stringify(cart));
                window.location.href = data.processingUrl;
            },
            error: function (data) {
                $('#id-payment-pane').show();
                $('#id-payment-loading').hide();
                showErrorOnPayment();
                //console.log(data);
            }
        })
    }


    // set cart
    let selectedProductId = '';
    let selectedProductImage = '';
    let selectedProductImageType = '';
    let selectedProductName = '';
    let selectedProductPrice = 0;
    let selectedProductCurren = '';

    $('.productList').on('click', function () {

        $('#productQuantity').val(1); //awalan

        let data = $(this).data('data');

        selectedProductId = data.id;
        selectedProductImage = data.image_mime;
        selectedProductImageType = data.image_type;
        selectedProductName = data.name;
        selectedProductPrice = data.retail_price;
        selectedProductCurren = data.currency;

        let productName = data.name;
        let productPrice = data.retail_price;
        let productCurren = data.currency;
        let productDesc = data.description;

        $('h2#addCartProductName').text(productName);
        $('span#addCartProductPrice').text(productPrice);
        $('span#addCartProductCurrency').text(productCurren);
        $('div#addCartProductDesc').text(productDesc);
    });

    $('#addToChart').on('click', function () {

        let productId = selectedProductId;
        let productImage = selectedProductImage;
        let productImageType = selectedProductImageType;
        let productPrice = selectedProductPrice;
        let productCurren = selectedProductCurren;
        let productName = selectedProductName;
        let productQuant = parseInt($('#productQuantity').val());

        // get session for check data exist
        let cart = JSON.parse(sessionStorage.getItem('cart'));

        if (cart != null) { //check cart empty
            let existing;
            for(let __i = 0; __i < cart.length; __i++ ) {
                let _v = cart[__i];
                if ( String(_v.pid) === String(productId) ) {
                    existing = _v;
                    break;
                }
            }

            //if (cart[productId] !== undefined) {
            if (typeof existing !== 'undefined') {
                let old = existing[productId].productQuan;
                existing[productId].productQuan = productQuant + old;
            } else {
                let newProduct= {
                    pid: productId,
                    [productId]: {
                        productId: productId,
                        productQuan: productQuant,
                        productImage: productImage,
                        productImageType: productImageType,
                        productName: productName,
                        productPrice: productPrice,
                        productCurren: productCurren,
                    },
                }
                cart.push(newProduct);
            }
            sessionStorage.setItem('cart', JSON.stringify(cart));

        } else {
            //NEW fresh cart
            //set name object from id product
            let product = {
                pid: productId,
                [productId]: {
                    productId: productId,
                    productQuan: productQuant,
                    productImage: productImage,
                    productImageType: productImageType,
                    productName: productName,
                    productPrice: productPrice,
                    productCurren: productCurren,
                },
            };
            let basket = [];
            basket.push(product)
            sessionStorage.setItem('cart', JSON.stringify(basket));

        }
        hideBtnCart();
        cartView();
        updateReview();
    });

    // tampilkan di cart
    $('#cartListbutton').on('click', function () {
        let dataCart = JSON.parse(sessionStorage.getItem('cart'));
        $.post(urlVC, {dataCart: dataCart}, function (data) {
            $('#cartDetail').html(data);
        });
    });

    //modal
    window.onclick = function (event) {
        let closeModalOption = document.getElementById('modalOption');
        if (event.target === closeModalOption) {
            $(closeModalOption).removeClass("visible");
        }
    }

    window.onclick = function (event) {
        let closeModalFAQ = document.getElementById('modalFAQ');
        if (event.target === closeModalFAQ) {
            $(closeModalFAQ).removeClass("visible");
        }
    }

    $(".btnOnModalFAQ").on('click', function (){
        if ($(this).attr('state') === 'open') {
            $('#modalFAQ').addClass('visible');
        } else {
            $('#modalFAQ').removeClass('visible');
        }
    });
});
