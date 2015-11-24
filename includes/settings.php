<?php

class EddAcpSettingsHtml {

	public static function renderField($type, $settings, $id) {
		if (!method_exists(__CLASS__, $type) || !$settings->hasOption($id)) {
			return;
		}
		ob_start();
		echo self::$type($id, $settings->getSubValueOptionName($id), $settings->getSubValue($id));
		$desc = $settings->getOption($id)->desc;
		printf('<label for="%1$s">%2$s</label>', $id, $desc);
		return ob_get_clean();
	}

	public static function text($id, $name, $value) {
		ob_start(); ?>
		<input type="text" class="regular-text" id="<?php echo $id; ?>" name="<?php echo $name; ?>" value="<?php echo esc_attr($value); ?>" />
		<?php return ob_get_clean();
	}

	public static function colorpicker($id, $name, $value) {
		ob_start(); ?>
		<div class="edd-acp-colorpicker">
			<input type="hidden" class="edd-acp-colorpicker-value" id="<?php echo $id; ?>" name="<?php echo $name; ?>" value="<?php echo esc_attr($value); ?>" />
			<div class="edd-acp-colorpicker-preview"></div>
		</div>
		<?php return ob_get_clean();
	}

	public static function checkbox($id, $name, $value) {
		ob_start(); ?>
		<input type="hidden" name="<?php echo $name; ?>" value="0" />
		<input type="checkbox" id="<?php echo $id; ?>" name="<?php echo $name; ?>" <?php checked($value, '1'); ?> value="1" />
		<?php return ob_get_clean();
	}

}

edd_acp()->getSettings()


	->addOption('textcolor', 'Text Color', 'Change the color of the text inside popup box.', '#000000', function($settings, $id, $args) {
		echo EddAcpSettingsHtml::renderField('colorpicker', $settings, $id);
	})

	->addOption('bgcolor', 'Background Color', 'Change the background color of the popup box.', '#ffffff', function($settings, $id, $args) {
		echo EddAcpSettingsHtml::renderField('colorpicker', $settings, $id);
	})

	->addOption('maintext', 'Popup Text', 'The text shown on the popup. The "%s" will be replaced by the name of the item added to the cart.', '%s had been added to you cart!', function($settings, $id, $args) {
		echo EddAcpSettingsHtml::renderField('text', $settings, $id);
	})

	->addOption('checkoutBtnText', 'Checkout Button Text', 'The text of the Checkout button.', 'Proceed to Checkout', function($settings, $id, $args) {
		echo EddAcpSettingsHtml::renderField('text', $settings, $id);
	})

	->addOption('continueBtnText', 'Continue Button Text', 'The text of the continue shopping button.', 'Continue shopping', function($settings, $id, $args) {
		echo EddAcpSettingsHtml::renderField('text', $settings, $id);
	})
;