<?php
/**
 * The template for displaying past sessions.
 *
 * @package lab
 */

include_once 'inc/sessions.php';

$show_all = isset( $_GET['show_all'] );
$past_sessions = get_user_past_sessions();
$past_sessions_count = $past_sessions->total();
if ( $past_sessions_count > 0 ) :
	if ( $show_all ) : ?>
		<div class="box">
			Past sessions
			<?php while ( $past_sessions->fetch() ) :
				echo session_detail( $past_sessions );
			endwhile; ?>
			<a href="/sessions/">Hide past sessions</a>
		</div>
	<?php else : ?>
		<p>
			<?php esc_html_e( ucfirst( inflect( $past_sessions_count, 'session has ', 'sessions have ' ) ) ); ?>
			already taken place. <a class="unimplemented" href="?show_all">Show past sessions</a>.
		</p>
	<?php endif;
endif; ?>
