<?php
/**
 * Project helpers.
 *
 * @package lab
 */

/**
 * Load a Pods project from an array.
 *
 * @param Array $project_array Project details in an array.
 * @return Pods Project.
 */
function load_project( $project_array ) {
	return pods( 'project', $project_array['pod_item_id'] );
}

/**
 * Return HTML for a project  detail listing.
 *
 * @param Pods $project The Pods object contining the project.
 * @return string HTML
 */
function project_detail( $project ) {
	if ( is_array( $project ) ) {
		$project = load_project( $project );
	}
	$name = $project->field( 'name' );
	$url = $project->field( 'permalink' );
	$description = $project->display( 'post_content' );
	return implode( '', [
		'<div class="project-summary">',
		sprintf( '<p class="project-summary__link"><a href="%s">%s</a></p>', $url, $name ),
		sprintf( '<p class="project-summary__description">%s</p>', $description ),
		'</div>',
	] );
}

/**
 * Get past projects for current user.
 *
 * @return Pods.
 */
function get_user_past_projects() {
	require_once 'sessions.php';
	$past_sessions = get_user_past_sessions();
	$project_ids = [];
	while ( $past_sessions->fetch() ) {
		$projects = $past_sessions->field( 'projects' );
		if ( is_array( $projects ) ) {
			foreach ( $projects as $project ) {
				$project_ids[] = $project['pod_item_id'];
			}
		}
	}
	return pods( 'project', [ 'where' => 'ID IN (' . implode( ', ', $project_ids ) . ')' ] );
}

