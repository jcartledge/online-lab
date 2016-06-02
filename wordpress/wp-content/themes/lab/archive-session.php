<?php
/**
 * The template for displaying sessions archive.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package lab
 */

use Carbon\Carbon;
include_once 'inc/groups.php';

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

		<?php
		if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
