<?php
/**
 * Sessions helpers.
 *
 * @package lab
 */

use Carbon\Carbon;
require_once 'groups.php';

define( 'SESSION_TIME_FORMAT', 'g.ia' );
define( 'SESSION_DATETIME_FORMAT', 'l F j, ' . SESSION_TIME_FORMAT );

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
	$where[] = $group_names ? sprintf( 'groups-groups_read_post.meta_value IN (%s)', $group_names ) : 'false';
	$where = implode( ' AND ', $where );
	$default_args = [
		'where' => $where,
		'orderby' => 'session_start_time.meta_value ASC',
	];
	$args = array_merge( $default_args, $args );
	return pods( 'session' )->find( $args );
}

/**
 * Get past sessions for current user.
 *
 * @param Array $args Additional args for find.
 * @return Pods.
 */
function get_user_past_sessions( $args = [] ) {
	return get_user_sessions( [ 'session_end_time.meta_value < NOW()' ], $args );
}

/**
 * Get current sessions for current user.
 *
 * @param Array $args Additional args for find.
 * @return Pods.
 */
function get_user_current_sessions( $args = [] ) {
	return get_user_sessions( [
		'session_start_time.meta_value < NOW()',
		'session_end_time.meta_value < NOW()',
	], $args );
}

/**
 * Get future sessions for current user.
 *
 * @param Array $args Additional args for find.
 * @return Pods.
 */
function get_user_future_sessions( $args = [] ) {
	return get_user_sessions( [ 'session_start_time.meta_value > NOW()' ], $args );
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
 * @param Pods   $session The Pods object contining the session.
 * @param string $label Label to prepend.
 * @return string HTML
 */
function session_detail( $session, $label = '' ) {
	return sprintf(
		'<p>%s<a href="%s">%s</a></p>',
		esc_html( $label ),
		esc_url( $session->field( 'permalink' ) ),
		esc_html( session_label( $session ) )
	);
}

/**
 * Label (start time - end time) for a session.
 *
 * @param Pods $session The Pods object containing the session.
 * @return string HTML.
 */
function session_label( $session ) {
	$session_start_time = session_time( $session );
	$session_end_time = session_time( $session, 'end' );
	return sprintf( '%s - %s', $session_start_time, $session_end_time );
}

/**
 * Formatted session time string.
 *
 * @param Pods   $session The Pods object containing the session.
 * @param string $which Should be 'start' (default) or 'end'.
 * @return String HTML.
 */
function session_time( $session, $which = 'start' ) {
	$format = [
		'start' => SESSION_DATETIME_FORMAT,
		'end' => SESSION_TIME_FORMAT,
	][ $which ];
	return ( new Carbon( $session->field( "session_${which}_time" ) ) )->format( $format );
}
