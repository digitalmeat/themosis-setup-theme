<?php

// set the options to change
$option = array(
    // we don't want no description
    'blogdescription'               => '',
    // disable comments
    'default_comment_status'        => 'closed',
    // disable trackbacks
    'use_trackback'                 => '',
    // disable pingbacks
    'default_ping_status'           => 'closed',
    // disable pinging
    'default_pingback_flag'         => '',
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
activate_plugin("wordfence/wordfence.php");
activate_plugin("admin-menu-editor/menu-editor.php");
activate_plugin("minify-html-markup/minify-html.php");
activate_plugin("wp-sanitize-file-name-plus");
activate_plugin( 'wp-super-cache/wp-cache.php' );
activate_plugin( 'wordpress-seo/wp-seo.php' );
activate_plugin( 'advanced-custom-fields-pro/acf.php' );

// switch the theme to "Meat Theme"
switch_theme( 'meat-theme' );

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