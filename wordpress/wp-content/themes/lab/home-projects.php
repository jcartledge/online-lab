<?php
/**
 * Home page projects template.
 *
 * @package lab
 */

require_logged_in_user();

require_once 'inc/projects.php';

$projects = pods( 'project' )->find( [ 'limit' => 3 ] );
$projects_url = site_url( '/projects/' ); ?>
<div class="box">
	<?php while ( $projects->fetch() ) :
		echo project_detail( $projects, false ); // WPCS: XSS OK.
	endwhile; ?>
<a href="<?php echo $projects_url; // WPCS: XSS OK. ?>">See all projects</a>
</div>
