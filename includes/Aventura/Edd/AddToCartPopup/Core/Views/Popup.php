<?php
// Get settings instance
$settings = $this->getPlugin()->getSettings();
// Prepare style attribute value
$style = sprintf(
    'color: %1$s; background: %2$s;', $settings->getSubValue('textcolor'), $settings->getSubValue('bgcolor')
);
// Get item name
$itemName = the_title_attribute(array(
    'before' => '',
    'after'  => '',
    'echo'   => false,
    'post'   => $viewbag->downloadId
));
// Filter it
$filteredItemName = apply_filters('edd_acp_item_name', $itemName, $viewbag->downloadId, $settings);

do_action('edd_acp_before_popup_view', $viewbag->downloadId, $settings);
?>

<div class="edd-acp-popup" style="<?php echo esc_attr($style); ?>">

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
        $checkoutButtonText = apply_filters('edd_acp_popup_checkout_button_text',
            $settings->getSubValue('checkoutBtnText'), $viewbag->downloadId, $settings);
        $continueButtonText = apply_filters('edd_acp_popup_continue_button_text',
            $settings->getSubValue('continueBtnText'), $viewbag->downloadId, $settings);
        ?>
        <a href="#" class="edd-acp-goto-checkout"><button class="button"><?php echo esc_html($checkoutButtonText); ?></button></a>
        <button class="button edd-acp-close-popup"><?php echo esc_html($continueButtonText); ?></button>
    </div>

<?php do_action('edd_acp_inside_popup_view_bottom', $viewbag->downloadId, $settings); ?>

</div>

<?php do_action('edd_acp_after_popup_view'); ?>