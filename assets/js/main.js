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
  const iconMenu   = menuToggle && menuToggle.querySelector('.icon-menu');
  const iconClose  = menuToggle && menuToggle.querySelector('.icon-close');

  function openMenu() {
    if (!mobileNav) return;
    mobileNav.removeAttribute('hidden');
    menuToggle.setAttribute('aria-expanded', 'true');
    if (iconMenu)  iconMenu.style.display  = 'none';
    if (iconClose) iconClose.style.display = '';
    document.body.style.overflow = 'hidden';
  }

  function closeMenu() {
    if (!mobileNav) return;
    mobileNav.setAttribute('hidden', '');
    menuToggle.setAttribute('aria-expanded', 'false');
    if (iconMenu)  iconMenu.style.display  = '';
    if (iconClose) iconClose.style.display = 'none';
    document.body.style.overflow = '';
  }

  if (menuToggle) {
    menuToggle.addEventListener('click', () => {
      const isOpen = !mobileNav.hasAttribute('hidden');
      isOpen ? closeMenu() : openMenu();
    });
  }

  /* Close menu on nav link click */
  if (mobileNav) {
    mobileNav.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));
  }

  /* Close on Escape */
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') { closeMenu(); closeSearch(); }
  });

  /* ── Search overlay ─────────────────────────────────────────── */
  const searchToggle  = document.querySelector('.js-search-toggle');
  const searchOverlay = document.querySelector('.js-search-overlay');
  const searchClose   = document.querySelector('.js-search-close');

  function openSearch() {
    if (!searchOverlay) return;
    searchOverlay.removeAttribute('hidden');
    searchToggle && searchToggle.setAttribute('aria-expanded', 'true');
    const field = searchOverlay.querySelector('.search-field');
    if (field) setTimeout(() => field.focus(), 50);
  }
  function closeSearch() {
    if (!searchOverlay) return;
    searchOverlay.setAttribute('hidden', '');
    searchToggle && searchToggle.setAttribute('aria-expanded', 'false');
  }

  if (searchToggle) searchToggle.addEventListener('click', openSearch);
  if (searchClose)  searchClose.addEventListener('click', closeSearch);
  if (searchOverlay) {
    searchOverlay.addEventListener('click', (e) => { if (e.target === searchOverlay) closeSearch(); });
  }

  /* ── Journal category filter ───────────────────────────────── */
  const journalFilters = document.querySelectorAll('.journal-filter');
  if (journalFilters.length) {
    journalFilters.forEach(function (btn) {
      btn.addEventListener('click', function () {
        const filter = this.dataset.filter;
        journalFilters.forEach(function (b) {
          b.classList.remove('is-active');
          b.setAttribute('aria-selected', 'false');
        });
        this.classList.add('is-active');
        this.setAttribute('aria-selected', 'true');
        document.querySelectorAll('.journal-card').forEach(function (card) {
          if (filter === 'all' || card.classList.contains(filter)) {
            card.classList.remove('is-hidden');
          } else {
            card.classList.add('is-hidden');
          }
        });
      });
    });
  }

  /* ── WooCommerce cart badge ─────────────────────────────────── */
  $(document.body).on('wc_fragments_refreshed added_to_cart removed_from_cart', function () {
    const badge = document.querySelector('.cart-badge');
    if (!badge || typeof wc_cart_params === 'undefined') return;
    const count = parseInt(wc_cart_params.cart_count || 0, 10);
    badge.textContent = count;
    badge.classList.toggle('is-visible', count > 0);
  });

}(window.jQuery || { fn: {}, on: function() {} }));
