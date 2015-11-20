<?php

namespace Aventura\Edd\AddToCartPopup\Plugin;

/**
 * Settings controller class, which acts as a wrapper for the database option.
 */
class Settings {

	/**
	 * Default name of the db option
	 */
	const DEFAULT_DB_OPTION_NAME = '';

	/**
	 * The parent plugin instance.
	 * 
	 * @var Aventura\Edd\AddToCartPopup\Plugin
	 */
	protected $_plugin;

	/**
	 * The name of the db option.
	 *
	 * @var string
	 */
	protected $_dbOptionName;

	/**
	 * The value stored in the db option.
	 * 
	 * @var mixed
	 */
	protected $_value = null;

	/**
	 * The settings fields.
	 * 
	 * @var array
	 */
	protected $_sections = array();

	/**
	 * Settings tab label.
	 * 
	 * @var string
	 */
	protected $_tabLabel = 'Add to Cart Popup';
	protected $_tabPosition = -1;
	protected $_tabSlug = 'acp';

	/**
	 * Constructor.
	 */
	public function __construct($plugin) {
		$this->setPlugin($plugin)
				->setDbOptionName(self::DEFAULT_DB_OPTION_NAME)
				->_construct();
	}
	
	/**
	 * Internal constructor.
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
	 * @return Aventura\Edd\AddToCartPopup\Plugin\Settings This instance
	 */
	public function setPlugin($plugin) {
		$this->_plugin = $plugin;
		return $this;
	}

	/**
	 * Gets the name of the DB option.
	 * 
	 * @return string
	 */
	public function getDbOptionName() {
		return $this->_dbOptionName;
	}
	
	/**
	 * Sets the name of the DB option.
	 *
	 * @param string $dbOptionName The name of the DB option
	 * @return Aventura\Edd\AddToCartPopup\Plugin\Settings This instance.
	 */
	public function setDbOptionName($dbOptionName) {
		$this->_dbOptionName = $dbOptionName;
		return $this;
	}

	/**
	 * Gets the tab slug.
	 * 
	 * @return string
	 */
	public function getTabSlug() {
		return $this->_tabSlug;
	}

	/**
	 * Sets the tab slug.
	 * 
	 * @param string $tabSlug The new tab slug.
	 * @return Aventura\Edd\AddToCartPopup\Plugin This instance
	 */
	public function setTabSlug($tabSlug) {
		$this->_tabSlug = $tabSlug;
		return $this;
	}

	/**
	 * Gets the settings tab label text.
	 * 
	 * @return string
	 */
	public function getTabLabel() {
		return $this->_tabLabel;
	}

	/**
	 * Sets the settings tabs label.
	 * 
	 * @param string $tabLabel The new label text
	 * @return Aventura\Edd\AddToCartPopup\Plugin This instance
	 */
	public function setTabLabel($tabLabel) {
		$this->_tabLabel = $tabLabel;
		return $this;
	}

	/**
	 * Gets the settings tab position.
	 * 
	 * @return integer
	 */
	public function getTabPosition() {
		return $this->_tabPosition;
	}

	/**
	 * Sets the settings tab position.
	 * 
	 * @param integer $tabPosition
	 * @return Aventura\Edd\AddToCartPopup\Plugin This instance
	 */
	public function setTabPosition($tabPosition) {
		$this->_tabPosition = $tabPosition;
		return $this;
	}

	/**
	 * Gets the value stored in the DB option.
	 * 
	 * @param  string $sub     (Optional) The index of the subvalue to retrieve. Default: null
	 * @param  mixed  $default (Optional) The value for the function to return if $sub is not null and is not found. Default: null
	 * @return mixed           If not params are specificed, the value stored in the option is returned, or array() if the option does not exist.
	 *                         Otherwise, the subvalue with index $sub is returned, and if not found $default is returned.
	 */
	public function getValue($sub = null, $default = null) {
		if ($this->_value === null) {
			$eddSettings = get_option( 'edd_settings', array() );
			$this->_value = isset($eddSettings[ $this->getDbOptionName() ])
					? $eddSettings[ $this->getDbOptionName() ]
					: array();
		}
		return ($sub === null)
				? $this->_value
				: $this->getSubValue($sub, $default);
	}

