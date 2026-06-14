<?php
/**
 * Template: Standard page
 * Elementor-compatible: when Elementor controls this page, it calls the_content()
 * which triggers Elementor's own render pipeline.
 */

// If Elementor is managing this page, use its full-width canvas
if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) {
    return;
}

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<?php
// If Elementor has content for this page, skip the page-hero wrapper
$el_data = get_post_meta( get_the_ID(), '_elementor_data', true );
$has_elementor = ! empty( $el_data ) && $el_data !== '[]' && get_post_meta( get_the_ID(), '_elementor_edit_mode', true ) === 'builder';
?>

<?php if ( ! $has_elementor ) : ?>
<div class="page-hero">
  <div class="container">
    <h1 class="page-hero__title"><?php the_title(); ?></h1>
  </div>
</div>
<div class="page-content">
  <div class="container-narrow entry-content">
    <?php the_content(); ?>
  </div>
</div>

<?php else : ?>
<div class="elementor-page-content">
  <?php the_content(); ?>
</div>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>
