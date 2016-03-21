var EddAcp = (function EddAcpClass() {

	EddAcp.prototype = Object.create(Object.prototype);

	var $ = jQuery;

	function EddAcp(element) {
		this.element = element;
		this.testing = false;
		this.initElems()
			.initEvents();
	}

	EddAcp.prototype.initElems = function() {
		// Get purchase elements
		this.eddPurchaseWrapper = this.element.find('.edd_purchase_submit_wrapper');
		this.eddPurchaseButton = this.eddPurchaseWrapper.find('a.edd-add-to-cart');
		// Get the popup element
		this.popup = this.element.find('.edd-acp-popup');
		// Get the item name
		this.itemName = this.popup.find('.edd-acp-item-name').val();
		// Get the variable price option element, if available
		this.priceOptions = this.element.find('div.edd_price_options');
		// Set the url of the "continue to checkout button" to the checkout page
		this.popup.find('a.edd-acp-goto-checkout').attr('href', edd_scripts.checkout_page);

		return this;
	};

	EddAcp.prototype.initEvents = function() {
		this.eddPurchaseButton.click(this.onPurchaseClick.bind(this));

		return this;
	};

	EddAcp.prototype.onPurchaseClick = function(event) {
		// Item name to show on popup
		var name = this.itemName;
		// Get selected price options
		var priceOptions = this.getSelectedPriceOption();
		// If no selection, or variable pricing disabled
		if (priceOptions !== null) {
			// Use hyphen between item name and selected options
			name += ' - ';
			// Get the default quantity field
			var eddQtyField = this.element.find('.edd-item-quantity');
			// Put selections in array, to join by comma later
			var optionStrings = [];
			for (var i in priceOptions) {
				// If the quantity is 1 and only one option is selected, do not show quantity
				var qtyStr = '';
				if (priceOptions[i].qty > 1 || priceOptions.length > 1) {
					qtyStr = ' x' + priceOptions[i].qty;
				} else if (eddQtyField.length > 0 && parseInt(eddQtyField.val()) > 1) {
					qtyStr = ' x' + eddQtyField.val();
				}
				// Generate string for selected price option and add to array
				var optionString = ' ' + priceOptions[i].name + qtyStr;
				optionStrings.push(optionString);
			}
			// Join options by comma and add to item name
			name += optionStrings.join(', ');
		}
		// Set the item name on popup element
		this.popup.find('strong.item-name').text(name);
		// Show the popup
		this.popup.bPopup({
			positionStyle: 'fixed',
			speed: 100,
			closeClass: 'edd-acp-close-popup'
		});
		if (this.testing) {
			event.stopPropagation();
			event.preventDefault();
		}
	};

	EddAcp.prototype.getSelectedPriceOption = function() {
		if (this.priceOptions.length === 0) {
			return null;
		}
		var selected = [];
		// For each price option
		this.priceOptions.find('> ul > li').each(function(i, l) {
			// Get the label and quantity wrapper
			var label = $(l).find('> label');
			var qtyWrapper = $(l).find('> div.edd_download_quantity_wrapper');
			// If the option is selected
			if (label.find('input').is('[type="checkbox"]:checked, [type="radio"]:checked')) {
				// Get the option name and entered quantity
				var name = label.find('.edd_price_option_name').text();
				var qty = qtyWrapper.length === 0
					? 1
					: parseInt(qtyWrapper.find('input.edd-item-quantity').val());
				// Add selection
				selected.push({
					name: name,
					qty: qty
				});
			}
		});
		console.log(selected);
		return selected;
	};

	return EddAcp;
}());

jQuery(document).ready( function() {
	window.edd_acp = {};
	// Instances array
	window.edd_acp.instances = [];
	// Go through each download and init instance
	jQuery('form.edd_download_purchase_form').each( function() {
		window.edd_acp.instances.push( new EddAcp( jQuery(this) ) );
	});
});
