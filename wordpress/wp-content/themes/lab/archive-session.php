<?php
/**
 * The template for displaying sessions archive.
 *
 * @package lab
 */

$user = new Groups_User( get_current_user_id() );
$groups = array_map( function ( $group ) {
	return $group->name;
}, $user->groups );
$groups = join_strings(array_filter($groups, function ( $name ) {
	return 'Registered' !== $name;
} ) );
$heading = "Sessions for ${groups}.";

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<header class="page-header">
			<h1><?php esc_html_e( $heading ); ?></h1>
		</header>

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
