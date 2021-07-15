jQuery(document).ready(function(){

$=jQuery;
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};
if(getUrlParameter("cart") !== undefined){
	$(".full_cart_menu").toggleClass("open");
    $(".close_checkout_menu").css("display","block");
    $(".open_checkout_menu").css("display","none")
    $("html").css("overflow","hidden");
    $('#masthead').css( 'padding-right','16px');
    $(".breadcrumbs").find("a:first-child").css("color","#111");
    $(".html_topbar_right").css( 'padding-right','16px');
};




 $(".cart-btn").click(function(){
    $(".full_cart_menu").toggleClass("open");
    $(".close_checkout_menu").css("display","block");
    $(".open_checkout_menu").css("display","none")
    $("html").css("overflow","hidden");
    $('#masthead').attr( 'style','padding-right: 0 !important');
    $(".breadcrumbs").find("a:first-child").css("color","#111");
    $(".html_topbar_right").css( 'padding-right','16px');
  });

	if ($(window).width() < 549) {
		if ($(".add-to-cart-container").find(".add_to_cart_success_block").length > 0) {
			let offset = parseInt($(".add_to_cart_success_msg").offset().top);
			let head = $(".header").height();
			let body = $("html, body");
			let h = (offset-head)- 120;
			if ($(window).width() < 549 && $(window).width() > 450) {
				h = h-35
			}
		 	body.animate({scrollTop:h}, 500);
		}
	}

    // if($(".open").length > 0) {
    //     console.log(5454)
        // let t = "<?php do_action( 'woocommerce_checkout_order_review' ); ?>";
        // console.log(t)
        // $(".order_review_copy").append(t);
    // }

});