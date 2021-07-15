<!DOCTYPE html>
<!--[if IE 9 ]> <html <?php language_attributes(); ?> class="ie9 <?php flatsome_html_classes(); ?>"> <![endif]-->
<!--[if IE 8 ]> <html <?php language_attributes(); ?> class="ie8 <?php flatsome_html_classes(); ?>"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> class="<?php flatsome_html_classes(); ?>"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'flatsome_after_body_open' ); ?>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'flatsome' ); ?></a>

<div id="wrapper">

	<?php do_action( 'flatsome_before_header' ); ?>

	<header id="header" class="header <?php flatsome_header_classes(); ?>">
		<div class="header-wrapper">
			<?php get_template_part( 'template-parts/header/header', 'wrapper' ); ?>
		</div>

	  
		<?php
   global $woocommerce;
   $count = $woocommerce->cart->cart_contents_count;

   if($count == '0'){
?>
	<div class="full_cart_menu">
		<div class="full_cart_menu_checkout">
		<div class="focused-checkout-header pb">
			<?php wc_get_template( 'checkout/header.php' ); ?>
		</div>

			<div class="car_empty">
				<!-- <div class="shopping_cart_item_count">
					<h3>Shopping bag(<?php echo $count ?>)</h3>
				</div>
				<div class="empty-bag">
					<h3>Looks like your bag is empty!</h3>
					<a href="https://outdoorservice.ch/produkt-kategorie/junior/"><button class="btn-v1">Junior</button></a>
					<a href="https://outdoorservice.ch/produkt-kategorie/damen/"><button class="btn-v2">Damen</button></a>
				</div> -->
				<h3>Dein Warenkorb ist gegenwartig leer</h3>
				<a href="https://outdoorservice.ch/shop/"><button class="btn-v1">Zuruck zum Shop</button></a>
            </div>
		</div>
	</div>
<?php  }else{
	?>
	<div class="full_cart_menu full_cart_menu_scroll">
		<div class="full_cart_menu_checkout">

		<div class="focused-checkout-header pb">
			<?php wc_get_template( 'checkout/header.php' ); ?>
		</div>
         <div class="aaaaaaa">
			<?php  
			echo do_shortcode( '[woocommerce_cart]' );?>
		 </div>
		</div>
	</div>
	<?php
   }





   
?>
















	</header>

	<?php do_action( 'flatsome_after_header' ); ?>

	<main id="main" class="<?php flatsome_main_classes(); ?>">
    
