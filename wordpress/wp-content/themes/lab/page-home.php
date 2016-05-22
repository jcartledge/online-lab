<?php
/**
 * Home page template.
 *
 * @package lab
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php if ( is_user_logged_in() ) : ?>
				<h2>Sessions</h2>
				<?php include 'home-sessions.php'; ?>
			<?php
				else :
					while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/content', 'page' );
					endwhile;
				endif;
			?>

		</main>
	</div>

<?php
get_footer();
