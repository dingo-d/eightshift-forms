<?php

/**
 * Template for the Checkbox Block view.
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

$checkboxLabel = Components::checkAttr('checkboxLabel', $attributes, $manifest);
$checkboxName = Components::checkAttr('checkboxName', $attributes, $manifest);
$checkboxValue = Components::checkAttr('checkboxValue', $attributes, $manifest);
$checkboxIsChecked = Components::checkAttr('checkboxIsChecked', $attributes, $manifest);
$checkboxIsDisabled = Components::checkAttr('checkboxIsDisabled', $attributes, $manifest);
$checkboxIsReadOnly = Components::checkAttr('checkboxIsReadOnly', $attributes, $manifest);
$checkboxIsRequired = Components::checkAttr('checkboxIsRequired', $attributes, $manifest);
$checkboxTracking = Components::checkAttr('checkboxTracking', $attributes, $manifest);

$checkboxClass = Components::classnames([
	Components::selector($componentClass, $componentClass),
	Components::selector($blockClass, $blockClass, $selectorClass),
	Components::selector($additionalClass, $additionalClass),
]);

if (empty($checkboxName)) {
	$checkboxName = apply_filters(Blocks::BLOCKS_NAME_TO_ID_FILTER_NAME, $checkboxLabel);
}

$checkboxId = apply_filters(Blocks::BLOCKS_NAME_TO_ID_FILTER_NAME, $checkboxName);

?>

<div class="<?php echo esc_attr($checkboxClass); ?>">
	<div class="<?php echo esc_attr("{$componentClass}__content"); ?>">
		<label
			for="<?php echo esc_attr($checkboxName); ?>"
			class="<?php echo esc_attr("{$componentClass}__label"); ?>"
		>
			<?php echo esc_attr($checkboxLabel); ?>
		</label>
		<input
			class="<?php echo esc_attr("{$componentClass}__input"); ?>"
			type="checkbox"
			name="<?php echo esc_attr($checkboxName); ?>"
			id="<?php echo esc_attr($checkboxId); ?>"
			value="<?php echo esc_attr($checkboxValue); ?>"
			data-validation-required="<?php echo esc_attr($checkboxIsRequired); ?>"
			data-tracking="<?php echo esc_attr($checkboxTracking); ?>"
			<?php echo $checkboxIsChecked ? 'checked': ''; ?>
			<?php echo $checkboxIsDisabled ? 'disabled': ''; ?>
			<?php echo $checkboxIsReadOnly ? 'readonly': ''; ?>
		/>
	</div>

	<?php
	echo Components::render( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'error',
		Components::props('error', $attributes, [
			'errorId' => $checkboxId,
			'blockClass' => $componentClass
		])
	);
	?>
</div>
