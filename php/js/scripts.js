$(document).ready(function () {

    var docHeight = $(window).height();
    var footerHeight = $('#site-footer').height();
    var footerTop = $('#site-footer').position().top + footerHeight;

    if (footerTop < docHeight) {
        $('#site-footer').css('margin-top', 10 + (docHeight - footerTop) + 'px');
    }



    $(".search-namecommon").focus(function () {

        $(this).parent().addClass("form-input-focus");

    }).blur(function () {
        $(this).parent().removeClass("form-input-focus");
    })

});
