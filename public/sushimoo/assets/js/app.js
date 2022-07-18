//Loader
$(window).on('load', function() {
    $('#status').fadeOut();
    $('#preloader').delay(350).fadeOut('slow');
    $('body').delay(350).css({'overflow':'visible'});
})

$(function(){
    //popover
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
    })

    //load menu sections
    /*
    $('.modal-menu').modaal({
        fullscreen: true,
        hide_close: true,
        overlay_close: true
    });
    $('.closeModaal').click(function () {
        $('.modal-menu').modaal('close');
    });
    */

    //Count + -
    $('.add').click(function () {
        $(this).prev().val(+$(this).prev().val() + 1);
    });
    $('.sub').click(function () {
        if ($(this).next().val() > 0) $(this).next().val(+$(this).next().val() - 1);
    });

    //Count + - extended
    $('.btn-number').click(function(e){
        e.preventDefault();
        idCart      = $(this).data('idCart');
        alert(idCart);
        fieldName   = $(this).attr('data-field');
        type        = $(this).attr('data-type');
        var input   = $(".cart-qty input[data-idCart="+ idCart +"]");
        var currentVal = parseInt(input.val());

        if (!isNaN(currentVal)) {
            if(type == 'minus') {
                
                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 1 + "x").change();
                }
                if(parseInt(input.val()) == input.attr('min')) {
                    //$(this).attr('disabled', true);
                    $('#modalDelete').modal('show'); //load modal confirmation
                    input.val(1 + "x");
                }
                if(currentVal == 1) {
                    $(this).html('<i class="fas fa-trash-alt"></i>');
                }
    
            } else if(type == 'plus') {
    
                if(currentVal < input.attr('max')) {
                    input.val(currentVal + 1 + "x").change();
                }
                if(parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }
    
            }
        } else {
            input.val(0);
        }
    });
    $('.input-number').focusin(function(){
       $(this).data('oldValue', $(this).val());
    });
    $('.input-number').change(function() {
        minValue =  parseInt($(this).attr('min'));
        maxValue =  parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());
        
        name = $(this).attr('name');
        if(valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            console.log('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            console.log('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
    });

    //textarea limit
    $(".area-notes").keyup(function(){
        var obj = $(this);
        var maxLen = 100;
        var val = obj.val();
        var chars = val.length;
        if(chars > maxLen){
             obj.val(val.substring(0,maxLen));
             $('.rchars').text('Text limit reached.');
        }else{
            $('.rchars').text('');
        }
    });

    //number only
    //$(".ibacor_fi").focus(function(){var a=$(this).data("prefix"),ibacor_currentId=$(this).attr('id'),ibacor_val=$(this).val();if(ibacor_val==''){$(this).val(a)}ibacor_fi(a.replace('ibacorat',''),ibacor_currentId);return false});function ibacor_fi(d,e){$('#'+e).keydown(function(c){setTimeout(function(){var a=bcr_riplis($('#'+e).val()),qq=bcr_riplis(d),ibacor_jumlah=qq.length,ibacor_cek=a.substring(0,ibacor_jumlah);if(a.match(new RegExp(qq))&&ibacor_cek==qq){$('#'+e).val(bcr_unriplis(a))}else{if(c.key=='Control'||c.key=='Backspace'||c.key=='Del'){$('#'+e).val(bcr_unriplis(qq))}else{var b=bcr_unriplis(qq)+c.key;$('#'+e).val(b.replace("undefined",""))}}},50)})}function bcr_riplis(a){var f=['+','$','^','*','?'];var r=['ibacorat','ibacordolar','ibacorhalis','ibacorkali','ibacortanya'];$.each(f,function(i,v){a=a.replace(f[i],r[i])});return a}function bcr_unriplis(a){var f=['+','$','^','*','?'];var r=['ibacorat','ibacordolar','ibacorhalis','ibacorkali','ibacortanya'];$.each(f,function(i,v){a=a.replace(r[i],f[i])});return a}
    $(".numbers").keydown(function (e) {
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
    $( ".numbers" ).change(function() {
        var max = parseInt($(this).attr('max'));
        var min = parseInt($(this).attr('min'));
        if ($(this).val() > max)
        {
            $(this).val(max);
        }
        else if ($(this).val() < min)
        {
            $(this).val(min);
        }       
    });

    //validate form payment
    $("#payments").validate({
        ignore: [],
        rules: {
            address: {required: true},
            fname: {required: true},
            //email: {required: true, email: true},
            phone: {
                digits: true,
                required: true, 
                minlength: 9,
                maxlength: 13,
            },
            pay: {required: true}
        },
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        errorPlacement: function(label, element) {
            if ( element.is(":radio") ) {
                label.addClass('f-12 fw-normal badge bg-danger mb-3');
                label.insertBefore(element);
            }else {
                label.addClass('f-12 fw-normal badge bg-danger');
                label.insertAfter(element);
            }
        },
        messages:{
            address : { required : "Alamat tidak boleh kosong"},
            fname : { required : "Nama tidak boleh kosong"},
            pay : { required : "Pilih metode pembayaran"},
            phone : { 
                required : "Nomor handphone tidak boleh kosong",
                digits :  "Format nomor handphone salah",
                minlength: "Nomor handphone terlalu pendek",
                maxlength: "Nomor handphone terlalu panjang",
            },
        }        
    });

});


// JS For Floating label
$(document).on('change focus', '.f-inputbox , .f-textbox', function () {
    $(this).siblings('.f-label').addClass('f-up'); 
});
$(document).on('blur', '.f-inputbox , .f-textbox', function () {
    if ($(this).val() === '') {
    $(this).siblings('.f-label').removeClass('f-up');
    }
});