<?php
/**
 * The template for displaying all single posts.
 *
 * @package lab
 */

require_logged_in_user();

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<h1 class="unimplemented">Session name</h1>

			<p class="session-date unimplemented">Tuesday May 3, 6.45PM.</p>
			<p class="session-group unimplemented">
				[Group 1](<a href="#" class="unimplemented">group detail</a>)
			</p>

			<p class="session-description unimplemented">
				Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula
				eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient
				montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque
				eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo,
				fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut,
			</p>

			<h2>Projects</h2>

			<div class="project-summary unimplemented">
				<p class="project-summary__link"><a href="#">Project name</a></p>
				<p class="project-summary__description">
					Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula
					eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient
					montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque
					eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo,
					fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut,
				</p>
			</div>



		<?php endwhile; ?>

		</main>
	</div>

<?php
get_footer();
