<?php
/**
 * The template for displaying future sessions.
 *
 * @package lab
 */

include_once 'inc/sessions.php';

$future_sessions = get_user_future_sessions();
$future_sessions_count = $future_sessions->total();

if ( $future_sessions_count > 0 ) : ?>
	<div class="box">
		Upcoming sessions
		<?php while ( $future_sessions->fetch() ) :
			echo session_detail( $future_sessions ); // WPCS: XSS OK.
		endwhile; ?>
	</div>
<?php else : ?>
	<p>There are no upcoming sessions.</p>
<?php endif; ?>
