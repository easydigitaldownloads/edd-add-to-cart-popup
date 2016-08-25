<?php

use \Aventura\Edd\AddToCartPopup\Core\Settings;

/**
 * Settings HTML rendering static class.
 */
abstract class EddAcpSettingsHtml
{

    /**
     * Renders a generic HTML field.
     * 
     * @param  string $type The type of the field to render. This should translate to a static method for this class.
     * @param  Settings $settings The settings class instance.
     * @param  string $id The ID of the option. Used to get the value to use when rendering the field.
     * @return string The HTML output.
     */
    public static function renderField($type, $settings, $id)
    {
        // Checks if method for this type exists, and the settings instance has the option with the given id.
        if (!method_exists(__CLASS__, $type) || !$settings->hasOption($id)) {
            return;
        }
        // Begin buffering
        ob_start();
        // Call the static method for the field's type, pasing the ID, option name and option value.
        echo self::$type($id, $settings->getSubValueOptionName($id), $settings->getSubValue($id));
        // Get the option description and output a label for the option field.
        $desc = $settings->getOption($id)->desc;
        printf('<label for="%1$s">%2$s</label>', esc_attr($id), nl2br(htmlentities($desc)));
        // Return the buffered output
        return ob_get_clean();
    }

    /**
     * Renders a regular text field.
     * 
     * @param  string $id The field ID.
     * @param  string $name The name attribute of the field.
     * @param  string $value The value of the field.
     * @return string The HTML output.
     */
    public static function text($id, $name, $value)
    {
        ob_start();
        ?>
        <input type="text"
               class="regular-text"
               id="<?php echo esc_attr($id); ?>"
               name="<?php echo esc_attr($name); ?>"
               value="<?php echo esc_attr($value); ?>"
               />
        <br/>
        <?php
        return ob_get_clean();
    }

    /**
     * Renders a small text field.
     * 
     * @param  string $id The field ID.
     * @param  string $name The name attribute of the field.
     * @param  string $value The value of the field.
     * @return string The HTML output.
     */
    public static function smalltext($id, $name, $value)
    {
        ob_start();
        ?>
        <input type="text"
               class="small-text"
               id="<?php echo esc_attr($id); ?>"
               name="<?php echo esc_attr($name); ?>"
               value="<?php echo esc_attr($value); ?>"
               />
        <br/>
        <?php
        return ob_get_clean();
    }

    /**
     * Renders a number field.
     * 
     * @param  string $id The field ID.
     * @param  string $name The name attribute of the field.
     * @param  string $value The value of the field.
     * @return string The HTML output.
     */
    public static function number($id, $name, $value)
    {
        ob_start();
        ?>
        <input type="number"
               class="small-text"
               id="<?php echo esc_attr($id); ?>"
               name="<?php echo esc_attr($name); ?>"
               value="<?php echo esc_attr($value); ?>"
               min="0"
               />
        <?php
        return ob_get_clean();
    }

    /**
     * Renders a number field suitable for pixel values.
     * 
     * @param  string $id The field ID.
     * @param  string $name The name attribute of the field.
     * @param  string $value The value of the field.
     * @return string The HTML output.
     */
    public static function numberPx($id, $name, $value)
    {
        ob_start();
        echo static::number($id, $name, $value);
        echo 'px';
        return ob_get_clean();
    }

    /**
     * Renders a WP Editor field.
     * 
     * @param string $id The field ID.
     * @param string $name The name attribute of the field.
     * @param string $value The value of the field.
     * @param array $args [optional] Array of arguments to pass to the wp_editor() function.
     * @return string The HTML output.
     */
    public static function editor($id, $name, $value, $args = array())
    {
        ob_start();
        $defaults = array(
            'textarea_rows' => 5
        );
        $settings = wp_parse_args($args, $defaults);
        $settings['textarea_name'] = $name;
        wp_editor($value, $id, $settings);
        return ob_get_clean();
    }

