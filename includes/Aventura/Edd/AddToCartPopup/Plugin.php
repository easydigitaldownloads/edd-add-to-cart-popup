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
	 * Constructor
	 * @param string $mainFile The plugin main file name.
	 */
	public function __construct($mainFile) {
		$this->_setMainFile($mainFile)
				->resetHookLoader();
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
	 * @return Aventura\Edd\AddToCartPopup\HookLoader
	 */
	public function resetHookLoader() {
		$this->_hookLoader = new HookLoader();
		return $this;
	}

	/**
	 * "Executes" the plugin.
	 * 
	 * @return Aventura\Edd\AddToCartPopup\Plugin This instance
	 */
	public function run() {
		$this->getHookLoader()->registerHooks();
		return $this;
	}

}
