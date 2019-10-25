jQuery(document).ready(function($) {

    $(".puremag-nav-primary .puremag-nav-menu").addClass("responsive-menu").before('<div class="puremag-responsive-menu-icon"></div>');

    $(".puremag-responsive-menu-icon").click(function(){
        $(this).next(".puremag-nav-primary .puremag-nav-menu").slideToggle();
    });

    $(window).resize(function(){
        if(window.innerWidth > 1076) {
            $(".puremag-nav-primary .puremag-nav-menu, nav .sub-menu, nav .children").removeAttr("style");
            $(".responsive-menu > li").removeClass("menu-open");
        }
    });

    $(".responsive-menu > li").click(function(event){
        if (event.target !== this)
        return;
        $(this).find(".sub-menu:first").slideToggle(function() {
            $(this).parent().toggleClass("menu-open");
        });
        $(this).find(".children:first").slideToggle(function() {
            $(this).parent().toggleClass("menu-open");
        });
    });

    $("div.puremag-responsive-menu > ul > li").click(function(event) {
        if (event.target !== this)
            return;
        $(this).find("ul:first").slideToggle(function() {
            $(this).parent().toggleClass("menu-open");
        });
    });

    $(".post").fitVids();

    $( 'body' ).prepend( '<div class="puremag-scroll-top"></div>');
    var scrollButtonEl = $( '.puremag-scroll-top' );
    scrollButtonEl.hide();

    $( window ).scroll( function () {
        if ( $( window ).scrollTop() < 20 ) {
            $( '.puremag-scroll-top' ).fadeOut();
        } else {
            $( '.puremag-scroll-top' ).fadeIn();
        }
    } );

    scrollButtonEl.click( function () {
        $( "html, body" ).animate( { scrollTop: 0 }, 300 );
        return false;
    } );

    $('#puremag-main-wrapper, #puremag-sidebar-wrapper').theiaStickySidebar({
        containerSelector: "#puremag-content-wrapper",
        additionalMarginTop: 0,
        additionalMarginBottom: 0,
        minWidth: 785,
    });

});