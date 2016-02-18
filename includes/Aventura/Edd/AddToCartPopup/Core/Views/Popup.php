<?php $settings = $this->getPlugin()->getSettings(); ?>

<style type="text/css">
	div.edd-acp-popup {
		color: <?php echo $settings->getSubValue('textcolor'); ?>;
		background: <?php echo $settings->getSubValue('bgcolor'); ?>;
	}
</style>

<div class="edd-acp-popup">
	<?php
		$itemName = the_title_attribute(array(
			'before'	=>	'',
			'after'		=>	'',
			'echo'		=>	false,
			'post'		=>	$viewbag->downloadId
		));
	?>
	<input type="hidden" class="edd-acp-item-name" value="<?php echo $itemName ?>" />
	<p>
		<?php printf($settings->getSubValue('maintext'), '<strong class="item-name"></strong>'); ?>
	</p>
	<p>
		<a href="#" class="edd-acp-goto-checkout"><button class="button"><?php echo $settings->getSubValue('checkoutBtnText'); ?></button></a>
		<button class="button edd-acp-close-popup">
			<?php echo $settings->getSubValue('continueBtnText'); ?>
		</button>
	</p>
</div>
