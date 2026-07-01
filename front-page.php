<?php
/**
 * Template: Homepage (front-page.php)
 *
 * When Elementor has built this page, the_content() triggers Elementor rendering.
 * Otherwise we show the native Sojourn design homepage.
 */

get_header();

$front_id   = get_option( 'page_on_front' );
$el_data    = get_post_meta( $front_id, '_elementor_data', true );
$has_el     = ! empty( $el_data ) && $el_data !== '[]'
              && get_post_meta( $front_id, '_elementor_edit_mode', true ) === 'builder';
$is_preview = defined( 'ELEMENTOR_VERSION' )
              && \Elementor\Plugin::$instance->preview->is_preview_mode();

if ( $is_preview ) :
    /* ── Elementor live-editor preview: let Elementor render in-place ── */
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;

elseif ( $has_el ) :
    /* ── Elementor-managed homepage ──
     * front-page.php runs after wp_head is flushed, so the_content() can't
     * enqueue the page CSS in time. get_builder_content_for_display( id, true )
     * returns the builder markup with its CSS embedded inline, so styling is
     * reliable in this custom-template context. */
    echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $front_id, true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

else :
    /* ── Native Sojourn homepage ───────────────────────────── */
?>

<!-- ── Hero ─────────────────────────────────────────────────── -->
<section class="hero" aria-label="<?php esc_attr_e( 'Homepage hero', 'period-lk' ); ?>">
  <div class="container hero__inner">
    <div class="hero__copy">
      <p class="eyebrow hero__eyebrow">Sri Lanka's period care store</p>
      <h1 class="hero__heading">
        Care that feels<br><em>like care.</em>
      </h1>
      <p class="hero__body">
        Reusable, leak-proof period panties and gentle period care — delivered to your door, discreetly,
        with cash on delivery. <span lang="si">ඔබට ශ්‍රී ලංකාවේ හොඳම කාල සැලකිල්ල.</span>
      </p>
      <div class="hero__actions">
        <a href="<?php echo esc_url( home_url( '/shop/period-panties/' ) ); ?>" class="btn btn--primary btn--pill btn--lg">
          Shop period panties
        </a>
        <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="btn btn--outline btn--pill btn--lg">
          Our story
        </a>
      </div>
    </div>
    <div class="hero__media" aria-hidden="true">
      <?php
      $hero_imgs = [
          wc_placeholder_img_src( 'category-tile' ),
          wc_placeholder_img_src( 'category-tile' ),
      ];
      foreach ( $hero_imgs as $img ) {
          echo '<div class="hero__media-img"><img src="' . esc_url( $img ) . '" alt="" loading="lazy"></div>';
      }
      ?>
    </div>
  </div>
</section>

<!-- ── Categories ────────────────────────────────────────────── -->
<section class="categories-section" aria-labelledby="cat-heading">
  <div class="container-wide">
    <div class="section-header">
      <p class="eyebrow">Shop by need</p>
      <h2 class="section-header__heading" id="cat-heading">Everything she needs</h2>
    </div>
    <div class="category-grid">
      <?php
      $categories = [
          [ 'name' => 'Period panties', 'si' => 'පීරියඩ් පැන්ටි', 'slug' => 'period-panties' ],
          [ 'name' => 'Period care',    'si' => 'කාල සැලකිල්ල',    'slug' => 'period-care' ],
          [ 'name' => 'Lingerie',       'si' => 'ලිංජරි',           'slug' => 'lingerie' ],
          [ 'name' => 'Gifts',          'si' => 'තෑගි',             'slug' => 'gifts' ],
      ];
      foreach ( $categories as $cat ) :
          $term = get_term_by( 'slug', $cat['slug'], 'product_cat' );
          $url  = $term ? get_term_link( $term ) : home_url( '/shop/' );
          $img  = '';
          if ( $term ) {
              $thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
              if ( $thumb_id ) $img = wp_get_attachment_image_url( $thumb_id, 'category-tile' );
          }
      ?>
      <a href="<?php echo esc_url( $url ); ?>" class="category-tile">
        <?php if ( $img ) : ?>
          <img class="category-tile__img" src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $cat['name'] ); ?>" loading="lazy">
        <?php endif; ?>
        <div class="category-tile__overlay"></div>
        <div class="category-tile__body">
          <span class="category-tile__sinhala" lang="si"><?php echo esc_html( $cat['si'] ); ?></span>
          <span class="category-tile__name"><?php echo esc_html( $cat['name'] ); ?></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── Bestsellers ───────────────────────────────────────────── -->
