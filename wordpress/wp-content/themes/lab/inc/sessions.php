<?php
/**
 * Sessions helpers.
 *
 * @package lab
 */

use Carbon\Carbon;
require_once 'groups.php';

define( 'SESSION_TIME_FORMAT', 'l F j, g.ia' );

/**
 * Get sessions for current user.
 *
 * @param Array $where Conditions for find.
 * @param Array $args Additional args for find.
 * @return Pods.
 */
function get_user_sessions( $where = [], $args = [] ) {
	$group_names = implode( ', ', array_map( function( $name ) {
		return sprintf( '"%s"', $name );
	}, user_group_names() ) );
	$where[] = sprintf( 'groups-groups_read_post.meta_value IN (%s)', $group_names );
	$where = implode( ' AND ', $where );
	$default_args = [
		'where' => $where,
		'order_by' => 'session_time.meta_value ASC',
	];
	$args = array_merge( $default_args, $args );
	return pods( 'session' )->find( $args );
}

/**
 * Get future sessions for current user.
 *
 * @param Array $args Additional args for find.
 * @return Pods.
 */
function get_user_future_sessions( $args = [] ) {
	return get_user_sessions( [ 'session_time.meta_value > NOW()' ], $args );
}

/**
 * Get past sessions for current user.
 *
 * @param Array $args Additional args for find.
 * @return Pods.
 */
function get_user_past_sessions( $args = [] ) {
	return get_user_sessions( [ 'session_time.meta_value < NOW()' ], $args );
}

/**
 * Get next session for current user.
 *
 * @return Pods.
 */
function get_next_session() {
	return get_user_future_sessions( [ 'limit' => 1 ] );
}

/**
 * Return HTML for a session detail listing.
 *
 * @param Pods $session The Pods object contining the session.
 * @return string HTML
 */
function session_detail( $session ) {
	$session_name = $session->field( 'name' );
	$session_time = ( new Carbon( $session->field( 'session_time' ) ) )->format( SESSION_TIME_FORMAT );
	$session_label = sprintf( '%s - %s', $session_name, $session_time );
	$url = $session->field( 'permalink' );
	return sprintf( '<p><a href="%s">%s</a></p>', esc_url( $url ), esc_html( $session_label ) );
}
