<?php
/**
 * The template for displaying projects archive.
 *
 * @package lab
 */

require_logged_in_user();

require 'inc/groups.php';
$groups = join_strings( user_group_names() );
$heading = "Projects for ${groups}.";

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<header class="page-header">
				<h1><?php esc_html_e( $heading ); ?></h1>
			</header>
			<?php include 'past-projects.php'; ?>
			<?php // include 'home-projects.php'; ?>
			<?php // include 'future-projects.php'; ?>
		</main>
	</div>
<?php get_footer();
