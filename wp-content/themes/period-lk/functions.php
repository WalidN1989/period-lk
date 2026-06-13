<?php
defined( 'ABSPATH' ) || exit;

// ─── Theme Setup ──────────────────────────────────────────────────────────────

add_action( 'after_setup_theme', 'periodlk_setup' );
function periodlk_setup(): void {
	load_theme_textdomain( 'period-lk', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo', [
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	] );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
	] );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );

	// Image sizes for srcset
	add_image_size( 'period-mobile',  480,  9999, false ); // 320–640 px viewports
	add_image_size( 'period-tablet',  900,  9999, false ); // 641–1024 px viewports
	add_image_size( 'period-desktop', 1440, 9999, false ); // 1025 px+ viewports

	register_nav_menus( [
		'primary' => __( 'Primary Navigation', 'period-lk' ),
		'footer'  => __( 'Footer Navigation', 'period-lk' ),
	] );
}

// ─── Enqueue Assets ───────────────────────────────────────────────────────────

add_action( 'wp_enqueue_scripts', 'periodlk_enqueue_assets' );
function periodlk_enqueue_assets(): void {
	$css_path = get_template_directory() . '/assets/css/main.css';
	$css_ver  = file_exists( $css_path ) ? hash_file( 'crc32b', $css_path ) : '1';

	wp_enqueue_style(
		'period-lk-main',
		get_template_directory_uri() . '/assets/css/main.css',
		[],
		$css_ver
	);

	// Minimal inline JS — no blocking external scripts
	$inline_js = <<<'JS'
(function(){
	// Intersection Observer lazy-load for images without native loading="lazy"
	if (!('loading' in HTMLImageElement.prototype)) {
		var imgs = document.querySelectorAll('img[data-src]');
		if (!imgs.length) return;
		var io = new IntersectionObserver(function(entries, obs){
			entries.forEach(function(e){
				if (!e.isIntersecting) return;
				var img = e.target;
				img.src = img.dataset.src;
				if (img.dataset.srcset) img.srcset = img.dataset.srcset;
				img.removeAttribute('data-src');
				obs.unobserve(img);
			});
		});
		imgs.forEach(function(img){ io.observe(img); });
	}
	// Mobile nav toggle
	var toggle = document.getElementById('nav-toggle');
	var menu   = document.getElementById('primary-menu');
	if (toggle && menu) {
		toggle.addEventListener('click', function(){
			var open = menu.getAttribute('aria-hidden') !== 'true';
			menu.setAttribute('aria-hidden', open ? 'true' : 'false');
			toggle.setAttribute('aria-expanded', open ? 'false' : 'true');
			menu.classList.toggle('is-open', !open);
		});
	}
})();
JS;

	wp_add_inline_script( 'period-lk-main', $inline_js );
}

// ─── Remove Unnecessary WordPress Scripts / Styles ────────────────────────────

add_action( 'init', 'periodlk_disable_emojis' );
function periodlk_disable_emojis(): void {
	remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles',     'print_emoji_styles' );
	remove_action( 'admin_print_styles',  'print_emoji_styles' );
	remove_filter( 'the_content_feed',    'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss',    'wp_staticize_emoji' );
	remove_filter( 'wp_mail',            'wp_staticize_emoji_for_email' );
	add_filter( 'emoji_svg_url', '__return_false' );
	add_filter( 'wp_resource_hints', 'periodlk_remove_emoji_dns_prefetch', 10, 2 );
}
function periodlk_remove_emoji_dns_prefetch( array $urls, string $relation_type ): array {
	if ( 'dns-prefetch' !== $relation_type ) return $urls;
	return array_filter( $urls, fn( $url ) => ! str_contains( (string) $url, 'twemoji' ) );
}

add_action( 'wp_enqueue_scripts', 'periodlk_dequeue_unnecessary', 20 );
function periodlk_dequeue_unnecessary(): void {
	// Remove jQuery on front-end (theme uses vanilla JS)
	if ( ! is_admin() ) {
		wp_dequeue_script( 'jquery' );
		wp_deregister_script( 'jquery' );
	}
	// Block editor styles on front-end
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'classic-theme-styles' );
	// Remove unused Dashicons on front-end
	if ( ! is_user_logged_in() ) {
		wp_dequeue_style( 'dashicons' );
	}
}

