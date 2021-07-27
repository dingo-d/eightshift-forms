import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
import { PanelBody, TextControl, TabPanel, Dashicon } from '@wordpress/components';
import { FormGeneralOptions } from './form-general-options';
import { FormDynamicsCrmOptions } from './form-dynamics-crm-options';
import { FormBuckarooOptions } from './form-buckaroo-options';
import { FormEmailOptions } from './form-email-options';
import { FormMailchimpOptions } from './form-mailchimp-options';
import { FormMailerliteOptions } from './form-mailerlite-options';
import { FormCustomEventOptions } from './form-custom-event-options';
import { FormCustomOptions } from './form-custom-options';

export const FormOptions = (props) => {
  const {
		setAttributes,
    attributes: {
      blockClass,
      formAction,
      formMethod,
      formTarget,
      id,
      classes,
      formType,
      formTypesComplex,
      formTypesComplexRedirect,
      formIsComplexType,
      dynamicsEntity,
      theme,
      formSuccessMessage,
      formErrorMessage,
      formShouldRedirectOnSuccess,
      formRedirectSuccess,
      formEmailTo,
      formEmailSubject,
      formEmailMessage,
      formEmailAdditionalHeaders,
      formEmailSendConfirmationToSender,
      formEmailConfirmationSubject,
      formEmailConfirmationMessage,
      buckarooService,
      buckarooPaymentDescription,
      buckarooEmandateDescription,
      buckarooSequenceType,
      buckarooIsSequenceTypeOnFrontend,
      buckarooRedirectUrl,
      buckarooRedirectUrlCancel,
      buckarooRedirectUrlError,
      buckarooRedirectUrlReject,
      mailchimpListId,
      mailchimpAddTag,
      mailchimpTags,
      mailchimpAddExistingMembers,
      mailerliteGroupId,
      eventNames,
    },
    actions: {
      onChangeAction,
      onChangeMethod,
      onChangeTarget,
      onChangeId,
      onChangeClasses,
      onChangeType,
      onChangeTypesComplex,
      onChangeTypesComplexRedirect,
      onChangeIsComplexType,
      onChangeDynamicsEntity,
      onChangeTheme,
      onChangeSuccessMessage,
      onChangeErrorMessage,
      onChangeShouldRedirectOnSuccess,
      onChangeRedirectSuccess,
      onChangeEmailTo,
      onChangeEmailSubject,
      onChangeEmailMessage,
      onChangeEmailAdditionalHeaders,
      onChangeEmailSendConfirmationToSender,
      onChangeEmailConfirmationSubject,
      onChangeEmailConfirmationMessage,
      onChangeBuckarooService,
      onChangeBuckarooPaymentDescription,
      onChangeBuckarooEmandateDescription,
      onChangeBuckarooSequenceType,
      onChangeBuckarooIsSequenceTypeOnFrontend,
      onChangeBuckarooRedirectUrl,
      onChangeBuckarooRedirectUrlCancel,
      onChangeBuckarooRedirectUrlError,
      onChangeBuckarooRedirectUrlReject,
      onChangeMailchimpListId,
      onChangeMailchimpAddTag,
      onChangeMailchimpTags,
      onChangeMailchimpAddExistingMembers,
      onChangeMailerliteGroupId,
      onChangeEventNames,
    } = {},
		attributes,
  } = props;

  const richTextClass = `${blockClass}__rich-text`;

  const formTypes = [
    { label: __('Email', 'eightshift-forms'), value: 'email' },
    { label: __('Custom (PHP)', 'eightshift-forms'), value: 'custom', redirects: true },
    { label: __('Custom (Event)', 'eightshift-forms'), value: 'custom-event' },
  ];

  const {
    hasThemes,
    themes = [],
    isDynamicsCrmUsed,
    isBuckarooUsed,
    isMailchimpUsed,
    isMailerliteUsed,
    dynamicsCrm = [],
  } = window.eightshiftForms;

  const mailchimpAdmin = window.eightshiftFormsAdmin.mailchimp || {};
  const mailerliteAdmin = window.eightshiftFormsAdmin.mailerlite || {};
  const mailchimpAudiences = (mailchimpAdmin && mailchimpAdmin.audiences) ? mailchimpAdmin.audiences : [];
  const mailerliteGroups = (mailerliteAdmin && mailerliteAdmin.groups) ? mailerliteAdmin.groups : [];

  const formThemeAsOptions = hasThemes ? themes.map((tempTheme) => ({ label: tempTheme, value: tempTheme })) : [];

  let crmEntitiesAsOptions = [];
  if (isDynamicsCrmUsed) {
    crmEntitiesAsOptions = [
      { label: __('Select CRM entity', 'eightshift-forms'), value: 'select-please' },
      ...dynamicsCrm.availableEntities.map((entity) => ({ label: entity, value: entity })),
    ];
    formTypes.push({ label: __('Microsoft Dynamics CRM 365', 'eightshift-forms'), value: 'dynamics-crm' });
  }

  if (isBuckarooUsed) {
    formTypes.push({ label: __('Buckaroo', 'eightshift-forms'), value: 'buckaroo', redirects: true });
  }

  if (isMailchimpUsed) {
    formTypes.push({ label: __('Mailchimp', 'eightshift-forms'), value: 'mailchimp' });
  }

  if (isMailerliteUsed) {
    formTypes.push({ label: __('Mailerlite', 'eightshift-forms'), value: 'mailerlite' });
  }

  const tabs = [
    {
      name: 'general',
      title: <Dashicon icon="admin-generic" />,
      className: 'tab-general components-button is-button is-default custom-button-with-icon',
    },
  ];

  if ((!formIsComplexType && formType === 'email') || (formIsComplexType && formTypesComplex.includes('email'))) {
    tabs.push({
      name: 'email',
      title: <Dashicon icon="email" />,
      className: 'tab-email components-button is-button is-default custom-button-with-icon',
    });
  }

  if (isDynamicsCrmUsed && (
    (!formIsComplexType && formType === 'dynamics-crm') || (formIsComplexType && formTypesComplex.includes('dynamics-crm'))
  )) {
    tabs.push({
      name: 'dynamics-crm',
      title: <Dashicon icon="cloud-upload" />,
      className: 'tab-dynamics-crm components-button is-button is-default custom-button-with-icon',
    });
  }

  if (isBuckarooUsed && (
    (!formIsComplexType && formType === 'buckaroo') || (formIsComplexType && formTypesComplexRedirect.includes('buckaroo'))
  )) {
    tabs.push({
      name: 'buckaroo',
      title: <Dashicon icon="money" />,
      className: 'tab-buckaroo components-button is-button is-default custom-button-with-icon',
    });
  }

  if (isMailchimpUsed && (
    (!formIsComplexType && formType === 'mailchimp') || (formIsComplexType && formTypesComplex.includes('mailchimp'))
  )) {
    tabs.push({
      name: 'mailchimp',
      title: <Dashicon icon="email-alt2" />,
      className: 'tab-mailchimp components-button is-button is-default custom-button-with-icon',
    });
  }

  if (isMailerliteUsed && (
    (!formIsComplexType && formType === 'mailerlite') || (formIsComplexType && formTypesComplex.includes('mailerlite'))
  )) {
    tabs.push({
      name: 'mailerlite',
      title: <Dashicon icon="email-alt2" />,
      className: 'tab-mailerlite components-button is-button is-default custom-button-with-icon',
    });
  }

  if ((!formIsComplexType && formType === 'custom') || (formIsComplexType && formTypesComplexRedirect.includes('custom'))) {
    tabs.push({
      name: 'custom',
      title: <Dashicon icon="arrow-right-alt" />,
      className: 'tab-custom components-button is-button is-default custom-button-with-icon',
    });
  }

  if ((!formIsComplexType && formType === 'custom-event') || (formIsComplexType && formTypesComplex.includes('custom-event'))) {
    tabs.push({
      name: 'custom-event',
      title: <Dashicon icon="megaphone" />,
      className: 'tab-custom-event components-button is-button is-default custom-button-with-icon',
    });
  }

  return (
    <PanelBody title={__('Form Settings', 'eightshift-forms')}>
      <TabPanel
        className="custom-button-tabs"
        activeClass="components-button is-button is-primary"
        tabs={tabs}
      >
        {(tab) => (
          <Fragment>
            {tab.name === 'general' && (
              <Fragment>
                <br />
                <strong className="notice-title">{__('General Options', 'eightshift-forms')}</strong>
                <p>{__('These are general form options.', 'eightshift-forms')}</p>
                <br />
                <FormGeneralOptions
									attributes={attributes}
									props={props}
                  blockClass={blockClass}
                  formType={formType}
                  formIsComplexType={formIsComplexType}
                  formTypesComplex={formTypesComplex}
                  formTypesComplexRedirect={formTypesComplexRedirect}
                  formTypes={formTypes}
                  theme={theme}
                  formThemeAsOptions={formThemeAsOptions}
                  hasThemes={hasThemes}
                  richTextClass={richTextClass}
                  formSuccessMessage={formSuccessMessage}
                  formErrorMessage={formErrorMessage}
                  formShouldRedirectOnSuccess={formShouldRedirectOnSuccess}
                  formRedirectSuccess={formRedirectSuccess}
									setAttributes={setAttributes}
                />
              </Fragment>
            )}
            {tab.name === 'email' && (
              <Fragment>
                <br />
                <strong className="notice-title">{__('Email Options', 'eightshift-forms')}</strong>
                <p>{__('These are options for when your form is sending emails. You can use form fields by name as placeholders in Subject and Message fields in the following format [[field_name]]. These will be replace with actual field values before sending.', 'eightshift-forms')}</p>
                <br />
                <FormEmailOptions
									attributes={attributes}
									setAttributes={setAttributes}
                  richTextClass={richTextClass}
                  formEmailTo={formEmailTo}
                  formEmailSubject={formEmailSubject}
                  formEmailMessage={formEmailMessage}
                  formEmailAdditionalHeaders={formEmailAdditionalHeaders}
                  formEmailSendConfirmationToSender={formEmailSendConfirmationToSender}
                  formEmailConfirmationMessage={formEmailConfirmationMessage}
                  formEmailConfirmationSubject={formEmailConfirmationSubject}
                />
              </Fragment>
            )}
            {tab.name === 'dynamics-crm' && (
              <Fragment>
                <br />
                <strong className="notice-title">{__('Dynamics CRM Options', 'eightshift-forms')}</strong>
                <p>{__('These are options for when your form is sending data to Dynamics CRM.', 'eightshift-forms')}</p>
                <br />
                <FormDynamicsCrmOptions
                  formType={formType}
                  crmEntitiesAsOptions={crmEntitiesAsOptions}
                  dynamicsEntity={dynamicsEntity}
                  isDynamicsCrmUsed={isDynamicsCrmUsed}
                  onChangeDynamicsEntity={onChangeDynamicsEntity}
                />
              </Fragment>
            )}
            {tab.name === 'buckaroo' && (
              <Fragment>
                <br />
                <strong className="notice-title">{__('Buckaroo Options', 'eightshift-forms')}</strong>
                <p>{__('These are options for when your form is sending data to Buckaroo.', 'eightshift-forms')}</p>
                <br />
                <FormBuckarooOptions
                  blockClass={blockClass}
                  formType={formType}
                  service={buckarooService}
                  paymentDescription={buckarooPaymentDescription}
                  emandateDescription={buckarooEmandateDescription}
                  sequenceType={buckarooSequenceType}
                  isSequenceTypeOnFrontend={buckarooIsSequenceTypeOnFrontend}
                  redirectUrl={buckarooRedirectUrl}
                  redirectUrlCancel={buckarooRedirectUrlCancel}
                  redirectUrlError={buckarooRedirectUrlError}
                  redirectUrlReject={buckarooRedirectUrlReject}
                  onChangeService={onChangeBuckarooService}
                  onChangeEmandateDescription={onChangeBuckarooEmandateDescription}
                  onChangePaymentDescription={onChangeBuckarooPaymentDescription}
                  onChangeSequenceType={onChangeBuckarooSequenceType}
                  onChangeRedirectUrl={onChangeBuckarooRedirectUrl}
                  onChangeRedirectUrlCancel={onChangeBuckarooRedirectUrlCancel}
                  onChangeRedirectUrlError={onChangeBuckarooRedirectUrlError}
                  onChangeRedirectUrlReject={onChangeBuckarooRedirectUrlReject}
                  onChangeIsSequenceTypeOnFrontend={onChangeBuckarooIsSequenceTypeOnFrontend}
                />

              </Fragment>
            )}
            {tab.name === 'mailchimp' && (
              <Fragment>
                <br />
                <strong className="notice-title">{__('Mailchimp Options', 'eightshift-forms')}</strong>
                <p>{__('These are options for when your form is sending data to Mailchimp.', 'eightshift-forms')}</p>
                <br />
                <FormMailchimpOptions
                  blockClass={blockClass}
                  formType={formType}
                  listId={mailchimpListId}
                  audiences={mailchimpAudiences}
                  addTag={mailchimpAddTag}
                  tags={mailchimpTags}
                  addExistingMembers={mailchimpAddExistingMembers}
                  onChangeListId={onChangeMailchimpListId}
                  onChangeAddTag={onChangeMailchimpAddTag}
                  onChangeTags={onChangeMailchimpTags}
                  onChangeAddExistingMembers={onChangeMailchimpAddExistingMembers}
                />

              </Fragment>
            )}
            {tab.name === 'mailerlite' && (
              <Fragment>
                <br />
                <strong className="notice-title">{__('MailerLite Options', 'eightshift-forms')}</strong>
                <p>{__('These are the options for when your form is sending data to MailerLite.', 'eightshift-forms')}</p>
                <br />
                <FormMailerliteOptions
                  blockClass={blockClass}
                  formType={formType}
                  groupId={mailerliteGroupId}
                  groups={mailerliteGroups}
                  onChangeGroupId={onChangeMailerliteGroupId}
                />

              </Fragment>
            )}
            {tab.name === 'custom' && (
              <Fragment>
                <br />
                <strong className="notice-title">{__('Custom PHP action', 'eightshift-forms')}</strong>
                <p>{__('These are options for when your form is triggering a custom PHP action.', 'eightshift-forms')}</p>
                <br />
                <FormCustomOptions
                  formAction={formAction}
                  formMethod={formMethod}
                  formTarget={formTarget}
                />

              </Fragment>
            )}
            {tab.name === 'custom-event' && (
              <Fragment>
                <br />
                <strong className="notice-title">{__('Custom event options', 'eightshift-forms')}</strong>
                <p>{__('These are options for when your form is triggering a custom event.', 'eightshift-forms')}</p>
                <br />
                <FormCustomEventOptions
                  blockClass={blockClass}
                  formType={formType}
                  eventNames={eventNames}
                  onChangeEventNames={onChangeEventNames}
                />

              </Fragment>
            )}
          </Fragment>
        )}
      </TabPanel>

      {onChangeClasses &&
        <TextControl
          label={__('Classes', 'eightshift-forms')}
          value={classes}
          onChange={onChangeClasses}
        />
      }

      {onChangeId &&
        <TextControl
          label={__('ID', 'eightshift-forms')}
          value={id}
          onChange={onChangeId}
        />
      }
    </PanelBody>
  );
};
