<?php get_header(); ?>

<div class="not-found-page">
	<h1>404</h1>
	<h2><?php esc_html_e( 'Page not found', 'period-lk' ); ?></h2>
	<p class="text-muted"><?php esc_html_e( 'The page you were looking for doesn\'t exist.', 'period-lk' ); ?></p>
	<a class="btn btn--primary mt-md" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php esc_html_e( 'Back to Home', 'period-lk' ); ?>
	</a>
</div>

<?php get_footer();