	/**
	 * Gets a subvalue from the db value.
	 * 
	 * @param  string $sub     The index of the subvalue to retrieve
	 * @param  mixed  $default (Optional) The value for the function to return if the subvalue is not found. Default: null
	 * @return mixed           The subvalue, or the value of $default if not found.
	 */
	public function getSubValue($sub, $default = null) {
		return isset($this->_value[$sub])
				? $this->_value[$sub]
				: $default;
	}

	/**
	 * Adds a settings section.
	 * 
	 * @param string   $id       The section ID.
	 * @param string   $title    The section title.
	 * @param string   $desc     The section description.
	 * @param callable $callback The callback that renders the section.
	 * @return Aventura\Edd\AddToCartPopup\Plugin This instance
	 */
	public function addSection($id, $title, $desc, $callback) {
		$this->_sections[$id] = (object) compact('id', 'title', 'desc', 'callback');
		return $this;
	}

	/**
	 * Checks if a settings section has been registered.
	 * 
	 * @param  string  $id The ID of the section to search for.
	 * @return boolean     True if the sectipon is found, false otherwise.
	 */
	public function hasSection($id) {
		return isset($this->_sections[$id]);
	}

	/**
	 * Removes a settings section.
	 * 
	 * @param  string $id The ID of the section to remove.
	 */
	public function removeSection($id) {
		unset($this->_sections[$id]);
	}

	/**
	 * Gets a settings sections.
	 * 
	 * @param  string $id The ID of the settings section to return.
	 * @return mixed      The settings section as an array or null if a section did not match the given $id.
	 */
	public function getSection($id) {
		return $this->hasSection($id)
				? $this->_sections[$id]
				: null;
	}

	/**
	 * Registers the tab in the EDD settings page.
	 * 
	 * @param  array $tabs The original EDD tabs array
	 * @return array       The tabs with the added messages tab
	 */
	public function filterEddSettingsTabs($tabs) {
		$last = array_splice($tabs, $this->getTabPosition());
		$mid = array($this->getTabSlug() => $this->getTabLabel());
		return array_merge($tabs, $mid, $last);
	}

	/**
	 * Registers the settings.
	 * 
	 * @param  array $settings The original EDD settings array.
	 * @return array
	 */
	public function filterEddSettings($settings) {
		// Create new entry for our settings tab
		$tab = $this->getTabSlug();
		$settings[$tab] = array();
		// Iterate sections
		foreach ($this->_sections as $_sectionId => $_section) {
			// Add the section to the EDD settings
			$settings[$tab][$_sectionId] = array(
				'id'		=>	$_sectionId,
				'name'		=>	$_section->title,
				'desc'		=>	$_section->desc,
				'type'		=>	'hook',
			);
			// Add the action for the callback that renders this section
			$actionHook = sprintf('edd_%s', $_sectionId);
			$this->getPlugin()->getHookLoader()->addAction($actionHook, $this, 'renderSection');
		}
		return $settings;
	}

	/**
	 * Renders a settings section, by calling its registered callback.
	 * 
	 * @param array $args Section information provided by EDD's settings API.
	 */
	public function renderSection($args) {
		$section = $this->getSection($args['id']);
		if ($section !== null) {
			call_user_func($section->callback, $args);
		} else {
			trigger_error(sprintf('Invalid callback given for settings section "%s"', $args['id']));
		}
	}

	/**
	 * Registers the settings with EDD.
	 * 
	 * @return Aventura\Edd\AddToCartPopup\Plugin\Settings This instance
	 */
	public function register() {
		$this->getPlugin()->getHookLoader()->queueFilter( 'edd_settings_tabs', $this, 'filterEddSettingsTabs' );
		$this->getPlugin()->getHookLoader()->queueFilter( 'edd_registered_settings', $this, 'filterEddSettings' );
		return $this;
	}

}