    /**
     * Renders a colorpicker field.
     * 
     * @param  string $id The field ID.
     * @param  string $name The name attribute of the field.
     * @param  string $value The value of the field.
     * @return string The HTML output.
     */
    public static function colorpicker($id, $name, $value)
    {
        ob_start();
        ?>
        <div class="edd-acp-colorpicker">
            <input type="hidden"
                   class="edd-acp-colorpicker-value"
                   id="<?php echo esc_attr($id); ?>"
                   name="<?php echo esc_attr($name); ?>"
                   value="<?php echo esc_attr($value); ?>" 
                   />
            <div class="edd-acp-colorpicker-preview"></div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Renders a checkbox field.
     * 
     * @param  string $id The field ID.
     * @param  string $name The name attribute of the field.
     * @param  string $value The value of the field.
     * @return string The HTML output.
     */
    public static function checkbox($id, $name, $value)
    {
        ob_start();
        ?>
        <input type="hidden" name="<?php echo esc_attr($name); ?>" value="0" />
        <input type="checkbox"
               id="<?php echo esc_attr($id); ?>"
               name="<?php echo esc_attr($name); ?>"
               <?php checked($value, '1'); ?>
               value="1"
               />
        <?php
        return ob_get_clean();
    }

    /**
     * Renders a number field that is more suitable for opacity values.
     *
     * @param  string $id The field ID.
     * @param  string $name The name attribute of the field.
     * @param  string $value The value of the field.
     * @return string The HTML output.
     */
    public static function opacity($id, $name, $value)
    {
        ob_start();
        ?>
        <input type="number"
               class="small-text"
               id="<?php echo esc_attr($id); ?>"
               name="<?php echo esc_attr($name); ?>"
               value="<?php echo esc_attr($value); ?>"
               min="0"
               max="1"
               step="0.05"
               />
        <?php
        return ob_get_clean();
    }

    /**
     * Renders a composite field for border properties.
     *
     * @param  string $id The field ID.
     * @param  string $name The name attribute of the field.
     * @param  string $value The value of the field.
     * @return string The HTML output.
     */
    public static function border($id, $name, $value)
    {
        ob_start();
        $properties = array(
            'width' => 'numberPx',
            'style' => 'borderStyle',
            'color' => 'colorpicker'
        );
        foreach($properties as $property => $fieldType) {
            $propId = sprintf('%s-%s', $id, $property);
            $propName = sprintf('%s[%s]', $name, $property);
            $propValue = isset($value[$property])
                ? $value[$property]
                : '';
            echo static::$fieldType($propId, $propName, $propValue);
        }
        return ob_get_clean();
    }

    /**
     * Renders a border style select element.
     * 
     * @staticvar type $borderStyles
     * @param  string $id The field ID.
     * @param  string $name The name attribute of the field.
     * @param  string $value The value of the field.
     * @return string The HTML output.
     */
    public static function borderStyle($id, $name, $value)
    {
        // Static border styles variable
        static $borderStyles = null;
        if (is_null($borderStyles)) {
            $borderStyles = array('none', 'solid', 'dashed', 'dotted', 'double', 'groove', 'ridge', 'inset', 'outset');
        }
        // Field output
        ob_start();
        ?>
        <select id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name); ?>">
            <?php foreach($borderStyles as $style) : ?>
            <option
                value="<?php echo esc_attr($style); ?>"
                <?php selected($value, $style); ?>
                >
                <?php echo $style; ?>
            </option>
            <?php endforeach; ?>
        </select>
        <?php
        return ob_get_clean();
    }

    /**
     * Renders a composite field for box shadow properties.
     * 
     * @param  string $id The field ID.
     * @param  string $name The name attribute of the field.
     * @param  string $value The value of the field.
     * @return string The HTML output.
     */
    public static function shadow($id, $name, $value)
    {
        ob_start();
        $properties = array(
            'blur' => 'numberPx',
            'color' => 'colorpicker',
            'opacity' => 'opacity'
        );
        foreach($properties as $property => $fieldType) {
            $propId = sprintf('%s-%s', $id, $property);
            $propName = sprintf('%s[%s]', $name, $property);
            $propValue = isset($value[$property])
                ? $value[$property]
                : '';
            echo static::$fieldType($propId, $propName, $propValue);
        }
        return ob_get_clean();
    }

