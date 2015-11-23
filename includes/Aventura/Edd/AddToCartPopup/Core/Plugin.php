<?php

namespace Aventura\Edd\AddToCartPopup\Core;
use Aventura\Edd\AddToCartPopup\Core\AssetsController;

/**
 * Plugin object class.
 */
class Plugin {

	/**
	 * @var string
	 */
	protected $_mainFile;

	/**
	 * @var Aventura\Edd\AddToCartPopup\HookLoader
	 */
	protected $_hookLoader;

	/**
	 * @var Aventura\Edd\AddToCartPopup\Core\Settings
	 */
	protected $_settings;

	/**
	 * @var Aventura\Edd\AddToCartPopup\Core\AssetsController
	 */
	protected $_assets;

	/**
	 * @var Aventura\Edd\AddToCartPopup\Core\ViewsController
	 */
	protected $_views;

	/**
	 * @var Aventura\Edd\AddToCartPopup\Core\Popup
	 */
	protected $_popup;

	/**
	 * Constructor
	 * @param string $mainFile The plugin main file name.
	 */
	public function __construct($mainFile) {
		$this->_setMainFile($mainFile)
				->resetHookLoader()
				->setSettings(new Settings($this))
				->setAssetsController(new AssetsController($this))
				->setViewsController(new ViewsController($this))
				->setPopup(new Popup($this));
	}

	/**
	 * Gets the plugin main file name.
	 * 
	 * @return string The plugin main file name.
	 */
	public function getMainFile() {
		return $this->_mainFile;
	}

	/**
	 * Sets the plugin main file name.
	 * 
	 * @param string $mainFile The plugin main file name.
	 * @return Aventura\Edd\AddToCartPopup\Core\Plugin This instance.
	 */
	protected function _setMainFile($mainFile) {
		$this->_mainFile = $mainFile;
		return $this;
	}

	/**
	 * Gets the hook loader.
	 * 
	 * @return Aventura\Edd\AddToCartPopup\HookLoader
	 */
	public function getHookLoader() {
		return $this->_hookLoader;
	}

	/**
	 * Resets the hook loader.
	 *
	 * @return Aventura\Edd\AddToCartPopup\Core\Plugin
	 */
	public function resetHookLoader() {
		$this->_hookLoader = new HookLoader();
		return $this;
	}

	/**
	 * Gets the settings.
	 * 
	 * @return Aventura\Edd\AddToCartPopup\Core\Settings
	 */
	public function getSettings() {
		return $this->_settings;
	}

	/**
	 * Sets the settings instance.
	 * 
	 * @param Aventura\Edd\AddToCartPopup\Core\Settings $settings
	 * @return Aventura\Edd\AddToCartPopup\Core\Plugin
	 */
	public function setSettings($settings) {
		$this->_settings = $settings;
		return $this;
	}

	/**
	 * Gets the assets controller instance.
	 * 
	 * @return Aventura\Edd\AddToCartPopup\Core\AssetsController
	 */
	public function getAssetsController() {
		return $this->_assets;
	}

	/**
	 * Sets the assets controller instance.
	 * 
	 * @param Aventura\Edd\AddToCartPopup\Core\AssetsController $assetsController
	 * @return Aventura\Edd\AddToCartPopup\Core\Plugin
	 */
	public function setAssetsController(AssetsController $assetsController) {
		$this->_assets = $assetsController;
		return $this;
	}

	/**
	 * Gets the views controller instance.
	 * 
	 * @return Aventura\Edd\AddToCartPopup\Core\ViewsController
	 */
	public function getViewsController() {
		return $this->_views;
	}

	/**
	 * Sets the views controller instance.
	 * 
	 * @param Aventura\Edd\AddToCartPopup\Core\ViewsController $viewsController
	 * @return Aventura\Edd\AddToCartPopup\Core\Plugin
	 */
	public function setViewsController(ViewsController $viewsController) {
		$this->_views = $viewsController;
		return $this;
	}

	/**
	 * Gets the popup instance.
	 * 
	 * @return Aventura\Edd\AddToCartPopup\Core\Popup
	 */
	public function getPopup() {
		return $this->_popup;
	}

	/**
	 * Sets the popup instance.
	 * 
	 * @param Aventura\Edd\AddToCartPopup\Core\Popup $popup
	 * @return Aventura\Edd\AddToCartPopup\Core\Plugin
	 */
	public function setPopup(Popup $popup) {
		$this->_popup = $popup;
		return $this;
	}

	/**
	 * Code to execute after all initialization and before any hook triggers
	 * 
	 * @return Aventura\Edd\AddToCartPopup\Core\Plugin This instance
	 */
	public function run() {
		do_action('edd_acp_on_run');

		// Hook all queued hooks
		$this->getHookLoader()->registerQueue();

		return $this;
	}

}
