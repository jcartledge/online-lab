<?php
/**
 * Home page sessions template.
 *
 * @package lab
 */

use Carbon\Carbon;

$sessions = pods( 'session' )->find([
	'where' => 'session_time.meta_value > NOW()',
	'orderby' => 'session_time.meta_value ASC',
	'limit' => 1,
]);
if ( $sessions->fetch() ) :
	$session_time = new Carbon( $sessions->field( 'session_time' ) );
	$url = $sessions->field( 'permalink' );
?>
<div class="box">
	<p>
		Your next session is <?php esc_html_e( $session_time->diffForHumans() ); ?>,
		on <?php esc_html_e( $session_time->format( 'l F j, g.iA' ) ); ?>.<br>
		<a href="<?php echo esc_url( $url ); ?>">Go to the session now</a>.
	</p>
	<p><a href="/sessions">See all sessions</a></p>
</div>
<?php
else :
?>
<p>There are no upcoming sessions.</p>
<?php
endif;
?>
