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

get_header();
$locations=get_terms('locations');
$ob=get_queried_object();
$cterm=0;
$h1='';
if (isset($ob->term_id)) {
	$cterm=$ob->term_id;
	$h1=$ob->name;
} elseif (is_single()) {
	if (have_posts()) {
		global $post;
		while (have_posts()) {
			the_post();
			$terms=wp_get_post_terms($post->ID,'things-to-do');
			foreach ($terms as $a) {
				if ($a->term_id) {
					$cterm=$a->term_id;
					break(2);	
				}
			}
		}
		rewind_posts();
	}
}
?>

	<section id="primary" class="site-content thingstodo">
		<div id="content" role="main">
		<img src="<?php echo get_template_directory_uri(); ?>/images/things-to-do.png" alt="Things to do" class="h1"/>
		<?php if ( have_posts() ) { ?>
			<div class="ttd-cont"><ul class="ttd-list">
			<?php
			foreach (get_terms('things-to-do') as $a) {
				echo '<li',(($a->term_id==$cterm) ? ' class="active"' : ''),'><a href="/things-to-do/',htmlq($a->slug),'">',html($a->name),'</a></li>';
			}
			?>
            <div class="arrow"></div>
			</ul></div>
			<?php
			if (is_single()) {
				while (have_posts()) {
					the_post();
					get_template_part( 'content', get_post_format() );
				}				
			} elseif (is_tax()) {
				$items=array();
				global $post;
				while (have_posts()) {
					the_post();
					$terms=wp_get_post_terms($post->ID,'locations');
					foreach ($terms as $a) {
						if (!isset($items[$a->term_id]))
							$items[$a->term_id]=array();
						$items[$a->term_id][]=$post;
					}
				}
				echo '<div class="ttd-items">';
				echo '<h1>',html($h1),'</h1>';
				$c=0;
				foreach ($locations as $a) {
					if (empty($items[$a->term_id]))
						continue;
					echo '<div',(($c++%2==0) ? ' style="clear:both"' : ''),'>';
					echo '<h2>',html($a->name),'</h2>';
					echo '<ul>';
					foreach ($items[$a->term_id] as $aa) {
						$ll=$link=get_post_meta($aa->ID,'wp_locations_link',true);
						//$ll=($ll) ? $ll.'" target="_blank' : get_permalink($aa->ID);
						$ll=($ll) ? '<a href="'.$ll.'" target="_blank">' : '';
						echo '<li>',$ll,'',html($aa->post_title),(($ll) ? '</a>' : ''),'</li>';
					}
					echo '</ul>';
					echo '</div>';
				}
				echo '</div>';
			} else {
				echo '<img src="/wp-content/themes/template/images/things-to-do-main.png" style="margin-left:-101px;float:right;margin-right:-99px;margin-top:-50px;"/>';	
			}
			echo '<div style="clear:both"></div>';
			?>

		<?php } else { ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php } ?>

		</div><!-- #content -->
	</section><!-- #primary -->
<script type="text/javascript">
jQuery(document).ready(function($) {
	var findpos=function(t,animate) {
		t=$(t);
		if (t.length==0)
			var top=-44;
		else {
			var top=t.position().top+2;
		}
		if (typeof(animate)=='undefined' || animate)
			$('.ttd-list .arrow').stop().animate({top:top},1000);
		else
			$('.ttd-list .arrow').css({top:top});
	};
	var gotoactive=function(animate) {
		var a=$('.ttd-list > li.active');
		findpos(a,animate);
	};
	$('.ttd-list > li').hover(function() {
		findpos(this);
	},function() {
		gotoactive();
	});
	gotoactive(0);
});
</script>
<?php get_sidebar(); ?>
<?php get_footer(); ?>