<?php

/**
 * Template for the Form Block view.
 *
 * @package EightshiftForms\Blocks.
 */

namespace EightshiftForms\Blocks;

use EightshiftForms\Helpers\Components;
use EightshiftForms\Helpers\Forms;
use EightshiftForms\Config\Config;
use EightshiftForms\Hooks\Actions;
use EightshiftForms\Rest\DynamicsCrmRoute;
use EightshiftForms\Rest\SendEmailRoute;
use EightshiftForms\Rest\AbstractBuckarooRoute as Buckaroo_Route;
use EightshiftForms\Rest\BuckarooEmandateRoute;
use EightshiftForms\Rest\MailchimpRoute;
use EightshiftForms\Rest\MailerliteRoute;

$current_url                  = ! empty(\get_permalink()) ? \get_permalink() : '';
$block_class                  = $attributes['blockClass'] ?? '';
$form_action                  = $attributes['action'] ?? '';
$form_method                  = $attributes['method'] ?? '';
$form_target                  = $attributes['target'] ?? '';
$form_classes                 = $attributes['classes'] ?? '';
$form_id                      = $attributes['id'] ?? 'form-' . hash('crc32', time() . wp_rand(0, 10000));
$form_type                    = $attributes['type'] ?? '';
$form_types_complex           = $attributes['typesComplex'] ?? '';
$form_types_complex_redirect  = $attributes['typesComplexRedirect'] ?? '';
$is_form_complex              = isset($attributes['isComplexType']) ? filter_var($attributes['isComplexType'], FILTER_VALIDATE_BOOL) : false;
$form_theme                   = $attributes['theme'] ?? '';
$success_message              = $attributes['successMessage'] ?? '';
$error_message                = $attributes['errorMessage'] ?? '';
$referral_url                 = isset($attributes['referralUrl']) ? $attributes['referralUrl'] : $current_url;
$should_redirect_on_success   = isset($attributes['shouldRedirectOnSuccess']) ? filter_var($attributes['shouldRedirectOnSuccess'], FILTER_VALIDATE_BOOL) : false;
$redirect_url_success         = $attributes['redirectSuccess'] ?? '';
$dynamics_crm_entity          = $attributes['dynamicsEntity'] ?? '';
$email_to                     = $attributes['emailTo'] ?? '';
$email_subject                = $attributes['emailSubject'] ?? '';
$email_message                = $attributes['emailMessage'] ?? '';
$email_additional_headers     = $attributes['emailAdditionalHeaders'] ?? '';
$email_send_confirm_to_sender = isset($attributes['emailSendConfirmationToSender']) ? filter_var($attributes['emailSendConfirmationToSender'], FILTER_VALIDATE_BOOL) : false;
$email_confirmation_subject   = $attributes['emailConfirmationSubject'] ?? '';
$email_confirmation_message   = $attributes['emailConfirmationMessage'] ?? '';
$buckaroo_redirect_url        = $attributes['buckarooRedirectUrl'] ?? '';
$buckaroo_redirect_url_cancel = ! empty($current_url) ? $current_url : \home_url();
$buckaroo_redirect_url_error  = $attributes['buckarooRedirectUrlError'] ?? '';
$buckaroo_redirect_url_reject = $attributes['buckarooRedirectUrlReject'] ?? '';
$buckaroo_service             = $attributes['buckarooService'] ?? '';
$buckaroo_payment_desc        = $attributes['buckarooPaymentDescription'] ?? '';
$buckaroo_emandate_desc       = $attributes['buckarooEmandateDescription'] ?? '';
$buckaroo_sequence_type       = $attributes['buckarooSequenceType'] ?? '';
$buckaroo_is_recurring        = $buckaroo_sequence_type === '0';
$buckaroo_sequence_type_front = isset($attributes['buckarooIsSequenceTypeOnFrontend']) ? filter_var($attributes['buckarooIsSequenceTypeOnFrontend'], FILTER_VALIDATE_BOOLEAN) : false;
$mailchimp_list_id            = $attributes['mailchimpListId'] ?? '';
$mailchimp_tags               = $attributes['mailchimpTags'] ?? [];
$mailchimp_add_existing       = isset($attributes['mailchimpAddExistingMembers']) ? filter_var($attributes['mailchimpAddExistingMembers'], FILTER_VALIDATE_BOOL) : false;
$mailerlite_group_id          = $attributes['mailerliteGroupId'] ?? '';
$custom_event_names           = $attributes['eventNames'] ?? [];
$used_types                   = Forms::detect_used_types($is_form_complex, $form_type, $form_types_complex, $form_types_complex_redirect);
$innerBlockContent            = ! empty($innerBlockContent) ? $innerBlockContent : '';

