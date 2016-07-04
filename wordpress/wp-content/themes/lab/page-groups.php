<?php
/**
 * Groups page
 *
 * @package lab
 */

require 'inc/groups.php';

/* die('<pre>' . print_r(current(user_groups()), 1)); */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class="box">
				<p><a href="<?php echo esc_url( get_edit_user_link() ); ?>">Update my details</a></p>
			</div>

			<div class="box">
				<?php foreach ( user_groups() as $group ) : ?>
					<h2><?php echo esc_html( $group->name ); ?></h2>
					<ul><?php foreach ( group_users( $group ) as $user ) : ?>
						<li class="user <?php echo esc_html( implode( ' ', $user->roles ) ); ?>">
							<?php echo get_avatar( $user->ID ); ?>
							<?php echo esc_html( $user->data->user_nicename ); ?>
						</li>
					<?php endforeach; ?></ul>
				<?php endforeach; ?>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
