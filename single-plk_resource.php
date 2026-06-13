<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="page-hero">
		<div class="container">
			<?php if ( function_exists( 'rank_math_the_breadcrumbs' ) ) rank_math_the_breadcrumbs(); ?>
			<p class="page-hero__eyebrow"><?php esc_html_e( 'Resource', 'period-lk' ); ?></p>
			<h1 class="page-hero__title"><?php the_title(); ?></h1>
		</div>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="container" style="margin-top:2rem;">
			<figure style="border-radius:var(--radius-lg);overflow:hidden;max-height:480px;">
				<?php the_post_thumbnail( 'period-desktop', [ 'loading' => 'eager', 'decoding' => 'async', 'fetchpriority' => 'high' ] ); ?>
			</figure>
		</div>
	<?php endif; ?>

	<div class="section">
		<div class="container">
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</div>
	</div>

</article>

<?php endwhile; ?>

<?php get_footer();
