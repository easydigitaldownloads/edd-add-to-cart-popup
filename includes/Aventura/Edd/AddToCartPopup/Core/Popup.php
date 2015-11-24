<?php

namespace Aventura\Edd\AddToCartPopup\Core;

/**
 * Represents the popup to be show on the front-end.
 */
class Popup extends Plugin\Module {

	/**
	 * Display options for the popup.
	 * 
	 * @var array
	 */
	protected $_display;

	/**
	 * Constructor.
	 */
	protected function _construct() {
		$this->setDisplayOptions(
				$this->getPlugin()->getSettings()->getValue('display', array())
		);
	}

	/**
	 * Gets the display options.
	 * 
	 * @return array
	 */
	public function getDisplayOptions() {
		return $this->_display;
	}

	/**
	 * Sets the display options.
	 * 
	 * @param array $display
	 */
	public function setDisplayOptions($display) {
		$this->_display = $display;
	}

	/**
	 * Renders the popup HTML.
	 * 
	 * @return string The rendered popup
	 */
	public function render() {
		echo $this->getPlugin()->getViewsController()->renderView('Popup');
	}

	public function enqueueAssets() {
		// Register assets
		$this->getPlugin()->getAssetsController()
				->registerScript('edd_acp_bpopup', EDD_ACP_JS_URL . 'jquery.bpopup.min.js')
				->registerScript('edd_acp_frontend_js', EDD_ACP_JS_URL . 'edd-acp.js', array('edd_acp_bpopup'))
				->registerStyle('edd_acp_frontend_css', EDD_ACP_CSS_URL . 'edd-acp-popup.css');
		// Enqueue front-end main script if on a singular download page
		if (is_singular() && get_post_type() === 'download') {
			$this->getPlugin()->getAssetsController()
					->enqueueStyle('edd_acp_frontend_css')
					->enqueueScript('edd_acp_frontend_js');
		}
	}

	/**
	 * Execution method, run on 'edd_acp_on_run' action.
	 */
	public function run() {
		// If the enabled toggle option is turned on
		if ($this->getPlugin()->getSettings()->getValue('enabled') == '1') {
			$this->getPlugin()->getHookLoader()
					// Hook in the popup render
					->queueAction( 'edd_purchase_link_top', $this, 'render' )
					->queueAction( AssetsController::HOOK_FRONTEND, $this, 'enqueueAssets' );
		}
	}

}
