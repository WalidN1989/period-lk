<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<?php
$categories = get_the_category();
$primary_cat = $categories ? $categories[0] : null;
$word_count  = str_word_count( wp_strip_all_tags( get_the_content() ) );
$read_min    = max( 1, (int) ceil( $word_count / 200 ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article' ); ?>>

	<header class="article-hero">
		<div class="container-narrow">
			<?php if ( function_exists( 'rank_math_the_breadcrumbs' ) ) rank_math_the_breadcrumbs(); ?>

			<?php if ( $primary_cat ) : ?>
				<a class="article-hero__cat" href="<?php echo esc_url( get_category_link( $primary_cat ) ); ?>">
					<?php echo esc_html( $primary_cat->name ); ?>
				</a>
			<?php endif; ?>

			<h1 class="article-hero__title"><?php the_title(); ?></h1>

			<div class="article-hero__meta">
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
				<span class="article-hero__dot" aria-hidden="true">&middot;</span>
				<span><?php printf( esc_html__( '%d min read', 'period-lk' ), $read_min ); ?></span>
			</div>
		</div>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="container-narrow">
			<figure class="article-cover">
				<?php the_post_thumbnail( 'period-desktop', [ 'loading' => 'eager', 'decoding' => 'async', 'fetchpriority' => 'high' ] ); ?>
			</figure>
		</div>
	<?php endif; ?>

	<div class="article-body">
		<div class="container-narrow">
			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<?php
			wp_link_pages( [
				'before' => '<div class="article-pagelinks">' . esc_html__( 'Pages:', 'period-lk' ),
				'after'  => '</div>',
			] );
			?>

			<?php
			$tags = get_the_tags();
			if ( $tags ) :
				echo '<div class="article-tags">';
				foreach ( $tags as $tag ) {
					echo '<a href="' . esc_url( get_tag_link( $tag ) ) . '" class="article-tag">'
						. esc_html( $tag->name ) . '</a>';
				}
				echo '</div>';
			endif;
			?>

			<footer class="article-byline">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 56, '', '', [ 'class' => 'article-byline__avatar' ] ); ?>
				<div class="article-byline__text">
					<span class="article-byline__label"><?php esc_html_e( 'Written by', 'period-lk' ); ?></span>
					<span class="article-byline__name"><?php the_author(); ?></span>
					<?php if ( get_the_author_meta( 'description' ) ) : ?>
						<p class="article-byline__bio"><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
					<?php endif; ?>
				</div>
			</footer>
		</div>
	</div>

	<?php
	/* ── Related posts ─────────────────────────────────────────── */
	$related_args = [
		'post_type'           => 'post',
		'posts_per_page'      => 3,
		'post__not_in'        => [ get_the_ID() ],
		'ignore_sticky_posts' => 1,
		'no_found_rows'       => true,
	];
	if ( $primary_cat ) {
		$related_args['cat'] = $primary_cat->term_id;
	}
	$related = new WP_Query( $related_args );

	if ( $related->have_posts() ) : ?>
		<section class="article-related">
			<div class="container">
				<h2 class="article-related__heading"><?php esc_html_e( 'Keep reading', 'period-lk' ); ?></h2>
				<div class="journal-grid">
					<?php while ( $related->have_posts() ) : $related->the_post(); ?>
						<article class="journal-card">
							<a class="journal-card__link" href="<?php the_permalink(); ?>">
								<div class="journal-card__media">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'medium_large', [ 'class' => 'journal-card__img', 'loading' => 'lazy' ] ); ?>
									<?php else : ?>
										<div class="journal-card__placeholder"></div>
									<?php endif; ?>
								</div>
								<div class="journal-card__body">
									<?php
									$rc = get_the_category();
									if ( $rc ) : ?>
										<span class="journal-card__cat"><?php echo esc_html( $rc[0]->name ); ?></span>
									<?php endif; ?>
									<h3 class="journal-card__title"><?php the_title(); ?></h3>
								</div>
							</a>
						</article>
					<?php endwhile; ?>
				</div>
			</div>
		</section>
	<?php endif;
	wp_reset_postdata();
	?>

</article>

<?php endwhile; ?>

<?php get_footer();