    /**
     * Renders an HTML button.
     *
     * @param string $id The button ID.
     * @param string $text The button text.
     * @param string $class The HTML class attribute.
     * @return string The rendered HTML.
     */
    public static function button($id, $text, $class)
    {
        ob_start();
        ?>
        <button
            id="<?php echo esc_attr($id); ?>"
            class="<?php echo esc_attr($class); ?>"
            type="button">
            <?php echo $text; ?>
        </button>
        <?php
        return ob_get_clean();
    }

    /**
     * Renders a Preview button inside a fake EDD purchase form.
     *
     * The preview button will trigger a popup for viewing purposes.
     *
     * @return string The HTML render.
     */
    public static function renderPreview()
    {
        ob_start();
        ?>
        <hr/>
        <div class="edd-acp-fake-purchase-form">
            <input type="hidden" class="edd_action_input" value="add_to_cart" />
            <input type="hidden" class="edd-item-quantity" value="1" />
            <div class="edd_purchase_submit_wrapper">
                <p>
                    <label>
                        <?php
                            echo EddAcpSettingsHtml::button(
                                'edd-acp-preview',
                                __('Preview', 'edd_acp'),
                                'button button-secondary edd-add-to-cart edd-acp-preview'
                            );
                        ?>
                        <?php _e('Click the button to preview your settings before saving.', 'edd_acp'); ?>
                    </label>
                </p>
            </div>
            <div id="edd-acp-preview-popup-container"></div>
        </div>
        <?php
        return ob_get_clean();
    }

}

// Get text domain
$textDomain = edd_acp()->getTextDomain()->getName();

/**
 * Registers the plugin options to a settings instance.
 *
 * @param Settings $settings The settings instance to which to register the options.
 * @return Settings $settings The settings instance.
 */
