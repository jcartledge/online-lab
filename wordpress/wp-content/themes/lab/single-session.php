<?php
/**
 * The template for displaying all single sessions.
 *
 * @package lab
 */

require_logged_in_user();
require_once 'inc/sessions.php';
require_once 'inc/projects.php';
require_once 'inc/groups.php';

$slug = pods_v( 'last', 'url' );
$session = pods( 'session', $slug );
$session_name = $session->field( 'name' );
$session_start_time = session_start_time( $session );
$session_projects = $session->field( 'projects' );

$group_links = join_strings( array_map( 'link_group_name', post_group_names() ) );

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<h1><?php esc_html_e( $session_name ); ?></h1>

			<p class="session-date"><?php esc_html_e( $session_start_time ); ?></p>
			<p class="session-group">
				<?php echo $group_links; // WPCS: XSS OK. ?>
			</p>

			<p class="session-description unimplemented">
				<?php echo $session->display( 'post_content' ); // WPCS: XSS OK. ?>
			</p>

			<?php if ( count( $session_projects ) ) : ?>
				<h2>Projects</h2>
				<?php foreach ( $session_projects as $session_project ) :
					echo project_detail( $session_project ); // WPCS: XSS OK.
				endforeach;
			endif; ?>

		</main>
	</div>

<?php
get_footer();
