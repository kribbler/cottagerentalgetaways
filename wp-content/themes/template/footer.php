<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
$p=$_SERVER['REQUEST_URI'];
$p=array_filter(explode('/',$p));
$pp=array_shift($p);
	?>
	</div></div></div></div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
    <div id="footerrel">
        	<?php
			foreach (imgs() as $a) {
				$top=$a['top'];
				$left=$a['left'];
				$pre=$class='';
				if ($left===false || $left===true) {
					$class=' class="animate'.(($left===true) ? ' righttoleft' : '').'"';
					$left=-9999;
					$pre='data-';
				}
				if ($a['link'])
					echo '<a href="',htmlq($a['link']),'">';
				echo '<img ',$pre,'src="',get_template_directory_uri(),'/images/',$a['img'],'.png" style="left:',$left,'px;bottom:',$top,'px;"',$class,'/>';
				if ($a['link'])
					echo '</a>';
			}
			?>
			<img src="<?php echo get_template_directory_uri(); ?>/images/blackwave.png" style="left:-700px;top:<?php echo (!$pp /*|| $pp=='our-cottages'*/) ? '189' : '104'; ?>px;"/>
    	</div> 
    <div id="footercont">  
        
        <div class="cont">
		<div class="main">
        	<div class="footlink">
            <a href="http://www.severncottageservices.ca/" target="_blank">
            Click Here For:<br/>
            <img src="<?php echo get_template_directory_uri(); ?>/images/severncottageservices.png"/>
            </a>
            </div>
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'footmenu' ) ); ?>
            <div id="copyright">
Copyright © Cottage Rental Getaways <?php echo date('Y'); ?>. All Rights Reserved.  <br/>         
<a href="http://divinedesigns.ca" target="_blank">Website Design: DivineDesign.ca - Divinely Inspired Web Design</a><br/>
            </div>
		</div><!-- .site-info -->
        </div>
	</div>
    
    </footer><!-- #colophon -->
    <div class="main" id="overlay">
    	<!-- put overlay images here -->
    </div>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>