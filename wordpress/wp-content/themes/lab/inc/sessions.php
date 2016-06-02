<?php
/**
 * Sessions helpers.
 *
 * @package lab
 */

require_once 'groups.php';

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

