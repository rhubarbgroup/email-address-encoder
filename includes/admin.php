<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'EAE_DISABLE_NOTICES' ) ) {
    include __DIR__ . '/mo-notice.php';
}

/**
 * Load the plugin's text domain.
 */
add_action( 'plugins_loaded', 'eae_load_textdomain' );

/**
 * Register the plugin's menu item.
 */
add_action( 'admin_menu', 'eae_register_ui' );

/**
 * Register the plugin's setting fields.
 */
add_action( 'admin_init', 'eae_register_settings' );

/**
 * Register the plugin's action links.
 */
add_filter( 'plugin_action_links', 'eae_plugin_actions_links', 10, 2 );

/**
 * Register page scanner admin notice.
 */
add_action( 'admin_notices', 'eae_page_scanner_notice' );

/**
 * Register admin scripts callback.
 */
add_action( 'admin_enqueue_scripts', 'eae_enqueue_script' );

/**
 * Register AJAX callback for "eae_dismiss_notice" action.
 */
add_action( 'wp_ajax_eae_dismiss_notice', 'eae_dismiss_notice' );

/**
 * Callback to load the plugin's text domain.
 *
 * @return void
 */
function eae_load_textdomain() {
    load_plugin_textdomain(
        'email-address-encoder',
        false,
        basename( dirname( __FILE__ ) ) . '/languages'
    );
}

/**
 * Callback to add the plugin's menu item to the "Settings" menu.
 *
 * @return void
 */
function eae_register_ui() {
	add_options_page(
        __( 'Email Address Encoder', 'email-address-encoder' ),
        __( 'Email Encoder', 'email-address-encoder' ),
        'manage_options',
        'email-address-encoder',
        'eae_options_page'
    );
}

/**
 * Register the plugin's setting fields.
 *
 * @return void
 */
function eae_register_settings() {
    register_setting( 'email-address-encoder', 'eae_search_in' );
    register_setting( 'email-address-encoder', 'eae_technique' );
    register_setting( 'email-address-encoder', 'eae_filter_priority' );
}

/**
 * Callback that displays the plugin's settings interface.
 *
 * @return void
 */
function eae_options_page() {
    include __DIR__ . '/ui.php';
}

/**
 * Callback to add "Settings" link to the plugin's action links.
 *
 * @param array $links
 * @param string $file
 *
 * @return array
 */
function eae_plugin_actions_links( $links, $file ) {
    if ( strpos( $file, 'email-address-encoder/' ) !== 0 ) {
        return $links;
    }

    $link = sprintf(
        '<a href="%s">%s</a>',
        admin_url( 'options-general.php?page=email-address-encoder' ),
        __( 'Settings', 'email-address-encoder' )
    );

    return array_merge( array( $link ), $links );
}

/**
 * Callback to add dismissible notices script on Dashboard screen.
 *
 * @return void
 */
function eae_enqueue_script() {
    $screen = get_current_screen();

    if ( ! isset( $screen->id ) || $screen->id !== 'dashboard' ) {
        return;
    }

    wp_enqueue_script(
        'dismissible-notices',
        plugins_url( 'dismiss-notice.js', __FILE__ ),
        array( 'jquery', 'common' )
    );
}

/**
 * Callback for "eae_dismiss_notice" AJAX requests.
 *
 * @return void
 */
function eae_dismiss_notice() {
    $notice = sprintf(
        'eae_dismissed_%s',
        sanitize_key( $_POST[ 'notice' ] )
    );

    update_user_meta( get_current_user_id(), $notice, '1' );

    wp_die();
}

/**
 * Admin notices callback that display the "Page Scanner" notice.
 *
 * @return void
 */
function eae_page_scanner_notice() {
    $screen = get_current_screen();

    if ( isset( $screen->id ) ) {
        if ( $screen->id === 'settings_page_email-address-encoder' ) {
            return;
        }

        if ( $screen->id !== 'dashboard' ) {
            return;
        }
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( defined( 'EAE_DISABLE_NOTICES' ) ) {
        return;
    }

    if ( get_user_meta( get_current_user_id(), 'eae_dismissed_page_scanner_notice', true ) === '1' ) {
        return;
    }

    printf(
        '<div class="notice notice-info is-dismissible" data-dismissible="page_scanner_notice"><p><strong>%s</strong> %s</p></div>',
        __( 'Make sure all your email addresses are encoded!', 'email-address-encoder' ),
        sprintf(
            __( 'Use the <a href="%s">Page Scanner</a> to test your site.', 'email-address-encoder' ),
            admin_url( 'options-general.php?page=email-address-encoder' )
        )
    );
}
