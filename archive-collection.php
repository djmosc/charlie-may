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

<div id="archive-collection">
	<div class="collection slider">
		<ul class="collection-list slide-items">
		<?php $i = 0; ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<li>
				<?php the_post_thumbnail(); ?>
			</li>
		<?php $i++; ?>
		<?php endwhile; ?>
		</ul>
		<nav class="slider-navigation">
			<button class="prev-btn"></button>
			<button class="next-btn"></button>
		</nav>

	</div>
</div>

<?php get_footer(); ?>
