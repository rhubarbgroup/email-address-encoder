<?php

if ( ! defined( 'ABSPATH' ) ) exit;

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
 * Register callback to display warnings of incompatible plugins.
 */
add_action( 'admin_notices', 'eae_compatibility_warnings' );

/**
 * Register scripts callback.
 */
add_action( 'wp_enqueue_scripts', 'eae_enqueue_scripts' );

/**
 * Register admin scripts callback.
 */
add_action( 'admin_enqueue_scripts', 'eae_enqueue_admin_scripts' );

/**
 * Register callback to transmit email address to remote server.
 */
add_action( 'load-settings_page_eae', 'eae_transmit_email' );

/**
 * Register callback to clear page caches.
 */
add_action( 'load-options.php', 'eae_clear_caches' );

/**
 * Register callback that cleans responses for the email detector.
 */
add_action( 'wp', 'eae_cleanup_response' );

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
        'eae',
        'eae_options_page'
    );
}

/**
 * Register the plugin's setting fields.
 *
 * @return void
 */
function eae_register_settings() {
    register_setting( 'email-address-encoder', 'eae_search_in', 'sanitize_text_field' );
    register_setting( 'email-address-encoder', 'eae_technique', 'sanitize_text_field' );
    register_setting( 'email-address-encoder', 'eae_filter_priority', 'absint' );
    register_setting( 'email-address-encoder', 'eae_notices', 'absint' );
}

/**
 * Callback that runs when the plugin is uninstalled.
 *
 * @return void
 */
