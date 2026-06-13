<?php get_header(); ?>

<section class="page-hero">
	<div class="container">
		<?php if ( is_home() && ! is_front_page() ) : ?>
			<p class="page-hero__eyebrow"><?php esc_html_e( 'Blog', 'period-lk' ); ?></p>
			<h1 class="page-hero__title"><?php esc_html_e( 'Latest Articles', 'period-lk' ); ?></h1>
		<?php elseif ( is_archive() ) : ?>
			<p class="page-hero__eyebrow"><?php esc_html_e( 'Archive', 'period-lk' ); ?></p>
			<h1 class="page-hero__title"><?php the_archive_title(); ?></h1>
			<?php the_archive_description( '<p class="page-hero__desc">', '</p>' ); ?>
		<?php elseif ( is_search() ) : ?>
			<h1 class="page-hero__title">
				<?php printf( esc_html__( 'Search results for: %s', 'period-lk' ), '<em>' . esc_html( get_search_query() ) . '</em>' ); ?>
			</h1>
		<?php else : ?>
			<h1 class="page-hero__title"><?php esc_html_e( 'Latest Articles', 'period-lk' ); ?></h1>
		<?php endif; ?>
	</div>
</section>

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
							<p class="card__meta">
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
									<?php echo esc_html( get_the_date() ); ?>
								</time>
							</p>
							<h2 class="card__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
							<?php if ( has_excerpt() ) : ?>
								<div class="card__excerpt"><?php the_excerpt(); ?></div>
							<?php endif; ?>
							<a class="btn btn--outline" href="<?php the_permalink(); ?>">
								<?php esc_html_e( 'Read more', 'period-lk' ); ?>
							</a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<div class="pagination">
				<?php
				echo paginate_links( [
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
				] );
				?>
			</div>

		<?php else : ?>
			<p class="text-center text-muted"><?php esc_html_e( 'No posts found.', 'period-lk' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer();
