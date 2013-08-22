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

<div id="archive-press-release">
	<div class="scroller" data-scroll-all="true" data-resize="true">
		<div class="scroller-mask">
			<div class="scroll-items-container">
			<?php $i = 0; ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="scroll-item <?php if($i == 0) echo 'current'; ?>" data-id="<?php the_ID(); ?>">
					<?php the_post_thumbnail('custom_medium', array('class' => 'scale')); ?>
					<h5><?php the_title(); ?></h5>
				</div>
			<?php $i++; ?>
			<?php endwhile; ?>
			</div>
		</div>
		<nav class="scroller-navigation">
			<button class="prev-btn large"></button>
			<button class="next-btn large"></button>
		</nav>

	</div>
</div>

<?php get_footer(); ?>
