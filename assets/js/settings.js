(function ($) {

	$(document).ready(function() {

		// Iterate all colorpicker containers
		$('.edd-acp-colorpicker').each(function() {
			// Prepare element pointers
			var self = $(this);
			var value = self.find('input.edd-acp-colorpicker-value');
			var preview = self.find('div.edd-acp-colorpicker-preview');

			// Colorpicker preview and value updater function
			var updateColorpicker = function(hsb, hex, rgb) {
				value.val('#' + hex);
				preview.css('backgroundColor', '#' + hex);
			};

			// Update element first time
			updateColorpicker(null, value.val().substr(1), null);

			// Set up color picker
			self.ColorPicker({
				// Set color before showing colorpicker
				onBeforeShow: function() {
					$(this).ColorPickerSetColor(value.val());
				},
				// Fade in effect
				onShow: function(colorpicker) {
					$(colorpicker).fadeIn(200);
					return false;
				},
				// Fade out effect
				onHide: function(colorpicker) {
					$(colorpicker).fadeOut(200);
					return false;
				},
				// Update color picker preview and value on change and submit
				onSubmit: updateColorpicker,
				onChange: updateColorpicker
			});
		});
	});

})(jQuery);