<?php

/**
 * Template for the Input Component.
 *
 * @package EightshiftForms
 */

use EightshiftForms\Blocks\Blocks;
use EightshiftForms\Helpers\Components;

$manifest = Components::getManifest(__DIR__);

$componentClass = $manifest['componentClass'] ?? '';
$additionalClass = $attributes['additionalClass'] ?? '';
$blockClass = $attributes['blockClass'] ?? '';
$selectorClass = $attributes['selectorClass'] ?? $componentClass;

$inputName = Components::checkAttr('inputName', $attributes, $manifest);
$inputValue = Components::checkAttr('inputValue', $attributes, $manifest);
$inputPlaceholder = Components::checkAttr('inputPlaceholder', $attributes, $manifest);
$inputType = Components::checkAttr('inputType', $attributes, $manifest);
$inputIsDisabled = Components::checkAttr('inputIsDisabled', $attributes, $manifest);
$inputIsReadOnly = Components::checkAttr('inputIsReadOnly', $attributes, $manifest);
$inputIsRequired = Components::checkAttr('inputIsRequired', $attributes, $manifest);
$inputTracking = Components::checkAttr('inputTracking', $attributes, $manifest);

// Fix for getting attribute that is part of the child component.
$inputFieldLabel = $attributes[Components::getAttrKey('inputFieldLabel', $attributes, $manifest)] ?? '';

$inputClass = Components::classnames([
	Components::selector($componentClass, $componentClass),
	Components::selector($blockClass, $blockClass, $selectorClass),
	Components::selector($additionalClass, $additionalClass),
]);

$inputIsDisabled = $inputIsDisabled ? 'disabled' : '';
$inputIsReadOnly = $inputIsReadOnly ? 'readonly' : '';

if (empty($inputName)) {
	$inputName = apply_filters(Blocks::BLOCKS_NAME_TO_ID_FILTER_NAME, $inputFieldLabel);
}

$inputId = apply_filters(Blocks::BLOCKS_NAME_TO_ID_FILTER_NAME, $inputName);

$input = '
<input
	class="'. esc_attr($inputClass) .'"
	name="'. esc_attr($inputName) . '"
	value="'. esc_attr($inputValue) . '"
	id="'. esc_attr($inputId) . '"
	placeholder="'. esc_attr($inputPlaceholder) . '"
	type="'. esc_attr($inputType) . '"
	data-validation-required="' . $inputIsRequired . '"
	data-tracking="' . $inputTracking . '"
	' . $inputIsDisabled . '
	' . $inputIsReadOnly . '
/>';

echo Components::render( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	'field',
	Components::props('field', $attributes, [
		'fieldContent' => $input,
		'fieldId' => $inputId,
	])
);
