var checkScreen = function(){
    if (windowWidth<992){
        $(".navbar-side").css('left','-265px');
    }else{
        $(".navbar-side").css('left','0');
    }
}
var openSideMenu = function(){
    $(".navbar-side").animate({ left: '0px' });
    $('.wrapper').show()
}
var closeSideMenu = function(){
    $(".navbar-side").animate({ left: '-265px' });
    $('.wrapper').hide()
}

var windowWidth = $(window).width()
$(function(){
    $(window).resize(function () {
        windowWidth = $(window).width()
        checkScreen()
    });
    $('.wrapper').click(function(){
        closeSideMenu()
    })
})