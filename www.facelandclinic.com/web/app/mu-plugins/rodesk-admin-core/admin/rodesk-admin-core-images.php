<?php
/**
 * Rodesk admin core images.
 *
 * Custom Rodesk setup for WordPress. This core plugins cleans up WP, adds custom dashboard functions, handle custom rewrite rules (for relative URL's), and uses a custom wpThumb fork for image handling.
 *
 * @package   rodesk-admin-core
 * @author    Rodesk BV <interactie@rodesk.nl>
 * @link      http://rodesk.nl
 * @copyright 2015 Rodesk BV
 */

/*  Most of these image function depend on the WPThumb plugin. Which is included in this plugin.

/*-----------------------------------------------------------------------------------*/
/*  The calls with all the WP actions and filter
/*-----------------------------------------------------------------------------------*/

class rodesk_admin_core_images {

    protected $plugin_slug = 'rodesk-admin-core';

    // Construct the class
    public function __construct() {

        // Run the actions
        add_action('after_setup_theme', array( $this, 'rodesk_save_image_settings' ) ); // Set default media settings

        // Run the filters
        add_filter( 'intermediate_image_sizes', array( $this, 'rodesk_thumb_remove_default' ) );  // Remove deault image sizes
        add_filter( 'intermediate_image_sizes_advanced', array( $this, 'rodesk_thumb_no_generating' ) ); // Prevent WP from generating resized images on upload (for both default and custom image-sizes)
        add_filter( 'wp_generate_attachment_metadata', array( $this, 'rodesk_thumb_generate_metadata') ); // Trick WP into thinking images were generated anyway (by addidng meta data)
        add_filter( 'wpthumb_create_args_from_size', array( $this, 'rodesk_thumb_args_from_wpsize') ); // Also use WPThumb for the all default sizes (except full)
        add_filter( 'image_resize_dimensions', array( $this, 'image_crop_dimensions'), 10, 6); // Force upscale images when needed
        add_filter( 'image_downsize', array( $this, 'rodesk_thumb_filter_image') , 99, 3 );
        add_filter( 'jpeg_quality', array( $this, 'rodesk_thumb_jpeg__quality' ) );
        add_filter( 'sanitize_file_name', array( $this, 'rodesk_sanitize_filename_upload' ), 10);

    }

    public function rodesk_save_image_settings() {
        // Never use year/month based folders for uploaded assets
        update_option('uploads_use_yearmonth_folders', 0);
    }

    // public function twhoog_sanitize_filename_upload( $filename ) {
    // Sanitize file upload filenames
    public function rodesk_sanitize_filename_upload($filename) {

        $sanitized_filename = remove_accents($filename); // Convert to ASCII

        // Standard replacements
        $invalid = array(
            ' ' => '-',
            '%20' => '-'
//            '_' => '-'
        );
        $sanitized_filename = str_replace(array_keys($invalid), array_values($invalid), $sanitized_filename);

//        $sanitized_filename = preg_replace('/[^A-Za-z0-9-\. ]/', '', $sanitized_filename); // Remove all non-alphanumeric except .
        $sanitized_filename = preg_replace('/\.(?=.*\.)/', '', $sanitized_filename); // Remove all but last .
        $sanitized_filename = preg_replace('/-+/', '-', $sanitized_filename); // Replace any more than one - in a row
        $sanitized_filename = str_replace('-.', '.', $sanitized_filename); // Remove last - if at the end
        $sanitized_filename = strtolower($sanitized_filename); // Lowercase

        return $sanitized_filename;
    }

    public function rodesk_thumb_jpeg__quality( $quality ) {
        return 100;
    }

    // Remove deault image sizes
    public function rodesk_thumb_remove_default( $image_sizes ) {

        unset( $image_sizes[1] ); // remove medium default image size
        unset( $image_sizes[2] ); // remove large default image size

        return $image_sizes;
    }

    // Get image size info (default and via add_image_size())
    private function rodesk_thumb_image_sizes() {

        global $_wp_additional_image_sizes;

        $sizes = array();
        $get_intermediate_image_sizes = get_intermediate_image_sizes();

        // Create the full array with sizes and crop info
        foreach( $get_intermediate_image_sizes as $_size ) {

            if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

                    $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
                    $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
                    $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );

            } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

