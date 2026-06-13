<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>

	<header class="page-hero">
		<div class="container">
			<?php if ( function_exists( 'rank_math_the_breadcrumbs' ) ) rank_math_the_breadcrumbs(); ?>
			<p class="page-hero__eyebrow">
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
			</p>
			<h1 class="page-hero__title"><?php the_title(); ?></h1>
		</div>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="container" style="margin-top:2rem;">
			<figure class="post-thumbnail" style="border-radius:var(--radius-lg);overflow:hidden;max-height:480px;">
				<?php the_post_thumbnail( 'period-desktop', [ 'loading' => 'eager', 'decoding' => 'async', 'fetchpriority' => 'high' ] ); ?>
			</figure>
		</div>
	<?php endif; ?>

	<div class="section">
		<div class="container">
			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<?php
			$tags = get_the_tags();
			if ( $tags ) :
				echo '<div class="post-tags" style="margin-top:2rem;display:flex;flex-wrap:wrap;gap:.5rem;">';
				foreach ( $tags as $tag ) {
					echo '<a href="' . esc_url( get_tag_link( $tag ) ) . '" class="btn btn--outline" style="font-size:.8125rem;min-height:36px;padding:.35rem .875rem;">'
						. esc_html( $tag->name ) . '</a>';
				}
				echo '</div>';
			endif;
			?>
		</div>
	</div>

</article>

<?php endwhile; ?>

<?php get_footer();
