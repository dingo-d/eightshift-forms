<?php

/**
 * The class register route for public form submiting endpoint - Moments
 *
 * @package EightshiftForms\Rest\Rout\Integrations\Momentses
 */

declare(strict_types=1);

namespace EightshiftForms\Rest\Routes\Integrations\Moments;

use EightshiftForms\Captcha\CaptchaInterface;
use EightshiftForms\Integrations\ClientInterface;
use EightshiftForms\Integrations\Moments\SettingsMoments;
use EightshiftForms\Labels\LabelsInterface;
use EightshiftForms\Rest\Routes\AbstractBaseRoute;
use EightshiftForms\Rest\Routes\Integrations\Mailer\FormSubmitMailerInterface;
use EightshiftForms\Rest\Routes\SubmitForm;
use EightshiftForms\Security\SecurityInterface;
use EightshiftForms\Validation\ValidationPatternsInterface;
use EightshiftForms\Validation\Validator;
use EightshiftForms\Validation\ValidatorInterface;

/**
 * Class FormSubmitMomentsRoute
 */
class FormSubmitMomentsRoute extends SubmitForm
{
	/**
	 * Route slug.
	 */
	public const ROUTE_SLUG = SettingsMoments::SETTINGS_TYPE_KEY;

	/**
	 * Instance variable for Moments data.
	 *
	 * @var ClientInterface
	 */
	protected $momentsClient;

	/**
	 * Create a new instance that injects classes
	 *
	 * @param ValidatorInterface $validator Inject ValidatorInterface which holds validation methods.
	 * @param ValidationPatternsInterface $validationPatterns Inject ValidationPatternsInterface which holds validation methods.
	 * @param LabelsInterface $labels Inject LabelsInterface which holds labels data.
	 * @param CaptchaInterface $captcha Inject CaptchaInterface which holds captcha data.
	 * @param SecurityInterface $security Inject SecurityInterface which holds security data.
	 * @param FormSubmitMailerInterface $formSubmitMailer Inject FormSubmitMailerInterface which holds mailer methods.
	 * @param ClientInterface $momentsClient Inject Moments which holds Moments connect data.
	 */
	public function __construct(
		ValidatorInterface $validator,
		ValidationPatternsInterface $validationPatterns,
		LabelsInterface $labels,
		CaptchaInterface $captcha,
		SecurityInterface $security,
		FormSubmitMailerInterface $formSubmitMailer,
		ClientInterface $momentsClient
	) {
		$this->validator = $validator;
		$this->validationPatterns = $validationPatterns;
		$this->labels = $labels;
		$this->captcha = $captcha;
		$this->security = $security;
		$this->formSubmitMailer = $formSubmitMailer;
		$this->momentsClient = $momentsClient;
	}

	/**
	 * Get the base url of the route
	 *
	 * @return string The base URL for route you are adding.
	 */
	protected function getRouteName(): string
	{
		return '/' . AbstractBaseRoute::ROUTE_PREFIX_FORM_SUBMIT . '/' . self::ROUTE_SLUG;
	}

	/**
	 * Implement submit action.
	 *
	 * @param array<string, mixed> $formDataReference Form reference got from abstract helper.
	 *
	 * @return mixed
	 */
	protected function submitAction(array $formDataReference)
	{
		$itemId = $formDataReference['itemId'];
		$formId = $formDataReference['formId'];
		$params = $formDataReference['params'];
		$files = $formDataReference['files'];

		// Send application to Moments.
		$response = $this->momentsClient->postApplication(
			$itemId,
			$params,
			$files,
			$formId
		);

		$validation = $response[Validator::VALIDATOR_OUTPUT_KEY] ?? [];
		$disableFallbackEmail = false;

		// Output integrations validation issues.
		if ($validation) {
			$response[Validator::VALIDATOR_OUTPUT_KEY] = $this->validator->getValidationLabelItems($validation, $formId);
			$disableFallbackEmail = true;
		}

		// Skip fallback email if integration is disabled.
		if (!$response['isDisabled'] && $response['status'] === AbstractBaseRoute::STATUS_ERROR) {
			// Prevent fallback email if we have validation errors parsed.
			if (!$disableFallbackEmail) {
				// Send fallback email.
				$this->formSubmitMailer->sendFallbackEmail($response);
			}
		}

		// Send email if it is configured in the backend.
		if ($response['status'] === AbstractBaseRoute::STATUS_SUCCESS) {
			$this->formSubmitMailer->sendEmails($formDataReference);
		}

		$labelsOutput = $this->labels->getLabel($response['message'], $formId);
		$responseOutput = $response;

		// Output fake success and send fallback email.
		if ($response['isDisabled'] && !$validation) {
			$this->formSubmitMailer->sendFallbackEmail($response);

			$fakeResponse = $this->getIntegrationApiSuccessOutput($response);

			$labelsOutput = $this->labels->getLabel($fakeResponse['message'], $formId);
			$responseOutput = $fakeResponse;
		}

		// Finish.
		return \rest_ensure_response(
			$this->getIntegrationApiOutput(
				$responseOutput,
				$labelsOutput,
			)
		);
	}
}
