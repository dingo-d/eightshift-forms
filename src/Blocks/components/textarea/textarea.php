<?php

/**
 * Template for the Textarea Component.
 *
 * @package EightshiftForms
 */

use EightshiftForms\Helpers\Components;

$manifest = Components::getManifest(__DIR__);

$componentClass = $manifest['componentClass'] ?? '';
$additionalClass = $attributes['additionalClass'] ?? '';
$blockClass = $attributes['blockClass'] ?? '';
$selectorClass = $attributes['selectorClass'] ?? $componentClass;

$textareaId = Components::checkAttr('textareaId', $attributes, $manifest);
$textareaName = Components::checkAttr('textareaName', $attributes, $manifest);
$textareaValue = Components::checkAttr('textareaValue', $attributes, $manifest);
$textareaPlaceholder = Components::checkAttr('textareaPlaceholder', $attributes, $manifest);
$textareaIsDisabled = Components::checkAttr('textareaIsDisabled', $attributes, $manifest);
$textareaIsReadOnly = Components::checkAttr('textareaIsReadOnly', $attributes, $manifest);
$textareaTracking = Components::checkAttr('textareaTracking', $attributes, $manifest);

// Fix for getting attribute that is part of the child component.
$textareaFieldLabel = $attributes[Components::getAttrKey('textareaFieldLabel', $attributes, $manifest)] ?? '';

$textareaClass = Components::classnames([
	Components::selector($componentClass, $componentClass),
	Components::selector($blockClass, $blockClass, $selectorClass),
	Components::selector($additionalClass, $additionalClass),
]);

$textarea = '<textarea
		class="' . esc_attr($textareaClass) . '"
		name="' . esc_attr($textareaName) . '"
		id="' . esc_attr($textareaId) . '"
		placeholder="' . esc_attr($textareaPlaceholder) . '"
		data-tracking="' . $textareaTracking . '"
		' . disabled($textareaIsDisabled, true, false) . '
		' . readonly($textareaIsReadOnly, true, false) . '
	>' . \apply_filters('the_content', $textareaValue) . '</textarea>
';

echo Components::render( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	'field',
	array_merge(
		Components::props('field', $attributes, [
			'fieldContent' => $textarea,
			'fieldId' => $textareaId,
			'fieldName' => $textareaName,
			'fieldDisabled' => !empty($textareaIsDisabled),
		]),
		[
			'additionalFieldClass' => $attributes['additionalFieldClass'] ?? '',
		]
	)
);
