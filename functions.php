<?php
// Add custom Theme Functions here


// custom field pdf document link
function pdfDocument() {
    global $post;
    //Get the field's value
    $pdf = get_field('pdf_document');

    // Pass it to the other shortcode and return its value
    if($pdf) {
        return '<a href="' .$pdf . '" target="_blank" style="text-decoration: underline;">Grössentabelle</a>';
    }
    else {
        return;
    }
}
add_shortcode( 'pdf-document', 'pdfDocument');

function my_enqueue_scripts()
{
    wp_enqueue_script('custom-script_child',get_stylesheet_directory_uri(). '/assets/script.js',array( 'jquery' ),true);
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' );

if( !function_exists('ceiling') )
{
    function ceiling($number, $significance = 1)
    {
        return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number/$significance)*$significance) : false;
    }
}
// 3 tage
function tagethree() {
    global $post;
    global $product;

        $min_regular_price = $product->get_price();
        $last = substr($min_regular_price, -1);
        if ($last > 5) {
            $min_regular_price =  round($min_regular_price,PHP_ROUND_HALF_UP);
            $min_regular_price = number_format($min_regular_price,2,".",".");
        }else if($last < 5 && $last != 0){
            $min_regular_price = ceiling($min_regular_price, 0.05);
        }
        return $min_regular_price;
}
add_shortcode( 'three-tage', 'tagethree');

// 5tage
function tagefive() {
    global $post;
    global $product;

    $pricefive = get_field('5_tage');
     
        $pricing_tiers_data = get_post_meta(  $post->ID, '_wcrp_rental_products_pricing_tiers_data', true );
        $myPercent=$pricing_tiers_data["percent"][0];
        $min_regular_price = $product->get_price();
        $price =  (double)$min_regular_price +  (double)$min_regular_price * (double)$myPercent / 100 ;
        $price = number_format($price,2,".",".");
        $last = substr($price, -1);
        if ($last > 5) {
            $price =  round($price,PHP_ROUND_HALF_UP);
            $price = number_format($price,2,".",".");
        }else if($last < 5 && $last != 0){
            $price = ceiling($price, 0.05);
        }

        return $price;
}
add_shortcode( 'five-tage', 'tagefive');

// 7tage
function tageseven() {
    global $post;
    global $product;

    $priceseven = get_field('7_tage');
        
        $pricing_tiers_data = get_post_meta(  $post->ID, '_wcrp_rental_products_pricing_tiers_data', true );
        $myPercent=$pricing_tiers_data["percent"][1];
        $min_regular_price = $product->get_price();
        $price =  (double)$min_regular_price +  (double)$min_regular_price * (double)$myPercent / 100 ;
        $price = number_format($price,2,".",".");
        $last = substr($price, -1);
        if ($last > 5) {
            $price =  round($price,PHP_ROUND_HALF_UP);
            $price = number_format($price,2,".",".");
        }else if($last < 5 && $last != 0){
            $price = ceiling($price, 0.05);
        }

        return $price;
}
add_shortcode( 'seven-tage', 'tageseven');

// mietpreis_ab
function mietpreis_ab() {
    global $product;
    global $post;

    $mietpreisprice = $product->get_price();
    $pricing_tiers_data = get_post_meta(  $post->ID, '_wcrp_rental_products_pricing_tiers_data', true );
    $myPercent=$pricing_tiers_data["percent"][1];
    $price =  (double)$mietpreisprice +  (double)$mietpreisprice * (double)$myPercent / 100 ;

    $price = number_format($price,2,".",".");
    $last = substr($price, -1);
    if ($last > 5) {
        $price =  round($price,PHP_ROUND_HALF_UP);
        $price = number_format($price,2,".",".");
    }else if($last < 5 && $last != 0){
        $price = ceiling($price, 0.05);
    }

    return $price;
}
add_shortcode( 'mietpreis-ab', 'mietpreis_ab');




// display brand and category in shop loop


function display_brand_before_title(){
    global $product;
    $erwachsenengroesse = $product->get_attribute( 'erwachsenengroesse' );
    $kindergroessen = $product->get_attribute( 'kindergroessen' );
    $attribute_erwachsenengroesse = str_replace(',', ' ', $erwachsenengroesse);
    $attribute_kindergroessen = str_replace(',', ' ', $kindergroessen);
    $product_id = $product->get_id();
    $brands = wp_get_post_terms( $product_id, 'pwb-brand' );
    $html = '';
    $html1 = '';
    $html2 = '';
 
    $categories = get_the_terms( get_the_ID(), 'product_cat' ); 

    if ( $categories ) {

        foreach($categories as $category) {
          $children = get_categories( array ('taxonomy' => 'product_cat', 'parent' => $category->term_id ));
    
          if ( count($children) != 0 ) {
            $html1 .= $category->name . ' ';
          }

          if ( count($children) == 0 ) {
            $html2 .= $category->name . ' ';
        }
         
        };

    
    };

    $html .= '<p class="product-category">' . $html1 . $html2 . '</p>';

    foreach( $brands as $brand ) {
        if($erwachsenengroesse != ''){ 
            echo '<p class="brand_product_attribute" style="float:right; margin-right: 35px">' . $attribute_erwachsenengroesse . '</p>';
        }elseif($kindergroessen != ''){
            echo '<p class="brand_product_attribute" style="float:right">' . $attribute_kindergroessen . '</p>';
        }
        $html .= '<p class="product-brand">' . $brand->name. '</p>';
    }

    echo $html;
}

