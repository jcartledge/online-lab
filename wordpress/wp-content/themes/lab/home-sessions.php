<?php
/**
 * Home page sessions template.
 *
 * @package lab
 */

use Carbon\Carbon;
include_once 'inc/sessions.php';

$sessions_url = site_url( '/sessions/' );

$current_session = get_current_session();
$is_current_session = $current_session->total();
if ( $is_current_session && $current_session->fetch() ) {
	$url = $current_session->field( 'permalink' );
} else {
	$next_session = get_next_session();
	$is_next_session = $next_session->total();
	if ( $is_next_session && $next_session->fetch() ) {
		$session_start_time = new Carbon( $next_session->field( 'session_start_time' ) );
		$url = $next_session->field( 'permalink' );
	}
}
if ( $is_current_session || $is_next_session ) : ?>
<div class="box">
	<p>
		<?php if ( $is_current_session ) : ?>
			The current session has started.
		<?php elseif ( $is_next_session ) : ?>
			Your next session is
			on <?php esc_html_e( $session_start_time->format( SESSION_DATETIME_FORMAT ) ); ?>.<br>
		<?php endif; ?>
		<a href="<?php echo esc_url( $url ); ?>">Go to the session now</a>.
	</p>
	<?php if ( empty( $show_all ) && filter_input( INPUT_SERVER, 'REQUEST_URI' ) !== $sessions_url ) : ?>
	<p><a href="<?php echo $sessions_url; // WPCS: XSS OK. ?>">See all sessions</a></p>
	<?php endif; ?>
</div>
<?php
else :
?>
<p>There are no upcoming sessions.</p>
<?php
endif;
?>
