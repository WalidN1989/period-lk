<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="page-hero">
		<div class="container">
			<?php if ( function_exists( 'rank_math_the_breadcrumbs' ) ) rank_math_the_breadcrumbs(); ?>
			<h1 class="page-hero__title"><?php the_title(); ?></h1>
		</div>
	</header>

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
