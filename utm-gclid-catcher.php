<?php
/*
Plugin Name:  UTM & GCLID catcher
Plugin URI:   https://pamteh.si/en/wp-utm-plugin/
Description:  A simple plugin to capture and save UTM tags and the Google Click Identifier (GCLID) in cookies, allowing them to be sent through forms. Also adds WPForms tags for UTM and GCLID.
Version:      1.0
Author:       Pamteh.si
Author URI:   https://pamteh.si
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  utm-gclid-catcher
Domain Path:  /languages
*/

function wpf_dev_register_smarttag( $tags ) {

    $tags[ 'gclid' ] = 'gclid';
    $tags[ 'utm_source' ] = 'utm_source';
    $tags[ 'utm_medium' ] = 'utm_medium';
    $tags[ 'utm_campaign' ] = 'utm_campaign';
    $tags[ 'utm_term' ] = 'utm_term';
    $tags[ 'utm_content' ] = 'utm_content';

    return $tags;
}

add_filter( 'wpforms_smart_tags', 'wpf_dev_register_smarttag', 10, 1 );

function wpf_dev_process_smarttag( $content, $tag ) {

    if (
        $tag === 'gclid' ||
        $tag === 'utm_source' ||
        $tag === 'utm_medium' ||
        $tag === 'utm_campaign' ||
        $tag === 'utm_term' ||
        $tag === 'utm_content'
    ) {
        if(isset($_COOKIE['utm-plugin_'.$tag])){
            $content = str_replace( '{'.$tag.'}', $_COOKIE['utm-plugin_'.$tag], $content );
        }

    }

    return $content;
}

add_filter( 'wpforms_smart_tag_process', 'wpf_dev_process_smarttag', 10, 2);


function add_my_var($public_query_vars) {
    $public_query_vars[] = 'gclid';
    $public_query_vars[] = 'utm_source';
    $public_query_vars[] = 'utm_medium';
    $public_query_vars[] = 'utm_campaign';
    $public_query_vars[] = 'utm_term';
    $public_query_vars[] = 'utm_content';
    return $public_query_vars;
}

add_filter('query_vars', 'add_my_var');

function utm_plugin_save_data()
{
    if ( get_query_var('gclid') ) {
        setcookie('utm-plugin_gclid', get_query_var('gclid'), time()+3600*24*90);
    }
    if ( get_query_var('utm_source') ) {
        setcookie('utm-plugin_utm_source', get_query_var('utm_source'), time()+3600*24*90);
    }
    if ( get_query_var('utm_medium') ) {
        setcookie('utm-plugin_utm_medium', get_query_var('utm_medium'), time()+3600*24*90);
    }
    if ( get_query_var('utm_campaign') ) {
        setcookie('utm-plugin_utm_campaign', get_query_var('utm_campaign'), time()+3600*24*90);
    }
    if ( get_query_var('utm_term') ) {
        setcookie('utm-plugin_utm_term', get_query_var('utm_term'), time()+3600*24*90);
    }
    if ( get_query_var('utm_content') ) {
        setcookie('utm-plugin_utm_content', get_query_var('utm_content'), time()+3600*24*90);
    }

}

add_action( 'wp', 'utm_plugin_save_data' );
