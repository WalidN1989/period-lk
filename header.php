<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#6a1b2a">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to content', 'period-lk' ); ?></a>

<!-- ── Announcement Bar ──────────────────────────────────────── -->
<div class="announcement-bar" role="region" aria-label="<?php esc_attr_e( 'Store announcements', 'period-lk' ); ?>">
  <div class="announcement-bar__track">
    <span class="announcement-bar__item">Free islandwide shipping over LKR 7,500</span>
    <span class="announcement-bar__sep" aria-hidden="true">·</span>
    <span class="announcement-bar__item">Discreet plain packaging, always</span>
    <span class="announcement-bar__sep" aria-hidden="true">·</span>
    <span class="announcement-bar__item">Cash on delivery available island-wide</span>
    <span class="announcement-bar__sep" aria-hidden="true">·</span>
    <span class="announcement-bar__item">නොමිලේ ද්වීපව්‍යාප්ත නැව්ගත කිරීම LKR 7,500 ට ඉහළින්</span>
    <span class="announcement-bar__sep" aria-hidden="true">·</span>
    <span class="announcement-bar__item">Free islandwide shipping over LKR 7,500</span>
    <span class="announcement-bar__sep" aria-hidden="true">·</span>
    <span class="announcement-bar__item">Discreet plain packaging, always</span>
    <span class="announcement-bar__sep" aria-hidden="true">·</span>
    <span class="announcement-bar__item">Cash on delivery available island-wide</span>
    <span class="announcement-bar__sep" aria-hidden="true">·</span>
    <span class="announcement-bar__item">නොමිලේ ද්වීපව්‍යාප්ත නැව්ගත කිරීම LKR 7,500 ට ඉහළින්</span>
  </div>
</div>

