<?php
/**
 * Rodesk admin core functions.
 *
 * Custom Rodesk setup for WordPress. This core plugins cleans up WP, adds custom dashboard functions, handle custom rewrite rules (for relative URL's), and uses a custom wpThumb fork for image handling.
 *
 * @package   rodesk-admin-core
 * @author    Rodesk BV <interactie@rodesk.nl>
 * @link      http://rodesk.nl
 * @copyright 2015 Rodesk BV
 */

/*-----------------------------------------------------------------------------------*/
/*  Customized Excerpt loading
/*  Add true or false to load read more link
/*-----------------------------------------------------------------------------------*/

function rodesk_excerpt($limit, $readmore = true, $input_content = '') {

    if($input_content) {
        $content = explode(' ', $input_content, $limit);
    } else {
        $content = explode(' ', get_the_content(), $limit);
    }
    if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ",$content).'...';
    } else {
        $content = implode(" ",$content);
    }
    $content = preg_replace('/\[.+\]/','', $content);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content, '');
    echo $content;
    if($readmore == true){
        echo ' <a href="' . get_permalink() . '">' . __( 'Continued', 'roots' ) . '</a>';
    }
}



/*-----------------------------------------------------------------------------------*/
/*  Customized Excerpt loading
/*  Add true or false to load read more link
/*-----------------------------------------------------------------------------------*/

function rodesk_get_user_role_by_id( $user_id ) {

    $roles = FALSE;

    if ( !empty( $user_id ) && is_integer( $user_id ) ) {
        $roles = get_userdata( $user_id )->roles;
    }

    if ( $roles ) {
        return $roles[0];
    }

    return;

}


/*-----------------------------------------------------------------------------------*/
/*  Load Google Analytics (if ID is filled in theme options)
/*-----------------------------------------------------------------------------------*/

function rodesk_analytics() {
  $rodesk_analytics_id = rodesk_get_option('site_analytics');
  if ($rodesk_analytics_id !== '') {

    echo "<script>\n";
        echo "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){\n";
        echo "(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),\n";
        echo "m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\n";
        echo "})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');\n";
        echo "ga('create', '" . $rodesk_analytics_id . "', 'auto');\n";
        echo "ga('send', 'pageview');\n";
    echo "</script>\n";

  }
}
add_action('rodesk_footer', 'rodesk_analytics');

/*-----------------------------------------------------------------------------------*/
/*  Set the options function for usage in theme
/*-----------------------------------------------------------------------------------*/

function rodesk_option( $option ){

    // Only run if ACF is installed
    if( !class_exists('acf') )
        return false;

    if( !isset( $option ) || empty( $option ) )
        return false;

    $rodesk_option = get_field($option, 'option');
    echo isset( $rodesk_option ) ? $rodesk_option : '';
}

function rodesk_get_option($option){

    // Only run if ACF is installed
    if( !class_exists('acf') )
        return false;

    if( !isset( $option ) || empty( $option ) )
        return false;

    $rodesk_option = get_field($option, 'option');
    return isset( $rodesk_option ) ? $rodesk_option : '';
}

/*-----------------------------------------------------------------------------------*/
/*  Generate pagination
/*----------------------------------------------------------------------------------*/

function rodesk_pagination($prev = '«', $next = '»') {
    global $wp_query, $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    $pagination = array(
        'base' => @add_query_arg('paged','%#%'),
        'format' => '',
        'total' => $wp_query->max_num_pages,
        'current' => $current,
        'prev_text' => __($prev),
        'next_text' => __($next),
        'type' => 'list'
);
    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array( 's' => get_query_var( 's' ) );

    echo paginate_links( $pagination );
};

/*-----------------------------------------------------------------------------------*/
/*  Load google maps inside post or pages
/*  Add true or false for also loading route elements (to-do: geocode start location)
/*-----------------------------------------------------------------------------------*/

