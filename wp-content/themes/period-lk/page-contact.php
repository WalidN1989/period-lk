<?php
/**
 * Template Name: Contact Page
 */
get_header(); ?>

<header class="page-hero">
	<div class="container">
		<?php if ( function_exists( 'rank_math_the_breadcrumbs' ) ) rank_math_the_breadcrumbs(); ?>
		<p class="page-hero__eyebrow"><?php esc_html_e( 'Get In Touch', 'period-lk' ); ?></p>
		<h1 class="page-hero__title"><?php the_title(); ?></h1>
		<p class="page-hero__desc">
			<?php esc_html_e( 'Have a question, partnership enquiry, or just want to say hello? Send us a message and we\'ll get back to you.', 'period-lk' ); ?>
		</p>
	</div>
</header>

<section class="section">
	<div class="container">
		<div class="contact-form-wrapper">
			<?php echo periodlk_contact_form(); ?>
		</div>
	</div>
</section>

<?php get_footer();
