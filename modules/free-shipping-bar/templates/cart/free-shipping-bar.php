<?php
/**
 * Free Shipping bar
 *
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="razzi-free-shipping-bar">
	<div class="razzi-free-shipping-bar__message">
		<?php echo $message; ?>
	</div>
	<div class="razzi-free-shipping-bar__progress">
		<div class="razzi-free-shipping-bar__progress-bar" style="width:<?php echo esc_attr( $percent ); ?>"></div>
	</div>
	<div class="razzi-free-shipping-bar__percent-value"><?php echo $percent; ?></div>
</div>