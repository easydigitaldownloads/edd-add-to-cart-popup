<?php

namespace Aventura\Edd\AddToCartPopup\Core;

/**
 * Renders styles from arrays.
 *
 * @author Miguel Muscat <miguelmuscat93@gmail.com>
 */
abstract class StyleRenderer
{

    /**
     * Renders a set of styles.
     * 
     * @param array $styles The styles to render. Expected to be an array of "style" arrays with selector keys.
     * @param string $scope The CSS scope; acts as a selector prefix
     * @param string $styleTag If true, a style tag will surround the rendered styles.
     * @return string The rendered result.
     */
    public static function renderStyles(array $styles, $scope = '', $styleTag = false)
    {
        $render = '';
        foreach ($styles as $selector => $rules) {
            $render .= static::renderStyle(sprintf('%s %s', $scope, $selector), $rules);
        }
        return $styleTag
            ? sprintf("<style type='text/css'>\n%s\n</style>", $render)
            : $render;
    }

    /**
     * Renders a style and its rules.
     * 
     * @param string $selector The selector.
     * @param array $rules An array of style rules.
     * @return string The rendered result.
     */
    public static function renderStyle($selector, array $rules)
    {
        $attributes = '';
        foreach ($rules as $attribute => $value) {
            $attributes .= static::renderRule($attribute, $value);
        }
        return sprintf("%s {\n%s}\n", $selector, $attributes);
    }

    /**
     * Renders a single rule.
     * 
     * @param string $attribute The rule attribute.
     * @param string $value The rule value.
     * @return string The rendered result.
     */
    public static function renderRule($attribute, $value)
    {
        return sprintf("\t%s: %s;\n", $attribute, $value);
    }

}
