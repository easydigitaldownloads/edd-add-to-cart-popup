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

// Get text domain
$textDomain = edd_acp()->getTextDomain()->getName();

// Get settings instance to add options to it
edd_acp()->getSettings()

	->addOption(
			'enabled',
			__('Enable Popup', $textDomain),
			__('Tick this box to enable the popup. Untick it to disable it.', $textDomain),
			'1',
			function($settings, $id, $args) {
				echo EddAcpSettingsHtml::renderField('checkbox', $settings, $id);
			}
		)

	->addOption(
			'textcolor',
			__('Text Color', $textDomain),
			__('Change the color of the text inside popup box.', $textDomain),
			'#000000',
			function($settings, $id, $args) {
				echo EddAcpSettingsHtml::renderField('colorpicker', $settings, $id);
			}
		)

	->addOption(
			'bgcolor',
			__('Background Color', $textDomain),
			__('Change the background color of the popup box.', $textDomain),
			'#ffffff',
			function($settings, $id, $args) {
				echo EddAcpSettingsHtml::renderField('colorpicker', $settings, $id);
			}
		)

	->addOption(
			'maintext',
			__('Popup Text', $textDomain),
			__('The text shown on the popup. The "%s" will be replaced by the name of the item added to the cart.', $textDomain),
			__('%s had been added to you cart!', $textDomain),
			function($settings, $id, $args) {
				echo EddAcpSettingsHtml::renderField('text', $settings, $id);
			}
		)

	->addOption(
			'checkoutBtnText',
			__('Checkout Button Text', $textDomain),
			__('The text of the Checkout button.', $textDomain),
			__('Proceed to Checkout', $textDomain),
			function($settings, $id, $args) {
				echo EddAcpSettingsHtml::renderField('text', $settings, $id);
			}
		)

	->addOption(
			'continueBtnText',
			__('Continue Button Text', $textDomain),
			__('The text of the continue shopping button.', $textDomain),
			__('Continue shopping', $textDomain),
			function($settings, $id, $args) {
				echo EddAcpSettingsHtml::renderField('text', $settings, $id);
			}
		)
;