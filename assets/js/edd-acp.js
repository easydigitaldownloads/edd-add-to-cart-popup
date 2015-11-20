;(function($) {

	var eddAddToCartClick = function(event) {
		console.log('Clicked the "Add to Cart" button!');
	};

	$(document).ready(function() {
		$('.edd_purchase_submit_wrapper > a.edd-add-to-cart').click(eddAddToCartClick);
	});

})(jQuery);