<?php

use \Aventura\Edd\AddToCartPopup\Core\StyleRenderer;

// Get settings instance
$settings = !is_null($viewbag->settings)
    ? $viewbag->settings
    : $this->getPlugin()->getSettings();

// Get item name
if ($viewbag->downloadId === 0) {
    $itemName = __('Test', 'edd_acp');
} else {
    $itemName = the_title_attribute(array(
        'before' => '',
        'after'  => '',
        'echo'   => false,
        'post'   => $viewbag->downloadId
    ));
}
// Filter it
$filteredItemName = apply_filters('edd_acp_item_name', $itemName, $viewbag->downloadId, $settings);

do_action('edd_acp_before_popup_view', $viewbag->downloadId, $settings);

// Prepare some style vars
$border = $settings->getValue('border');
$shadow = $settings->getValue('shadow');
$shadowColor = StyleRenderer::colorHexToRgba($shadow['color'], $shadow['opacity']);

/**
 * Print styles.
 */
$popupStyles = array(
    '' => array(
        'background-color' => $settings->getSubValue('bgcolor'),
        'box-shadow'       => sprintf('0 0 %spx %s', $shadow['blur'], $shadowColor),
        'border'           => sprintf('%dpx %s %s', $border['width'], $border['style'], $border['color']),
    ),
    'p' => array(
        'color'            => $settings->getSubValue('textcolor'),
        'font-size'        => $settings->getSubValue('fontsize'),
    ),
    'button.button' => array(
        'padding'          => $settings->getSubValue('btnPadding'),
        'border'           => $settings->getSubValue('btnBorder'),
        'border-radius'    => sprintf('%spx', $settings->getSubValue('btnBorderRadius')),
        'font-size'        => $settings->getSubValue('fontsize'),
    ),
    'button.edd-acp-checkout-btn' => array(
        'color'            => $settings->getSubValue('checkoutBtnTextColor'),
        'background'       => $settings->getSubValue('checkoutBtnBgColor')
    ),
    'button.edd-acp-checkout-btn:hover' => array(
        'color'            => $settings->getSubValue('checkoutBtnHoverTextColor'),
        'background'       => $settings->getSubValue('checkoutBtnHoverBgColor')
    ),
    'button.edd-acp-continue-btn' => array(
        'color'            => $settings->getSubValue('continueBtnTextColor'),
        'background'       => $settings->getSubValue('continueBtnBgColor')
    ),
    'button.edd-acp-continue-btn:hover' => array(
        'color'            => $settings->getSubValue('continueBtnHoverTextColor'),
        'background'       => $settings->getSubValue('continueBtnHoverBgColor')
    ),
);
$popupStylesFiltered = apply_filters('edd_acp_popup_styles', $popupStyles, $settings);
echo StyleRenderer::renderStyles($popupStylesFiltered, 'body div.edd-acp-popup', true);

$overlayStyles = array(
);
$overlayStylesFiltered = apply_filters('edd_acp_overlay_styles', $overlayStyles, $settings);
echo StyleRenderer::renderStyles($overlayStylesFiltered, 'body', true);
?>

<div class="edd-acp-popup">

    <?php do_action('edd_acp_inside_popup_view_top', $viewbag->downloadId, $settings); ?>

    <input type="hidden" class="edd-acp-item-name" value="<?php echo esc_attr($filteredItemName); ?>" />
    <div class="edd-acp-popup-singular">
        <?php
        $singularText = apply_filters('edd_acp_popup_singular_text', $settings->getSubValue('maintext'),
            $viewbag->downloadId, $settings);
        $singularTextFormatted = sprintf($singularText, '<strong class="item-name"></strong>');
        $formattedSingular = apply_filters('edd_acp_popup_singular_text_formatted', $singularTextFormatted, $viewbag->downloadId,
            $settings);
        echo wpautop($formattedSingular);
        ?>
    </div>
    <div class="edd-acp-popup-plural">
        <?php
        $pluralText = apply_filters('edd_acp_popup_plural_text', $settings->getSubValue('pluraltext'),
            $viewbag->downloadId, $settings);
        $pluralTextFormatted = sprintf($pluralText, '<strong class="item-name"></strong>');
        echo apply_filters('edd_acp_popup_plural_text_formatted', $pluralTextFormatted, $viewbag->downloadId, $settings);
        ?>
    </div>
    <div>
        <?php
        // If Checkout button is enabled
        if ((bool)($settings->getSubValue('showCheckoutBtn'))) {
            // Filter the text
            $checkoutBtnText = apply_filters('edd_acp_popup_checkout_button_text',
                $settings->getSubValue('checkoutBtnText'),
                $viewbag->downloadId,
                $settings
            );
            $checkoutBtnEscapedText = esc_html($checkoutBtnText);
            printf('<a href="#" class="edd-acp-goto-checkout"><button class="button edd-acp-checkout-btn">%s</button></a>', $checkoutBtnEscapedText);
        }
        // If Continue Shopping button is enabled
        if ((bool)($settings->getSubValue('showContinueBtn'))) {
            // Filter the text
            $continueBtnText = apply_filters('edd_acp_popup_continue_button_text',
                $settings->getSubValue('continueBtnText'),
                $viewbag->downloadId,
                $settings
            );
            $continueBtnEscapedText = esc_html($continueBtnText);
            printf('<button class="button edd-acp-close-popup edd-acp-continue-btn">%s</button>', $continueBtnEscapedText);
        }
        ?>
    </div>

<?php do_action('edd_acp_inside_popup_view_bottom', $viewbag->downloadId, $settings); ?>

</div>

<?php do_action('edd_acp_after_popup_view'); ?>