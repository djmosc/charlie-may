<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package charlie_may
 * @since charlie_may 1.0
 */

get_header(); ?>
<section id="front-page" class="clearfix">
	<?php if ( get_field('slides')) :?>
		<div id="homepage-scroller" class="scroller" data-auto-scroll="true" >
			<div class="inner">
				<div class="scroller-mask">
					<?php $i = 0; ?>
					<?php while (the_repeater_field('slides')) : ?>
					<?php
						$background_image = get_sub_field('background_image');
					?>
					<div class="scroll-item <?php if($i == 0) echo 'current'; ?>" data-id="<?php echo $i;?>" style="background-image: url(<?php echo $background_image['sizes']['slide'];?>)">
						<div class="container inner">
							<div class="content <?php the_sub_field('alignment'); ?>">
								<?php the_sub_field('content'); ?>
							</div>
						</div>
					</div>
					<?php $i++; ?>
					<?php endwhile; ?>
				</div>
				<div class="scroller-navigation">
					<a class="prev-btn"></a>
					<a class="next-btn"></a>
				</div>
			</div>
		</div><!-- #homepage-scroller -->
	<?php endif; ?>

	<div id="widgets">
		<div class="container">
			<div class="inner">
				<?php dynamic_sidebar('homepage_content'); ?>
			</div>
		</div>
	</div>
	<?php if ( get_field('content')) :?>
	<div id="content">
		<div class="container">
			<?php if ( get_field('content')):?>
			<?php get_template_part('inc/content'); ?>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
</section><!-- #front-page -->

<?php get_footer(); ?>