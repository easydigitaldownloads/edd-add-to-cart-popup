<?php

namespace Aventura\Edd\AddToCartPopup\Core;

/**
 * Settings controller class, which acts as a wrapper for the database option.
 */
class Settings extends Plugin\Module {

	/**
	 * The name of the option that EDD uses.
	 */
	const EDD_SETTINGS_OPTION_NAME = 'edd_settings';

	/**
	 * Default name of the db option
	 */
	const DEFAULT_DB_OPTION_NAME = 'acp';

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
	 * The settings options.
	 * 
	 * @var array
	 */
	protected $_options = array();

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
	protected function _construct() {
		$this->setDbOptionName(self::DEFAULT_DB_OPTION_NAME);
	}

	/**
	 * Execution method, run on 'edd_acp_on_run' action.
	 */
	public function run() {
		$this->register();
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
	 * @return Aventura\Edd\AddToCartPopup\Core\Settings This instance.
	 */
	public function setDbOptionName($dbOptionName) {
		$this->_dbOptionName = $dbOptionName;
		return $this;
	}

	/**
	 * Gets the option name for a subvalue.
	 * 
	 * @param  string $subName The name of the subvalue.
	 * @return string
	 */
	public function getSubValueOptionName($subName) {
		return sprintf('%1$s[%2$s][%3$s]', self::EDD_SETTINGS_OPTION_NAME, $this->getDbOptionName(), $subName);
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
	 * @return Aventura\Edd\AddToCartPopup\Core\Settings This instance
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
	 * @return Aventura\Edd\AddToCartPopup\Core\Settings This instance
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
	 * @return Aventura\Edd\AddToCartPopup\Core\Settings This instance
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
			$eddSettings = get_option( self::EDD_SETTINGS_OPTION_NAME, array() );
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
				: ( isset($this->_options[$sub])
							? $this->_options[$sub]->default
							: $default );
	}

	/**
	 * Adds a settings option.
	 * 
	 * @param string   $id       The option ID.
	 * @param string   $title    The option title.
	 * @param string   $desc     The option description.
	 * @param mixed    $default  The default value of the option.
	 * @param callable $callback The callback that renders the option.
	 * @return Aventura\Edd\AddToCartPopup\Core\Settings This instance
	 */
	public function addOption($id, $title, $desc, $default, $callback) {
		$this->_options[$id] = (object) compact('id', 'title', 'desc', 'default', 'callback');
		return $this;
	}

	/**
	 * Checks if a settings option has been registered.
	 * 
	 * @param  string  $id The ID of the option to search for.
	 * @return boolean     True if the option is found, false otherwise.
	 */
	public function hasOption($id) {
		return isset($this->_options[$id]);
	}

	/**
	 * Removes a settings option.
	 * 
	 * @param  string $id The ID of the option to remove.
	 */
	public function removeOption($id) {
		unset($this->_options[$id]);
	}

	/**
	 * Gets a settings options.
	 * 
	 * @param  string $id The ID of the settings option to return.
	 * @return mixed      The settings option as an array or null if a option did not match the given $id.
	 */
	public function getOption($id) {
		return $this->hasOption($id)
				? $this->_options[$id]
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
		// Iterate options
		foreach ($this->_options as $_optionId => $_option) {
			// Add the option to the EDD settings
			$settings[$tab][$_optionId] = array(
				'id'		=>	$_optionId,
				'name'		=>	$_option->title,
				'desc'		=>	$_option->desc,
				'type'		=>	'hook',
			);
			// Add the action for the callback that renders this option
			$actionHook = sprintf('edd_%s', $_optionId);
			$this->getPlugin()->getHookLoader()->addAction($actionHook, $this, 'renderOption');
		}
		return $settings;
	}

	/**
	 * Renders a settings option, by calling its registered callback.
	 * 
	 * @param array $args Option information provided by EDD's settings API.
	 */
	public function renderOption($args) {
		$option = $this->getOption($args['id']);
		if ($option !== null) {
			call_user_func_array($option->callback,
				array($this, $args['id'], $args['desc'], $args)
			);
		} else {
			trigger_error(sprintf('Invalid callback given for settings option "%s"', $args['id']));
		}
	}

	/**
	 * Registers the settings with EDD.
	 * 
	 * @return Aventura\Edd\AddToCartPopup\Core\Settings This instance
	 */
	public function register() {
		$this->getPlugin()->getHookLoader()->queueFilter( 'edd_settings_tabs', $this, 'filterEddSettingsTabs' );
		$this->getPlugin()->getHookLoader()->queueFilter( 'edd_registered_settings', $this, 'filterEddSettings' );
		return $this;
	}

}
