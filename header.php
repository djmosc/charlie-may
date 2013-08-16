<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package charlie_may
 * @since charlie_may 1.0
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html xmlns:fb="http://ogp.me/ns/fb#" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html xmlns:fb="http://ogp.me/ns/fb#" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html xmlns:fb="http://ogp.me/ns/fb#" class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html xmlns:fb="http://ogp.me/ns/fb#" class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html xmlns:fb="http://ogp.me/ns/fb#" class="no-js"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link href="<?php echo get_template_directory_uri(); ?>/images/misc/favicon.png" rel="shortcut icon" type="image/x-icon">

    <script type="text/javascript">
		var themeUrl = '<?php bloginfo( 'template_url' ); ?>';
		var baseUrl = '<?php bloginfo( 'url' ); ?>';
	</script>
    <?php

	if ( ! is_admin() ) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', get_template_directory_uri().'/js/libs/jquery.min.js', false, '1.9.1');
        wp_enqueue_script('jquery');
    }
	
	function load_assets() {

		wp_enqueue_style('style', get_template_directory_uri().'/css/style.css');
		wp_register_style('fancybox', get_template_directory_uri().'/css/jquery.fancybox.css');

		wp_enqueue_script('modernizr', get_template_directory_uri().'/js/libs/modernizr.min.js');
		wp_enqueue_script('jquery', get_template_directory_uri().'/js/libs/jquery.min.js');
		wp_enqueue_script('easing', get_template_directory_uri().'/js/plugins/jquery.easing.js', array('jquery'), '', true);
		wp_enqueue_script('scroller', get_template_directory_uri().'/js/plugins/jquery.scroller.js', array('jquery'), '', true);
		wp_enqueue_script('actual', get_template_directory_uri().'/js/plugins/jquery.actual.js', array('jquery'), '', true);
		wp_enqueue_script('imagesloaded', get_template_directory_uri().'/js/plugins/jquery.imagesloaded.js', array('jquery'), '', true);
		wp_enqueue_script('transit', get_template_directory_uri().'/js/plugins/jquery.transit.js', array('jquery'), '', true);
		wp_register_script('fancybox', get_template_directory_uri().'/js/plugins/jquery.fancybox.min.js', array('jquery'), '', true);
		wp_enqueue_script('main', get_template_directory_uri().'/js/main.js', array('jquery'), '', true);

	}

	add_action('wp_enqueue_scripts', 'load_assets');
	wp_head();
?>

</head>
<body <?php body_class(); ?>>
<div id="wrap" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="header" role="banner">
		<div class="top">
			<div class="inner container">
				<ul class="ecommerce-options clearfix">
					<li class="account">
						<a href="<?php echo get_permalink(get_field('account_page', 'options')); ?>" class="account-btn" ><?php echo get_the_title(get_field('account_page', 'options')); ?>
						</a>
					</li>
					<?php if ( is_user_logged_in() ): ?>
					<li class="logout">
						<a href="<?php echo wp_logout_url('/'); ?>" class="logout-btn" >
							<?php _e("Logout") ?>
						</a>
					</li>
					<?php endif; ?>
					<?php global $woocommerce; ?>
					<li class="cart">
						<a href="<?php echo get_permalink(get_field('cart_page', 'options')); ?>" class="cart-btn" ><?php echo get_the_title(get_field('cart_page', 'options')); ?></a>
						&nbsp;&nbsp;<strong class="items"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?></strong>
					</li>
				</ul>
			</div>	
		</div>
		<div class="bottom">
			<div class="inner container">
				<h1 class="logo-container">
					<a class="logo" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</h1>
				<?php get_search_form(); ?>
				<div class="navigation-container">
					<a href="<?php echo get_permalink(get_field('cart_page', 'options')); ?>" class="cart-btn" >
						<?php echo get_the_title(get_field('cart_page', 'options')); ?>:
						<strong class="items"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?></strong>
					</a>
					<button class="mobile-navigation-btn uppercase">menu <i aria-hidden="true" class="icon-arrow-down tiny"></i></button>
					<nav role="navigation" class="site-navigation main-navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'primary_header', 'menu_class' => 'clearfix menu', 'container' => false ) ); ?>
					</nav><!-- .site-navigation .main-navigation -->
				</div>
			</div>
		</div>
	</header><!-- #header -->
	<?php if(!is_front_page()): ?>
	<?php if ( function_exists('yoast_breadcrumb') ) yoast_breadcrumb('<div id="breadcrumbs"><div class="inner container">','</div></div>'); ?>
	<?php endif; ?>
	<div id="main" class="site-main" role="main">
		<div id="ajax-page"></div>