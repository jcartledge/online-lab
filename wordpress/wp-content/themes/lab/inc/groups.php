<?php

function user_group_names() {
	$user = new Groups_User( get_current_user_id() );
	$group_names = array_map( function ( $group ) {
		return $group->name;
	}, $user->groups );
	return array_filter($group_names, function ( $name ) {
		return 'Registered' !== $name;
	} );
}
