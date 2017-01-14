<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Twelve already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
$args = array(
	'posts_per_page'=>-1,
);
query_posts( $args );


get_header(); ?>


<?php get_sidebar(); ?>
	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="entry-header">
				<h1 class="entry-title">Our  Policies and Statements</h1>
			</header><!-- .archive-header -->
			<div class="entry-content">
			<?php (function_exists('dynamic_sidebar') && dynamic_sidebar('policies')) ?>
			</div>
            <div id="policies">
			<?php
			/* Start the Loop */
			$count=0;
			while ( have_posts() ) : the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part( 'content', 'policies' );
				$count+=1;
				if ($count%3==0)
					echo '<div style="clear:both"></div>';
			endwhile;
			?>
            </div>
            <?php
			twentytwelve_content_nav( 'nav-below' );
			?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_footer(); ?>