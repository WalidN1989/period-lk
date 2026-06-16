<?php
/**
 * Template: Blog Index (home.php)
 * Sojourn Journal — "Real talk. No taboo."
 */
get_header();

$all_count  = (int) wp_count_posts()->publish;
$categories = get_categories( [
    'hide_empty' => true,
    'exclude'    => get_option( 'default_category' ),
] );
?>

<!-- ── Journal hero ────────────────────────────────────────── -->
<section class="journal-hero" aria-label="<?php esc_attr_e( 'The Journal', 'period-lk' ); ?>">
  <div class="container">
    <p class="eyebrow">The Journal</p>
    <h1 class="journal-hero__heading">Real talk. No taboo.</h1>
    <p class="journal-hero__sub">Cycle care, intimate wellness and body talk for Sri Lankan women.</p>

    <?php if ( $categories ) : ?>
    <div class="journal-filters" role="tablist" aria-label="<?php esc_attr_e( 'Filter by category', 'period-lk' ); ?>">
      <button class="journal-filter is-active" data-filter="all" role="tab" aria-selected="true">
        All <span class="journal-filter__count">(<?php echo $all_count; ?>)</span>
      </button>
      <?php foreach ( $categories as $cat ) : ?>
        <button class="journal-filter" data-filter="cat-<?php echo esc_attr( $cat->term_id ); ?>" role="tab" aria-selected="false">
          <?php echo esc_html( $cat->name ); ?> <span class="journal-filter__count">(<?php echo intval( $cat->count ); ?>)</span>
        </button>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- ── Journal grid ─────────────────────────────────────────── -->
<section class="journal-grid-section">
  <div class="container-wide">
    <?php if ( have_posts() ) : ?>
      <div class="journal-grid" id="journal-grid">
        <?php while ( have_posts() ) : the_post();
          $cats      = get_the_category();
          $cat_ids   = implode( ' ', array_map( fn( $c ) => 'cat-' . $c->term_id, $cats ) );
          $cat_label = $cats ? $cats[0]->name : '';
        ?>
          <article class="journal-card <?php echo esc_attr( $cat_ids ); ?>">
            <a href="<?php the_permalink(); ?>" class="journal-card__link">

              <div class="journal-card__media">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail( 'medium_large', [ 'class' => 'journal-card__img', 'loading' => 'lazy', 'alt' => get_the_title() ] ); ?>
                <?php else : ?>
                  <div class="journal-card__placeholder" aria-hidden="true"></div>
                <?php endif; ?>
              </div>

              <div class="journal-card__body">
                <?php if ( $cat_label ) : ?>
                  <span class="journal-card__cat"><?php echo esc_html( strtoupper( $cat_label ) ); ?></span>
                <?php endif; ?>
                <h2 class="journal-card__title"><?php the_title(); ?></h2>
              </div>

            </a>
          </article>
        <?php endwhile; ?>
      </div>

      <div class="journal-pagination">
        <?php the_posts_pagination( [ 'mid_size' => 2, 'prev_text' => '←', 'next_text' => '→' ] ); ?>
      </div>

    <?php else : ?>
      <p class="journal-empty">No articles yet — check back soon.</p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