<!-- ── Store Header ──────────────────────────────────────────── -->
<header class="store-header" role="banner" id="site-header">
  <div class="store-header__inner container-wide">

    <!-- Logo -->
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="store-header__logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> — <?php esc_attr_e( 'Home', 'period-lk' ); ?>">
      <?php
      $logo_id = get_theme_mod( 'custom_logo' );
      if ( $logo_id ) {
          echo wp_get_attachment_image( $logo_id, 'full', false, [ 'class' => 'site-logo', 'alt' => get_bloginfo( 'name' ) ] );
      } else {
      ?>
        <svg class="site-logo-mark" width="32" height="32" viewBox="0 0 32 32" fill="none" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
          <circle cx="16" cy="16" r="5" fill="#f7e6ea"/>
          <ellipse cx="16" cy="8" rx="4" ry="7" fill="#6a1b2a" opacity=".85"/>
          <ellipse cx="16" cy="24" rx="4" ry="7" fill="#6a1b2a" opacity=".85"/>
          <ellipse cx="8" cy="16" rx="7" ry="4" fill="#6a1b2a" opacity=".85"/>
          <ellipse cx="24" cy="16" rx="7" ry="4" fill="#6a1b2a" opacity=".85"/>
          <ellipse cx="9.7" cy="9.7" rx="4" ry="7" fill="#8a3142" opacity=".7" transform="rotate(-45 9.7 9.7)"/>
          <ellipse cx="22.3" cy="22.3" rx="4" ry="7" fill="#8a3142" opacity=".7" transform="rotate(-45 22.3 22.3)"/>
        </svg>
        <span class="site-logo-text">period<span class="site-logo-dot">.</span>lk</span>
      <?php } ?>
    </a>

    <!-- Primary nav (desktop) -->
    <nav class="store-header__nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary', 'period-lk' ); ?>">
      <?php
      wp_nav_menu( [
          'theme_location' => 'primary',
          'menu_class'     => 'nav-list',
          'container'      => false,
          'fallback_cb'    => function () {
              echo '<ul class="nav-list">';
              $pages = [
                  'Period Panties' => '/product-category/period-panties/',
                  'Period Care'    => '/product-category/period-care/',
                  'Lingerie'       => '/product-category/lingerie/',
                  'Shop'           => '/shop/',
                  'Blog'           => '/blog/',
              ];
              foreach ( $pages as $label => $href ) {
                  printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( $href ) ), esc_html( $label ) );
              }
              echo '</ul>';
          },
      ] );
      ?>
    </nav>

    <!-- Header actions -->
    <div class="store-header__actions">
      <!-- Search -->
      <button class="header-icon-btn js-search-toggle" aria-label="<?php esc_attr_e( 'Search', 'period-lk' ); ?>" aria-expanded="false">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true">
          <circle cx="8.5" cy="8.5" r="5.5"/><path d="M15 15l3 3"/>
        </svg>
      </button>

      <!-- Account -->
      <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="header-icon-btn" aria-label="<?php esc_attr_e( 'My account', 'period-lk' ); ?>">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true">
          <circle cx="10" cy="7" r="3.5"/><path d="M2 17.5c0-4 3.6-7 8-7s8 3 8 7"/>
        </svg>
      </a>

      <!-- Wishlist -->
      <a href="<?php echo esc_url( home_url( '/wishlist/' ) ); ?>" class="header-icon-btn" aria-label="<?php esc_attr_e( 'Wishlist', 'period-lk' ); ?>">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true">
          <path d="M10 17s-7-4.5-7-9a4 4 0 018 0 4 4 0 018 0c0 4.5-7 9-7 9z"/>
        </svg>
      </a>

      <!-- Cart -->
      <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="header-icon-btn header-cart-btn" aria-label="<?php esc_attr_e( 'Shopping bag', 'period-lk' ); ?>">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true">
          <path d="M6 7V5a4 4 0 018 0v2"/><rect x="2" y="7" width="16" height="11" rx="2"/>
        </svg>
        <?php if ( function_exists( 'WC' ) && WC()->cart ) : ?>
          <span class="cart-badge <?php echo WC()->cart->get_cart_contents_count() > 0 ? 'is-visible' : ''; ?>" aria-live="polite">
            <?php echo intval( WC()->cart->get_cart_contents_count() ); ?>
          </span>
        <?php endif; ?>
      </a>

      <!-- Mobile menu toggle -->
      <button class="header-icon-btn header-menu-toggle js-menu-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'period-lk' ); ?>" aria-expanded="false" aria-controls="mobile-nav">
        <svg class="icon-menu" width="22" height="22" viewBox="0 0 22 22" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true">
          <path d="M3 6h16M3 11h16M3 16h16"/>
        </svg>
        <svg class="icon-close" width="22" height="22" viewBox="0 0 22 22" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true">
          <path d="M5 5l12 12M17 5L5 17"/>
        </svg>
      </button>
    </div>

  </div><!-- /.store-header__inner -->

  <!-- Mobile nav drawer -->
  <nav class="mobile-nav" id="mobile-nav" aria-label="<?php esc_attr_e( 'Mobile navigation', 'period-lk' ); ?>" hidden>
    <div class="mobile-nav__inner">
      <?php
      wp_nav_menu( [
          'theme_location' => 'primary',
          'menu_class'     => 'mobile-nav__list',
          'container'      => false,
          'fallback_cb'    => function () {
              echo '<ul class="mobile-nav__list">';
              $pages = [
                  'Period Panties' => '/product-category/period-panties/',
                  'Period Care'    => '/product-category/period-care/',
                  'Lingerie'       => '/product-category/lingerie/',
                  'Shop'           => '/shop/',
                  'Blog'           => '/blog/',
              ];
              foreach ( $pages as $label => $href ) {
                  printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( $href ) ), esc_html( $label ) );
              }
              echo '</ul>';
          },
      ] );
      ?>
    </div>
  </nav>

  <!-- Search overlay -->
  <div class="search-overlay js-search-overlay" hidden>
    <div class="search-overlay__inner container">
      <?php get_search_form(); ?>
      <button class="search-overlay__close js-search-close" aria-label="<?php esc_attr_e( 'Close search', 'period-lk' ); ?>">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true">
          <path d="M4 4l12 12M16 4L4 16"/>
        </svg>
      </button>
    </div>
  </div>
</header>

<main id="main-content" class="site-main">
