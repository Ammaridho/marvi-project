//Init
$('#fullpage').fullpage({
    //menu: '#menu',
    //anchors: ['section-1', 'section-2', 'section-3', 'section-4', 'section-5',
    //        'section-6', 'section-7', 'section-8', 'section-9',
    //        'section-10', 'section-11', 'section-12'],
    navigation: false,
    scrollBar: false,
    scrollingSpeed: 700,
    fitToSection: true,
    licenseKey: '630K9-3N6F7-7MJF8-H5OHJ-QSVMO',
    afterLoad: function(origin, destination, direction){
        if(destination.index === 1){
            $('#previewCart').show();
        }else{
            $('#previewCart').hide();
        }
    },
});

//Nav Arrow
$('.arrowUp').click(function(){
    $.fn.fullpage.moveSectionUp();
});
$('.arrowDown').click(function(){
    $.fn.fullpage.moveSectionDown();
});
$('.arrowDownSm').click(function(){
    $.fn.fullpage.moveSectionDown();
});

function arrowDownSm() {
    $.fn.fullpage.moveSectionDown();
}
