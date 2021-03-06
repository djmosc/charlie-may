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
    <?php wp_head(); ?>

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
					<li class="cart">
						<a href="<?php echo get_permalink(get_field('cart_page', 'options')); ?>" class="cart-btn" ><?php echo get_the_title(get_field('cart_page', 'options')); ?></a>
						&nbsp;&nbsp;<a class="items" href="<?php echo get_permalink(get_field('cart_page', 'options')); ?>"><?php echo sprintf(_n('%d', '%d', WC()->cart->cart_contents_count, 'woothemes'), WC()->cart->cart_contents_count);?></a>
						<?php if (isset($_GET['added-to-cart'])) :?>
						<div class="added-to-cart">
							<button class="close-btn">&times;</button>
							<header class="header">
								<h5 class="uppercase text-center novecento no-margin"><?php _e("Recently Added", THEME_NAME); ?></h5>
							</header>
							<div class="products">
							<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
								$_product = $cart_item['data'];
									if ( $_product->exists() && $cart_item['quantity'] > 0  && $cart_item['product_id'] == $_GET['added-to-cart']) : ?>
								<div class="product clearfix">
									<div class="span three thumbnail alpha">
									<?php
									$thumbnail = $_product->get_image('shop_thumbnail', array('class' => 'scale'));

									if ( ! $_product->is_visible() || ( ! empty( $_product->variation_id ) && ! $_product->parent_is_visible() ) )
										echo $thumbnail;
									else
										printf('<a href="%s" class="overlay-btn">%s</a>', esc_url( get_permalink( $cart_item['product_id'] ) ), $thumbnail );
								?>
									</div>
									<div class="span seven">
										<h5 class="product-title"><?php
											if ( ! $_product->is_visible() || ( ! empty( $_product->variation_id ) && ! $_product->parent_is_visible() ) )
												echo $_product->get_title();
											else
												printf('<a href="%s">%s</a>', esc_url( get_permalink(  $cart_item['product_id'] ) ), $_product->get_title() );
										?></h5>
										<?php echo WC()->cart->get_item_data( $cart_item ); ?>

										<p class="price"><?php 
										$product_price = get_option('woocommerce_tax_display_cart') == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();
										echo woocommerce_price( $product_price );
										?></p>

									</div>
								</div>		
								<?php endif; ?>
							<?php endforeach; ?>
							</div>
							<footer class="footer">
								<a href="<?php echo get_permalink(get_field('cart_page', 'options')); ?>" class="white-btn"><?php _e("View Bag", THEME_NAME); ?></a>
								<a href="<?php echo get_permalink(get_field('cart_page', 'options')); ?>" class="black-btn"><?php _e("Checkout", THEME_NAME); ?></a>
							</footer>
						</div>
						<?php endif; ?>
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
						<strong class="items"><?php echo sprintf(_n('%d', '%d', WC()->cart->cart_contents_count, 'woothemes'), WC()->cart->cart_contents_count);?></strong>
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
		<?php
		$args = array(
				'delimiter'		=> ' / ',
				'wrap_before'	=> '<nav id="breadcrumbs"><div class="inner container">',
				'wrap_after'	=> '</div></nav>',
				'home'			=> _x( "Charlie May", 'breadcrumb', 'woocommerce' )
		);
		?>
		<?php woocommerce_breadcrumb( $args ); ?>
	<?php //if ( function_exists('yoast_breadcrumb') ) yoast_breadcrumb('<div id="breadcrumbs"><div class="inner container">','</div></div>'); ?>
	<?php endif; ?>
	<div id="main" class="site-main" role="main">
		<div id="ajax-page"></div>