add_action( 'woocommerce_before_shop_loop_item_title', 'display_brand_before_title' );


// display attribute in shop loop

function display_brand_before_titlee(){
    global $product;
    $product_id = $product->get_id();
    $value_uvp = get_field( "uvp");
     
    $price_val = round($value_uvp,PHP_ROUND_HALF_UP);
    $uvp_price = number_format($price_val,2,".",".");




    $value_mietpreis_ab = get_field( "mietpreis_ab");
    
        echo '<div class="uvp_mietpreis_abb"><p class="product-uvp">UVP' . ' ' . $uvp_price.' CHF</p><p>mieten ab' . ' ' . do_shortcode( '[mietpreis-ab]' ) . ' CHF</p></div>';
   
}

add_action( 'woocommerce_after_shop_loop_item_title', 'display_brand_before_titlee' );


// product images slider in shop loop


function productThumbsSlider() {

		global $product;

		$attachment_ids = $product->get_gallery_attachment_ids();

        echo '<div class="gallery-slider-section"><div class="product-thumbs">';
        echo '<div class="thumb"><a href="' . get_permalink($product->get_id()) . '">';
        if(wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ))[0]) {
            echo '<img src="' . wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ))[0] . '">';
        }
        else {
            echo '<img src="/wp-content/uploads/woocommerce-placeholder.png">';
        }
        echo '</a></div>';

        // echo '<div class="thumb"><a href="' . get_permalink($product->get_id()) . '"><img src="' . wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ))[0] . '"></a></div>';

		foreach( $attachment_ids as $attachment_id ) {

		  	$thumbnail_url = wp_get_attachment_image_src( $attachment_id, 'thumbnail' )[0];

		  	echo '<div class="thumb"><a href="' . get_permalink($product->get_id()) . '"><img src="' . $thumbnail_url . '"></a></div>';

		}

		echo '</div></div>';
	

 }

 add_action('woocommerce_before_shop_loop_item_title','productThumbsSlider', 5);

 function flatsome_checkout_breadcrumb_class($endpoint){
    $classes = array();
    if($endpoint == 'cart' && is_cart() ||
        $endpoint == 'checkout' && is_checkout() && !is_wc_endpoint_url('order-received') ||
        $endpoint == 'order-received' && is_wc_endpoint_url('order-received')) {
        $classes[] = 'current';
    } else{
        $classes[] = 'hide-for-small';
    }
    return implode(' ', $classes);
}



function ra_change_translate_text( $translated_text ) {
    if ( $translated_text == 'Tue' ) {
        $translated_text = 'Die';
    }
    return $translated_text;
}
add_filter( 'init', 'ra_change_translate_text', 20 );


