<?php
/*  Copyright 2015 Renzo Johnson (email: renzo.johnson at gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/* Shortcode [home]
================================================== */
if (!function_exists('blocks_home_url')) {
  function blocks_home_url() {

    $home_url = home_url();
    return $home_url;

  }
  add_shortcode('home', 'blocks_home_url');
}


/* Author credits before </body>
================================================== */
if (!function_exists('blocks_author')) {
  function blocks_author() {

    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    if ( class_exists( 'autoptimizeHTML') )  {

      $blocks_footer_output = '<!--noptimize--><!-- Wordpress Blocks plugin developed by RenzoJohnson.com --><!--/noptimize-->';

    } else {

      $blocks_footer_output = '<!-- Wordpress Blocks plugin developed by RenzoJohnson.com -->';

    }

    print $blocks_footer_output;

  }
}

if (!function_exists('blocks_wp_loaded')) {
  function blocks_wp_loaded() {

    add_filter( 'wp_footer' , 'blocks_author' , 20 );

  }
  add_action( 'wp_loaded', 'blocks_wp_loaded' );
}


/* Updts
================================================== */
if (!function_exists('blocks_upd')) {
  function blocks_upd ( $update, $item ) {
      $plugins = array (
          'blocks',
          'contact-form-7-mailchimp-extension',
          'contact-form-7-campaign-monitor-extension',
      );
      if ( in_array( $item->slug, $plugins ) ) {
          return true;
      } else {
          return $update;
      }
  }
  add_filter( 'auto_update_plugin', 'blocks_upd', 10, 2 );
}


/* Sept 22, 2015
================================================== */
add_filter( 'auto_core_update_send_email', '__return_false' );
add_filter( 'wpcmsb_form_elements', 'do_shortcode' );
add_filter( 'wpcf7_form_elements', 'do_shortcode' );




/* Nov 16, 2017 remove emoji
================================================== */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );



/* Remove jQuery Migrate Script from header and Load jQuery from Google API
================================================== */
if (!function_exists('spartan_remove_jquery_migrate_load_google_hosted_jquery')) {
  function spartan_remove_jquery_migrate_load_google_hosted_jquery() {
    if (!is_admin()) {
      wp_deregister_script('jquery');
      wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js', false, null);
      wp_enqueue_script('jquery');
    }
  }
  // add_action('init', 'spartan_remove_jquery_migrate_load_google_hosted_jquery');
}



/* Nov 17, 2017
================================================== */
if (!function_exists('spartan_remove_toolbar_menu')) {
  function spartan_remove_toolbar_menu() {

    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('updraft_admin_node');
    $wp_admin_bar->remove_node('tribe-events');
    $wp_admin_bar->remove_node('new_draft');
    $wp_admin_bar->remove_node('revslider');
    $wp_admin_bar->remove_node('1'); // theme options
    $wp_admin_bar->remove_node('2');
    $wp_admin_bar->remove_node('wp-logo');
    // $wp_admin_bar->remove_node('new-content');
    $wp_admin_bar->remove_node('customize');
    $wp_admin_bar->remove_node('updates');
    $wp_admin_bar->remove_node('comments');
    $wp_admin_bar->remove_node('search');

  }
  add_action('wp_before_admin_bar_render', 'spartan_remove_toolbar_menu', 999);
}



/* Nov 17, 2017
================================================== */
if (!function_exists('spartan_remove_toolbar_node')) {
  function spartan_remove_toolbar_node($wp_admin_bar) {
    $wp_admin_bar->remove_node('popup-maker');
    $wp_admin_bar->remove_node('autoptimize');

  }
  add_action('admin_bar_menu', 'spartan_remove_toolbar_node', 999);
}