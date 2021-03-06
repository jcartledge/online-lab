<?php
/**
 * The template for displaying sessions archive.
 *
 * @package lab
 */

require_logged_in_user();

require 'inc/groups.php';
$groups = join_strings( user_group_names() );
$heading = "Sessions for ${groups}.";

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<header class="page-header">
				<h1><?php esc_html_e( $heading ); ?></h1>
			</header>
			<?php include 'past-sessions.php'; ?>
			<?php include 'home-sessions.php'; ?>
			<?php include 'future-sessions.php'; ?>
		</main>
	</div>
<?php get_footer();
