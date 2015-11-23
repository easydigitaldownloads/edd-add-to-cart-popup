<?php
	$settings = $this->getPlugin()->getSettings();
?>
<style type="text/css">
div#edd-acp-popup {
	color: <?php echo $settings->getSubValue('textcolor', 'black'); ?>;
	background: <?php echo $settings->getSubValue('bgcolor', 'white'); ?>;
}
</style>

<div id="edd-acp-popup">
	<p>
		<strong class="item-name"></strong> has been added to your cart!
	</p>
	<p>
		<a href="#" class="edd-acp-goto-checkout">
			<button class="button">Proceed to Checkout</button>
		</a>
		<button class="button edd-acp-close-popup">Continue Shopping</button>
	</p>
</div>
