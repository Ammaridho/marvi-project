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
    //global m odal
    

    $(".numbers").on("keypress keyup blur",function (event) {
        //this.value = this.value.replace(/[^0-9\.]/g,'');
        $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
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
                var t = "You can only select " + e.maximum + " categories";
                //e.maximum != 1 && (t += "s");
                return t;
            }
        },
    });
    $('.store-avaibility').select2({
        multiple: true,
    });
    $(".store-categories").val([]).change(); //clear the selection
    $('.default-select-single').select2();
    $('.default-select-single-disabled').select2({
        disabled: true,
    });
    $('#addNewProductCategory')
        .select2({
            multiple: true,
        })
        .on('select2:open', () => {
            $(".select2-results:not(:has(a))").append('<a href="#" id="test1" onClick="modal()" class="text-center p-2" style="background: #e7e7e7; display: block;">Create New Category</a>');
    });

    $('#modalSelect2').select2({
        dropdownParent: $('#modalSocials')
    });

    //onBoarding
    /*
    $('.next').on("click", function(){
        $('.prev').removeClass('text-light');
        
        const $active = $('.item.active');
        const $next = $active.next();
        if ($next.length) {
            $active.removeClass('active');
            $next.addClass('active');
        }
        if( $('.item:last').hasClass('active') ){
            $('.next').addClass('text-light');
        }
    })
    $('.prev').on("click", function(){
        $('.next').removeClass('text-light');

        const $active = $('.item.active');
        const $prev = $active.prev();
        if ($prev.length) {
            $active.removeClass('active');
            $prev.addClass('active');
        }
        if( $('.item:first').hasClass('active') ){
            $('.prev').addClass('text-light');
        }
    });
    */

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
    
    //toggle
    // -- inventory
    $("input[type='checkbox'].inventory").click(function(){
        $(".openInventory").toggle();
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

    //variant repeater
    $('.repeater').repeater({ initEmpty: true });

    //default button loader
    $(".btnAction").click(function() {
        $(this).prop("disabled", true);
        $(this).html( 'Wait ...');
    });

    //
    $("#selectAll").click(function() {
        $("input[type=checkbox].opsi").prop("checked", $(this).prop("checked"));
    });
    $("input[type=checkbox].opsi").click(function() {
        if (!$(this).prop("checked")) {
            $("#selectAll").prop("checked", false);
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
      if(value == "Menu Category" || value == "Status"){
        $(this).css({"color":"gray",'font-weight':'bold','margin-bottom':'0px','padding-bottom':'0'});
      }
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

});