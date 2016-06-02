<?php
/**
 * The template for displaying past sessions.
 *
 * @package lab
 */

use Carbon\Carbon;
include_once 'inc/sessions.php';

/**
 * Return the correct singular or plural string.
 *
 * @param int    $count The number of items.
 * @param string $singular String to return for one item.
 * @param string $plural String to return for zero or more than one items.
 * @return string
 */
function inflect( $count, $singular, $plural ) {
	static $formatter;
	if ( empty( $formatter ) ) {
		$formatter = new NumberFormatter( 'en', NumberFormatter::SPELLOUT );
	}
	$count_english = $formatter->format( $count );
	return sprintf( '%s %s', $count_english, 1 === $count ? $singular : $plural );
}

$show_all = isset( $_GET['show_all'] );
$past_sessions = get_user_past_sessions();
$past_sessions_count = $past_sessions->total();
if ( $past_sessions_count > 0 ) :
	if ( $show_all ) :
?>
<div class="box">
Past sessions
<?php
while ( $past_sessions->fetch() ) :
	$session_name = $past_sessions->field( 'name' );
	$session_time = ( new Carbon( $past_sessions->field( 'session_time' ) ) )->format( 'l F j, g.ia' );
	$url = $past_sessions->field( 'permalink' );
?>
<p><a href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( sprintf( '%s - %s', $session_name, $session_time ) ); ?></a></p>
<?php
endwhile;
?>
<a href="/sessions/">Hide past sessions</a>
</div>
<?php
	else :
?>
<p>
	<?php esc_html_e( ucfirst( inflect( $past_sessions_count, 'session has ', 'sessions have ' ) ) ); ?>
	already taken place. <a class="unimplemented" href="?show_all">Show past sessions</a>.
</p>
<?php
	endif;
endif;
?>