function rodesk_loadmaps($map_route) {

    // Load contact details from options page
    global $post;
    $address = rodesk_get_option('address_street').','.rodesk_get_option('address_zip').','.rodesk_get_option('address_city');

    // Load JS for Google Maps
    if($address): ?>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

    <script type="text/javascript">

    var directionDisplay;
    var directionsService = new google.maps.DirectionsService();

    function initialize() {
        geocoder = new google.maps.Geocoder();
            directionsDisplay = new google.maps.DirectionsRenderer();
            var myOptions = {
              zoom: 17,
              mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

            getPosition();
            calcRoute();
    }

    function getPosition() {
        var address = <?php echo '"' .$address. '"' ?>

        geocoder.geocode( { 'address': address}, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                placeMarker(results[0].geometry.location);
                map.setCenter(results[0].geometry.location);
              } else {
                alert("Geocode was not successful for the following reason: " + status);
              }
            });
    }

    function placeMarker(addr) {

        var contentString =
            '<div id="map_content">'+
            '<h2><?php rodesk_option('address_name'); ?></h2>'+
            '<p><?php rodesk_option('address_street'); ?><br/><?php rodesk_option('address_zip'); ?>, <?php rodesk_option('address_city'); ?><br/><br/>Telefoon: <?php rodesk_option('address_phone'); ?><br/>Email: <?php rodesk_option('address_email'); ?><br/></p>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        // Define Marker properties
        var image = new google.maps.MarkerImage('<?php get_bloginfo('template_directory')?>/img/marker.png',
        new google.maps.Size(50.0, 61.0),
            new google.maps.Point(0, 0),
            new google.maps.Point(25.0, 30.0)
        );

        var shadow = new google.maps.MarkerImage('<?php get_bloginfo('template_directory')?>/img/shadow-marker.png',
        new google.maps.Size(81.0, 61.0),
                new google.maps.Point(0, 0),
                new google.maps.Point(25.0, 30.0)
        );

        var marker = new google.maps.Marker({
            position: addr,
            map: map,
            icon: image,
            shadow: shadow,
            animation: google.maps.Animation.DROP
        });

        google.maps.event.addListener(marker, 'click', function() {
          infowindow.open(map,marker);
        });
    }

    function calcRoute(addr) {
        directionsDisplay.setMap(map);
        directionsDisplay.setPanel(document.getElementById("directionsPanel"));

        var start = document.getElementById("routeStart").value;
        var end = "51.873097,4.521192";
        var request = {
          origin:start,
          destination:end,
          travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
          }
        });

        $(".adp-directions").addClass('table table-striped');
      }
    </script>
    <?php

    //Load the map canvas divs
    if ($map_route == true) {
        echo '
        <form action="" onsubmit="calcRoute();return false;" id="routeForm">
            <label style="margin-top: 20px">Voer hier uw vertrekpunt in</label>
            <input type="text" id="routeStart" value="">
            <input type="submit" value="Plan route" class="btn btn-middle btn-primary">
        </form>
        ';
    }

    echo '<div id="map_holder"><div id="map_canvas"></div></div>';

    if ($map_route == true) {
    echo '<div id="directionsPanel"></div>';
    }

    endif;
};

/*-----------------------------------------------------------------------------------*/
/*  Remove default caption from wordpress (need to be moved to cleanup)
/*-----------------------------------------------------------------------------------*/

add_filter( 'img_caption_shortcode', 'wap8_img_caption', 10, 3 );

function wap8_img_caption($nowt, $attr, $content) {
    extract( shortcode_atts( array(
        'id' => '',
        'align' => 'alignnone',
        'width' => '',
        'caption' => '',
    ), $attr ) );

    if ( 1 > (int) $width || empty( $caption ) ) {
        return $content;
    }

    if ( $id )
        $id = 'id="' . esc_attr( $id ) . '" ';

    return '<div ' . $id . 'class="wp-caption ' . esc_attr( $align ) . '" style="width:' . ( (int) $width ) . 'px;">' . do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}


?>
