<?php
/**
 * Groups helpers.
 *
 * @package lab
 */

/**
 * Get an array of names of groups the current user belongs to.
 *
 * @return Array groups.
 */
function user_group_names() {
	return array_map( function ( $group ) {
		return $group->name;
	}, user_groups() );
}

/**
 * Get an array of groups the current user belongs to.
 *
 * @param array $excludes Names of groups to exclude from the results.
 *
 * @return array groups.
 */
function user_groups( $excludes = [ 'Registered' ] ) {
	if ( ! is_user_logged_in() ) {
		return [];
	}
	$user = new Groups_User( get_current_user_id() );
	return array_map(
		function ( $group ) {
			$group->members = group_users( $group );
			return $group;
		}, array_filter(
			$user->groups,
			function ( $group ) use ( $excludes ) {
				return ! in_array( $group->name, $excludes, true );
			}
		)
	);
}

/**
 * Return userdata for a group.
 *
 * @param Groups_Group $group The group to retrieve users for.
 *
 * @return array get_userdata for each user ID.
 */
function group_users( $group ) {
	$sql = sprintf(
		'SELECT user_id FROM wp_groups_user_group WHERE group_id = %d',
		$group->group_id
	);
	return array_filter(
		array_map(
			function ( $user ) {
				return get_userdata( $user->user_id );
			},
			$GLOBALS['wpdb']->get_results( $sql )
		),
		function ( $user ) {
			return ! in_array( 'administrator', $user->roles, true );
		}
	);
}

/**
 * Userdata for group organised by roles.
 *
 * @param Groups_Group $group The group to retrieve users for.
 *
 * @return array get_userdata for each user ID.
 */
function group_users_by_role( $group ) {
	$users = group_users( $group );
	$roles = [
		'mentor' => [],
		'participant' => [],
	];
	return array_reduce( $users, function( $acc, $user ) {
		if ( in_array( 'mentor', $user->roles, true ) ) {
			$acc['mentor'][] = $user;
		} else if ( in_array( 'participant', $user->roles, true ) ) {
			$acc['participant'][] = $user;
		}
		return $acc;
	}, $roles );
}

/**
 * Get the names of groups that can see this post.
 *
 * @return Array Group names.
 */
function post_group_names() {
	$groups = new Groups_Post_Access();
	return $groups->get_read_post_capabilities( get_the_ID() );
}

/**
 * Build a URL from a group name.
 *
 * @param String $group_name The name of the group.
 * @return String URL
 */
function group_url( $group_name ) {
	return sprintf( '/groups/%s', sanitize_title( $group_name ) );
}

/**
 * Convert a group name into an HTML link.
 *
 * @param String $group_name The name of the group.
 * @return String Link.
 */
function link_group_name( $group_name ) {
	return sprintf( '<a href="%s">%s</a>', group_url( $group_name ), ucfirst( $group_name ) );
}
