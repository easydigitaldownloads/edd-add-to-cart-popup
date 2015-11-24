<?php

class EddAcpHtml {

	public static function regularTextField($id, $desc, $value, $name) {
		ob_start(); ?>
		<input type="text" class="regular-text" id="<?php echo $id; ?>" name="<?php echo $name; ?>" value="<?php echo esc_attr($value); ?>" />
		<label for="<?php echo $id; ?>"><?php echo $desc; ?></label>
		<?php return ob_get_clean();
	}

	public static function colorpicker($id, $desc, $value, $name) {
		ob_start(); ?>
		<div class="edd-acp-colorpicker">
			<input type="hidden" class="edd-acp-colorpicker-value" id="<?php echo $id; ?>" name="<?php echo $name; ?>" value="<?php echo esc_attr($value); ?>" />
			<div class="edd-acp-colorpicker-preview"></div>
		</div>
		<label for="<?php echo $id; ?>"><?php echo $desc; ?></label>
		<?php return ob_get_clean();
	}

}

edd_acp()->getSettings()

	->addOption('textcolor', 'Text Color', 'Change the color of the text inside popup box.', '#000000', function($settings, $id, $desc, $args) {
		echo EddAcpHtml::colorpicker(
			$id,
			$desc,
			$settings->getSubValue($id),
			$settings->getSubValueOptionName($id)
		);
	})

	->addOption('bgcolor', 'Background Color', 'Change the background color of the popup box.', '#ffffff', function($settings, $id, $desc, $args) {
		echo EddAcpHtml::colorpicker(
			$id,
			$desc,
			$settings->getSubValue($id, '#ffffff'),
			$settings->getSubValueOptionName($id)
		);
	})

	->addOption('maintext', 'Popup Text', 'The text shown on the popup. The "%s" will be replaced by the name of the item added to the cart.', '%s had been added to you cart!', function($settings, $id, $desc, $args) {
		echo EddAcpHtml::regularTextField(
			$id,
			$desc,
			$settings->getSubValue($id),
			$settings->getSubValueOptionName($id)
		);
	})

	->addOption('checkoutBtnText', 'Checkout Button Text', 'The text of the Checkout button.', 'Proceed to Checkout', function($settings, $id, $desc, $args) {
		echo EddAcpHtml::regularTextField(
			$id,
			$desc,
			$settings->getSubValue($id),
			$settings->getSubValueOptionName($id)
		);
	})

	->addOption('continueBtnText', 'Continue Button Text', 'The text of the continue shopping button.', 'Continue shopping', function($settings, $id, $desc, $args) {
		echo EddAcpHtml::regularTextField(
			$id,
			$desc,
			$settings->getSubValue($id),
			$settings->getSubValueOptionName($id)
		);
	})
;