<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and
 * everything up until <div id="content">
 *
 * @package lab
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'lab' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<p class="site-title">
				<a class="site-title__link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img
					class="site-title__logo"
					src="//thelab.org.au/thelab_v2/wp-content/uploads/2016/04/lab-logo-v3.png"
					alt="<?php bloginfo( 'name' ); ?>">
				</a>
			</p>
		</div><!-- .site-branding -->

		<?php if ( is_user_logged_in() ) : ?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'lab' ); ?></button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'main' ) ); ?>
			</nav><!-- #site-navigation -->
		<?php else :
			wp_loginout( $_SERVER['REQUEST_URI'] ); // WPCS: XSS OK.
		endif; ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
