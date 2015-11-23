var EddAcp = (function EddAcpClass() {

	EddAcp.prototype = Object.create(Object.prototype);

	var $ = jQuery;

	function EddAcp() {
		this.initElems();
		this.initEvents();
		this.testing = false;
	}

	EddAcp.prototype.initElems = function() {
		this.popup = $('#edd-acp-popup');
		this.eddPurchaseWrapper = $('.edd_purchase_submit_wrapper');
		this.eddPurchaseButton = this.eddPurchaseWrapper.find('a.edd-add-to-cart');
		this.itemName = $('h1.entry-title > span').text();
		this.popup.find('strong.item-name').text(this.itemName);
		this.popup.find('a.edd-acp-goto-checkout').attr('href', edd_scripts.checkout_page);
	};

	EddAcp.prototype.initEvents = function() {
		this.eddPurchaseButton.click(this.onPurchaseClick.bind(this));
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
	window.eddAcp = new EddAcp();
});
