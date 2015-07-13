<?php

// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}
 
delete_option( 'lh_hash' );
delete_option( 'lh_vert' );
delete_option( 'lh_overlay' );
delete_option( 'lh_stack' );
delete_option( 'lh_size' );
delete_option( 'lh_resp' );
delete_option( 'lh_width' );
delete_option( 'lh_title' );
delete_option( 'lh_font_weight' );
delete_option( 'lh_text_align' );
delete_option( 'lh_margin_top' );
delete_option( 'lh_margin_bottom' );
delete_option( 'lh_url' );
delete_option( 'lh_id' );
delete_option( 'lh_gray' );
 
