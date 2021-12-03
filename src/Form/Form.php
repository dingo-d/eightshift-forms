<?php

/**
 * Class that holds all filter used in the component and blocks regarding form.
 *
 * @package EightshiftLibs\Form
 */

declare(strict_types=1);

namespace EightshiftForms\Form;

use EightshiftForms\Mailer\SettingsMailer;
use EightshiftForms\Settings\Settings\SettingsGeneral;
use EightshiftForms\Settings\SettingsHelper;
use EightshiftFormsVendor\EightshiftLibs\Services\ServiceInterface;

/**
 * Form class.
 */
class Form implements ServiceInterface
{
	/**
	 * Use general helper trait.
	 */
	use SettingsHelper;

	/**
	 * Filter settings option value key.
	 */
	public const FILTER_FORM_SETTINGS_OPTIONS_NAME = 'es_forms_form_settings_options';

	/**
	 * Register all the hooks
	 *
	 * @return void
	 */
	public function register(): void
	{
		\add_filter(self::FILTER_FORM_SETTINGS_OPTIONS_NAME, [$this, 'getFormSettingsOptions']);
	}

	/**
	 * Create array of additonal form options
	 *
	 * @param string $formId Form ID.
	 *
	 * @return array<string, mixed>
	 */
	public function getFormSettingsOptions(string $formId): array
	{
		$output = [];

		// Get post ID prop.
		$output['formPostId'] = $formId;

		// Get form type.
		$output['formType'] = SettingsMailer::SETTINGS_TYPE_KEY;

		// Tracking event name.
		$output['formTrackingEventName'] = $this->getSettingsValue(
			SettingsGeneral::SETTINGS_GENERAL_TRACKING_EVENT_NAME_KEY,
			$formId
		);

		// Success redirect url.
		$output['formSuccessRedirect'] = $this->getSettingsValue(
			SettingsGeneral::SETTINGS_GENERAL_REDIRECTION_SUCCESS_KEY,
			$formId
		);

		return $output;
	}
}
