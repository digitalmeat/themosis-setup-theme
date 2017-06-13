<?php

// set the options to change
$option = array(
    // we don't want no description
    'blogdescription'               => '',
    // change category base
    'category_base'                 => '/cat',
    // change tag base
    'tag_base'                      => '/label',
    // disable comments
    'default_comment_status'        => 'closed',
    // disable trackbacks
    'use_trackback'                 => '',
    // disable pingbacks
    'default_ping_status'           => 'closed',
    // disable pinging
    'default_pingback_flag'         => '',
    // change the permalink structure
    'permalink_structure'           => '/%postname%/',
    // dont use year/month folders for uploads
    'uploads_use_yearmonth_folders' => '',
    // don't use those ugly smilies
    'use_smilies'                   => ''
);

// change the options!
foreach ( $option as $key => $value ) {
    update_option( $key, $value );
}

// flush rewrite rules because we changed the permalink structure
global $wp_rewrite;
$wp_rewrite->flush_rules();

// delete the default comment, post and page
wp_delete_comment( 1 );
wp_delete_post( 1, TRUE );
wp_delete_post( 2, TRUE );

// we need to include the file below because the activate_plugin() function isn't normally defined in the front-end
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
// activate pre-bundled plugins
activate_plugin( 'wp-super-cache/wp-cache.php' );
activate_plugin( 'wordpress-seo/wp-seo.php' );
activate_plugin( 'contact-form-7/wp-contact-form-7.php' );

// switch the theme to "Headliner"
switch_theme( 'headliner' );

function plugin_activation( $plugin ) {
    if( ! function_exists('activate_plugin') ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    if( ! is_plugin_active( $plugin ) ) {
        activate_plugin( $plugin );
    }
}


//rrmdir(__DIR__)

function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir."/".$object))
                    rrmdir($dir."/".$object);
                else
                    unlink($dir."/".$object);
            }
        }
        rmdir($dir);
    }
}