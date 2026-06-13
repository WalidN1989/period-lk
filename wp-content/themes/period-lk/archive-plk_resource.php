<?php get_header(); ?>

<header class="page-hero">
	<div class="container">
		<?php if ( function_exists( 'rank_math_the_breadcrumbs' ) ) rank_math_the_breadcrumbs(); ?>
		<p class="page-hero__eyebrow"><?php esc_html_e( 'Period.lk', 'period-lk' ); ?></p>
		<h1 class="page-hero__title"><?php esc_html_e( 'Resources', 'period-lk' ); ?></h1>
		<p class="page-hero__desc"><?php esc_html_e( 'Guides, articles and tools about menstrual health.', 'period-lk' ); ?></p>
	</div>
</header>

<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="grid-3">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="card__image">
								<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
									<?php the_post_thumbnail( 'period-tablet', [ 'loading' => 'lazy', 'decoding' => 'async' ] ); ?>
								</a>
							</div>
						<?php endif; ?>
						<div class="card__body">
							<h2 class="card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<div class="card__excerpt"><?php the_excerpt(); ?></div>
							<a class="btn btn--outline" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'period-lk' ); ?></a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<div class="pagination"><?php echo paginate_links( [ 'prev_text' => '&larr;', 'next_text' => '&rarr;' ] ); ?></div>
		<?php else : ?>
			<p class="text-center text-muted"><?php esc_html_e( 'No resources found.', 'period-lk' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer();
