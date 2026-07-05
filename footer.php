</main><!-- #main-content -->

<?php
/**
 * Elementor Pro Theme Builder support.
 * elementor_theme_do_location() echoes the published Footer template that
 * matches this request (if any) and returns true; if none matches, it
 * returns false and the coded footer below renders as an automatic
 * fallback. This wiring is also required for the Elementor editor itself
 * to be able to open/edit Footer templates at all (its preview iframe
 * looks for the wrapper this function outputs).
 */
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) :
?>

<!-- ── Site Footer ───────────────────────────────────────────── -->
<footer class="site-footer" role="contentinfo">

  <!-- Newsletter band -->
  <div class="footer-newsletter">
    <div class="container">
      <div class="footer-newsletter__inner">
        <div class="footer-newsletter__copy">
          <p class="eyebrow">Stay in the loop</p>
          <h2 class="footer-newsletter__heading">Care that feels like care</h2>
          <p class="footer-newsletter__sub">Period tips, new arrivals, and the occasional love note. No spam, ever.</p>
        </div>
        <?php echo periodlk_newsletter_form(); ?>
      </div>
    </div>
  </div>

  <!-- Footer grid -->
  <div class="footer-main">
    <div class="container">
      <div class="footer-grid">

        <!-- Brand column -->
        <div class="footer-col footer-col--brand">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
            <svg width="28" height="28" viewBox="0 0 32 32" fill="none" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
              <circle cx="16" cy="16" r="5" fill="#efcfd6"/>
              <ellipse cx="16" cy="8" rx="4" ry="7" fill="#fff7f3" opacity=".85"/>
              <ellipse cx="16" cy="24" rx="4" ry="7" fill="#fff7f3" opacity=".85"/>
              <ellipse cx="8" cy="16" rx="7" ry="4" fill="#fff7f3" opacity=".85"/>
              <ellipse cx="24" cy="16" rx="7" ry="4" fill="#fff7f3" opacity=".85"/>
              <ellipse cx="9.7" cy="9.7" rx="4" ry="7" fill="#e7c9d0" opacity=".7" transform="rotate(-45 9.7 9.7)"/>
              <ellipse cx="22.3" cy="22.3" rx="4" ry="7" fill="#e7c9d0" opacity=".7" transform="rotate(-45 22.3 22.3)"/>
            </svg>
            <span class="footer-logo__text">period<span class="footer-logo__dot">.</span>lk</span>
          </a>
          <p class="footer-tagline">Sri Lanka's home for reusable period panties, gentle period care and thoughtful gifting. Delivered to your door — discreetly, in cash.</p>
          <!-- Social -->
          <div class="footer-social" aria-label="<?php esc_attr_e( 'Social media', 'period-lk' ); ?>">
            <a href="https://www.instagram.com/period.lk" target="_blank" rel="noopener noreferrer" class="footer-social__link" aria-label="Instagram">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".8" fill="currentColor" stroke="none"/></svg>
            </a>
            <a href="https://www.facebook.com/period.lk" target="_blank" rel="noopener noreferrer" class="footer-social__link" aria-label="Facebook">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><path d="M18 2h-3a4 4 0 00-4 4v3H8v4h3v8h4v-8h3l1-4h-4V6a1 1 0 011-1h3z"/></svg>
            </a>
            <a href="https://wa.me/94701234567" target="_blank" rel="noopener noreferrer" class="footer-social__link" aria-label="WhatsApp">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
            </a>
          </div>
        </div>

        <!-- Shop column -->
        <div class="footer-col">
          <h3 class="footer-col__heading">Shop</h3>
          <ul class="footer-col__list">
            <li><a href="<?php echo esc_url( home_url( '/shop/period-panties/' ) ); ?>">Period panties · පීරියඩ් පැන්ටි</a></li>
            <li><a href="<?php echo esc_url( home_url( '/shop/period-care/' ) ); ?>">Period care</a></li>
            <li><a href="<?php echo esc_url( home_url( '/shop/lingerie/' ) ); ?>">Lingerie</a></li>
            <li><a href="<?php echo esc_url( home_url( '/shop/activewear/' ) ); ?>">Activewear</a></li>
            <li><a href="<?php echo esc_url( home_url( '/shop/swimwear/' ) ); ?>">Swimwear</a></li>
            <li><a href="<?php echo esc_url( home_url( '/shop/gifts/' ) ); ?>">Gifts &amp; hampers · තෑගි</a></li>
          </ul>
        </div>

        <!-- Help column -->
        <div class="footer-col">
          <h3 class="footer-col__heading">Help</h3>
          <ul class="footer-col__list">
            <li><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>">FAQ</a></li>
            <li><a href="<?php echo esc_url( home_url( '/sizing-guide/' ) ); ?>">Sizing guide</a></li>
            <li><a href="<?php echo esc_url( home_url( '/shipping-delivery/' ) ); ?>">Shipping &amp; delivery</a></li>
            <li><a href="<?php echo esc_url( home_url( '/returns/' ) ); ?>">Returns &amp; exchanges</a></li>
            <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact us</a></li>
            <li><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">My account</a></li>
          </ul>
        </div>

        <!-- About column -->
        <div class="footer-col">
          <h3 class="footer-col__heading">About</h3>
          <ul class="footer-col__list">
            <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">Our story</a></li>
            <li><a href="<?php echo esc_url( home_url( '/sustainability/' ) ); ?>">Sustainability</a></li>
            <li><a href="<?php echo esc_url( home_url( '/period-guide/' ) ); ?>">Period guide</a></li>
          </ul>
          <!-- Trust badges -->
          <div class="footer-trust">
            <div class="footer-trust__item">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
              <span>Secure checkout</span>
            </div>
            <div class="footer-trust__item">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v4h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
              <span>Discreet delivery</span>
            </div>
            <div class="footer-trust__item">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
              <span>Pay on delivery</span>
            </div>
          </div>
        </div>

      </div><!-- /.footer-grid -->
    </div><!-- /.container -->
  </div><!-- /.footer-main -->

  <!-- Footer bottom bar -->
  <div class="footer-bottom">
    <div class="container">
      <p class="footer-bottom__copy">
        &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> period.lk &mdash; Colombo, Sri Lanka.
        All prices in LKR. Reusable. Leak-proof. Yours.
      </p>
      <nav class="footer-bottom__legal" aria-label="<?php esc_attr_e( 'Legal', 'period-lk' ); ?>">
        <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy policy</a>
        <a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>">Terms</a>
        <a href="<?php echo esc_url( home_url( '/returns/' ) ); ?>">Returns</a>
      </nav>
    </div>
  </div>

</footer><!-- .site-footer -->

<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
