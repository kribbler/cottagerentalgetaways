<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content site-page">
		<div id="content" role="main">
			<?php dynamic_sidebar('sidebar-2'); ?> 
            <div class="homebox">
            <h2>Have a Location in Mind?</h2>
            <p>Select a property from the map below.</p>
            <div id="homemap">
            <?php echo fsrep_listings_display('', '', '', '', '', '',true, 0); ?>
            </div>
            </div>
            
            <div class="homebox">
            <h2>Have a Date in Mind?</h2>
            <p>Click on a date to find<br/>available properties</p>
            <?php
            wp_enqueue_script('propertyscript','/wp-content/plugins/cottagerentalgetaways/homescript.js');
			echo do_shortcode('[sbc id="2" legend="no" title="no" view="1" dropdown="no" weekstart="0"]');
			?>
            </div>            
			<?php while ( have_posts() ) : the_post(); ?>
           <?php
		    if (has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
  				the_post_thumbnail('full',array('class'=>'h1'));
			}
			?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->
    <?php
	 $GMapType='ROADMAP';
	 $GMapLat=58;
	 $GMapLong=0;
	 $GMapZoom=3;
	 $MarkerListingURL='sort=all';
	?>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false"></script>
    <script type="text/javascript">
      function FSREPMap() {
				function listinginfo(infowindow, marker) { 
					return function() {
						infowindow.open(map, marker);
					};
				}
       var myOptions = {
          center: new google.maps.LatLng(<?php echo $GMapLat; ?>, <?php echo $GMapLong; ?>),
          zoom: <?php echo $GMapZoom; ?>,
          mapTypeId: google.maps.MapTypeId.<?php echo $GMapType; ?>
        };
        var map = new google.maps.Map(document.getElementById("listings_map"),
            myOptions);
						

				if (window.XMLHttpRequest) {
					// FireFox, Opera, Safari, Chrome, IE7
					xmlhttp = new XMLHttpRequest();
				} else {
					// IE6
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.open("GET","<?php echo get_option('home'); ?>/wp-content/plugins/fs-real-estate-plugin/xml/marker_listings.php?<?php echo $MarkerListingURL; ?>",false);
				xmlhttp.send();
				xmlDoc = xmlhttp.responseXML; 
				listing = xmlDoc.getElementsByTagName("LISTING");
				var bounds = new google.maps.LatLngBounds ();

				for (var i=0;i<listing.length;i++) { 
					var lat 	= listing[i].getElementsByTagName("LAT")[0].childNodes[0].nodeValue;
					var lng 	= listing[i].getElementsByTagName("LONG")[0].childNodes[0].nodeValue;
					var latlngset;
					latlngset = new google.maps.LatLng(lat, lng);
					bounds.extend (latlngset);
					var marker = new google.maps.Marker({  
						position: new google.maps.LatLng(listing[i].getElementsByTagName("LAT")[0].childNodes[0].nodeValue, listing[i].getElementsByTagName("LONG")[0].childNodes[0].nodeValue),
						map: map,
						title: listing[i].getElementsByTagName("LABEL")[0].childNodes[0].nodeValue
					});
					if (listing[i].getElementsByTagName("IMAGE")[0].childNodes[0].nodeValue != 'None') {
						var content = '<div style="text-align: center;"><a href="' + listing[i].getElementsByTagName("URL")[0].childNodes[0].nodeValue + '"><img src="' + listing[i].getElementsByTagName("IMAGE")[0].childNodes[0].nodeValue + '" border="0" alt="" style="border: 1px solid #999999;"/></a><br/><strong>' + listing[i].getElementsByTagName("NAME")[0].childNodes[0].nodeValue + '</strong><br/>Asking Price: ' + listing[i].getElementsByTagName("PRICE")[0].childNodes[0].nodeValue + '<br/><a href="' + listing[i].getElementsByTagName("URL")[0].childNodes[0].nodeValue + '">view listing</a><br/></div>';
					} else {
						var content = '<div style="text-align: center;"><strong>' + listing[i].getElementsByTagName("NAME")[0].childNodes[0].nodeValue + '</strong><br/>Asking Price: ' + listing[i].getElementsByTagName("PRICE")[0].childNodes[0].nodeValue + '<br/><a href="' + listing[i].getElementsByTagName("URL")[0].childNodes[0].nodeValue + '">view listing</a><br/></div>';
					}
					var infowindow = new google.maps.InfoWindow();
						infowindow.setContent(content);
						google.maps.event.addListener(
							marker, 
							'click', 
							listinginfo(infowindow, marker)
					);		
				}
				map.fitBounds (bounds);
      }
	jQuery(document).ready(function($) {
		FSREPMap();
	});
    </script> 
<?php get_sidebar(); ?>
<?php get_footer(); ?>