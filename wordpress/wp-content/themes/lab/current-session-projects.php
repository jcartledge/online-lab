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
if ( 1 === $session->total() ) :
	$projects = get_projects_for_session( $session ); ?>

	<div class="box">
		<?php echo session_detail( $session ); // WPCS: XSS OK. ?>
		<?php while ( $projects->fetch() ) :
			echo project_detail( $projects ); // WPCS: XSS OK.
		endwhile; ?>
	</div>

<?php endif;
