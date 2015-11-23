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

	->addOption('textcolor', 'Text Color', 'Change the color of the text inside popup box.', function($id, $desc, $args) {
		$settings = edd_acp()->getSettings();
		echo EddAcpHtml::colorpicker(
			$id,
			$desc,
			$settings->getSubValue($id, '#000000'),
			$settings->getSubValueOptionName($id)
		);
	})

	->addOption('bgcolor', 'Background Color', 'Change the background color of the popup box.', function($id, $desc, $args) {
		$settings = edd_acp()->getSettings();
		echo EddAcpHtml::colorpicker(
			$id,
			$desc,
			$settings->getSubValue($id, '#ffffff'),
			$settings->getSubValueOptionName($id)
		);
	})
;