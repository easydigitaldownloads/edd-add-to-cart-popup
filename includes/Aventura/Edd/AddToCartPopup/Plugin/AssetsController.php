<?php

namespace Aventura\Edd\AddToCartPopup\Plugin;

/**
 * Assets controller class, for registering and enqueueing static assets.
 */
class AssetsController {

	// Asset type constants
	const TYPE_SCRIPT = 'script';
	const TYPE_STYLE = 'style';

	const HOOK_FRONTEND = 'wp_enqueue_scripts';
	const HOOK_ADMIN = 'admin_enqueue_scripts';
	const HOOK_LOGIN = 'login_enqueue_scripts';

	/**
	 * @var Aventura\Edd\AddToCartPopup\Plugin
	 */
	protected $_plugin;

	/**
	 * Constructor.
	 *
	 * @uses Assets::_construct()
	 */
	public function __construct($plugin = null) {
		$this->setPlugin($plugin)
				->_construct();
	}

	/**
	 * Internal constructor for extending.
	 * 
	 * @access protected
	 */
	protected function _construct() {}

	/**
	 * Gets the parent plugin instance to which this istance belongs to.
	 * 
	 * @return Aventura\Edd\AddToCartPopup\Plugin
	 */
	public function getPlugin() {
		return $this->_plugin;
	}

	/**
	 * Sets the parent plugin instance to which this instance belongs to.
	 * 
	 * @param Aventura\Edd\AddToCartPopup\Plugin $plugin The plugin instance
	 * @return Aventura\Edd\AddToCartPopup\Plugin\AssetsController This instance
	 */
	public function setPlugin($plugin) {
		$this->_plugin = $plugin;
		return $this;
	}

	/**
	 * Registers a script.
	 *
	 * @uses Assets::script()
	 * @see Assets::script()
	 */
	public function registerScript($handle, $src, $deps = array(), $ver = false, $in_footer = false) {
		return $this->script(false, $handle, $src, $deps, $ver, $in_footer);
	}

	/**
	 * Enqueues a script.
	 *
	 * @uses Assets::script()
	 * @see Assets::script()
	 */
	public function enqueueScript($handle, $src = null, $deps = array(), $ver = false, $in_footer = false) {
		return $this->script(true, $handle, $src, $deps, $ver, $in_footer);
	}

	/**
	 * All in one handler method for scripts.
	 *
	 * @param  boolean $enqueue   If true, the script is enqueued. If false, the script is only registered.
	 * @param  string  $handle    The script handle
	 * @param  string  $src       The path to the source file of the script
	 * @param  array   $deps      An array of script handles that this script depends upon. Default: array()
	 * @param  boolean $ver       The version of the script. Default: false
	 * @param  boolean $in_footer If true, the script is added to the footer of the page. If false, it is added to the document head. Default: false
	 * @return Aventura\Edd\AddToCartPopup\Plugin\AssetsController
	 */
	protected function script($enqueue, $handle, $src = null, $deps = array(), $ver = false, $in_footer = false) {
		return $this->handleAsset('script', $enqueue, $handle, $src, $deps, $ver, $in_footer);
	}

	/**
	 * Registers a style.
	 *
	 * @uses Assets::style()
	 * @see Assets::style()
	 */
	public function registerStyle($handle, $src, $deps = array(), $ver = false, $media = 'all') {
		return $this->style(false, $handle, $src, $deps, $ver, $media);
	}

	/**
	 * Enqueues a style.
	 *
	 * @uses Assets::style()
	 * @see Assets::style()
	 */
	public function enqueueStyle($handle, $src = null, $deps = array(), $ver = false, $media = 'all') {
		return $this->style(true, $handle, $src, $deps, $ver, $media);
	}

	/**
	 * All in one handler method for styles.
	 *
	 * @param  boolean $enqueue If true, the style is enqueued. If false, the style is only registered.
	 * @param  string  $handle  The style handle
	 * @param  string  $src     The path to the source file of the style
	 * @param  array   $deps    An array of style handles that this style depends upon. Default: array()
	 * @param  boolean $ver     The version of the style. Default: false
	 * @param  string  $media   The style's media scope. Default: all
	 * @return Aventura\Edd\AddToCartPopup\Plugin\AssetsController
	 */
	public function style($where, $enqueue, $handle, $src, $deps = array(), $ver = false, $media = 'all') {
		return $this->handleAsset('style', $where, $type, $enqueue, $handle, $src, $deps, $ver, $media);
	}

	/**
	 * All in one method for setting up a hook and callback for an asset.
	 * 
	 * @param  string  $type    Asset::TYPE_SCRIPT or Asset::TYPE_STYLE
	 * @param  boolean $enqueue If true, the asset is enqueued. If false, the asset is only registered.
	 * @param  string  $handle  The asset's handle string
	 * @param  string  $src     Path to the asset's source file
	 * @param  array   $deps    Array of other similar asset handles that this asset depends on.
	 * @param  string  $ver     String version of the asset, for caching purposes.
	 * @param  mixed   $extra   Extra data to be included, such as style media or script location in document.
	 * @return Aventura\Edd\AddToCartPopup\Plugin\AssetsController
	 */
	protected function handleAsset($type, $enqueue, $handle, $src, $deps, $ver, $extra) {
		// Generate name of function to use (whether for enqueueing or registration)
		$fn = sprintf('wp_%1$s_%2$s', $enqueue === true? 'enqueue' : 'register', $type);
		// Call the enqueue/register function
		call_user_func_array($fn, array($handle, $src, $deps, $ver, $extra));

		return $this;
	}
}
