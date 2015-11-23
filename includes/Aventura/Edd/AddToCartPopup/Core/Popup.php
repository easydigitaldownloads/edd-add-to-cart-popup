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

	/**
	 * Execution method, run on 'edd_acp_on_run' action.
	 */
	public function run() {
		$this->getPlugin()->getHookLoader()->queueAction( 'edd_purchase_link_top', $this, 'render' );
	}

}
