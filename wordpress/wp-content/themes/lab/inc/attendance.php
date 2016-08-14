<?php

/**
 * Attendance helpers.
 *
 * @package lab
 */

require_once 'groups.php';
require_once 'sessions.php';

function get_attendance_list() {
	global $wpdb;

	// List all groups.
	$group_table = _groups_get_tablename( 'group' );
	$groups = $wpdb->get_results( "SELECT name, group_id FROM ${group_table} WHERE name != 'Registered'" );

	return array_map(function ( $group ) {
		$users = group_users_by_role( $group )[ 'participant' ];
		$sessions = query_posts([
			'post_type' => 'session',
			'meta_key' => 'groups-groups_read_post',
			'meta_query' => [
				[
					'key'=> 'groups-groups_read_post',
					'value' => $group->name,
				],
			],
		]);
		return [
			'name' => $group->name,
			'columns' => array_map( function ( $session ) {
				return [ 'label' => $session->post_title ];
			}, $sessions ),
			'rows' => array_map( function ( $user ) use ( $sessions ) {
				return [
					'label' => $user->data->display_name,
					'columns' => array_map( function ( $session ) {
						return 'x';
					}, $sessions ),
				];
			}, $users ),
		];
	}, $groups );
	
}

function get_attendance_tables () {
	return implode( array_map( function ( $group ) {
		return sprintf('<h2>%s</h2>%s',
			$group['name'],
			get_attendance_table( $group )
		);
	}, get_attendance_list() ) );
}

function get_attendance_table ( $group ) {
	return sprintf( '<table>%s%s</table>',
		get_attendance_table_head( $group ),
		get_attendance_table_body( $group )
	);
}

function get_attendance_table_head ( $group ) {
	return sprintf( '<tr><th>&nbsp;</th>%s</tr>',
		implode( array_map( function ( $column ) {
			return sprintf( '<th>%s</th>', $column['label'] );
		}, $group['columns'] ) )
	);
}

function get_attendance_table_body ( $group ) {
	return implode( array_map( function ( $row ) {
		return sprintf( '<tr><td>%s</td>%s</tr>',
			$row[ 'label' ],
			implode( array_map( function ( $column ) {
				return sprintf( '<td>%s</td>', $column );
			}, $row['columns'] ) )
		);
	}, $group['rows'] ) );
}
