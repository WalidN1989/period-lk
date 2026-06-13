<?php
defined( 'ABSPATH' ) || exit;

// ─── Contact Form Processing ───────────────────────────────────────────────────

add_action( 'init', 'periodlk_contact_form_process' );
function periodlk_contact_form_process(): void {
	if (
		! isset( $_POST['periodlk_contact_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['periodlk_contact_nonce'] ) ), 'periodlk_contact_submit' )
	) {
		return;
	}

	// Honeypot: bots fill the hidden field, humans don't
	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'success', wp_get_referer() ) );
		exit;
	}

	$name    = sanitize_text_field( wp_unslash( $_POST['contact_name']    ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['contact_email']   ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ?? '' ) );
	$errors  = [];

	if ( empty( $name ) ) {
		$errors[] = 'name';
	}
	if ( empty( $email ) || ! is_email( $email ) ) {
		$errors[] = 'email';
	}
	if ( empty( $message ) ) {
		$errors[] = 'message';
	}

	if ( ! empty( $errors ) ) {
		$query = http_build_query( [
			'contact' => 'error',
			'fields'  => implode( ',', $errors ),
			// Re-surface safe values so the form can pre-fill
			'cn'      => $name,
			'ce'      => $email,
			'cm'      => $message,
		] );
		wp_safe_redirect( wp_get_referer() . '?' . $query );
		exit;
	}

	$admin_email  = 'contact@period.lk';
	$site_name    = get_bloginfo( 'name' );

	// Email to site admin
	$admin_subject = sprintf( '[%s] New contact message from %s', $site_name, $name );
	$admin_body    = sprintf(
		"You received a new contact message.\n\nName: %s\nEmail: %s\n\nMessage:\n%s\n",
		$name, $email, $message
	);
	wp_mail(
		$admin_email,
		$admin_subject,
		$admin_body,
		[
			'Content-Type: text/plain; charset=UTF-8',
			'Reply-To: ' . $name . ' <' . $email . '>',
		]
	);

	// Confirmation email to the user
	$user_subject = sprintf( 'We received your message — %s', $site_name );
	$user_body    = sprintf(
		"Hi %s,\n\nThank you for reaching out to Period.lk. We've received your message and will get back to you shortly.\n\nFor urgent matters, follow us on social media @period.lk.\n\nWarm regards,\nThe Period.lk Team\nhttps://period.lk\n",
		$name
	);
	wp_mail(
		$email,
		$user_subject,
		$user_body,
		[
			'Content-Type: text/plain; charset=UTF-8',
			'From: ' . $site_name . ' <' . $admin_email . '>',
		]
	);

	wp_safe_redirect( add_query_arg( 'contact', 'success', wp_get_referer() ) );
	exit;
}

/**
 * Render the contact form HTML.
 * Usage: echo periodlk_contact_form();
 *   or:  [contact_form] shortcode.
 */
function periodlk_contact_form(): string {
	$status  = sanitize_key( $_GET['contact'] ?? '' );
	$fields  = array_map( 'sanitize_key', explode( ',', sanitize_text_field( $_GET['fields'] ?? '' ) ) );
	$prev_name    = sanitize_text_field( wp_unslash( $_GET['cn'] ?? '' ) );
	$prev_email   = sanitize_email( wp_unslash( $_GET['ce'] ?? '' ) );
	$prev_message = sanitize_textarea_field( wp_unslash( $_GET['cm'] ?? '' ) );

	if ( 'success' === $status ) {
		return '<div class="contact-success" role="alert">'
			. esc_html__( 'Thank you! We\'ll be in touch.', 'period-lk' )
			. '</div>';
	}

	$has_error = fn( string $field ): bool => 'error' === $status && in_array( $field, $fields, true );
	$err_class = fn( string $field ): string => $has_error( $field ) ? ' has-error' : '';
	$err_msg   = fn( string $msg ): string  => '<span class="field-error" role="alert">' . esc_html( $msg ) . '</span>';

	ob_start();
	?>
	<form
		id="contact-form"
		class="contact-form"
		method="post"
		action="<?php echo esc_url( get_permalink() ); ?>"
		novalidate
	>
		<?php wp_nonce_field( 'periodlk_contact_submit', 'periodlk_contact_nonce' ); ?>

		<?php if ( 'error' === $status ) : ?>
		<div class="contact-error-summary" role="alert">
			<?php esc_html_e( 'Please correct the highlighted fields below.', 'period-lk' ); ?>
		</div>
		<?php endif; ?>

		<!-- Honeypot (hidden from real users via CSS/aria) -->
		<div class="contact-honeypot" aria-hidden="true">
			<label for="website">Leave this blank</label>
			<input
				type="text"
				id="website"
				name="website"
				tabindex="-1"
				autocomplete="off"
			>
		</div>

		<div class="form-group<?php echo esc_attr( $err_class( 'name' ) ); ?>">
			<label for="contact_name">
				<?php esc_html_e( 'Your Name', 'period-lk' ); ?>
				<span aria-hidden="true"> *</span>
			</label>
			<input
				type="text"
				id="contact_name"
				name="contact_name"
				value="<?php echo esc_attr( $prev_name ); ?>"
				required
				aria-required="true"
				autocomplete="name"
			>
			<?php if ( $has_error( 'name' ) ) echo $err_msg( 'Name is required.' ); ?>
		</div>

		<div class="form-group<?php echo esc_attr( $err_class( 'email' ) ); ?>">
			<label for="contact_email">
				<?php esc_html_e( 'Email Address', 'period-lk' ); ?>
				<span aria-hidden="true"> *</span>
			</label>
			<input
				type="email"
				id="contact_email"
				name="contact_email"
				value="<?php echo esc_attr( $prev_email ); ?>"
				required
				aria-required="true"
				autocomplete="email"
				inputmode="email"
			>
			<?php if ( $has_error( 'email' ) ) echo $err_msg( 'A valid email address is required.' ); ?>
		</div>

		<div class="form-group<?php echo esc_attr( $err_class( 'message' ) ); ?>">
			<label for="contact_message">
				<?php esc_html_e( 'Message', 'period-lk' ); ?>
				<span aria-hidden="true"> *</span>
			</label>
			<textarea
				id="contact_message"
				name="contact_message"
				rows="6"
				required
				aria-required="true"
			><?php echo esc_textarea( $prev_message ); ?></textarea>
			<?php if ( $has_error( 'message' ) ) echo $err_msg( 'Message cannot be empty.' ); ?>
		</div>

		<button type="submit" class="btn btn--primary">
			<?php esc_html_e( 'Send Message', 'period-lk' ); ?>
		</button>
	</form>
	<?php
	return ob_get_clean();
}

add_shortcode( 'contact_form', 'periodlk_contact_form' );
