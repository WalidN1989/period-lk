<?php
/**
 * Rank Math automated configuration.
 *
 * Run once after theme + Rank Math activation:
 *   wp eval-file wp-content/themes/period-lk/inc/rankmath-setup.php
 *
 * Or trigger via WP-CLI:
 *   wp eval 'periodlk_configure_rankmath();'
 */
defined( 'ABSPATH' ) || exit;

function periodlk_configure_rankmath(): void {
	if ( ! class_exists( 'RankMath' ) ) {
		WP_CLI::error( 'Rank Math plugin is not active.' );
		return;
	}

	// ── General Settings ──────────────────────────────────────────────────────
	update_option( 'rank_math_general_settings', array_merge(
		(array) get_option( 'rank_math_general_settings', [] ),
		[
			'breadcrumbs'         => 1,
			'breadcrumbs_home'    => 1,
			'breadcrumbs_prefix'  => '',
			'breadcrumbs_separator'=> '/',
			'noindex_empty_taxonomies' => 1,
			'attachment_redirect_urls' => 1,
		]
	) );

	// ── Titles & Meta ──────────────────────────────────────────────────────────
	update_option( 'rank_math_titles', array_merge(
		(array) get_option( 'rank_math_titles', [] ),
		[
			'website_name'           => 'period.lk',
			'homepage_title'         => 'Period.lk — Menstrual Health for Sri Lanka',
			'homepage_description'   => 'Breaking stigma, building awareness. Period.lk is Sri Lanka\'s home for menstrual health education, resources, and community stories.',
			'author_archive_title'   => '%name% — Period.lk',
			'local_business_type'    => 'Organization',
			'local_business_name'    => 'period.lk',
			'local_business_url'     => 'https://period.lk',
		]
	) );

	// ── Sitemap ───────────────────────────────────────────────────────────────
	update_option( 'rank_math_sitemap', array_merge(
		(array) get_option( 'rank_math_sitemap', [] ),
		[
			'items_per_page'  => 200,
			'include_images'  => 1,
			'exclude_posts'   => '',
			'exclude_terms'   => '',
		]
	) );

	// ── Social Profiles ───────────────────────────────────────────────────────
	update_option( 'rank_math_social_url_facebook',  'https://facebook.com/periodlk' );
	update_option( 'rank_math_social_url_instagram', 'https://instagram.com/period.lk' );
	update_option( 'rank_math_social_url_linkedin',  'https://linkedin.com/company/periodlk' );
	update_option( 'rank_math_social_url_tiktok',    'https://tiktok.com/@period.lk' );

	// ── Organization Schema ───────────────────────────────────────────────────
	update_option( 'rank_math_schema_Organization', [
		'@type'   => 'Organization',
		'name'    => 'period.lk',
		'url'     => 'https://period.lk',
		'logo'    => get_template_directory_uri() . '/assets/images/logo.png',
		'sameAs'  => [
			'https://facebook.com/periodlk',
			'https://instagram.com/period.lk',
			'https://tiktok.com/@period.lk',
			'https://linkedin.com/company/periodlk',
		],
	] );

	// ── Enable Breadcrumb Schema for all CPTs ─────────────────────────────────
	$post_types = array_keys( get_post_types( [ 'public' => true ] ) );
	$cpt_settings = (array) get_option( 'rank_math_post_type_settings', [] );
	foreach ( $post_types as $pt ) {
		$cpt_settings[ $pt ]['breadcrumbs'] = 1;
	}
	update_option( 'rank_math_post_type_settings', $cpt_settings );

	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		WP_CLI::success( 'Rank Math configured for period.lk.' );
	}
}

// Auto-run once on theme activation (idempotent — options are just overwritten)
add_action( 'after_switch_theme', 'periodlk_configure_rankmath' );