function eae_uninstall_hook() {
    if ( ! function_exists( 'get_plugins' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    if ( array_key_exists( 'email-encoder-premium/email-address-encoder.php', get_plugins() ) ) {
        return;
    }

    delete_option( 'eae_search_in' );
    delete_option( 'eae_technique' );
    delete_option( 'eae_filter_priority' );
}

/**
 * Callback that runs when the plugin is activated.
 *
 * @return void
 */
function eae_activation_hook() {
    update_option( 'eae_search_in', 'filters' );
    update_option( 'eae_technique', 'entities' );
    update_option( 'eae_filter_priority', (integer) EAE_FILTER_PRIORITY );
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
 * Callback to add links to the plugin's action links.
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

    return array_merge( array(
        sprintf(
            '<a target="_blank" rel="noopener" href="https://encoder.till.im/guide?utm_source=wp-plugin&amp;utm_medium=action-link">%s</a>',
            __( 'FAQ', 'email-address-encoder' )
        ),
        sprintf(
            '<a target="_blank" rel="noopener" href="https://encoder.till.im/download?utm_source=wp-plugin&amp;utm_medium=action-link">%s</a>',
            __( 'Premium', 'email-address-encoder' )
        ),
        sprintf(
            '<a href="%s">%s</a>',
            admin_url( 'options-general.php?page=eae' ),
            __( 'Settings', 'email-address-encoder' )
        ),
    ), $links );
}

/**
 * Callback to load email detector script.
 *
 * @return void
 */
function eae_enqueue_scripts() {
    if ( ! is_admin_bar_showing() ) {
        return;
    }

    if ( is_preview() ) {
        return;
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( defined( 'EAE_DISABLE_NOTICES' ) && EAE_DISABLE_NOTICES ) {
        return;
    }

    if ( get_option( 'eae_notices', '0' ) == '1' ) {
        return;
    }

    add_action( 'wp_footer', 'eae_adminbar_styles' );

    $version = get_file_data( __DIR__ . '/../email-address-encoder.php', array( 'Version' => 'Version' ) );

    wp_enqueue_script( 'email-detector', plugins_url( 'email-detector.js', __FILE__ ), null, $version[ 'Version' ], true );

    wp_localize_script( 'email-detector', 'eae_detector', array(
        'one_email' => __( '1 Unprotected Email', 'email-address-encoder' ),
        'many_emails' => __( '{number} Unprotected Emails', 'email-address-encoder' ),
        'fetch_failed' => __( '[Email Address Encoder] The email detector failed to fetch and search this page for unprotected email addresses. This happens in some scenarios, you can ignore this message.', 'email-address-encoder' ),
    ) );

    add_filter( 'script_loader_tag', 'eae_defer_script', 10, 2 );
}

/**
 * Callback to load email detector script.
 *
 * @return void
 */
function eae_adminbar_styles() {
    $styles = '#wp-admin-bar-eae > .ab-item:before { content: "\f534"; top: 2px; }';

    echo "\n<style type=\"text/css\">{$styles}</style>\n";
}

/**
 * Defer email detector script.
 *
 * @return void
 */
function eae_defer_script( $tag, $handle ) {
    if ( $handle === 'email-detector' ) {
        return str_replace( ' src', ' defer="defer" src', $tag );
    }

    return $tag;
}

/**
 * Callback to add dismissible notices script on Dashboard screen.
 *
 * @return void
 */
function eae_enqueue_admin_scripts() {
    $screen = get_current_screen();

    if ( ! isset( $screen->id ) ) {
        return;
    }

    if ( ! in_array( $screen->id, array( 'dashboard', 'edit-page' ) ) ) {
        return;
    }

    wp_enqueue_script(
        'dismissible-notices',
        plugins_url( 'dismiss-notice.js', __FILE__ ),
        array( 'jquery' )
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

    if ( ! isset( $screen->id ) ) {
        return;
    }

    if ( ! in_array( $screen->id, array( 'dashboard', 'edit-page' ) ) ) {
        return;
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( defined( 'EAE_DISABLE_NOTICES' ) && EAE_DISABLE_NOTICES ) {
        return;
    }

    if ( get_option( 'eae_notices', '0' ) == '1' ) {
        return;
    }

    if ( get_user_meta( get_current_user_id(), 'eae_dismissed_automatic_warnings_notice', true ) == '1' ) {
        return;
    }

    printf(
        '<div class="notice notice-info is-dismissible" data-dismissible="automatic_warnings_notice"><p><strong>%s</strong> %s</p></div>',
        __( 'Protect your email addresses!', 'email-address-encoder' ),
        sprintf(
            __( 'Receive <a href="%1$s">automatic warnings</a> when your site contains unprotected email addresses, or use the <a href="%1$s">page scanner</a> to test your site manually.', 'email-address-encoder' ),
            admin_url( 'options-general.php?page=eae' )
        )
    );
}

/**
 * Transmit email address to remote server.
 *
 * @return void
 */
function eae_transmit_email() {
    if (
        empty( $_POST ) ||
        ! isset( $_POST[ 'action' ], $_POST[ 'eae_notify_email' ] ) ||
        $_POST[ 'action' ] !== 'subscribe'
    ) {
        return;
    }

    $host = parse_url( get_home_url(), PHP_URL_HOST );

    if (
        $host === 'localhost' ||
        filter_var( $host, FILTER_VALIDATE_IP ) ||
        preg_match( '/\.(dev|test|local)$/', $host ) ||
        preg_match( '/^(dev|test|staging)\./', $host )
    ) {
        return add_settings_error(
            'eae_notify_email',
            'invalid',
            sprintf( __( 'Sorry, "%s" doesn’t appear to be a production domain.', 'email-address-encoder' ), $host ),
            'error'
        );
    }

    check_admin_referer( 'subscribe' );

    $response = wp_remote_post( 'https://encoder.till.im/api/subscribe', array(
        'headers' => array(
            'Accept' => 'application/json',
        ),
        'body' => array(
            'url' => get_home_url(),
            'email' => $_POST[ 'eae_notify_email' ],
        ),
    ) );

    if ( is_wp_error( $response ) || $response[ 'response' ][ 'code' ] !== 200 ) {
        return add_settings_error(
            'eae_notify_email',
            'invalid',
            __( 'Whoops, something went wrong. Please try again.', 'email-address-encoder' ),
            'error'
        );
    }

    add_settings_error(
        'eae_notify_email',
        'subscribed',
        __( 'You’ll receive a notification should your site contain unprotected email addresses.', 'email-address-encoder' ),
        'updated'
    );
}

/**
 * Clear page caches caches.
 *
 * @return void
 */
function eae_clear_caches() {
    if (
        empty( $_POST ) ||
        ! isset( $_POST[ 'option_page' ] ) ||
        $_POST[ 'option_page' ] !== 'email-address-encoder'
    ) {
        return;
    }

    // W3 Total Cache
    if ( function_exists( 'w3tc_flush_all' ) ) {
        w3tc_flush_all();
    }

    // WP Rocket
    if ( function_exists( 'rocket_clean_domain' ) ) {
        rocket_clean_domain();
    }

    // WP Super Cache
    if ( function_exists( 'wp_cache_clear_cache' ) ) {
        wp_cache_clear_cache();
    }

    // JCH Optimize
    if ( class_exists( 'JchPlatformCache' ) && method_exists( 'JchPlatformCache', 'deleteCache' ) ) {
        JchPlatformCache::deleteCache( true );
    }

    // LiteSpeed Cache
    if ( class_exists( 'LiteSpeed_Cache_API' ) && method_exists( 'LiteSpeed_Cache_API', 'purge_all' ) ) {
        LiteSpeed_Cache_API::purge_all();
    }

    // Cachify
    if ( class_exists( 'Cachify' ) && method_exists( 'Cachify', 'flush_total_cache' ) ) {
        Cachify::flush_total_cache( true );
    }
}

/**
 * Remove output that might contain email addresses that
 * would lead to false-positive matches.
 *
 * @return void
 */
function eae_cleanup_response() {
    if ( ! isset( $_SERVER[ 'HTTP_X_EMAIL_DETECTOR' ] ) || $_SERVER[ 'HTTP_X_EMAIL_DETECTOR' ] !== 'true' ) {
        return;
    }

    // Disable Admin Bar
    add_filter( 'show_admin_bar', '__return_false' );

    // Disable Debug Bar
    add_filter( 'debug_bar_enable', '__return_false' );

    // Disable Query Monitor
    add_filter( 'user_has_cap', function ( $caps ) {
        $caps[ 'view_query_monitor' ] = false;

        return $caps;
    } );
}

/**
 * Display warnings when incompatible plugins are detected.
 *
 * @return void
 */
function eae_compatibility_warnings() {
    $screen = get_current_screen();

    if ( ! isset( $screen->id ) ) {
        return;
    }

    $screens = array(
        'dashboard',
        'plugins',
        'edit-page',
        'settings_page_eae'
    );

    if ( ! in_array( $screen->id, $screens ) ) {
        return;
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );

    foreach ( $plugins as $plugin ) {
        if ( strpos( $plugin, 'ginger/' ) === 0 ) {
            $gingerCookieInstalled = true;
        }
    }

    if ( isset( $gingerCookieInstalled ) ) {
        printf(
            '<div class="notice notice-error"><p><strong>%s</strong> %s</p></div>',
            __( 'Incompatible plugin detected!', 'email-address-encoder' ),
            sprintf(
                __( 'The "Ginger – EU Cookie Law" plugin decodes all HTML entities and thus prevents the Email Address Encoder from working. Please use a different cookie banner plugin, or use the full-page scanner technique of the <a href="%s">Premium version</a>.', 'email-address-encoder' ),
                admin_url( 'options-general.php?page=eae' )
            )
        );
    }
}
