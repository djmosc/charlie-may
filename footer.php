<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package charlie_may
 * @since charlie_may 1.0
 */
?>
	</div><!-- #main .site-main -->
	<div id="social">
		<div class="inner container">
			<div class="span five alpha">

				<ul class="social-links">
					<li>
						<h5 class="uppercase"><?php _e("Join Us", THEME_NAME); ?></h5>
					</li>
					<li>
						<a class="facebook-btn" href="<?php echo get_field('facebook_url', 'options');?>" target="_blank"></a>
					</li>
					<li>
						<a class="twitter-btn" href="<?php echo get_field('twitter_url', 'options');?>" target="_blank"></a>
					</li>
					<li>
						<a class="instagram-btn" href="<?php echo get_field('instagram_url', 'options');?>" target="_blank"></a>
					</li>
					<li>
						<a class="tumblr-btn" href="<?php echo get_field('tumblr_url', 'options');?>" target="_blank"></a>
					</li>
					<li>
						<a class="pinterest-btn" href="<?php echo get_field('pinterest_url', 'options');?>" target="_blank"></a>
					</li>
				</ul>
			</div>
			<div class="span three right omega">
				<?php gravity_form(1, false, false); ?>
			</div>

		</div>
	</div>
	<footer id="footer" class="site-footer" role="contentinfo">
		<div class="top">
			<div class="container inner">
				<?php dynamic_sidebar('footer'); ?>
			</div>
		</div>
		<div class="bottom">
			<div class="container inner">
				<div class="span five alpha">
					<p>&copy; <?php echo date('Y'); ?><?php _e("The Great British Teddy Bear Company&reg; all rights reserved.", THEME_NAME); ?></p>
				</div>
				<div class="span five omega">
					<nav role="navigation" class="footer-navigation right">
						<?php wp_nav_menu( array( 'theme_location' => 'primary_footer', 'menu_class' => 'clearfix menu', 'container' => false ) ); ?>
					</nav><!-- .site-navigation .main-navigation -->
				</div>
			</div>
		</div>
	</footer><!-- #footer .site-footer -->
</div><!-- #wrap -->

<?php wp_footer(); ?>

<script>
  // (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  // (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  // m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  // })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  // ga('create', 'UA-9989995-2', 'charlie-may.co.uk');
  // ga('send', 'pageview');

</script>
<script src="//s7.addthis.com/js/300/addthis_widget.js"></script>

</body>
</html>