<?php get_header(); ?>

<section class="error-404 section">
	<div class="container">
		<h1>404</h1>
		<h2 style="font:var(--type-display-md);font-family:var(--font-serif);color:var(--color-ink);margin-bottom:var(--space-md);">
			<?php esc_html_e( 'Page not found', 'period-lk' ); ?>
		</h2>
		<p style="font:var(--type-body-lg);font-family:var(--font-sans);color:var(--color-muted);max-width:460px;margin:0 auto;">
			<?php esc_html_e( 'The page you were looking for doesn\'t exist — it may have moved, or the link was mistyped. Here are some good places to go instead.', 'period-lk' ); ?>
		</p>

		<div style="display:flex;flex-wrap:wrap;gap:12px;justify-content:center;margin-top:var(--space-xl);">
			<a class="btn btn--primary btn--pill" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Back to Home', 'period-lk' ); ?>
			</a>
			<a class="btn btn--outline btn--pill" href="<?php echo esc_url( home_url( '/shop/' ) ); ?>">
				<?php esc_html_e( 'Shop period care', 'period-lk' ); ?>
			</a>
			<a class="btn btn--outline btn--pill" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">
				<?php esc_html_e( 'Read the blog', 'period-lk' ); ?>
			</a>
		</div>

		<div style="max-width:420px;margin:var(--space-xl) auto 0;">
			<?php get_search_form(); ?>
		</div>
	</div>
</section>

<?php get_footer();
