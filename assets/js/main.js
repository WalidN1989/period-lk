/* period.lk — main.js | Sojourn v3.0.0 */
(function ($) {
  'use strict';

  /* ── Sticky header shadow ──────────────────────────────────── */
  const header = document.getElementById('site-header');
  if (header) {
    const onScroll = () => header.classList.toggle('is-scrolled', window.scrollY > 8);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ── Mobile menu toggle ────────────────────────────────────── */
  const menuToggle = document.querySelector('.js-menu-toggle');
  const mobileNav  = document.getElementById('mobile-nav');
  if (menuToggle && mobileNav) {
    menuToggle.addEventListener('click', () => {
      const isOpen = mobileNav.hidden === false;
      mobileNav.hidden = isOpen;
      menuToggle.setAttribute('aria-expanded', String(!isOpen));
      document.querySelector('.icon-menu').style.display = isOpen ? '' : 'none';
      document.querySelector('.icon-close').style.display = isOpen ? 'none' : '';
    });
  }

  /* ── Search overlay ─────────────────────────────────────────── */
  const searchToggle  = document.querySelector('.js-search-toggle');
  const searchOverlay = document.querySelector('.js-search-overlay');
  const searchClose   = document.querySelector('.js-search-close');

  function openSearch() {
    if (!searchOverlay) return;
    searchOverlay.hidden = false;
    searchToggle && searchToggle.setAttribute('aria-expanded', 'true');
    const field = searchOverlay.querySelector('.search-field');
    if (field) setTimeout(() => field.focus(), 50);
  }
  function closeSearch() {
    if (!searchOverlay) return;
    searchOverlay.hidden = true;
    searchToggle && searchToggle.setAttribute('aria-expanded', 'false');
  }

  if (searchToggle) searchToggle.addEventListener('click', openSearch);
  if (searchClose)  searchClose.addEventListener('click', closeSearch);
  if (searchOverlay) {
    searchOverlay.addEventListener('click', (e) => { if (e.target === searchOverlay) closeSearch(); });
  }
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeSearch(); });

  /* ── WooCommerce cart badge live update ─────────────────────── */
  $(document.body).on('wc_fragments_refreshed added_to_cart removed_from_cart', function () {
    const badge = document.querySelector('.cart-badge');
    if (!badge || typeof wc_cart_params === 'undefined') return;
    const count = parseInt(wc_cart_params.cart_count || 0, 10);
    badge.textContent = count;
    badge.classList.toggle('is-visible', count > 0);
  });

}(window.jQuery || { fn: {}, on: () => {} }));
