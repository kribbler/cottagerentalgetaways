<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<?php if ( is_active_sidebar( 'blog' ) ) : ?>
		<div id="secondary" class="widget-area blogsidebar" role="complementary">
			<?php dynamic_sidebar( 'blog' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>