<?php $settings = $this->getPlugin()->getSettings(); ?>

<style type="text/css">
	div#edd-acp-popup {
		color: <?php echo $settings->getSubValue('textcolor'); ?>;
		background: <?php echo $settings->getSubValue('bgcolor'); ?>;
	}
</style>

<div id="edd-acp-popup">
	<p>
		<?php printf($settings->getSubValue('maintext'), '<strong class="item-name"></strong>'); ?>
	</p>
	<p>
		<a href="#" class="edd-acp-goto-checkout">
			<button class="button">
				<?php echo $settings->getSubValue('checkoutBtnText'); ?>
			</button>
		</a>
		<button class="button edd-acp-close-popup">
			<?php echo $settings->getSubValue('continueBtnText'); ?>
		</button>
	</p>
</div>