function eddAcpRegisterOptions(Settings $settings)
{
    $settings
        ->addOption(
            'enabled', __('Enable Popup', 'edd_acp'),
            __('Tick this box to enable the popup. Untick it to disable it.', 'edd_acp'), '0',
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('checkbox', $settings, $id);
                echo EddAcpSettingsHtml::renderPreview();
            }
        )
        ->addOption(
            'maintext', __('Popup Text', 'edd_acp'),
            __('The text shown on the popup. The "%s" will be replaced by the name of the item added to the cart.',
                'edd_acp'), __('%s has been added to your cart!', 'edd_acp'),
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('editor', $settings, $id);
            }
        )
        ->addOption(
            'pluraltext', __('Popup Plural Text', 'edd_acp'),
            __("The text shown on the popup when multiple items have been added to the cart.\n"
                . "The \"%s\" will be replaced with a comma separated list of the names of the added items.", 'edd_acp'),
            __('%s have been added to your cart!', 'edd_acp'),
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('editor', $settings, $id);
            }
        )
        ->addOption(
            'fontsize', __('Font Size', 'edd_acp'),
            __('The font size for the popup text, in one of these formats: 10px, 2em, 50%. Leave empty to use the theme default font size.'),
            '',
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('smalltext', $settings, $id);
            }
        )
        ->addOption(
            'textcolor', __('Text Color', 'edd_acp'), __('Change the color of the text inside popup box.', 'edd_acp'),
            '#000000',
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('colorpicker', $settings, $id);
            }
        )
        ->addOption(
            'bgcolor', __('Background Color', 'edd_acp'), __('Change the background color of the popup box.', 'edd_acp'),
            '#ffffff',
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('colorpicker', $settings, $id);
            }
        )
        ->addOption(
            'border', __('Border', 'edd_acp'),
            __('The border thickness, style and color respectively.', 'edd_acp'),
            array(
                'width' => '0',
                'style' => 'solid',
                'color' => '#000'
            ),
            function ($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('border', $settings, $id);
            }
        )
        ->addOption(
            'shadow', __('Shadow', 'edd_acp'),
            __('The shadow blur amount, color and opacity respectively.', 'edd_acp'),
            array(
                'blur'    => '0',
                'color'   => '#000',
                'opacity' => '0.5'
            ),
            function ($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('shadow', $settings, $id);
            }
        )

        /**
         * Options for generic button styles
         */
        ->addOption('btnStylesHeader', __('Button Styles', 'edd_acp'))
        ->addOption(
            'btnBorder', __('Button Border', 'edd_acp'),
            __('The button border CSS rule. Example: "1px solid #000". Leave empty to use the theme defaults.'),
            array(
                'width' => '1',
                'style' => 'solid',
                'color' => '#000'
            ),
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('border', $settings, $id);
            }
        )
        ->addOption(
            'btnBorderRadius', __('Border Radius', 'edd_acp'),
            __('The border radius, in pixels. For example: "2", "5", etc. Leave empty to use the theme default.', 'edd_acp'),
            '2',
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('number', $settings, $id);
            }
        )
        ->addOption(
            'btnPadding', __('Button Padding', 'edd_acp'),
            __('The inner padding for the popup buttons, in pixels. For example: "15px", "6px 10px", etc. Leave empty to use the theme defaults.', 'edd_acp'),
            '',
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('smalltext', $settings, $id);
            }
        )

        /**
         * Options for the Checkout Button
         */
        ->addOption('checkoutBtnHeader', __('Checkout Button', 'edd_acp'))
        ->addOption(
            'showCheckoutBtn',
            __('Enabled', 'edd_acp'),
            __('Tick to show the Checkout button', 'edd_acp'),
            '1',
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('checkbox', $settings, $id);
            }
        )
        ->addOption(
            'checkoutBtnText',
            __('Text', 'edd_acp'),
            __('The text of the Checkout button.', 'edd_acp'),
            __('Proceed to Checkout', 'edd_acp'),
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('text', $settings, $id);
            }
        )
        ->addOption(
            'checkoutBtnTextColor',
            __('Text Color', 'edd_acp'),
            __('The text color for the Checkout button', 'edd_acp'), '#fff',
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('colorpicker', $settings, $id);
            }
        )
        ->addOption(
            'checkoutBtnBgColor',
            __('Background Color', 'edd_acp'),
            __('The background color for the Checkout button.', 'edd_acp'),
            '#444',
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('colorpicker', $settings, $id);
            }
        )
        ->addOption(
            'checkoutBtnHoverTextColor',
            __('Text Color on Hover', 'edd_acp'),
            __('The text color for the Checkout button when hovered.', 'edd_acp'),
            '#fff',
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('colorpicker', $settings, $id);
            }
        )
        ->addOption(
            'checkoutBtnHoverBgColor',
            __('Background Color on Hover', 'edd_acp'),
            __('The background color for the Checkout button when hovered.', 'edd_acp'),
            '#444',
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('colorpicker', $settings, $id);
            }
        )

        /**
         * Options for the Continue Shopping Button
         */
        ->addOption('continueBtnHeader', __('Continue Button', 'edd_acp'))
        ->addOption(
            'showContinueBtn',
            __('Enabled', 'edd_acp'),
            __('Tick to show the Continue Shopping button', 'edd_acp'),
            '1',
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('checkbox', $settings, $id);
            }
        )
        ->addOption(
            'continueBtnText',
            __('Text', 'edd_acp'),
            __('The text of the continue shopping button.', 'edd_acp'),
            __('Continue shopping', 'edd_acp'),
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('text', $settings, $id);
            }
        )
        ->addOption(
            'continueBtnTextColor',
            __('Text Color', 'edd_acp'),
            __('The text color for the Continue Shopping button', 'edd_acp'),
            '#fff',
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('colorpicker', $settings, $id);
            }
        )
        ->addOption(
            'continueBtnBgColor',
            __('Background Color', 'edd_acp'),
            __('The background color for the Continue Shopping button.', 'edd_acp'),
            '#444',
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('colorpicker', $settings, $id);
            }
        )
        ->addOption(
            'continueBtnHoverTextColor',
            __('Text Color on Hover', 'edd_acp'),
            __('The text color for the Continue Shopping button when hovered.', 'edd_acp'),
            '#fff',
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('colorpicker', $settings, $id);
            }
        )
        ->addOption(
            'continueBtnHoverBgColor',
            __('Background Color on Hover', 'edd_acp'),
            __('The background color for the Continue Shopping button when hovered.', 'edd_acp'),
            '#444',
            function($settings, $id, $args)
            {
                echo EddAcpSettingsHtml::renderField('colorpicker', $settings, $id);
            }
        )
    ;
    return $settings;
}

// Register settings to the singleton's settings
eddAcpRegisterOptions(edd_acp()->getSettings());
