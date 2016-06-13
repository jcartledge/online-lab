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
 * @param Pods   $project The Pods object contining the project.
 * @param bool   $detail  Show the teaser/excerpt/summary.
 * @param string $label   Text to prepend.
 * @return string HTML
 */
function project_detail( $project, $detail = true, $label = '' ) {
	if ( is_array( $project ) ) {
		$project = load_project( $project );
	}
	$name = $project->field( 'name' );
	$url = $project->field( 'permalink' );
	$description = $project->display( 'post_content' );
	return implode( '', [
		'<div class="project-summary">',
		sprintf( '<p class="project-summary__link">%s<a href="%s">%s</a></p>', $label, $url, $name ),
		$detail ? sprintf( '<p class="project-summary__description">%s</p>', $description ) : '',
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
	return get_projects_for_session( get_user_past_sessions() );
}

/**
 * Get future projects for current user.
 *
 * @return Pods.
 */
function get_user_future_projects() {
	require_once 'sessions.php';
	return get_projects_for_session( get_user_future_sessions() );
}

/**
 * Get a list of project IDs associated with a Pods session object.
 *
 * @param Pods $session Pods session object.
 * @return Array IDs.
 */
function get_session_project_ids( $session ) {
	$project_ids = [];
	while ( $session->fetch() ) {
		$projects = $session->field( 'projects' );
		if ( is_array( $projects ) ) {
			foreach ( $projects as $project ) {
				$project_ids[] = $project['pod_item_id'];
			}
		}
	}
	$session->reset();
	return $project_ids;
}

/**
 * Get Pods project object from a list of project IDs.
 *
 * @param Array $project_ids Project IDs.
 * @return Pods Project(s).
 */
function get_projects_from_ids( $project_ids ) {
	$where = $project_ids ? 'ID IN (' . implode( ', ', $project_ids ) . ')' : 'false';
	return pods( 'project', [ 'where' => $where ] );
}

/**
 * Get projects for a single session.
 *
 * @param Pods $session Pods session object.
 * @return Pods Projects.
 */
function get_projects_for_session( $session ) {
	return get_projects_from_ids( get_session_project_ids( $session ) );
}
