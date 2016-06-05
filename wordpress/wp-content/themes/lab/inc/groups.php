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
