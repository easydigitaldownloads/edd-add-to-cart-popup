<?php
	// Get settings instance
	$settings = $this->getPlugin()->getSettings();
	// Prepare style attribute value
	$style = sprintf(
		'color: %1$s; background: %2$s;',
		$settings->getSubValue('textcolor'),
		$settings->getSubValue('bgcolor')
	);
?>

<div class="edd-acp-popup" style="<?php echo esc_attr($style); ?>">
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
		<a href="#" class="edd-acp-goto-checkout"><button class="button">
			<?php echo htmlentities( $settings->getSubValue('checkoutBtnText') ); ?>
		</button></a>
		<button class="button edd-acp-close-popup">
			<?php echo htmlentities( $settings->getSubValue('continueBtnText') ); ?>
		</button>
	</p>
</div>
