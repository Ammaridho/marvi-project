//page loader
NProgress.start();
NProgress.done();

function modal() {
    alert('Modal opened');
}

//popOver global
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})

//jquery
$(function(){
    //lazy
    $('.lazy').Lazy({
        effect: 'fadeIn',
    });

    $(".numbers").on("keypress keyup blur",function (event) {
        //this.value = this.value.replace(/[^0-9\.]/g,'');
        $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

     $(".number-lat-lon").on("keypress keyup blur",function (event) {
        $(this).val($(this).val().replace(/[^0-9\.\-\+$]/g,''));
    });

    //View product id
    $('.show-product').click(function() {
        /*
        if($(this).text() == 'View'){
            $(this).text('Less');
        } else {
            $(this).text('View');
        }*/
        $('.more-product').not('#blockProduct' + $(this).attr('target')).hide('');
        $('#blockProduct' + $(this).attr('target')).toggle('');
    });

    //Date range
    var start = moment().subtract(29, 'days');
    var today = moment();
    var end = moment();
    function cb(start, end) {
        $('#dateRange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    $('#dateRange').daterangepicker({
        "opens": "left",
        startDate: start,
        endDate: end,
        ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    cb(start, end);

    $('#dateFilter').daterangepicker({
        "opens": "center",
        startDate: start,
        endDate: end,
        ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    cb(start, end);

    $('#dateFilterSettle').daterangepicker({
        "opens": "center",
        startDate: today,
        endDate: end,
        ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    cb(start, end);

    $('.single-date').daterangepicker({
        autoUpdateInput: false,
        singleDatePicker: true,
        showDropdowns: false,
        minYear: 2022,
        maxYear: parseInt(moment().format('YYYY'),10),
    });
    $('.single-date').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });
    $('.single-date').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    //Select 2
    $('.store-categories').select2({
        multiple: true,
        maximumSelectionLength: 5,
        language: {
            maximumSelected: function (e) {
                var t = "You can only select " + e.maximum + " type of locations";
                //e.maximum != 1 && (t += "s");
                return t;
            }
        },
    });
    $('.store-avaibility').select2({
        multiple: true,
    });



    $(".store-categories").val([]).change(); //clear the selection
    $('.default-select-single').select2({allowClear: false});
    $('.default-select-single-disabled').select2({
        disabled: true,
    });


    $('#modalSelect2').select2({
        dropdownParent: $('#modalSocials')
    });

    //action Buttons
    $(".actionSaved").click(function() {
        var btn = $(this);
        btn.text('Saving ...');
        setTimeout(function() {
            btn.text('Save');
        }, 2000);
    });
    $("#actionDelete").click(function() {
        var btn = $(this);
        btn.text('Deleted ...');
        setTimeout(function() {
            $('#containerTime').hide('slow');
            btn.html('<i class="bx bx-trash-alt text-danger" ></i>');
        }, 2000);
    });

    //action manage store
    $("#manageStore input, #manageStore textarea, #manageStore select").change( function() {
        $('#containerButton').show('slow');
    });
    $("#btnCancelManageStore").click(function() {
        $('#containerButton').hide('slow');
    });

    //countTextrea
    $('textarea#description').keyup(function() {
        var characterCount = $(this).val().length,
        current = $('#current'),
        maximum = $('#maximum'),
        theCount = $('#the-count');
        current.text(characterCount);
        if (characterCount >= 250) {
          theCount.css('font-weight','bold');
        }
    });

    //activated/deativated store
    $("#flexSwitchCheckChecked").click(function() {
        $('#modalStoreActive').modal('show');
    });

    //masking input
    $('.time').mask('00:00');
    $('.phone_with_ddd').mask('(+00) 0000-0000-0000');
    $('.idr').mask('#.##0', {reverse: true});

    //btn hours
    $("#savedTime").change( function() {
        $("#btnSaveHours button").removeAttr('disabled');
    });
    $(".resetForm").click(function() {
        $("form").get(0).reset();
        e.preventDefault();
    });
    $("#addTime").click(function() {
        $('#containerTime').show('slow');
    });

    //inputCounter
    $('#inputCount').keyup(function() {
        var characterCount = $(this).val().length,
        countNow = $('#countNow');
        countNow.text(characterCount);
        if (countNow >= 20) {
            countNow.css('font-weight','bold');
        }
    });
    //inputCounter2
    $('#inputCount2').keyup(function() {
        var characterCount = $(this).val().length,
        countNow = $('#countNow2');
        countNow.text(characterCount);
        if (countNow >= 20) {
            countNow.css('font-weight','bold');
        }
    });

    //Multiple inputCounter
    $('.input-counter').on("load propertychange keyup input paste",
    function () {
        var cc = $(this).val().length;
        var id=$(this,'.input-counter').attr('id');
        //$('#'+id).prevUntil('.input-count span').text(cc);
        $(this).parent().prev('div').find('span').text(cc);
    });
    $('.input-counter').trigger('load');

    //datepicker default
    $('[data-toggle="datepicker"]').datepicker({
        format: 'dd / mm / yyyy',
    });

    //special date
    $("#addSpecialDate").click(function() {
        $('#containerSpecialDate').show('slow');
    });

    //toggles
    // -- inventory
    //$("input[type='checkbox'].inventory").click(function(){
    //    $(".openInventory").addClass("hidden"); }, function () { $(".openInventory").removeClass("hidden");
    //});
    $("input[type='checkbox'].inventory").click(function(){
        $(".openInventory").slideToggle();
        $("#stock, #lowStock").val("");
    });
    $("input[type='checkbox'].daysAhead").click(function(){
        $(".openDaysAhead").slideToggle();
    });

    //clear extra cat select
    $("#clearExtraCat").click(function(){
        $('#addNewProductCategory').val('').trigger('change');
    });

    // -- orders type
    $("input[type='radio'].order-type").click(function(){
        var test = $(this).val();
        if(test == 'openOrderType'){
            $(".open-wrapper").show();
        } else {
            $(".open-wrapper").hide();
        }
    });

    //repeater
    $('.repeater').repeater({ initEmpty: false });


    //default button loader
    $(".btnAction").click(function() {
        $(this).prop("disabled", true);
        $(this).html( 'Wait ...');
    });

    //
    $("#selectAll").click(function() {
        $("input[type=checkbox].opsi").prop("checked", $(this).prop("checked"));

        //btn settled
        if ($(this).prop("checked")) {
            $("#btn-settled").removeAttr("disabled");
        } else {
            $("#btn-settled").attr("disabled", "disabled");
        }

    });
    $("input[type=checkbox].opsi").click(function() {
        if (!$(this).prop("checked")) {
            $("#selectAll").prop("checked", false);
        }

        //btn settled
        if ($(this).prop("checked")) {
            $("#btn-settled").removeAttr("disabled");
        } else {
            $("#btn-settled").attr("disabled", "disabled");
        }

    });

    ///Uploads
    $("#uploads").uploader({
        ajaxConfig: {
          url: "upload.php",
          method: "post",
          paramsBuilder: function (uploaderFile) {
            let form = new FormData();
            form.append("file", uploaderFile.file)
            return form
          },
          ajaxRequester: function (config, uploaderFile, progressCallback, successCallback, errorCallback) {
            $.ajax({
              url: config.url,
              contentType: false,
              processData: false,
              method: config.method,
              data: config.paramsBuilder(uploaderFile),
              success: function (response) {
                successCallback(response)
              },
              error: function (response) {
                console.error("Error", response)
                errorCallback("Error")
              },
              xhr: function () {
                let xhr = new XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (e) {
                    let progressRate = (e.loaded / e.total) * 100;
                    progressCallback(progressRate)
                })
                return xhr;
              }
            })
          },
          responseConverter: function (uploaderFile, response) {
            return {
              url: response.data,
              name: null,
            }
          },
        },
    });

    //checked label
    $('.btn-checkbox').on('change', function() {
        //var valueSelected = $(this).attr('id');
        var label = $("label[for='"+$(this).attr("id")+"']");
        if($(this).prop('checked')){
            $(label).text('Active');
        }else{
            $(label).text('Not active');
        }
    });

    //nice Select
    $('select.nice').niceSelect();
    $(".nice ul li").each(function(){
      var value = $(this).attr("data-value");
      /*
      if(value == "Menu Category" || value == "Status"){
        $(this).css({"color":"gray",'font-weight':'bold','margin-bottom':'0px','padding-bottom':'0'});
      }
      */
    });

    //sort
    $(".store-sort").sortable();

    //discounts
    $('.option-discounts').click(function(){
        var inputValue = $(this).attr("value");
        var targetBox = $("." + inputValue);
        $(".box").not(targetBox).hide('slow');
        $(targetBox).show('slow');
        console.log(inputValue);
    });

    $('.option-promo-code').click(function(){
        var inputValue = $(this).attr("value");
        var targetBox = $("." + inputValue);
        $(".box2").not(targetBox).hide('slow');
        $(targetBox).show('slow');
        console.log(inputValue);
    });

    //onchanged open/close
    $('#toggler-status').change(function(){
        let selected = $(this).select2('data');
        $('.div-toggler').hide();
        selected.forEach( function(option){
            $("#"+option.id).show();
        })
    });

    $('.btn-new-store-caregories').click(function(){
        $('.wrap-new-store-catergories').show('slow');
    });

    //toggle fulflment minmum order
    $('.toggle-minimum-order-delivery').on('click', function () {
        $('.toggle-minimum-order-info-delivery').toggle();
    });
    //toggle fulflment minmum order
    $('.toggle-minimum-order-pickup').on('click', function () {
        $('.toggle-minimum-order-info-pickup').toggle();
    });

    //activated activated configure
    $('#listOptions .accordion-button').attr("disabled", true).addClass('text-low');
    $('.toggle-delivery').on('click', function () {
        if(this.checked){
            $('#listOptions .accordion-button').attr("disabled", false);
            $('#listOptions .accordion-button').removeClass('text-low');
        }
        if(!this.checked){
            $('#listOptions .accordion-button').attr("disabled", true);
            $('.collapse').collapse('hide');
            $('#listOptions .accordion-button').addClass('text-low');
        }
    });

    $('#listOptions-2 .accordion-button').attr("disabled", true).addClass('text-low');
    $('.toggle-pickup').on('click', function () {
        if(this.checked){
            $('#listOptions-2 .accordion-button').attr("disabled", false);
            $('#listOptions-2 .accordion-button').removeClass('text-low');
        }
        if(!this.checked){
            $('#listOptions-2 .accordion-button').attr("disabled", true);
            $('.collapse').collapse('hide');
            $('#listOptions-2 .accordion-button').addClass('text-low');
        }
    });

    //eye of the tiger :)
    $('.password-group').find('.password-box').each(function(index, input) {
        var $input = $(input);
        $input.parent().find('.password-visibility').click(function() {
            var change = "";
            if ($(this).find('i').hasClass('bx-hide')) {
                $(this).find('i').removeClass('bx-hide')
                $(this).find('i').addClass('bx-show')
                change = "text";
            } else {
                $(this).find('i').removeClass('bx-show')
                $(this).find('i').addClass('bx-hide')
                change = "password";
            }
            var rep = $("<input type='" + change + "' />")
                .attr('id', $input.attr('id'))
                .attr('name', $input.attr('name'))
                .attr('class', $input.attr('class'))
                .val($input.val())
                .insertBefore($input);
            $input.remove();
            $input = rep;
        }).insertAfter($input);
    });

    //auto complete
    $.fn.autofill.lang = {
        emptyTable: "Location not found ...",
        processing: "Processing ...",
    }
    var items = [
        "Jl. Atiek Soeardi, Tigaraksa, Tangerang, Banten 15720",
        "Jl. Veteran No.10, Jakarta Pusat 10110",
        "Graha Depok Mas Blok A1-4 Jl. Arief Rahman Hakim No.3 Beji Kota Depok",
        "Jl. Margonda Raya No. 54 Depok",
        "Jalan Mayor Oking No 14, Kel. Cimekar, Kec. Cibinong, Kab. Bogor",
        "Ruko Serang City Square, Jl. Raya Cilegon KM 3 - 5 Blok C/8, Serang",
        "Jl. MT. Haryono No. 79, Madiun 69139",
        "Ruko Tuparev Super Blok (TSB) Blok A3, Jl. Tuparev No. 83 A, Cirebon",
        "Ruko Sun City Square Blok A No. 42, Jl. M. Hasibuan Margajaya Bekasi selatan, Bekasi",
        "Ciputat Indah Permai B-7, Jl. Ir. H. Juanda No. 50, Tangerang Selatan",
        "Ruko Komplek Mekar Wangi, Jl. Mekar Utama No. 22, Bandung",
    ];
    $("#location-store").autofill({
        values: items,
        itemsLimit: 5,
        minCharacters: 2,
        onSelect: (item) => {
            $('#storeAddr').val('Auto filled street address');
            $('#storeBulding').val('Auto filled buidling if available');
            $('#storeCity').val('Auto filled city');
            $('#storeState').val('Auto filled states');
            $('#storePostal').val('12345');
        },
    });
    var product = [
        "Ayam Bakar",
        "Ayam Bakar Madu",
        "Ayam Bakar Taliwang",
        "Ayam Bakar Kecap",
        "Ayam Bakar Sambal Ijo",
        "Ayam Bakar Sambal Matah",
        "Bebek Guling",
        "Es Jeruk",
        "Es Campur",
        "Teh Manis",
        "What the hell you think i am ?",
    ];
    $("#search-product").autofill({
        values: product,
        itemsLimit: 5,
        minCharacters: 2,
        onSelect: (item) => {
            $('#inputCount').val('Auto filled menu name');
            $('#description').val('Auto filled menu description');
            $('#price').val('45000');
            $('#prep').val('15');
            $('#storePostal').val('12345');
        },
    });

    // regex sku
    $('.regex-sku').on('input',function () {
        this.value = this.value.replace(/[^a-zA-Z0-9._-]/g, '').replace(/(\..*?)\..*/g, '$1');
    })

    // regex number
    $('.regex-number').on('input',function () {
        this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    })

    //Button save and block UI
    $("#btnSave").click(function() {
        $(this).html( 'Saving ...');
        $.blockUI({
            overlayCSS: { backgroundColor: '#fff' },
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: 'transparent',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .9,
                color: '#000',
                fontSize:'16px',
                timeout: 3000,
            },
            message: $('#wait'),
        });
        setTimeout(function () {
            window.history.go(-1);
        }, 3100);
    });

    
    //upload
    $('.upload-bulk input').change(function () {
        var res=$('.upload-bulk input').val();
        var arr = res.split("\\");
        var filename=arr.slice(-1)[0];
        $('#file-response').html(filename);
        //$('.upload-bulk p').text(this.files.length + " file(s) selected");
      });
  
      //repeater x select2
      $("#repeater-button").click(function(){
        setTimeout(function(){
    
          $(".select2").select2({
              placeholder: "Select",
              allowClear: true
          });
    
        }, 100);
      });
      $("#repeater-button-2").click(function(){
        setTimeout(function(){
    
          $(".select2").select2({
              placeholder: "Select",
              allowClear: false
          });
    
        }, 100);
      });
  
      //demo POS  +/-
      $('.btn-number').click(function(e){
        e.preventDefault();
        
        fieldName = $(this).attr('data-field');
        type      = $(this).attr('data-type');
        var input = $("input[name='"+fieldName+"']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if(type == 'minus') {
                
                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                } 
                if(parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }
    
            } else if(type == 'plus') {
    
                if(currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
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
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        } 
    });
  
    //reset
      $('input.withreset').click(function(){
          $('input', $(this).parent()).val('');
      });
  
    //promotions type
    $("select.promotype").change(function(){
      $(this).find("option:selected").each(function(){
          var optionValue = $(this).attr("value");
          if(optionValue){
              $(".box").not("." + optionValue).hide();
              $("." + optionValue).show();
          } else{
              $(".box").hide();
          }
      });
    }).change();
    $(".applyAllproduct").click(function() {
      if($(this).is(":checked")) {
          $(".boxOption").hide();
      } else {
          $(".boxOption").show();
      }
    });
    $(".applyAllpayment").click(function() {
      if($(this).is(":checked")) {
          $(".boxOptionPayment").hide();
      } else {
          $(".boxOptionPayment").show();
      }
    });
    $(".applyAllproduct2").click(function() {
      if($(this).is(":checked")) {
          $(".boxOption2").hide();
      } else {
          $(".boxOption2").show();
      }
    });
  
    //QR template section
    $('#inputTitle').keyup(function(){
        var newValue = $(this).val();
        $('#wtitle').text(newValue);
    });
    $("#color1").change(function() { 
        $("#wtitle").css('color', $(this).val());
    });

    $('#inputSubTitle').keyup(function(){
        var newValue = $(this).val();
        $('#wsubtitle').text(newValue);
    });
    $("#color2").change(function() { 
        $("#wsubtitle").css('color', $(this).val());
    });

    $('#shortdesc').keyup(function(){
        var newValue = $(this).val();
        $('#wdesc').text(newValue);
    });
    $("#color3").change(function() { 
        $("#wdesc").css('color', $(this).val());
    });

    $('#inputHelper').keyup(function(){
        var newValue = $(this).val();
        $('#whelper').text(newValue);
    });
    $("#color4").change(function() { 
        $("#whelper").css('color', $(this).val());
    });

    $(".locationShow").click(function() {
        if($(this).is(":checked")) {
            $(".locationCon").show();
        } else {
            $(".locationCon").hide();
        }
    });
    $(".socialShow").click(function() {
        if($(this).is(":checked")) {
            $(".socialCon").show();
        } else {
            $(".socialCon").hide();
        }
    });

    $('textarea#shortdesc').keyup(function() {
        var characterCount = $(this).val().length,
        current = $('#current'),
        maximum = $('#maximum'),
        theCount = $('#the-count');  
        current.text(characterCount);
        if (characterCount >= 250) {
        theCount.css('font-weight','bold');
        }  
    });

    $("#colorText").change(function() { 
        $(".socialCon, .footer-desc").css('color', $(this).val());
    });
    $("#colorBackground").change(function() { 
        $("#theme-one").css('background', $(this).val());
        $(".imgBackground svg").css({ fill: $(this).val() });
    });

    $("#btnInserLogo").change(function() { 
        const file = this.files[0];
        if (file){
        let reader = new FileReader();
        reader.onload = function(event){
            $('.viewLogo').attr('src', event.target.result);
        }
        reader.readAsDataURL(file);
        }
    });
  
    $("#btnInserbackground").change(function() { 
        const file = this.files[0];
        if (file){
            let reader = new FileReader();
            reader.onload = function(event){
                //$('.imageName').attr('background', event.target.result);
                $('#imageName').css('background-image', 'url("'+ event.target.result +'")');
                //$('body').css('background', 'transparent url("'+ event.target.result +'")');
            }
            reader.readAsDataURL(file);
        }
    });
  
    //Dropzone
    const previewTemplate = `<div class="dz-preview dz-file-preview">
    <div class="dz-details">
        <div class="dz-thumbnail">
        <img data-dz-thumbnail>
        <span class="dz-nopreview">No preview</span>
        <div class="dz-success-mark"></div>
        <div class="dz-error-mark"></div>
        <div class="dz-error-message"><span data-dz-errormessage></span></div>
        <div class="progress">
            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
        </div>
        </div>
        <div class="dz-filename" data-dz-name></div>
        <div class="dz-size" data-dz-size></div>
    </div>
    </div>`;
    if ($('#dropzone-basic').length) {
        $("div#dropzone-basic").dropzone({ url: "/file/post" });
        const myDropzone = new Dropzone('#dropzone-basic', {
            previewTemplate: previewTemplate,
            parallelUploads: 1,
            maxFilesize: 20,
            addRemoveLinks: true,
            maxFiles: 1
        });
    }
});