<section class="products-section" aria-labelledby="bestsellers-heading">
  <div class="container-wide">
    <div class="section-header">
      <p class="eyebrow">Most loved</p>
      <h2 class="section-header__heading" id="bestsellers-heading">Bestsellers</h2>
      <p class="section-header__sub">What your sisters are buying this week.</p>
    </div>
    <?php
    if ( class_exists( 'WooCommerce' ) ) {
        echo do_shortcode( '[products limit="4" columns="4" orderby="popularity" order="DESC"]' );
    }
    ?>
    <div class="text-center" style="margin-top:var(--space-xxl)">
      <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn--outline btn--pill">
        View all products
      </a>
    </div>
  </div>
</section>

<!-- ── Value band ────────────────────────────────────────────── -->
<section class="value-band" aria-label="<?php esc_attr_e( 'Why period.lk', 'period-lk' ); ?>">
  <div class="container">
    <div class="value-band__grid">
      <div class="value-item">
        <div class="value-item__icon" aria-hidden="true">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v4h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        </div>
        <h3 class="value-item__title">Free islandwide shipping</h3>
        <p class="value-item__body">Free delivery on orders over LKR 7,500. Cash on delivery everywhere in Sri Lanka.</p>
      </div>
      <div class="value-item">
        <div class="value-item__icon" aria-hidden="true">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <h3 class="value-item__title">Plain, discreet packaging</h3>
        <p class="value-item__body">No branding on the outside. What's inside is between you and your door.</p>
      </div>
      <div class="value-item">
        <div class="value-item__icon" aria-hidden="true">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/><path d="M8 12l3 3 5-5"/></svg>
        </div>
        <h3 class="value-item__title">Reusable, planet-friendly</h3>
        <p class="value-item__body">One pair of period panties replaces hundreds of single-use pads. Better for you, better for the earth.</p>
      </div>
    </div>
  </div>
</section>

<!-- ── Gifting band ──────────────────────────────────────────── -->
<section class="gifting-band" aria-labelledby="gifting-heading">
  <div class="container gifting-band__inner">
    <div class="gifting-band__copy">
      <p class="eyebrow">Gifts &amp; hampers · <span lang="si">තෑගි</span></p>
      <h2 class="gifting-band__heading" id="gifting-heading">The gift she actually wants.</h2>
      <p class="gifting-band__body">
        Build a thoughtful hamper — period panties, skin care, a journal.
        Perfect for birthdays, self-care kits, and "I've got you" moments.
      </p>
      <a href="<?php echo esc_url( home_url( '/shop/gifts/' ) ); ?>" class="btn btn--ghost btn--pill">
        Build a hamper
      </a>
    </div>
    <div class="gifting-band__media" aria-hidden="true">
      <div class="gifting-band__media-img"></div>
      <div class="gifting-band__media-img" style="margin-top:32px"></div>
    </div>
  </div>
</section>

<!-- ── Testimonial ───────────────────────────────────────────── -->
<section class="testimonial-section" aria-label="<?php esc_attr_e( 'Customer review', 'period-lk' ); ?>">
  <div class="container">
    <div class="section-header">
      <p class="eyebrow">Real reviews</p>
      <h2 class="section-header__heading">What she said</h2>
    </div>
    <div class="testimonial-card">
      <div class="testimonial-card__stars" aria-label="<?php esc_attr_e( '5 stars', 'period-lk' ); ?>">
        <?php for ( $i = 0; $i < 5; $i++ ) : ?>
          <svg width="18" height="18" viewBox="0 0 18 18" aria-hidden="true"><path d="M9 1l2.3 4.6 5.1.7-3.7 3.6.9 5.1L9 12.6 4.4 15l.9-5.1L1.6 6.3l5.1-.7z"/></svg>
        <?php endfor; ?>
      </div>
      <blockquote class="testimonial-card__quote">
        &ldquo;I was sceptical at first but now I won't go back. The leakproof
        lining is incredible and I love that it arrived in a plain box.&rdquo;
      </blockquote>
      <p class="testimonial-card__author">Dilini R. &mdash; Colombo</p>
    </div>
  </div>
</section>

<?php
endif; /* end Elementor / native conditional */
get_footer();
?>