$block_classes = Components::classnames([
  $block_class,
  $form_classes,
  'js-form',
  "js-form__type--{$form_type}",
  ! empty($form_theme) ? "{$block_class}__theme--{$form_theme}" : '',
]);

if (empty($this)) {
	return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>">
  <form
	id="<?php echo esc_attr($form_id); ?>"
	class="<?php echo esc_attr("{$block_class}__form js-{$block_class}-form"); ?>"
	action="<?php echo esc_attr($form_action); ?>"
	method="<?php echo esc_attr($form_method); ?>"
	target="<?php echo esc_attr($form_target); ?>"
	target="<?php echo esc_attr($form_target); ?>"
	<?php ! empty($form_id) ? printf('id="%s"', esc_attr($form_id)) : ''; ?>
	<?php $is_form_complex ? printf('data-is-form-complex') : ''; ?>
	<?php $should_redirect_on_success ? printf('data-redirect-on-success="%s"', esc_url($redirect_url_success)) : ''; ?>

	<?php if (isset($used_types[Config::BUCKAROO_METHOD])) { ?>
	  data-buckaroo-service="<?php echo esc_attr($buckaroo_service); ?>"
	<?php } ?>

	<?php if (! $is_form_complex) { ?>
	  data-form-type="<?php echo esc_attr($form_type); ?>"
	<?php } else { ?>
	  data-form-types-complex="<?php echo esc_attr(implode(',', $form_types_complex)); ?>"
	  data-form-types-complex-redirect="<?php echo esc_attr(implode(',', $form_types_complex_redirect)); ?>"
	<?php } ?>
  >
	<?php echo wp_kses_post($innerBlockContent); ?>

	<?php

	/**
	 * Project specific fields.
	 */
	if (has_action(Actions::EXTRA_FORM_FIELDS)) {
		do_action(Actions::EXTRA_FORM_FIELDS, $attributes ?? []);
	}

	/**
	 * Here we need to add some additional fields for specific methods.
	 */
	?>
	<input type="hidden" name="referral-url" value="<?php echo esc_url($referral_url); ?>" />

	<?php if (isset($used_types[Config::DYNAMICS_CRM_METHOD])) { ?>
	  <input type="hidden" name="<?php echo esc_attr(DynamicsCrmRoute::ENTITY_PARAM); ?>" value="<?php echo esc_attr($dynamics_crm_entity); ?>" />
	<?php } ?>

	<?php if (isset($used_types[Config::EMAIL_METHOD])) { ?>
	  <input type="hidden" name="<?php echo esc_attr(SendEmailRoute::TO_PARAM); ?>" value="<?php echo esc_attr($email_to); ?>" />
	  <input type="hidden" name="<?php echo esc_attr(SendEmailRoute::SUBJECT_PARAM); ?>" value="<?php echo esc_attr($email_subject); ?>" />
	  <input type="hidden" name="<?php echo esc_attr(SendEmailRoute::MESSAGE_PARAM); ?>" value="<?php echo esc_attr($email_message); ?>" />
	  <input type="hidden" name="<?php echo esc_attr(SendEmailRoute::ADDITIONAL_HEADERS_PARAM); ?>" value="<?php echo esc_attr($email_additional_headers); ?>" />
	  <input type="hidden" name="<?php echo esc_attr(SendEmailRoute::SEND_CONFIRMATION_TO_SENDER_PARAM); ?>" value="<?php echo (int) $email_send_confirm_to_sender; ?>" />
	  <input type="hidden" name="<?php echo esc_attr(SendEmailRoute::CONFIRMATION_SUBJECT_PARAM); ?>" value="<?php echo esc_attr($email_confirmation_subject); ?>" />
	  <input type="hidden" name="<?php echo esc_attr(SendEmailRoute::CONFIRMATION_MESSAGE_PARAM); ?>" value="<?php echo esc_attr($email_confirmation_message); ?>" />
	<?php } ?>

	<?php if (isset($used_types[Config::BUCKAROO_METHOD])) { ?>
	  <input type="hidden" name="<?php echo esc_attr(Buckaroo_Route::REDIRECT_URL_PARAM); ?>" value="<?php echo esc_attr($buckaroo_redirect_url); ?>" />
	  <input type="hidden" name="<?php echo esc_attr(Buckaroo_Route::REDIRECT_URL_CANCEL_PARAM); ?>" value="<?php echo esc_attr($buckaroo_redirect_url_cancel); ?>" />
	  <input type="hidden" name="<?php echo esc_attr(Buckaroo_Route::REDIRECT_URL_ERROR_PARAM); ?>" value="<?php echo esc_attr($buckaroo_redirect_url_error); ?>" />
	  <input type="hidden" name="<?php echo esc_attr(Buckaroo_Route::REDIRECT_URL_REJECT_PARAM); ?>" value="<?php echo esc_attr($buckaroo_redirect_url_reject); ?>" />

		<?php if ($buckaroo_service === 'emandate') { ?>
		<input type="hidden" name="<?php echo esc_attr(BuckarooEmandateRoute::EMANDATE_DESCRIPTION_PARAM); ?>" value="<?php echo esc_attr($buckaroo_emandate_desc); ?>" />

			<?php if (! $buckaroo_sequence_type_front && $buckaroo_is_recurring) { ?>
		  <input type="hidden" name="<?php echo esc_attr(BuckarooEmandateRoute::SEQUENCE_TYPE_IS_RECURRING_PARAM); ?>" value="1" />
			<?php } ?>
		<?php } ?>

		<?php if ($buckaroo_service === 'ideal') { ?>
		<input type="hidden" name="<?php echo esc_attr(Buckaroo_Route::PAYMENT_DESCRIPTION_PARAM); ?>" value="<?php echo esc_attr($buckaroo_payment_desc); ?>" />
		<?php } ?>
	<?php } ?>

	<?php if (isset($used_types[Config::MAILCHIMP_METHOD])) { ?>
	  <input type="hidden" name="<?php echo esc_attr(MailchimpRoute::LIST_ID_PARAM); ?>" value="<?php echo esc_attr($mailchimp_list_id); ?>" />
	  <input type="hidden" name="<?php echo esc_attr(MailchimpRoute::ADD_EXISTING_MEMBERS_PARAM); ?>" value="<?php echo (int) $mailchimp_add_existing; ?>" />

		<?php foreach ($mailchimp_tags as $mailchimp_tag) { ?>
		<input type="hidden" name="<?php echo esc_attr(MailchimpRoute::TAGS_PARAM); ?>[]" value="<?php echo esc_attr($mailchimp_tag); ?>" />
		<?php } ?>
	<?php } ?>

	<?php if (isset($used_types[Config::MAILERLITE_METHOD])) { ?>
	  <input type="hidden" name="<?php echo esc_attr(MailerliteRoute::GROUP_ID_PARAM); ?>" value="<?php echo esc_attr($mailerlite_group_id); ?>" />
	<?php } ?>

	<?php if (isset($used_types[Config::CUSTOM_EVENT_METHOD])) { ?>
		<?php foreach ($custom_event_names as $custom_event_name) { ?>
		<input type="hidden" name="custom-events[]" value="<?php echo esc_attr($custom_event_name); ?>" />
		<?php } ?>
	<?php } ?>

	<input type="hidden" name="form-unique-id" value="<?php echo esc_attr($form_id); ?>" />
	<?php wp_nonce_field($form_id, 'nonce', false); ?>
  </form>

  <?php echo wp_kses_post(Components::render('form-overlay')); ?>
  <?php echo wp_kses_post(Components::render('spinner', ['theme' => $form_theme])); ?>
  <?php echo wp_kses_post(Components::render('form-message', ['message' => $success_message, 'type' => 'success', 'theme' => $form_theme])); ?>
  <?php echo wp_kses_post(Components::render('form-error-message-wrapper', ['theme' => $form_theme])); ?>
</div>

