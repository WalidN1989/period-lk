<?php
/**
 * period.lk — Theme functions
 * Sojourn design v3.0.0 | WooCommerce + Elementor + Rank Math
 */

defined( 'ABSPATH' ) || exit;

/* ── Constants ─────────────────────────────────────────────── */
define( 'PERIOD_LK_VERSION', '3.0.0' );
define( 'PERIOD_LK_DIR',     get_template_directory() );
define( 'PERIOD_LK_URI',     get_template_directory_uri() );

/* ── Theme support ──────────────────────────────────────────── */
add_action( 'after_setup_theme', function () {
    load_theme_textdomain( 'period-lk', PERIOD_LK_DIR . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form','comment-form','comment-list','gallery','caption','style','script' ] );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );

    /* WooCommerce */
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    /* Block-editor color palette (Sojourn tokens) */
    add_theme_support( 'editor-color-palette', [
        [ 'name' => 'Wine',   'slug' => 'wine',   'color' => '#6a1b2a' ],
        [ 'name' => 'Blush',  'slug' => 'blush',  'color' => '#f7e6ea' ],
        [ 'name' => 'Cream',  'slug' => 'cream',  'color' => '#fbf2ea' ],
        [ 'name' => 'Canvas', 'slug' => 'canvas', 'color' => '#fffdfb' ],
        [ 'name' => 'Ink',    'slug' => 'ink',    'color' => '#2a1216' ],
        [ 'name' => 'Gold',   'slug' => 'gold',   'color' => '#c08a3e' ],
    ] );

    /* Navigation menus */
    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'period-lk' ),
        'footer'  => __( 'Footer Navigation',  'period-lk' ),
    ] );
} );

/* ── Image sizes ────────────────────────────────────────────── */
add_action( 'after_setup_theme', function () {
    add_image_size( 'product-portrait', 480, 600, true );
    add_image_size( 'hero-landscape',  1440, 720, true );
    add_image_size( 'category-tile',   600, 700, true );
} );

/* ── Enqueue assets ─────────────────────────────────────────── */
add_action( 'wp_enqueue_scripts', function () {
    /* Google Fonts — Playfair Display + Hanken Grotesk */
    wp_enqueue_style(
        'period-lk-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500;1,600&family=Hanken+Grotesk:wght@400;500;600&display=swap',
        [],
        null
    );

    /* style.css — design tokens */
    wp_enqueue_style(
        'period-lk-tokens',
        PERIOD_LK_URI . '/style.css',
        [ 'period-lk-fonts' ],
        PERIOD_LK_VERSION
    );

    /* Main stylesheet */
    wp_enqueue_style(
        'period-lk-main',
        PERIOD_LK_URI . '/assets/css/main.css',
        [ 'period-lk-tokens' ],
        PERIOD_LK_VERSION
    );

    /* Preserve jQuery for Elementor */
    if ( ! is_admin() && ! defined( 'ELEMENTOR_VERSION' ) ) {
        wp_dequeue_script( 'jquery' );
        wp_deregister_script( 'jquery' );
    }

    /* Theme JS */
    wp_enqueue_script(
        'period-lk-main',
        PERIOD_LK_URI . '/assets/js/main.js',
        [ 'jquery' ],
        PERIOD_LK_VERSION,
        true
    );

    wp_localize_script( 'period-lk-main', 'periodLK', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'period_lk_nonce' ),
    ] );
} );

/* ── WooCommerce ────────────────────────────────────────────── */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
add_filter( 'loop_shop_columns',       fn() => 4 );
add_filter( 'loop_shop_per_page',      fn() => 12 );
add_filter( 'woocommerce_product_thumbnails_columns', fn() => 4 );

add_filter( 'woocommerce_breadcrumb_defaults', fn( $d ) => array_merge( $d, [
    'delimiter'   => '<span class="bc-sep" aria-hidden="true">/</span>',
    'wrap_before' => '<nav class="wc-breadcrumb" aria-label="Breadcrumb"><ol>',
    'wrap_after'  => '</ol></nav>',
    'before'      => '<li>',
    'after'       => '</li>',
    'home'        => __( 'Home', 'period-lk' ),
] ) );

/* ── Elementor compatibility ───────────────────────────────── */
add_action( 'elementor/theme/register_locations', function ( $locations ) {
    $locations->register_all_core_location();
} );

/* ── SVG uploads ────────────────────────────────────────────── */
add_filter( 'upload_mimes', function ( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
} );

/* ── Performance ────────────────────────────────────────────── */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles',     'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles',  'print_emoji_styles' );

/* ── Widgets ────────────────────────────────────────────────── */
add_action( 'widgets_init', function () {
    register_sidebar( [
        'name'          => __( 'Shop Sidebar', 'period-lk' ),
        'id'            => 'shop-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );
} );

/* ── Product page stylesheet ───────────────────────────────── */
add_action( 'wp_enqueue_scripts', function () {
    if ( is_product() ) {
        wp_enqueue_style(
            'period-lk-product',
            PERIOD_LK_URI . '/assets/css/product.css',
            [ 'period-lk-main' ],
            PERIOD_LK_VERSION
        );
    }
} );

/* ── Product trust badges ──────────────────────────────────── */
add_action( 'woocommerce_after_add_to_cart_button', function () {
    echo '<div class="product-trust-badges">';
    $badges = [
        [ 'icon' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v4h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>', 'text' => 'Cash on delivery available island-wide' ],
        [ 'icon' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>', 'text' => 'Discreet plain-box packaging, always' ],
        [ 'icon' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>', 'text' => 'Free islandwide shipping over LKR 7,500' ],
    ];
    foreach ( $badges as $badge ) {
        echo '<div class="product-trust-badge">' . $badge['icon'] . '<span>' . esc_html( $badge['text'] ) . '</span></div>';
    }
    echo '</div>';
}, 15 );
