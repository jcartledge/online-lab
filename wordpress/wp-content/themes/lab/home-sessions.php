<?php
/**
 * Home page sessions template.
 *
 * @package lab
 */

use Carbon\Carbon;
include_once 'inc/sessions.php';

$next_session = get_next_session();

if ( $next_session->fetch() ) :
	$session_start_time = new Carbon( $next_session->field( 'session_start_time' ) );
	$url = $next_session->field( 'permalink' );
?>
<div class="box">
	<p>
		Your next session is <?php esc_html_e( $session_start_time->diffForHumans() ); ?>,
		on <?php esc_html_e( $session_start_time->format( SESSION_DATETIME_FORMAT ) ); ?>.<br>
		<a href="<?php echo esc_url( $url ); ?>">Go to the session now</a>.
	</p>
	<?php if ( empty( $show_all ) && '/sessions/' !== filter_input( INPUT_SERVER, 'REQUEST_URI' ) ) : ?>
	<p><a href="/sessions">See all sessions</a></p>
	<?php endif; ?>
</div>
<?php
else :
?>
<p>There are no upcoming sessions.</p>
<?php
endif;
?>
