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
		// Set the item name
		this.popup.find('strong.item-name').text(this.itemName);
		// Set the url of the "continue to checkout button" to the checkout page
		this.popup.find('a.edd-acp-goto-checkout').attr('href', edd_scripts.checkout_page);

		return this;
	};

	EddAcp.prototype.initEvents = function() {
		this.eddPurchaseButton.click(this.onPurchaseClick.bind(this));

		return this;
	};

	EddAcp.prototype.onPurchaseClick = function(event) {
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
