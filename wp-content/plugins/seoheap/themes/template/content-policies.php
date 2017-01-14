<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
 
global $post;
$link='';
$pdfs = get_post_meta(get_the_ID(), 'wp_custom_pdf_attachment', true);
$link=array_pop($pdfs);
if (!$link)
	return; 
?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    	<a href="<?php echo $link; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/pdf.png" alt="Download"/></a>
		<header class="entry-header">
			<h3 class="entry-title">
				<a href="<<?php echo $link; ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h3>
		</header><!-- .entry-header -->
		<div class="entry-summary">
			<?php the_post(); ?>
		</div><!-- .entry-summary -->
	</article><!-- #post -->
