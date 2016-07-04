<?php
/**
 * Home page people template.
 *
 * @package lab
 */

?>
<div class="box">
<p><a href="<?php echo site_url( '/groups' ); // WPCS: XSS OK. ?>">Go to my group</a></p>
	<p><a href="<?php echo esc_url( get_edit_user_link() ); ?>">Update my details</a></p>
</div>
