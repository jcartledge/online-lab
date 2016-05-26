<?php
/**
 * Home page projects template.
 *
 * @package lab
 */

$projects = pods( 'project' )->find([
	'limit' => 3,
]);
?>
<div class="box">
<?php
while ( $projects->fetch() ) :
	$url = $projects->field( 'permalink' );
?>
	<p>
		<a href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( $projects->field( 'name' ) ); ?></a>
	</p>
<?php
endwhile;
?>
	<a href="/projects">See all projects</a>
</div>
