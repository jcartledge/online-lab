<?php
/**
 * The template for displaying all single projects.
 *
 * @package lab
 */

require_logged_in_user();
get_header();
the_post();
the_title( '<h1>', '</h1>' );
the_content();
get_footer();
