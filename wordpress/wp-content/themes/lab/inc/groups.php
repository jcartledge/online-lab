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
	if ( ! is_user_logged_in() ) {
		return [];
	}
	$user = new Groups_User( get_current_user_id() );
	$group_names = array_map( function ( $group ) {
		return $group->name;
	}, $user->groups );
	return array_filter($group_names, function ( $name ) {
		return 'Registered' !== $name;
	} );
}
