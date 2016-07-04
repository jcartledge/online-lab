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
$session_projects = $session->field( 'projects' );

$group_links = join_strings( array_map( 'link_group_name', post_group_names() ) );

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<h1>Session for <?php echo $group_links; // WPCS: XSS OK. ?></h1>
			<h2><?php esc_html_e( session_label( $session ) ); ?></h2>

			<p class="session-date"><?php esc_html_e( $session_start_time ); ?></p>
			<p class="session-group">
			</p>

			<p class="session-description">
				<?php echo $session->display( 'post_content' ); // WPCS: XSS OK. ?>
			</p>

			<?php if ( current_user_can( 'edit_participant_notes' ) ) : ?>
				<p>
					<a target="_blank" href="<?php bloginfo( 'url' ); ?>/wp-admin/post-new.php?post_type=participant_note">Add participant note</a>
				</p>
			<?php endif; ?>

			<?php if ( $session_projects ) : ?>
				<h2>Projects</h2>
				<?php foreach ( $session_projects as $session_project ) :
					echo project_detail( $session_project ); // WPCS: XSS OK.
				endforeach;
			endif; ?>

			<h2>Connect</h2>
			<ul class="connect-list">
				<li class="connect-list__slack">
					<a target="_blank" href="<?php esc_html_e( $session->field( 'slack_url' ) ); ?>">
						<i class="fa fa-slack"></i>
						Join the Slack chat.
					</a>
				</li>
				<li class="connect-list__zoom">
					<a target="_blank" href="<?php esc_html_e( $session->field( 'zoom_url' ) ); ?>">
						<i class="fa fa-video-camera"></i>
						Join the Zoom video meeting.
					</a>
				</li>
			</ul>

		</main>
	</div>

<?php
get_footer();
