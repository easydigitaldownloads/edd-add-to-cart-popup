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
	public function render($downloadId, Settings $settings = null) {
        $args = compact('downloadId', 'settings');
		echo $this->getPlugin()->getViewsController()->renderView('Popup', $args);
	}

    /**
     * Generates a preview.
     */
    public function generatePreview(array $settings = array()) {
        // Create a dummy instance
        $dummyInstance = new Settings($this->getPlugin());
        $dummyInstance->setDbOptionName('acp_preview');
        // Register the options to the dummy instance
        eddAcpRegisterOptions($dummyInstance);
        $dummyInstance->setValuesCache($settings);
        // Generate the render using the dummy settings instance
        return $this->render(0, $dummyInstance);
    }

    /**
     * Generates a preview for an AJAX event.
     *
     * Expects the POST 'settings' index to contain an array of the settings values.
     */
    public function ajaxPreview() {
        $settings = filter_input(INPUT_POST, 'settings', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        echo $this->generatePreview($settings);
        die;
    }

	public function enqueueAssets() {
		// Register assets
		$this->getPlugin()->getAssetsController()
				->registerScript('edd_acp_bpopup', EDD_ACP_JS_URL . 'jquery.bpopup.min.js', array('jquery'))
				->registerScript('edd_acp_frontend_js', EDD_ACP_JS_URL . 'edd-acp.js', array('edd_acp_bpopup'))
				->registerStyle('edd_acp_frontend_css', EDD_ACP_CSS_URL . 'edd-acp-popup.css');
		// Enqueue front-end main script
		$this->getPlugin()->getAssetsController()
				->enqueueStyle('edd_acp_frontend_css')
				->enqueueScript('edd_acp_frontend_js');
	}

	/**
	 * Checks for the EDD AJAX option and shows a notice if needed.
	 */
	public function checkEddAjax() {
		global $typenow;
		if ( $typenow === 'download' && $this->getPlugin()->getSettings()->getValue('enabled') == '1' ) {
			$eddSettings = get_option(Settings::EDD_SETTINGS_OPTION_NAME, array());
			if ( !isset($eddSettings['enable_ajax_cart']) || $eddSettings['enable_ajax_cart'] == '0' ) {
				ob_start(); ?>
				<div class="error settings-error notice is-dismissible">
					<p>%s</p>
					<button type="button" class="notice-dismiss">
						<span class="screen-reader-text"><?php _e('Dismiss this notice.'); ?></span>
					</button>
				</div>
				<?php
				printf(
					ob_get_clean(),
					__('The Add to Cart Popup requires the "Enable Ajax" option (in the Misc settings page) to be enabled for the plugin to work correctly.', 'edd_acp')
				);
			}
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
					->queueAction( AssetsController::HOOK_FRONTEND, $this, 'enqueueAssets' )
                    ->queueAction( AssetsController::HOOK_ADMIN, $this, 'enqueueAssets' );
		}
		// Check for EDD's AJAX option
		if ( is_admin() ) {
			$this->getPlugin()->getHookLoader()->queueAction('admin_notices', $this, 'checkEddAjax');
            $this->getPlugin()->getHookLoader()->queueAction('wp_ajax_edd_acp_preview', $this, 'ajaxPreview');
		}
	}

}