function ArabicDate( $time = false ) {

    if ( $time === false ) {
        $time = current_time( 'timestamp' );
    }
    $months = array("January" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر");
    $your_date = date( 'y-m-d', $time ); // The Date calculated from the $time variable
    $en_month = date("M", $time );
    foreach ($months as $en => $ar) {
        if ($en == $en_month) { $ar_month = $ar; }
    }

    $find = array ("Sat", "Sun", "Mon", "Tue", "Wed" , "Thu", "Fri");
    $replace = array ("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
    $ar_day_format = date('D', $time); // The Current Day
    $ar_day = str_replace($find, $replace, $ar_day_format);

    $standard = array("0","1","2","3","4","5","6","7","8","9");
    $eastern_arabic_symbols = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");

    // use this line to format your arabic date
    $current_date = $ar_day.' '.date( 'd', $time ).' / '.$ar_month.' / '.date( 'Y', $time );
    $arabic_date = str_replace($standard , $eastern_arabic_symbols , $current_date);

    return $arabic_date;

}

add_filter( 'get_the_date', 'f711_convert_to_arabic_date', 10, 3 );
function f711_convert_to_arabic_date( $the_date, $d, $post ) {
    $posttime = strtotime( $post->post_date );
    return ArabicDate( $posttime );
}


         
// add the filter 
// add_filter( 'woocommerce_cart_product_subtotal', 'filter_woocommerce_cart_product_subtotal', 10, 4 ); 

wp_enqueue_script ( 'custom-script', get_template_directory_uri() . '/assets/js/main_single.js', array('jquery'),'',true);
add_action( 'woocommerce_add_to_cart', function ($cart_item_data,$productId)
{
    global $woocommerce;
    //$items = $woocommerce->cart->get_cart();
        
        //global $woocommerce;
        //$cart_item_count =  $woocommerce->cart->cart_contents;
        $price = '';
            foreach( WC()->cart->get_cart() as $cart_item ){
                $product_id = $cart_item['product_id'];
                 if($productId == $product_id){
                    $price = $cart_item['wcrp_rental_products_cart_item_price'];
                  }
            }
              
                $val = round( $price,PHP_ROUND_HALF_UP);
                $value = number_format($val,2,".",".");

            add_action( 'woocommerce_after_add_to_cart_button', 'add_content_after_addtocart_button_func' );      	
    ?>
<!--
      <div class="add_to_cart_success_block">
         <div class="add_to_cart_success_msg">
             <div class="top_side">
                 <span class="msg_title">Zum Korb hinzugefügt</span><span class="close-block">X</span>
             </div>
             <p>Du hast <?php  global $woocommerce; echo $woocommerce->cart->cart_contents_count; ?> Artikel im Warenkorb.</p><br>
             <div>
                 <span class="product_price_title_msg">Zwischensumme</span>
   

                 <span class="product_price_msg">CHF <?php echo $value; ?></span>
             </div>
             <div>
                 <span class="lieferung">Lieferung</span>
                 <span class="product_price_msg">Kostenlos</span>
             </div>
             <hr>
             <div>
                 <span class="leferung_price_text">Gesamt inkl. Lieferung</span>
                 <span class="leferung_price_price">CHF <?php  echo $value;  ?> </span>
             </div>
             <div class="cart-btn"><a href="https://outdoorservice.ch/cart/"><button class="msg_cart_btn">Zum Warenkorb</button></a></div>
             <div class="checkout-btn"><a href="https://outdoorservice.ch/checkout/"><button class="msg_checkout_btn">Zur Kasse</button></a></div>
-->

            
<!--
             <div class="payment-icons inline-block"><div class="payment-icon"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 32">
            <path d="M10.781 7.688c-0.251-1.283-1.219-1.688-2.344-1.688h-8.376l-0.061 0.405c5.749 1.469 10.469 4.595 12.595 10.501l-1.813-9.219zM13.125 19.688l-0.531-2.781c-1.096-2.907-3.752-5.594-6.752-6.813l4.219 15.939h5.469l8.157-20.032h-5.501l-5.062 13.688zM27.72 26.061l3.248-20.061h-5.187l-3.251 20.061h5.189zM41.875 5.656c-5.125 0-8.717 2.72-8.749 6.624-0.032 2.877 2.563 4.469 4.531 5.439 2.032 0.968 2.688 1.624 2.688 2.499 0 1.344-1.624 1.939-3.093 1.939-2.093 0-3.219-0.251-4.875-1.032l-0.688-0.344-0.719 4.499c1.219 0.563 3.437 1.064 5.781 1.064 5.437 0.032 8.97-2.688 9.032-6.843 0-2.282-1.405-4-4.376-5.439-1.811-0.904-2.904-1.563-2.904-2.499 0-0.843 0.936-1.72 2.968-1.72 1.688-0.029 2.936 0.314 3.875 0.752l0.469 0.248 0.717-4.344c-1.032-0.406-2.656-0.844-4.656-0.844zM55.813 6c-1.251 0-2.189 0.376-2.72 1.688l-7.688 18.374h5.437c0.877-2.467 1.096-3 1.096-3 0.592 0 5.875 0 6.624 0 0 0 0.157 0.688 0.624 3h4.813l-4.187-20.061h-4zM53.405 18.938c0 0 0.437-1.157 2.064-5.594-0.032 0.032 0.437-1.157 0.688-1.907l0.374 1.72c0.968 4.781 1.189 5.781 1.189 5.781-0.813 0-3.283 0-4.315 0z"></path>
            </svg>
            </div><div class="payment-icon"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 32">
            <path d="M7.114 14.656c-1.375-0.5-2.125-0.906-2.125-1.531 0-0.531 0.437-0.812 1.188-0.812 1.437 0 2.875 0.531 3.875 1.031l0.563-3.5c-0.781-0.375-2.406-1-4.656-1-1.594 0-2.906 0.406-3.844 1.188-1 0.812-1.5 2-1.5 3.406 0 2.563 1.563 3.688 4.125 4.594 1.625 0.594 2.188 1 2.188 1.656 0 0.625-0.531 0.969-1.5 0.969-1.188 0-3.156-0.594-4.437-1.343l-0.563 3.531c1.094 0.625 3.125 1.281 5.25 1.281 1.688 0 3.063-0.406 4.031-1.157 1.063-0.843 1.594-2.062 1.594-3.656-0.001-2.625-1.595-3.719-4.188-4.657zM21.114 9.125h-3v-4.219l-4.031 0.656-0.563 3.563-1.437 0.25-0.531 3.219h1.937v6.844c0 1.781 0.469 3 1.375 3.75 0.781 0.625 1.907 0.938 3.469 0.938 1.219 0 1.937-0.219 2.468-0.344v-3.688c-0.282 0.063-0.938 0.22-1.375 0.22-0.906 0-1.313-0.5-1.313-1.563v-6.156h2.406l0.595-3.469zM30.396 9.031c-0.313-0.062-0.594-0.093-0.876-0.093-1.312 0-2.374 0.687-2.781 1.937l-0.313-1.75h-4.093v14.719h4.687v-9.563c0.594-0.719 1.437-0.968 2.563-0.968 0.25 0 0.5 0 0.812 0.062v-4.344zM33.895 2.719c-1.375 0-2.468 1.094-2.468 2.469s1.094 2.5 2.468 2.5 2.469-1.124 2.469-2.5-1.094-2.469-2.469-2.469zM36.239 23.844v-14.719h-4.687v14.719h4.687zM49.583 10.468c-0.843-1.094-2-1.625-3.469-1.625-1.343 0-2.531 0.563-3.656 1.75l-0.25-1.469h-4.125v20.155l4.688-0.781v-4.719c0.719 0.219 1.469 0.344 2.125 0.344 1.157 0 2.876-0.313 4.188-1.75 1.281-1.375 1.907-3.5 1.907-6.313 0-2.499-0.469-4.405-1.407-5.593zM45.677 19.532c-0.375 0.687-0.969 1.094-1.625 1.094-0.468 0-0.906-0.093-1.281-0.281v-7c0.812-0.844 1.531-0.938 1.781-0.938 1.188 0 1.781 1.313 1.781 3.812 0.001 1.437-0.219 2.531-0.656 3.313zM62.927 10.843c-1.032-1.312-2.563-2-4.501-2-4 0-6.468 2.938-6.468 7.688 0 2.625 0.656 4.625 1.968 5.875 1.157 1.157 2.844 1.719 5.032 1.719 2 0 3.844-0.469 5-1.251l-0.501-3.219c-1.157 0.625-2.5 0.969-4 0.969-0.906 0-1.532-0.188-1.969-0.594-0.5-0.406-0.781-1.094-0.875-2.062h7.75c0.031-0.219 0.062-1.281 0.062-1.625 0.001-2.344-0.5-4.188-1.499-5.5zM56.583 15.094c0.125-2.093 0.687-3.062 1.75-3.062s1.625 1 1.687 3.062h-3.437z"></path>
            </svg>
            </div><div class="payment-icon"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 32">
            <path d="M42.667-0c-4.099 0-7.836 1.543-10.667 4.077-2.831-2.534-6.568-4.077-10.667-4.077-8.836 0-16 7.163-16 16s7.164 16 16 16c4.099 0 7.835-1.543 10.667-4.077 2.831 2.534 6.568 4.077 10.667 4.077 8.837 0 16-7.163 16-16s-7.163-16-16-16zM11.934 19.828l0.924-5.809-2.112 5.809h-1.188v-5.809l-1.056 5.809h-1.584l1.32-7.657h2.376v4.753l1.716-4.753h2.508l-1.32 7.657h-1.585zM19.327 18.244c-0.088 0.528-0.178 0.924-0.264 1.188v0.396h-1.32v-0.66c-0.353 0.528-0.924 0.792-1.716 0.792-0.442 0-0.792-0.132-1.056-0.396-0.264-0.351-0.396-0.792-0.396-1.32 0-0.792 0.218-1.364 0.66-1.716 0.614-0.44 1.364-0.66 2.244-0.66h0.66v-0.396c0-0.351-0.353-0.528-1.056-0.528-0.442 0-1.012 0.088-1.716 0.264 0.086-0.351 0.175-0.792 0.264-1.32 0.703-0.264 1.32-0.396 1.848-0.396 1.496 0 2.244 0.616 2.244 1.848 0 0.353-0.046 0.749-0.132 1.188-0.089 0.616-0.179 1.188-0.264 1.716zM24.079 15.076c-0.264-0.086-0.66-0.132-1.188-0.132s-0.792 0.177-0.792 0.528c0 0.177 0.044 0.31 0.132 0.396l0.528 0.264c0.792 0.442 1.188 1.012 1.188 1.716 0 1.409-0.838 2.112-2.508 2.112-0.792 0-1.366-0.044-1.716-0.132 0.086-0.351 0.175-0.836 0.264-1.452 0.703 0.177 1.188 0.264 1.452 0.264 0.614 0 0.924-0.175 0.924-0.528 0-0.175-0.046-0.308-0.132-0.396-0.178-0.175-0.396-0.308-0.66-0.396-0.792-0.351-1.188-0.924-1.188-1.716 0-1.407 0.792-2.112 2.376-2.112 0.792 0 1.32 0.045 1.584 0.132l-0.265 1.451zM27.512 15.208h-0.924c0 0.442-0.046 0.838-0.132 1.188 0 0.088-0.022 0.264-0.066 0.528-0.046 0.264-0.112 0.442-0.198 0.528v0.528c0 0.353 0.175 0.528 0.528 0.528 0.175 0 0.35-0.044 0.528-0.132l-0.264 1.452c-0.264 0.088-0.66 0.132-1.188 0.132-0.881 0-1.32-0.44-1.32-1.32 0-0.528 0.086-1.099 0.264-1.716l0.66-4.225h1.584l-0.132 0.924h0.792l-0.132 1.585zM32.66 17.32h-3.3c0 0.442 0.086 0.749 0.264 0.924 0.264 0.264 0.66 0.396 1.188 0.396s1.1-0.175 1.716-0.528l-0.264 1.584c-0.442 0.177-1.012 0.264-1.716 0.264-1.848 0-2.772-0.924-2.772-2.773 0-1.142 0.264-2.024 0.792-2.64 0.528-0.703 1.188-1.056 1.98-1.056 0.703 0 1.274 0.22 1.716 0.66 0.35 0.353 0.528 0.881 0.528 1.584 0.001 0.617-0.046 1.145-0.132 1.585zM35.3 16.132c-0.264 0.97-0.484 2.201-0.66 3.697h-1.716l0.132-0.396c0.35-2.463 0.614-4.4 0.792-5.809h1.584l-0.132 0.924c0.264-0.44 0.528-0.703 0.792-0.792 0.264-0.264 0.528-0.308 0.792-0.132-0.088 0.088-0.31 0.706-0.66 1.848-0.353-0.086-0.661 0.132-0.925 0.66zM41.241 19.697c-0.353 0.177-0.838 0.264-1.452 0.264-0.881 0-1.584-0.308-2.112-0.924-0.528-0.528-0.792-1.32-0.792-2.376 0-1.32 0.35-2.42 1.056-3.3 0.614-0.879 1.496-1.32 2.64-1.32 0.44 0 1.056 0.132 1.848 0.396l-0.264 1.584c-0.528-0.264-1.012-0.396-1.452-0.396-0.707 0-1.235 0.264-1.584 0.792-0.353 0.442-0.528 1.144-0.528 2.112 0 0.616 0.132 1.056 0.396 1.32 0.264 0.353 0.614 0.528 1.056 0.528 0.44 0 0.924-0.132 1.452-0.396l-0.264 1.717zM47.115 15.868c-0.046 0.264-0.066 0.484-0.066 0.66-0.088 0.442-0.178 1.035-0.264 1.782-0.088 0.749-0.178 1.254-0.264 1.518h-1.32v-0.66c-0.353 0.528-0.924 0.792-1.716 0.792-0.442 0-0.792-0.132-1.056-0.396-0.264-0.351-0.396-0.792-0.396-1.32 0-0.792 0.218-1.364 0.66-1.716 0.614-0.44 1.32-0.66 2.112-0.66h0.66c0.086-0.086 0.132-0.218 0.132-0.396 0-0.351-0.353-0.528-1.056-0.528-0.442 0-1.012 0.088-1.716 0.264 0-0.351 0.086-0.792 0.264-1.32 0.703-0.264 1.32-0.396 1.848-0.396 1.496 0 2.245 0.616 2.245 1.848 0.001 0.089-0.021 0.264-0.065 0.529zM49.69 16.132c-0.178 0.528-0.396 1.762-0.66 3.697h-1.716l0.132-0.396c0.35-1.935 0.614-3.872 0.792-5.809h1.584c0 0.353-0.046 0.66-0.132 0.924 0.264-0.44 0.528-0.703 0.792-0.792 0.35-0.175 0.614-0.218 0.792-0.132-0.353 0.442-0.574 1.056-0.66 1.848-0.353-0.086-0.66 0.132-0.925 0.66zM54.178 19.828l0.132-0.528c-0.353 0.442-0.838 0.66-1.452 0.66-0.707 0-1.188-0.218-1.452-0.66-0.442-0.614-0.66-1.232-0.66-1.848 0-1.142 0.308-2.067 0.924-2.773 0.44-0.703 1.056-1.056 1.848-1.056 0.528 0 1.056 0.264 1.584 0.792l0.264-2.244h1.716l-1.32 7.657h-1.585zM16.159 17.98c0 0.442 0.175 0.66 0.528 0.66 0.35 0 0.614-0.132 0.792-0.396 0.264-0.264 0.396-0.66 0.396-1.188h-0.397c-0.881 0-1.32 0.31-1.32 0.924zM31.076 15.076c-0.088 0-0.178-0.043-0.264-0.132h-0.264c-0.528 0-0.881 0.353-1.056 1.056h1.848v-0.396l-0.132-0.264c-0.001-0.086-0.047-0.175-0.133-0.264zM43.617 17.98c0 0.442 0.175 0.66 0.528 0.66 0.35 0 0.614-0.132 0.792-0.396 0.264-0.264 0.396-0.66 0.396-1.188h-0.396c-0.881 0-1.32 0.31-1.32 0.924zM53.782 15.076c-0.353 0-0.66 0.22-0.924 0.66-0.178 0.264-0.264 0.749-0.264 1.452 0 0.792 0.264 1.188 0.792 1.188 0.35 0 0.66-0.175 0.924-0.528 0.264-0.351 0.396-0.879 0.396-1.584-0.001-0.792-0.311-1.188-0.925-1.188z"></path>
            </svg>
            </div></div>
         </div>  
     </div> 
-->
     <!-- jQuery.document() -->
    <?php
            // }
    function add_content_after_addtocart_button_func() {
        if (!empty( WC()->cart->get_cart())) {
            $product_id = end( WC()->cart->cart_contents)['product_id'];
             
             $price = '';
            foreach( WC()->cart->get_cart() as $cart_item ){
                $productId = $cart_item['product_id'];
                 if($productId == $product_id){
                    $price = $cart_item['wcrp_rental_products_cart_item_price'];
                  }
            }
    //         $val = round( $price,PHP_ROUND_HALF_UP);
               $value = $price!= ''?number_format($price,2,".","."):'';   

               $last = substr($value, -1);
                if ($last > 5) {
                    $valuee =  round($value,PHP_ROUND_HALF_UP);
                    $valuee = number_format($valuee,2,".",".");
                }else if($last < 5 && $last != 0){
                    $valuee = ceiling($value, 0.05);
                }else{
                    $valuee = $value;
                }
                // echo $value . '';
                // echo $valuee;
                
                //add_action( 'woocommerce_after_add_to_cart_button', 'add_content_after_addtocart_button_func' ); 
        
        ?>
    
 <div class="add_to_cart_success_block">
         <div class="add_to_cart_success_msg">
             <div class="top_side">
                 <span class="msg_title">Zum Warenkorb hinzugefügt</span><span class="close-block">X</span>
             </div>
             <p>Du hast <?php  global $woocommerce; echo $woocommerce->cart->cart_contents_count; ?> Artikel im Warenkorb.</p><br>
             <div>
                 <span class="product_price_title_msg">Zwischensumme</span>
   
                 <span class="product_price_msg">CHF <?php echo $valuee; ?></span>
                 <!-- <span class="product_price_msg">CHF <?php //echo $value; ?></span> -->

             </div>
             <div>
                 <span class="lieferung">Lieferung</span>
                 <span class="product_price_msg">Kostenlos</span>
             </div>
             <hr>
             <div>
                 <span class="leferung_price_text">Gesamt inkl. Lieferung</span>
                 <span class="leferung_price_price">CHF <?php  echo $valuee;  ?> </span>
             </div>
             <div class="cart-btn myBtn" style="border-radius: 5px; border: 1px solid; margin-bottom: 5px; padding: 5px; font-family: d-din-bold;">Zum Warenkorb</div>
             <!-- <a href="/cart" class="msg_cart_btn" style="border: none;"><div class="cart-btn" style="border-radius: 5px; border: 1px solid; margin-bottom: 5px; padding: 5px; font-family: d-din-bold;">Zum Warenkorb</div></a> -->
             <a href="/checkout"><div class="checkout-btn myBtn" style="border-radius: 5px; border: 1px solid; margin-bottom: 5px; padding: 5px; font-family: d-din-bold;">Zur Kasse</div></a>


            

             <div class="payment-icons inline-block"><div class="payment-icon"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 32">
            <path d="M10.781 7.688c-0.251-1.283-1.219-1.688-2.344-1.688h-8.376l-0.061 0.405c5.749 1.469 10.469 4.595 12.595 10.501l-1.813-9.219zM13.125 19.688l-0.531-2.781c-1.096-2.907-3.752-5.594-6.752-6.813l4.219 15.939h5.469l8.157-20.032h-5.501l-5.062 13.688zM27.72 26.061l3.248-20.061h-5.187l-3.251 20.061h5.189zM41.875 5.656c-5.125 0-8.717 2.72-8.749 6.624-0.032 2.877 2.563 4.469 4.531 5.439 2.032 0.968 2.688 1.624 2.688 2.499 0 1.344-1.624 1.939-3.093 1.939-2.093 0-3.219-0.251-4.875-1.032l-0.688-0.344-0.719 4.499c1.219 0.563 3.437 1.064 5.781 1.064 5.437 0.032 8.97-2.688 9.032-6.843 0-2.282-1.405-4-4.376-5.439-1.811-0.904-2.904-1.563-2.904-2.499 0-0.843 0.936-1.72 2.968-1.72 1.688-0.029 2.936 0.314 3.875 0.752l0.469 0.248 0.717-4.344c-1.032-0.406-2.656-0.844-4.656-0.844zM55.813 6c-1.251 0-2.189 0.376-2.72 1.688l-7.688 18.374h5.437c0.877-2.467 1.096-3 1.096-3 0.592 0 5.875 0 6.624 0 0 0 0.157 0.688 0.624 3h4.813l-4.187-20.061h-4zM53.405 18.938c0 0 0.437-1.157 2.064-5.594-0.032 0.032 0.437-1.157 0.688-1.907l0.374 1.72c0.968 4.781 1.189 5.781 1.189 5.781-0.813 0-3.283 0-4.315 0z"></path>
            </svg>
            </div><div class="payment-icon"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 32">
            <path d="M7.114 14.656c-1.375-0.5-2.125-0.906-2.125-1.531 0-0.531 0.437-0.812 1.188-0.812 1.437 0 2.875 0.531 3.875 1.031l0.563-3.5c-0.781-0.375-2.406-1-4.656-1-1.594 0-2.906 0.406-3.844 1.188-1 0.812-1.5 2-1.5 3.406 0 2.563 1.563 3.688 4.125 4.594 1.625 0.594 2.188 1 2.188 1.656 0 0.625-0.531 0.969-1.5 0.969-1.188 0-3.156-0.594-4.437-1.343l-0.563 3.531c1.094 0.625 3.125 1.281 5.25 1.281 1.688 0 3.063-0.406 4.031-1.157 1.063-0.843 1.594-2.062 1.594-3.656-0.001-2.625-1.595-3.719-4.188-4.657zM21.114 9.125h-3v-4.219l-4.031 0.656-0.563 3.563-1.437 0.25-0.531 3.219h1.937v6.844c0 1.781 0.469 3 1.375 3.75 0.781 0.625 1.907 0.938 3.469 0.938 1.219 0 1.937-0.219 2.468-0.344v-3.688c-0.282 0.063-0.938 0.22-1.375 0.22-0.906 0-1.313-0.5-1.313-1.563v-6.156h2.406l0.595-3.469zM30.396 9.031c-0.313-0.062-0.594-0.093-0.876-0.093-1.312 0-2.374 0.687-2.781 1.937l-0.313-1.75h-4.093v14.719h4.687v-9.563c0.594-0.719 1.437-0.968 2.563-0.968 0.25 0 0.5 0 0.812 0.062v-4.344zM33.895 2.719c-1.375 0-2.468 1.094-2.468 2.469s1.094 2.5 2.468 2.5 2.469-1.124 2.469-2.5-1.094-2.469-2.469-2.469zM36.239 23.844v-14.719h-4.687v14.719h4.687zM49.583 10.468c-0.843-1.094-2-1.625-3.469-1.625-1.343 0-2.531 0.563-3.656 1.75l-0.25-1.469h-4.125v20.155l4.688-0.781v-4.719c0.719 0.219 1.469 0.344 2.125 0.344 1.157 0 2.876-0.313 4.188-1.75 1.281-1.375 1.907-3.5 1.907-6.313 0-2.499-0.469-4.405-1.407-5.593zM45.677 19.532c-0.375 0.687-0.969 1.094-1.625 1.094-0.468 0-0.906-0.093-1.281-0.281v-7c0.812-0.844 1.531-0.938 1.781-0.938 1.188 0 1.781 1.313 1.781 3.812 0.001 1.437-0.219 2.531-0.656 3.313zM62.927 10.843c-1.032-1.312-2.563-2-4.501-2-4 0-6.468 2.938-6.468 7.688 0 2.625 0.656 4.625 1.968 5.875 1.157 1.157 2.844 1.719 5.032 1.719 2 0 3.844-0.469 5-1.251l-0.501-3.219c-1.157 0.625-2.5 0.969-4 0.969-0.906 0-1.532-0.188-1.969-0.594-0.5-0.406-0.781-1.094-0.875-2.062h7.75c0.031-0.219 0.062-1.281 0.062-1.625 0.001-2.344-0.5-4.188-1.499-5.5zM56.583 15.094c0.125-2.093 0.687-3.062 1.75-3.062s1.625 1 1.687 3.062h-3.437z"></path>
            </svg>
            </div><div class="payment-icon"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 32">
            <path d="M42.667-0c-4.099 0-7.836 1.543-10.667 4.077-2.831-2.534-6.568-4.077-10.667-4.077-8.836 0-16 7.163-16 16s7.164 16 16 16c4.099 0 7.835-1.543 10.667-4.077 2.831 2.534 6.568 4.077 10.667 4.077 8.837 0 16-7.163 16-16s-7.163-16-16-16zM11.934 19.828l0.924-5.809-2.112 5.809h-1.188v-5.809l-1.056 5.809h-1.584l1.32-7.657h2.376v4.753l1.716-4.753h2.508l-1.32 7.657h-1.585zM19.327 18.244c-0.088 0.528-0.178 0.924-0.264 1.188v0.396h-1.32v-0.66c-0.353 0.528-0.924 0.792-1.716 0.792-0.442 0-0.792-0.132-1.056-0.396-0.264-0.351-0.396-0.792-0.396-1.32 0-0.792 0.218-1.364 0.66-1.716 0.614-0.44 1.364-0.66 2.244-0.66h0.66v-0.396c0-0.351-0.353-0.528-1.056-0.528-0.442 0-1.012 0.088-1.716 0.264 0.086-0.351 0.175-0.792 0.264-1.32 0.703-0.264 1.32-0.396 1.848-0.396 1.496 0 2.244 0.616 2.244 1.848 0 0.353-0.046 0.749-0.132 1.188-0.089 0.616-0.179 1.188-0.264 1.716zM24.079 15.076c-0.264-0.086-0.66-0.132-1.188-0.132s-0.792 0.177-0.792 0.528c0 0.177 0.044 0.31 0.132 0.396l0.528 0.264c0.792 0.442 1.188 1.012 1.188 1.716 0 1.409-0.838 2.112-2.508 2.112-0.792 0-1.366-0.044-1.716-0.132 0.086-0.351 0.175-0.836 0.264-1.452 0.703 0.177 1.188 0.264 1.452 0.264 0.614 0 0.924-0.175 0.924-0.528 0-0.175-0.046-0.308-0.132-0.396-0.178-0.175-0.396-0.308-0.66-0.396-0.792-0.351-1.188-0.924-1.188-1.716 0-1.407 0.792-2.112 2.376-2.112 0.792 0 1.32 0.045 1.584 0.132l-0.265 1.451zM27.512 15.208h-0.924c0 0.442-0.046 0.838-0.132 1.188 0 0.088-0.022 0.264-0.066 0.528-0.046 0.264-0.112 0.442-0.198 0.528v0.528c0 0.353 0.175 0.528 0.528 0.528 0.175 0 0.35-0.044 0.528-0.132l-0.264 1.452c-0.264 0.088-0.66 0.132-1.188 0.132-0.881 0-1.32-0.44-1.32-1.32 0-0.528 0.086-1.099 0.264-1.716l0.66-4.225h1.584l-0.132 0.924h0.792l-0.132 1.585zM32.66 17.32h-3.3c0 0.442 0.086 0.749 0.264 0.924 0.264 0.264 0.66 0.396 1.188 0.396s1.1-0.175 1.716-0.528l-0.264 1.584c-0.442 0.177-1.012 0.264-1.716 0.264-1.848 0-2.772-0.924-2.772-2.773 0-1.142 0.264-2.024 0.792-2.64 0.528-0.703 1.188-1.056 1.98-1.056 0.703 0 1.274 0.22 1.716 0.66 0.35 0.353 0.528 0.881 0.528 1.584 0.001 0.617-0.046 1.145-0.132 1.585zM35.3 16.132c-0.264 0.97-0.484 2.201-0.66 3.697h-1.716l0.132-0.396c0.35-2.463 0.614-4.4 0.792-5.809h1.584l-0.132 0.924c0.264-0.44 0.528-0.703 0.792-0.792 0.264-0.264 0.528-0.308 0.792-0.132-0.088 0.088-0.31 0.706-0.66 1.848-0.353-0.086-0.661 0.132-0.925 0.66zM41.241 19.697c-0.353 0.177-0.838 0.264-1.452 0.264-0.881 0-1.584-0.308-2.112-0.924-0.528-0.528-0.792-1.32-0.792-2.376 0-1.32 0.35-2.42 1.056-3.3 0.614-0.879 1.496-1.32 2.64-1.32 0.44 0 1.056 0.132 1.848 0.396l-0.264 1.584c-0.528-0.264-1.012-0.396-1.452-0.396-0.707 0-1.235 0.264-1.584 0.792-0.353 0.442-0.528 1.144-0.528 2.112 0 0.616 0.132 1.056 0.396 1.32 0.264 0.353 0.614 0.528 1.056 0.528 0.44 0 0.924-0.132 1.452-0.396l-0.264 1.717zM47.115 15.868c-0.046 0.264-0.066 0.484-0.066 0.66-0.088 0.442-0.178 1.035-0.264 1.782-0.088 0.749-0.178 1.254-0.264 1.518h-1.32v-0.66c-0.353 0.528-0.924 0.792-1.716 0.792-0.442 0-0.792-0.132-1.056-0.396-0.264-0.351-0.396-0.792-0.396-1.32 0-0.792 0.218-1.364 0.66-1.716 0.614-0.44 1.32-0.66 2.112-0.66h0.66c0.086-0.086 0.132-0.218 0.132-0.396 0-0.351-0.353-0.528-1.056-0.528-0.442 0-1.012 0.088-1.716 0.264 0-0.351 0.086-0.792 0.264-1.32 0.703-0.264 1.32-0.396 1.848-0.396 1.496 0 2.245 0.616 2.245 1.848 0.001 0.089-0.021 0.264-0.065 0.529zM49.69 16.132c-0.178 0.528-0.396 1.762-0.66 3.697h-1.716l0.132-0.396c0.35-1.935 0.614-3.872 0.792-5.809h1.584c0 0.353-0.046 0.66-0.132 0.924 0.264-0.44 0.528-0.703 0.792-0.792 0.35-0.175 0.614-0.218 0.792-0.132-0.353 0.442-0.574 1.056-0.66 1.848-0.353-0.086-0.66 0.132-0.925 0.66zM54.178 19.828l0.132-0.528c-0.353 0.442-0.838 0.66-1.452 0.66-0.707 0-1.188-0.218-1.452-0.66-0.442-0.614-0.66-1.232-0.66-1.848 0-1.142 0.308-2.067 0.924-2.773 0.44-0.703 1.056-1.056 1.848-1.056 0.528 0 1.056 0.264 1.584 0.792l0.264-2.244h1.716l-1.32 7.657h-1.585zM16.159 17.98c0 0.442 0.175 0.66 0.528 0.66 0.35 0 0.614-0.132 0.792-0.396 0.264-0.264 0.396-0.66 0.396-1.188h-0.397c-0.881 0-1.32 0.31-1.32 0.924zM31.076 15.076c-0.088 0-0.178-0.043-0.264-0.132h-0.264c-0.528 0-0.881 0.353-1.056 1.056h1.848v-0.396l-0.132-0.264c-0.001-0.086-0.047-0.175-0.133-0.264zM43.617 17.98c0 0.442 0.175 0.66 0.528 0.66 0.35 0 0.614-0.132 0.792-0.396 0.264-0.264 0.396-0.66 0.396-1.188h-0.396c-0.881 0-1.32 0.31-1.32 0.924zM53.782 15.076c-0.353 0-0.66 0.22-0.924 0.66-0.178 0.264-0.264 0.749-0.264 1.452 0 0.792 0.264 1.188 0.792 1.188 0.35 0 0.66-0.175 0.924-0.528 0.264-0.351 0.396-0.879 0.396-1.584-0.001-0.792-0.311-1.188-0.925-1.188z"></path>
            </svg>
            </div></div>
         </div>  
     </div> 




<?php
    }else{ ?>
        <div class="add_to_cart_success_block">
             <div class="add_to_cart_success_msg">
                <div class="top_side">
                    <p>Dieser Artikel ist für diesen Zeitraum leider nicht verfügbar.<span class="close-block">X</span></p>
                </div>
             </div>
        </div>
    <?php }    
        
        
        
    }
},10,2);

function filter_woocommerce_cart_totals_coupon_html( $coupon_html, $coupon, $discount_amount_html ) {
    $link = $_SERVER["REQUEST_URI"]."&remove_coupon=".$coupon->code;
    $coupon_html = $discount_amount_html ."<a href='".$link."' class='woocommerce-remove-coupon' data-coupon='".$coupon->code."'>[Entfernen]</a>";
    return $coupon_html;
}
add_filter( 'woocommerce_cart_totals_coupon_html', 'filter_woocommerce_cart_totals_coupon_html', 10, 3 );

add_action('woocommerce_applied_coupon', 'apply_product_on_coupon');
function apply_product_on_coupon( $coupon_code ) {
    $link = $_SERVER["REQUEST_URI"]."?cart=open";
    global $woocommerce;
    $woocommerce->cart->add_discount($coupon_code);
    $woocommerce->cart->calculate_totals();
    wp_redirect($link);exit();
}


?>