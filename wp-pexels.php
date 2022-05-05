<?php
/*
 * Plugin Name:         Pexels: Free Stock Photos
 * Plugin URI: https://github.com/uwejacobs/wp-pexels-free-stock-photos.git
 * Description:         Pexels provides high quality and completely free stock images for personal and commercial use. This plugin helps you search, browse and download those photos directly to your WordPress site, giving you the benefits of hosting them (cropping, compressing, caching etc.).
 * Version:             1.3.0
 * Author:              Uwe Jacobs, Raaj Trambadia
 * Author URI:          https://ujsoftware.com
 * Requires at least:   5.6
 * Tested up to:        5.9.3
 * Requires PHP:        7.0
 * Text Domain:         pexels_fsp_images
 * Original Plugin URI: https://raajtram.com/plugins/pexels
 * Original Author URI: https://raajtram.com
 * License:             GPLv3
*/

/* Add Plugin Settings */
include(plugin_dir_path(__FILE__) . 'settings.php');

/* Add the "Settings" Link to the /plugins Page */
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'pexels_fsp_action_links' );

function pexels_fsp_action_links( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'upload.php?page=pexels_fsp_images_settings') ) .'">Get Photos</a>';
   return $links;
}

/**
 * Dont Update the Plugin
 * If there is a plugin in the repo with the same name, this prevents WP from prompting an update.
 *
 * @author Jon Brown
 * @param  array $r Existing request arguments
 * @param  string $url Request URL
 * @return array Amended request arguments
 */
if (!function_exists('pexels_dont_update__plugin')) {
	function pexels_dont_update__plugin( $r, $url ) {
		if ( 0 !== strpos( $url, 'https://api.wordpress.org/plugins/update-check/1.1/' ) )
			return $r; // Not a plugin update request. Bail immediately.
		$plugins = json_decode( $r['body']['plugins'], true );
		unset( $plugins['plugins'][plugin_basename( UJ_DIR . '/wp-pexels.php' )] );
		$r['body']['plugins'] = json_encode( $plugins );
		return $r;
	}
	
	add_filter( 'http_request_args', 'pexels_dont_update__plugin', 5, 2 );
}

/**
 * Author Links on CF Plugin
 *
 */
if (!function_exists('pexels_author_links_on_plugin')) {
        function pexels_author_links_on_plugin( $links, $file ) {

                if ( strpos( $file, 'wp-pexels.php' ) !== false ) {
                        $links[1] = 'By <a href="https://www.ujsoftware.com">Uwe Jacobs</a>';
                        $links[2] = 'Original by <a href="https://raajtram.com/">Raaj Trambadia</a>';
                }

                return $links;
        }

        add_filter( 'plugin_row_meta', 'pexels_author_links_on_plugin', 10, 2 );
}
