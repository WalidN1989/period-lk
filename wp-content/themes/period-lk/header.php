<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main-content"><?php esc_html_e( 'Skip to content', 'period-lk' ); ?></a>

<header class="site-header" role="banner">
	<div class="container">
		<div class="site-header__inner">

			<div class="site-logo">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a class="site-logo__text" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php bloginfo( 'name' ); ?>
					</a>
				<?php endif; ?>
			</div>

			<button
				class="nav-toggle"
				id="nav-toggle"
				aria-controls="primary-menu"
				aria-expanded="false"
				aria-label="<?php esc_attr_e( 'Toggle navigation', 'period-lk' ); ?>"
			>
				<span></span>
				<span></span>
				<span></span>
			</button>

			<nav class="primary-nav" id="primary-menu" aria-label="<?php esc_attr_e( 'Primary', 'period-lk' ); ?>" aria-hidden="true">
				<?php
				wp_nav_menu( [
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => false,
				] );
				?>
			</nav>

		</div>
	</div>
</header>

<main id="main-content" class="site-main" role="main">
