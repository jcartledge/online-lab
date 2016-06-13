<?php
/**
 * Home page projects template.
 *
 * @package lab
 */

require_logged_in_user();

require_once 'inc/sessions.php';
require_once 'inc/projects.php';

$session = get_next_session();
if ( $session->total() ) :
	$projects = get_projects_for_session( $session ); ?>

	<div class="box">
		<?php echo session_detail( $session, 'Session: ' ); // WPCS: XSS OK. ?>
		<?php while ( $projects->fetch() ) :
			echo project_detail( $projects, true, 'Project: ' ); // WPCS: XSS OK.
		endwhile; ?>
	</div>

<?php endif;