                $sizes[ $_size ] = array(
                        'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                        'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                        'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
                );
            }

        }

        return $sizes;
    }

    // Turn all image sizes into dynmaic WPThumb images
    function rodesk_thumb_filter_image( $null, $id, $args ) {

        // Do not run this function when in the admin dashboard
        $from_frontend = isset( $_REQUEST['frontend_ajax'] ) && ( TRUE === (bool) $_REQUEST['frontend_ajax'] );
        if ( defined('DOING_AJAX') && DOING_AJAX && is_admin() && !$from_frontend ) {
            return $null;
        }

        // check if $args is a WP Thumb argument list, or native WordPress one
        // wp thumb looks like this: 'width=300&height=120&crop=1'
        // native looks like 'thumbnail'
        if ( is_string( $args ) && ! strpos( (string) $args, '=' ) ) {

            if( $args == 'full' || $args == 'thumbnail' ) {
                return false;
            }

            // If this is a  WP image size. Convert it to WPThumb args
            $args = apply_filters( 'wpthumb_create_args_from_size', $args );

            // // if there are no "special" wpthumb args, then we shouldn' bother creating a WP Thumb, just use the WordPress one
            // if ( $args === ( $args = apply_filters( 'wpthumb_create_args_from_size', $args ) ) )
            //  return $null;
        }

        $args = wp_parse_args( $args );

        if ( ! empty( $args[0] ) )
            $args['width'] = $args[0];

        if ( ! empty( $args[1] ) )
            $args['height'] = $args[1];

        if ( ! empty( $args['crop'] ) && $args['crop'] && empty( $args['crop_from_position'] ) )
             $args['crop_from_position'] = get_post_meta( $id, 'wpthumb_crop_pos', true );

        if ( empty( $path ) )
            $path = get_attached_file( $id );

        $path = apply_filters( 'wpthumb_post_image_path', $path, $id, $args );
        $args = apply_filters( 'wpthumb_post_image_args', $args, $id );

        $image = new WP_Thumb( $path, $args );

        $args = $image->getArgs();

        extract( $args );

        if ( ! $image->errored() ) {

            $image_src = $image->returnImage();

            $crop = (bool) ( empty( $crop ) ) ? false : $crop;
            $image_meta = '';
            if($image->getCacheFilePath() != '') {
                $image_meta = @getimagesize($image->getCacheFilePath());
            }
            if ( ! $image->errored() && $image_meta ) :

                $html_width = $image_meta[0];
                $html_height = $image_meta[1];

            else :
                $html_width = $html_height = false;

            endif;

        } else {

            $html_width = $width;
            $html_height = $height;
            $image_src = $image->getFileURL();
        }

        return array( $image_src, $html_width, $html_height, true );

    }

    // Also use WPThumb for the all default sizes (except full)
    // (bacuase we are going to stop the default WP generating)
    public function rodesk_thumb_args_from_wpsize( $size ) {

        if ( $size != 'full' && $size != 'thumbnail' && $size != 'avatar' ) {

            $sizes = $this->rodesk_thumb_image_sizes();


            if( !is_array($size) && !empty( $sizes[ $size ] ) ) {
                $size_sizes = $sizes[ $size ];
            }

            if( isset( $size_sizes ) && is_array( $size_sizes ) ) {
                $size = 'width=' . $size_sizes['width'] . '&height=' . $size_sizes['height'] . '&crop=1';
            }

            return $size;

        } else {
            return $size;
        }

    }

    // Prevent WP from generating resized images on upload (for both default and custom image-sizes)
    public function rodesk_thumb_no_generating($sizes) {
        global $rodesk_image_sizes;

        // Save the sizes to a global
        // Because the next function needs them to lie to WP about what sizes were generated
        $rodesk_image_sizes = $sizes;

        // Force WP to not make sizes by telling it there's no sizes to make. Except the thubnail for in the Wp gallery
        return array( "thumbnail" => isset( $sizes['thumbnail'] ) ? $sizes['thumbnail'] : '' );

    }

    // Trick WP into thinking images were generated anyway (by addidng meta data)
    public function rodesk_thumb_generate_metadata($meta) {
        global $rodesk_image_sizes;

        // If $rodesk_image_sizes is not defined it means we are uploading something other than an image
        if ( empty( $rodesk_image_sizes ) || ! is_array( $rodesk_image_sizes ) ) {
            return $meta;
        }

        foreach ($rodesk_image_sizes as $sizename => $size) {

            // Figure out what size WP would make this:
            $newsize = image_resize_dimensions( $meta['width'], $meta['height'], $size['width'], $size['height'], $size['crop']);

            if ($newsize) {

                $info       = pathinfo($meta['file']);
                $ext        = $info['extension'];
                $name       = wp_basename($meta['file'], ".$ext");
                $suffix     = "{$newsize[4]}x{$newsize[5]}";
                $orgfile    = "{$name}.{$ext}";
                $newfile    = "{$name}-{$suffix}.{$ext}";
                $upload_dir = wp_upload_dir();

                // If this is not a thumbnail always return original image name
                if( $sizename != 'thumbnail' ) {

                    $filename = $orgfile;

                // If this is a thumbnail return new (formatted) image name
                } else {

                    // Check if the formatted thumbnail image excists
                    if( file_exists( $upload_dir['path'] . '/' . $newfile ) ) {
                        $filename = $newfile;
                    // Else return original image format
                    } else {
                        $filename = $orgfile;
                    }
                }

                // Build the fake meta entry for the size in question
                $resized = array(
                    'file' => $filename,
                    'width' => $newsize[4],
                    'height' => $newsize[5],
                );

                $meta['sizes'][$sizename] = $resized;
            }

        }

        return $meta;
    }

    // Force to genrate upscaled images if needed
    /** http://wordpress.stackexchange.com/questions/50649/how-to-scale-up-featured-post-thumbnail **/
    public function image_crop_dimensions( $default, $orig_w, $orig_h, $dest_w, $dest_h, $crop) {

        if ( !$crop ) return null; // let the wordpress default function handle this

        $aspect_ratio = $orig_w / $orig_h;
        $size_ratio = max($dest_w / $orig_w, $dest_h / $orig_h);

        $crop_w = round($dest_w / $size_ratio);
        $crop_h = round($dest_h / $size_ratio);

        $s_x = floor( ($orig_w - $crop_w) / 2 );
        $s_y = floor( ($orig_h - $crop_h) / 2 );

        return array( 0, 0, (int) $s_x, (int) $s_y, (int) $dest_w, (int) $dest_h, (int) $crop_w, (int) $crop_h );

    }

}
?>