// Remove generator meta, RSD link, Windows Live Writer manifest, shortlink
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

// ─── Performance: Add native loading="lazy" to all images ─────────────────────

add_filter( 'the_content',            'periodlk_add_lazy_load' );
add_filter( 'post_thumbnail_html',    'periodlk_add_lazy_load' );
add_filter( 'get_avatar',             'periodlk_add_lazy_load' );
add_filter( 'widget_text_content',    'periodlk_add_lazy_load' );

function periodlk_add_lazy_load( string $content ): string {
	if ( is_admin() || empty( $content ) ) return $content;

	return preg_replace_callback(
		'/<img([^>]*)>/i',
		function ( array $m ): string {
			$attrs = $m[1];
			if ( str_contains( $attrs, 'loading=' ) ) return $m[0];
			return '<img' . $attrs . ' loading="lazy">';
		},
		$content
	);
}

// ─── Performance: srcset helper ───────────────────────────────────────────────

add_filter( 'wp_calculate_image_sizes', 'periodlk_image_sizes', 10, 2 );
function periodlk_image_sizes( string $sizes, array $size ): string {
	return '(max-width: 640px) 480px, (max-width: 1024px) 900px, 1440px';
}

// ─── Rank Math Compatibility ───────────────────────────────────────────────────
// Rank Math auto-detects post types, taxonomies, and fields when the theme
// declares title-tag support. The hooks below ensure no conflicts.

add_action( 'after_setup_theme', 'periodlk_rankmath_compat' );
function periodlk_rankmath_compat(): void {
	// Let Rank Math control the document title
	if ( function_exists( 'rank_math' ) ) {
		remove_action( 'wp_head', '_wp_render_title_tag', 1 );
	}
}

// Expose custom fields to Rank Math variable replacements
add_filter( 'rank_math/vars/post_custom_field', 'periodlk_rankmath_custom_fields', 10, 2 );
function periodlk_rankmath_custom_fields( mixed $value, array $args ): mixed {
	if ( empty( $args['extra'] ) ) return $value;
	$post_id = get_the_ID();
	return get_post_meta( $post_id, $args['extra'], true ) ?: $value;
}

// ─── Custom Post Types ─────────────────────────────────────────────────────────

add_action( 'init', 'periodlk_register_post_types' );
function periodlk_register_post_types(): void {
	// Resources CPT (articles, guides, FAQs for menstrual health content)
	register_post_type( 'plk_resource', [
		'labels' => [
			'name'               => __( 'Resources', 'period-lk' ),
			'singular_name'      => __( 'Resource', 'period-lk' ),
			'add_new_item'       => __( 'Add New Resource', 'period-lk' ),
			'edit_item'          => __( 'Edit Resource', 'period-lk' ),
			'search_items'       => __( 'Search Resources', 'period-lk' ),
			'not_found'          => __( 'No resources found.', 'period-lk' ),
		],
		'public'             => true,
		'has_archive'        => true,
		'rewrite'            => [ 'slug' => 'resources' ],
		'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
		'show_in_rest'       => true, // Gutenberg + Rank Math compatibility
		'menu_icon'          => 'dashicons-book-alt',
	] );

	// Stories CPT (community stories / testimonials)
	register_post_type( 'plk_story', [
		'labels' => [
			'name'          => __( 'Stories', 'period-lk' ),
			'singular_name' => __( 'Story', 'period-lk' ),
			'add_new_item'  => __( 'Add New Story', 'period-lk' ),
			'edit_item'     => __( 'Edit Story', 'period-lk' ),
		],
		'public'       => true,
		'has_archive'  => true,
		'rewrite'      => [ 'slug' => 'stories' ],
		'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-format-quote',
	] );
}

// ─── Contact Form Handler (loaded separately) ──────────────────────────────────

require_once get_template_directory() . '/inc/contact-form.php';
require_once get_template_directory() . '/inc/rankmath-setup.php';

// ─── Clean up <head> ──────────────────────────────────────────────────────────

add_filter( 'wp_head', 'periodlk_clean_head', 1 );
function periodlk_clean_head(): void {
	ob_start( fn( $buf ) => preg_replace( '/\n\s*\n/', "\n", $buf ) );
}
