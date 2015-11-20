<?php

namespace Aventura\Edd\AddToCartPopup;

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
	 * @var Aventura\Edd\AddToCartPopup\Plugin\Settings
	 */
	protected $_settings;

	/**
	 * @var Aventura\Edd\AddToCartPopup\Plugin\AssetsController
	 */
	protected $_assets;

	/**
	 * Constructor
	 * @param string $mainFile The plugin main file name.
	 */
	public function __construct($mainFile) {
		$this->_setMainFile($mainFile)
				->resetHookLoader()
				->setSettings(new Plugin\Settings($this))
				->setAssetsController(new Plugin\AssetsController($this));
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
	 * @return Aventura\Edd\AddToCartPopup\Plugin This instance.
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
	 * @return Aventura\Edd\AddToCartPopup\Plugin
	 */
	public function resetHookLoader() {
		$this->_hookLoader = new HookLoader();
		return $this;
	}

	/**
	 * Gets the settings.
	 * 
	 * @return Aventura\Edd\AddToCartPopup\Plugin\Settings
	 */
	public function getSettings() {
		return $this->_settings;
	}

	/**
	 * Sets the settings instance.
	 * 
	 * @param Aventura\Edd\AddToCartPopup\Plugin\Settings $settings
	 * @return Aventura\Edd\AddToCartPopup\Plugin
	 */
	public function setSettings($settings) {
		$this->_settings = $settings;
		return $this;
	}

	/**
	 * Gets the assets controller instance.
	 * 
	 * @return Aventura\Edd\AddToCartPopup\Plugin\AssetsController
	 */
	public function getAssetsController() {
		return $this->_assets;
	}

	/**
	 * Sets the assets controller instance.
	 * 
	 * @param Aventura\Edd\AddToCartPopup\Plugin\AssetsController $assetsController
	 * @return Aventura\Edd\AddToCartPopup\Plugin
	 */
	public function setAssetsController(\Aventura\Edd\AddToCartPopup\Plugin\AssetsController $assetsController) {
		$this->_assets = $assetsController;
		return $this;
	}

	/**
	 * "Executes" the plugin.
	 * 
	 * @return Aventura\Edd\AddToCartPopup\Plugin This instance
	 */
	public function run() {
		// Code to execute after all initialization and before any hook triggers
		
		// Register settings
		$this->getSettings()->register();

		// Hook all queued hooks
		$this->getHookLoader()->registerQueue();

		return $this;
	}

}
