<?php

/**

 * The default template for displaying content. Used for both single and index/archive/search.

 *

 * @package WordPress

 * @subpackage Twenty_Twelve

 * @since Twenty Twelve 1.0

 */

?>



	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( is_search() ) : // Only display Excerpts for Search ?>

		<div class="entry-summary">

			<?php the_excerpt(); ?>

		</div><!-- .entry-summary -->

		<?php else : ?>

		<div class="entry-content">

			<?php the_content(); ?>

		</div><!-- .entry-content -->

		<?php endif; ?>



	</article><!-- #post -->

