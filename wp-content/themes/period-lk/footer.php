</main><!-- #main-content -->

<footer class="site-footer" role="contentinfo">
	<div class="container">
		<div class="footer-grid">

			<div class="footer-col">
				<h3><?php bloginfo( 'name' ); ?></h3>
				<p><?php bloginfo( 'description' ); ?></p>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Quick Links', 'period-lk' ); ?></h4>
				<?php
				wp_nav_menu( [
					'theme_location' => 'footer',
					'container'      => false,
					'fallback_cb'    => false,
					'depth'          => 1,
				] );
				?>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Follow Us', 'period-lk' ); ?></h4>
				<ul class="social-links" style="list-style:none;padding:0;display:flex;flex-direction:column;gap:.5rem;">
					<li><a href="https://facebook.com/periodlk" rel="noopener noreferrer" aria-label="Facebook">Facebook</a></li>
					<li><a href="https://instagram.com/period.lk" rel="noopener noreferrer" aria-label="Instagram">Instagram</a></li>
					<li><a href="https://tiktok.com/@period.lk" rel="noopener noreferrer" aria-label="TikTok">TikTok</a></li>
					<li><a href="https://linkedin.com/company/periodlk" rel="noopener noreferrer" aria-label="LinkedIn">LinkedIn</a></li>
				</ul>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Contact', 'period-lk' ); ?></h4>
				<p><a href="mailto:contact@period.lk">contact@period.lk</a></p>
				<p><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>"><?php esc_html_e( 'Send us a message →', 'period-lk' ); ?></a></p>
			</div>

		</div>

		<div class="footer-bottom">
			<p>
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
				<?php esc_html_e( 'All rights reserved.', 'period-lk' ); ?>
			</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
