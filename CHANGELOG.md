
# Change Log for the Eightshift Forms
All notable changes to this project will be documented in this file.

This projects adheres to [Semantic Versioning](https://semver.org/) and [Keep a CHANGELOG](https://keepachangelog.com/).

## [3.0.0]

### Added
- Forms listing filter will allow you to filter form by type.
- Forms settings will now follow the used theme admin color scheme.
- New Dashboard settings page where you can toggle options you want to use in the project.
- New checkbox toggle state for the settings pages.
- Conditional logic for all integration forms.
- Documentation page in the settings.
- Migrations page where you can migrate the data for the options that were changed in the major versions.

### Changed
- Visual styling for all settings pages with tabs, better copy, and a lot of UX/UI improvements.
- Fallback emails are no longer in the troubleshooting class but as a standalone class.
- Your forms will now show only integrations in the settings set in the Block editor.

### Fixed
- Optimized loading of all settings pages.

### Removed
- `ES_DEVELOP_MODE` constant because you can configure everything from the settings page.

## [2.2.0]

### Changed
- HubSpot internal logic for api auth. Switching from API Key to Private App.

## [2.1.0]

### Fixed
- Issue with the hidden field and legacy items in the integration settings.

### Changed
- MailerLite default status to active

## [2.0.1]

### Fixed
- Hubspot fix so the input hidden is not displayed on the frontend.

## [2.0.0]

### Added
- custom form params are now in one place and used as an enum for PHP and JS.
- server errors will no longer produce a fatal error on the form but will output the message to the user, which is also translatable.
- option to remove all unnecessary custom params set on the form before the final integration post, so we don't send unnecessary stuff.
- new admin setting sidebar title for grouping the sections
- new troubleshooting section that contains debugging options: skip validation, form reset on submit, output log.
- new fallback email fields for all integrations; this will send an email with all details if there is an integration issue.
- `es_forms_geolocation_db_location` filter to specify the location of the geolocation database in your project.
- `es_forms_geolocation_phar_location ` filter to specify the location of the geolocation database in your project.
- new filter `es_forms_troubleshooting_output_log` provides the ability to output internal logs to an external source.
- new toggle button in troubleshooting settings will enable you to skip captcha validation.
- geolocation license copy
- new sortable option to all integration fields.

### Changed
- all JS global variables for frontend and backend are now using the same name.
- internal custom field for actions is now called es-form-action.
- filter for setting http request from `httpRequestArgs ` to `httpRequestTimeout` because it is used only to set timeout.
- Greenhouse integration from `wp_remote_post ` to regular `Curl` because of the issues while sending the attachments. You are now only limited on the amount of memory your server can send.
- form will now throw an error if form-ID or type is missing in the request.
- all remote requests are now outputed via helper for easier and more predictable output.
- converting from internal geolocation logic to libs abstract class logic.
- updating libs.
- `ES_GEOLOCAITON` global constant to `ES_GEOLOCAITON_IP`.

### Fixed
- all wrong text domains are changed from `eightshift-form` to `eightshift-forms`.
- Active campaign body was set wrong and was not working.
- Active campaign setting info copy for setting api key and url.
- customSuccess label is now translatable from settings.
- validator will now skip the input type hidden because there is no need for that.
- Greenhouse timeout issue on large files.
- wrong mime type for google docs file format .docx
- internal filter naming for functions

### Removed
- `ES_DEVELOP_MODE_SKIP_VALIDATION ` because it is used from admin now.
- `ES_LOG_MODE ` because it is used from admin now.
- `es_forms_geolocation_user_location` filter.

## [1.4.0]

### Fixed
- preselected values for custom select.
- added additional corrections for localStorage.
- missing attribute from component to form block manifest.json.
- updating libs and frontend libs.
- fixing loading of js.
- fixing way the settings are passed to the js.
- fixing linting issues.

### Removed
- removing unnecessary style and scripts.

### Added
- new field hidden attributes for hiding fields from dom.
- hidden field for hubspot integration.
- preselected value field for hubspot integration.
- enabled field for hubspot integration.
- new custom form type used to provide custom form action location.
- options in forms block to define action.
- option to send form submit to external url if form action is set.
- new tracking class for storing url tags and detecting tags from get param.
- new option to store url tracking tags to localStorage for later usage.
- new filters for tracking.
- local and global file upload allowed types.

## [1.3.0]

### Fixed
- logic for scroll to top and scroll to first error.
- Mailchimp integration merge fields.

### Changed
- Logic behind the form Js initialization with the option to avoid domReady.

### Added
- Method to remove all event listeners on demand.
- New event when all event listeners are removed.
- Filter for updating http_request_args.
- Better internal logging for integrations.

## [1.2.4]

### Added
- Option to provide checkbox unchecked value.
- New filter to allow filtering of the formDataTypeSelector attribute during form component renders.

### Fixed
- Greenhouse integration checkbox true/false unchecked value.

## [1.2.3]

### Fixed
- Geolocation hook condition to be able to disable on filter.

## [1.2.2]

### Fixed
- Internal build process for GH actions.

## [1.2.1]

### Fixed
- Internal links to support WP multisite.

## [1.2.0]

### Added
- passing get parameters to the backend to process and get what we need.
- New Greenhouse field that gets data from the get parameter and pass it to the api.

### Fixed
- Broken validation for file type.
- Validation for input type to detect the type and validate accordingly.

## [1.1.1]

### Fixed
- Option to show WP-CLI command.
- Mailchimp integration total number of list items to show.

## [1.1.0]

### Added
- Option to use string templates in mailer subject and other fields.

## [1.0.0]

- Initial production release.

[3.0.0]: https://github.com/infinum/eightshift-forms/compare/2.2.0...3.0.0
[2.2.0]: https://github.com/infinum/eightshift-forms/compare/2.1.0...2.2.0
[2.1.0]: https://github.com/infinum/eightshift-forms/compare/2.0.1...2.1.0
[2.0.1]: https://github.com/infinum/eightshift-forms/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/infinum/eightshift-forms/compare/1.4.0...2.0.0
[1.4.0]: https://github.com/infinum/eightshift-forms/compare/1.3.0...1.4.0
[1.3.0]: https://github.com/infinum/eightshift-forms/compare/1.2.4...1.3.0
[1.2.4]: https://github.com/infinum/eightshift-forms/compare/1.2.3...1.2.4
[1.2.3]: https://github.com/infinum/eightshift-forms/compare/1.2.2...1.2.3
[1.2.2]: https://github.com/infinum/eightshift-forms/compare/1.2.1...1.2.2
[1.2.1]: https://github.com/infinum/eightshift-forms/compare/1.2.0...1.2.1
[1.2.0]: https://github.com/infinum/eightshift-forms/compare/1.1.1...1.2.0
[1.1.1]: https://github.com/infinum/eightshift-forms/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/infinum/eightshift-forms/compare/1.0.0...1.1.0
[1.0.0]: https://github.com/infinum/eightshift-forms/releases/tag/1.0.0
