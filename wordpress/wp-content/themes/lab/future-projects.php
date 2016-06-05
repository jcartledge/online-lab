<?php
/**
 * The template for displaying future projects.
 *
 * @package lab
 */

include_once 'inc/projects.php';

$future_projects = get_user_future_projects();
$future_projects_count = $future_projects->total();

if ( $future_projects_count > 0 ) : ?>
	<div class="box">
		Upcoming projects
		<?php while ( $future_projects->fetch() ) :
			echo project_detail( $future_projects, false ); // WPCS: XSS OK.
		endwhile; ?>
	</div>
<?php else : ?>
	<p>There are no upcoming projects.</p>
<?php endif; ?>
