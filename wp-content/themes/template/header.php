<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php bloginfo('name'); ?> - <?php the_title('')?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link href='http://fonts.googleapis.com/css?family=Roboto:500,400,900' rel='stylesheet' type='text/css'>
<!-- font-family: 'Roboto', sans-serif; -->
<link href='http://fonts.googleapis.com/css?family=Damion' rel='stylesheet' type='text/css'>
<!-- font-family: 'Damion', cursive; -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php wp_deregister_script('jquery'); ?>
<link id="page_favicon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" rel="icon" type="image/x-icon"/>
<script src="<?php echo get_template_directory_uri(); ?>/js/script.js" type="text/javascript"></script>
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head();
$p=$_SERVER['REQUEST_URI'];
$p=array_filter(explode('/',$p));
switch ($pp=array_shift($p)) {
	case 'our-cottages':
	case 'contact-us':
		imgs('canoe',false,-80);	
		imgs('deck',-500,-132);
		break;
	case 'services':
		imgs('man',200,1);	
		imgs('waterski',-800,-83);
		break;		
	case 'thingstodo':
	case 'things-to-do':
		imgs('speedboat',-600,-80);	
		imgs('boyfish',200,-158);
		break;
	case 'policies':
		imgs('surprise',-400,30);
		imgs('boyfish',-450,-158);
		imgs('transboat',300,300);	
		imgs('deck2',300,-132);
		break;
	case 'owners-info':
	case 'about-us':
		imgs('canoel',true,-80);
		imgs('surprise',-550,30);
		imgs('fire',500,70);
		break;

	/* Original OUR COTTAGES footer:
	case 'our-cottages':
		imgs('blackwave',700,-215);
		imgs('smboat',-800,-40);
		imgs('waterskihome',450,-215);	
		break;
	*/
	
		
	case '':
		imgs('surprise',-550,30);
		imgs('blackwave',700,-215);
		imgs('smboat',-800,-40);
		imgs('waterskihome',450,-215);
		imgs('ourproperties',-480,-153,'/our-cottages/');
		imgs('lookingtorent',-155,-153,'/owners-info/');
		imgs('our-services',170,-153,'/services');

}
?>

<?php
echo "<script>var jquery_placeholder_url = '".get_bloginfo('wpurl')."/wp-content/plugins/gravity-forms-placeholders/jquery.placeholder-1.0.1.js';</script>";
echo '<script src= "'.get_bloginfo('wpurl').'/wp-content/plugins/gravity-forms-placeholders/gf.placeholders.js"></script>';
?>
</head>

<body <?php body_class(); ?>>
<!-- Qualaroo for cottagerentalgetaways.ca -->
<script type="text/javascript">
  var _kiq = _kiq || [];
  (function(){
    setTimeout(function(){
    var d = document, f = d.getElementsByTagName('script')[0], s = d.createElement('script'); s.type = 'text/javascript';
    s.async = true; s.src = '//s3.amazonaws.com/ki.js/51597/aZw.js'; f.parentNode.insertBefore(s, f);
    }, 1);
  })();
</script>
<div id="page" class="hfeed site">
	<header id="header" class="site-header" role="banner">
		<hgroup><div class="main">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo get_template_directory_uri(); ?>/images/cottage-rentals-logo.png"/></a>
			<?php dynamic_sidebar('social'); ?>
		</div></hgroup>
		<nav id="site-navigation" class="main-navigation" role="navigation"><div class="main">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		</div></nav><!-- #site-navigation -->
	</header><!-- #masthead -->
	<div id="main" class="wrapper"><div><div><div class="main">