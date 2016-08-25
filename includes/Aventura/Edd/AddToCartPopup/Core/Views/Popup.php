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
$padding = $settings->getValue('padding');

/**
 * Print styles.
 */
$popupStyles = array(
    '' => array(
        'background-color' => $settings->getValue('bgcolor'),
        'box-shadow'       => sprintf('0 0 %spx %s', $shadow['blur'], $shadowColor),
        'border'           => sprintf('%dpx %s %s', $border['width'], $border['style'], $border['color']),
        'border-radius'    => sprintf('%dpx', $settings->getValue('borderRadius')),
        'padding-top'      => sprintf('%dpx', $padding['top']),
        'padding-bottom'   => sprintf('%dpx', $padding['bottom']),
        'padding-left'     => sprintf('%dpx', $padding['left']),
        'padding-right'    => sprintf('%dpx', $padding['right']),
    ),
    'p' => array(
        'color'            => $settings->getValue('textcolor'),
        'font-size'        => $settings->getValue('fontsize'),
    ),
    'button.button' => array(
        'padding'          => $settings->getValue('btnPadding'),
        'border'           => $settings->getValue('btnBorder'),
        'border-radius'    => sprintf('%spx', $settings->getValue('btnBorderRadius')),
        'font-size'        => $settings->getValue('fontsize'),
    ),
    'button.edd-acp-checkout-btn' => array(
        'color'            => $settings->getValue('checkoutBtnTextColor'),
        'background'       => $settings->getValue('checkoutBtnBgColor')
    ),
    'button.edd-acp-checkout-btn:hover' => array(
        'color'            => $settings->getValue('checkoutBtnHoverTextColor'),
        'background'       => $settings->getValue('checkoutBtnHoverBgColor')
    ),
    'button.edd-acp-continue-btn' => array(
        'color'            => $settings->getValue('continueBtnTextColor'),
        'background'       => $settings->getValue('continueBtnBgColor')
    ),
    'button.edd-acp-continue-btn:hover' => array(
        'color'            => $settings->getValue('continueBtnHoverTextColor'),
        'background'       => $settings->getValue('continueBtnHoverBgColor')
    ),
);
$popupStylesFiltered = apply_filters('edd_acp_popup_styles', $popupStyles, $settings);
echo StyleRenderer::renderStyles($popupStylesFiltered, 'body div.edd-acp-popup', true);

// Prepare some overlay style vars
$overlay = $settings->getValue('overlay');

$overlayStyles = array(
    '.b-modal' => array(
        'background-color' => sprintf('%s !important', $overlay['color']),
        'opacity'          => sprintf('%.2f !important', $overlay['opacity']),
    )
);
$overlayStylesFiltered = apply_filters('edd_acp_overlay_styles', $overlayStyles, $settings);
echo StyleRenderer::renderStyles($overlayStylesFiltered, 'body', true);
?>

<div class="edd-acp-popup">

    <?php do_action('edd_acp_inside_popup_view_top', $viewbag->downloadId, $settings); ?>

    <input type="hidden" class="edd-acp-item-name" value="<?php echo esc_attr($filteredItemName); ?>" />
    <div class="edd-acp-popup-singular">
        <?php
        $singularText = apply_filters('edd_acp_popup_singular_text', $settings->getValue('maintext'),
            $viewbag->downloadId, $settings);
        $singularTextFormatted = sprintf($singularText, '<strong class="item-name"></strong>');
        $formattedSingular = apply_filters('edd_acp_popup_singular_text_formatted', $singularTextFormatted, $viewbag->downloadId,
            $settings);
        echo wpautop($formattedSingular);
        ?>
    </div>
    <div class="edd-acp-popup-plural">
        <?php
        $pluralText = apply_filters('edd_acp_popup_plural_text', $settings->getValue('pluraltext'),
            $viewbag->downloadId, $settings);
        $pluralTextFormatted = sprintf($pluralText, '<strong class="item-name"></strong>');
        echo apply_filters('edd_acp_popup_plural_text_formatted', $pluralTextFormatted, $viewbag->downloadId, $settings);
        ?>
    </div>
    <div class="edd-acp-button-container edd-acp-buttons-<?php echo esc_attr($settings->getValue('btnAlignment')) ?>">
        <?php
        // If Checkout button is enabled
        if ((bool)($settings->getValue('showCheckoutBtn'))) {
            // Filter the text
            $checkoutBtnText = apply_filters('edd_acp_popup_checkout_button_text',
                $settings->getValue('checkoutBtnText'),
                $viewbag->downloadId,
                $settings
            );
            $checkoutBtnEscapedText = esc_html($checkoutBtnText);
            printf('<a href="#" class="edd-acp-goto-checkout"><button class="button edd-acp-checkout-btn">%s</button></a>', $checkoutBtnEscapedText);
        }
        // If Continue Shopping button is enabled
        if ((bool)($settings->getValue('showContinueBtn'))) {
            // Filter the text
            $continueBtnText = apply_filters('edd_acp_popup_continue_button_text',
                $settings->getValue('continueBtnText'),
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