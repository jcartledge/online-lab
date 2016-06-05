<?php
/**
 * The template for displaying past projects.
 *
 * @package lab
 */

include_once 'inc/projects.php';

$show_all = isset( $_GET['show_all'] ); // Input var okay.
$past_projects = get_user_past_projects();
$past_projects_count = $past_projects->total();
if ( $past_projects_count > 0 ) :
	if ( $show_all ) : ?>
		<div class="box">
			Past projects
			<?php while ( $past_projects->fetch() ) :
				echo session_detail( $past_projects ); // WPCS: XSS OK.
			endwhile; ?>
			<a href="/projects/">Hide past projects</a>
		</div>
	<?php else : ?>
		<p>
			<?php esc_html_e( ucfirst( inflect( $past_projects_count, 'project has ', 'projects have ' ) ) ); ?>
			already taken place. <a href="?show_all">Show past projects</a>.
		</p>
	<?php endif;
endif; ?>
