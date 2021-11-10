<?php

/**
 * Template for the HubSpot Block view.
 *
 * @package EightshiftForms
 */

use EightshiftForms\Helpers\Components;
use EightshiftForms\Helpers\Helper;
use EightshiftForms\Integrations\Hubspot\Hubspot;
use EightshiftForms\Integrations\Hubspot\SettingsHubspot;

$manifest = Components::getManifest(__DIR__);

$blockClass = $attributes['blockClass'] ?? '';

$hubspotServerSideRender = Components::checkAttr('hubspotServerSideRender', $attributes, $manifest);
$hubspotFormPostId = Components::checkAttr('hubspotFormPostId', $attributes, $manifest);

if ($hubspotServerSideRender) {
	$hubspotFormPostId = Helper::encryptor('encrypt', $hubspotFormPostId);
}

$hubspotFormPostIdDecoded = Helper::encryptor('decode', $hubspotFormPostId);

// Check if hubspot data is set and valid.
$isSettingsValid = \apply_filters(SettingsHubspot::FILTER_SETTINGS_IS_VALID_NAME, $hubspotFormPostIdDecoded);

$hubspotClass = Components::classnames([
	Components::selector($blockClass, $blockClass),
	Components::selector(!$isSettingsValid, $blockClass, '', 'invalid')
]);

// Bailout if settings are not ok but show msg only in editor.
if (!$isSettingsValid && $hubspotServerSideRender) {
	?>
		<div class="<?php echo esc_attr($hubspotClass); ?>">
			<?php esc_html_e('Sorry, it looks like your HubSpot settings are not configured correctly. Please go to your form setting and input all required settings.', 'eightshift-forms'); ?>
		</div>
	<?php

	return;
}

// Output form.
echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	Hubspot::FILTER_MAPPER_NAME,
	$hubspotFormPostId
);
