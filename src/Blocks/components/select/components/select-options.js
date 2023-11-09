import React from 'react';
import { __ } from '@wordpress/i18n';
import { select } from '@wordpress/data';
import { useState } from '@wordpress/element';
import { TextControl, PanelBody, Button } from '@wordpress/components';
import {
	icons,
	checkAttr,
	getAttrKey,
	IconLabel,
	props,
	Section,
	IconToggle,
	STORE_NAME,
	NumberPicker,
	Control,
} from '@eightshift/frontend-libs/scripts';
import { FieldOptions } from '../../../components/field/components/field-options';
import { FieldOptionsAdvanced } from '../../field/components/field-options-advanced';
import { isOptionDisabled, NameFieldLabel, NameChangeWarning } from './../../utils';
import { ConditionalTagsOptions } from '../../conditional-tags/components/conditional-tags-options';

export const SelectOptions = (attributes) => {
	const manifest = select(STORE_NAME).getComponent('select');

	const {
		options,
	} = manifest;

	const {
		setAttributes,
	} = attributes;

	const [isNameChanged, setIsNameChanged] = useState(false);

	const selectName = checkAttr('selectName', attributes, manifest);
	const selectIsDisabled = checkAttr('selectIsDisabled', attributes, manifest);
	const selectIsRequired = checkAttr('selectIsRequired', attributes, manifest);
	const selectTracking = checkAttr('selectTracking', attributes, manifest);
	const selectDisabledOptions = checkAttr('selectDisabledOptions', attributes, manifest);
	const selectUseSearch = checkAttr('selectUseSearch', attributes, manifest);
	const selectPlaceholder = checkAttr('selectPlaceholder', attributes, manifest);
	const selectUseLabelAsPlaceholder = checkAttr('selectUseLabelAsPlaceholder', attributes, manifest);
	const selectIsMultiple = checkAttr('selectIsMultiple', attributes, manifest);
	const selectMinCount = checkAttr('selectMinCount', attributes, manifest);
	const selectMaxCount = checkAttr('selectMaxCount', attributes, manifest);

	return (
		<>
			<PanelBody title={__('Select', 'eightshift-forms')}>
				<Section icon={icons.options} label={__('General', 'eightshift-forms')}>
					<TextControl
						label={<NameFieldLabel value={selectName} />}
						help={__('Identifies the field within form submission data. Must be unique.', 'eightshift-forms')}
						value={selectName}
						onChange={(value) => {
							setIsNameChanged(true);
							setAttributes({ [getAttrKey('selectName', attributes, manifest)]: value });
						}}
						disabled={isOptionDisabled(getAttrKey('selectName', attributes, manifest), selectDisabledOptions)}
					/>

					<NameChangeWarning isChanged={isNameChanged} />

					{!selectUseLabelAsPlaceholder &&
						<TextControl
							label={<IconLabel icon={icons.fieldPlaceholder} label={__('Placeholder', 'eightshift-forms')} />}
							help={__('Shown when the field is empty', 'eightshift-forms')}
							value={selectPlaceholder}
							onChange={(value) => setAttributes({ [getAttrKey('selectPlaceholder', attributes, manifest)]: value })}
							disabled={isOptionDisabled(getAttrKey('selectPlaceholder', attributes, manifest), selectDisabledOptions)}
							className='es-no-field-spacing'
						/>
					}
					<IconToggle
						icon={icons.fieldPlaceholder}
						label={__('Use label as placeholder', 'eightshift-forms')}
						checked={selectUseLabelAsPlaceholder}
						onChange={(value) => {
							setAttributes({ [getAttrKey('selectPlaceholder', attributes, manifest)]: undefined });
							setAttributes({ [getAttrKey('selectUseLabelAsPlaceholder', attributes, manifest)]: value });
						}}
					/>
				</Section>

				<FieldOptions
					{...props('field', attributes, {
						fieldDisabledOptions: selectDisabledOptions,
					})}
					additionalControls={<FieldOptionsAdvanced {...props('field', attributes)} />}
				/>

				<Section icon={icons.checks} label={__('Validation', 'eightshift-forms')}>
					<IconToggle
						icon={icons.required}
						label={__('Required', 'eightshift-forms')}
						checked={selectIsRequired}
						onChange={(value) => setAttributes({ [getAttrKey('selectIsRequired', attributes, manifest)]: value })}
						disabled={isOptionDisabled(getAttrKey('selectIsRequired', attributes, manifest), selectDisabledOptions)}
					/>

					{selectIsMultiple &&
						<Control
							icon={icons.range}
							label={__('Number of items', 'eightshift-forms')}
							additionalLabelClasses='es-mb-0!'
						>
							<div className='es-h-spaced es-gap-5!'>
								<div className='es-display-flex es-items-end es-gap-2'>
									<NumberPicker
										label={__('Min', 'eightshift-forms')}
										value={selectMinCount}
										onChange={(value) => setAttributes({ [getAttrKey('selectMinCount', attributes, manifest)]: value })}
										min={options.selectMinCount.min}
										step={options.selectMinCount.step}
										disabled={isOptionDisabled(getAttrKey('selectMinCount', attributes, manifest), selectDisabledOptions)}
										placeholder='–'
										fixedWidth={4}
										noBottomSpacing
									/>

									{selectMinCount > 0 && !isOptionDisabled(getAttrKey('selectMinCount', attributes, manifest), selectDisabledOptions) &&
										<Button
											label={__('Disable', 'eightshift-forms')}
											icon={icons.clear}
											onClick={() => setAttributes({ [getAttrKey('selectMinCount', attributes, manifest)]: undefined })}
											className='es-button-square-32 es-button-icon-24'
											showTooltip
										/>
									}
								</div>

								<div className='es-display-flex es-items-end es-gap-2'>
									<NumberPicker
										label={__('Max', 'eightshift-forms')}
										value={selectMaxCount}
										onChange={(value) => setAttributes({ [getAttrKey('selectMaxCount', attributes, manifest)]: value })}
										min={options.selectMaxCount.min}
										step={options.selectMaxCount.step}
										disabled={isOptionDisabled(getAttrKey('selectMaxCount', attributes, manifest), selectDisabledOptions)}
										placeholder='–'
										fixedWidth={4}
										noBottomSpacing
									/>

									{selectMaxCount > 0 && !isOptionDisabled(getAttrKey('selectMaxCount', attributes, manifest), selectDisabledOptions) &&
										<Button
											label={__('Disable', 'eightshift-forms')}
											icon={icons.clear}
											onClick={() => setAttributes({ [getAttrKey('selectMaxCount', attributes, manifest)]: undefined })}
											className='es-button-square-32 es-button-icon-24'
											showTooltip
										/>
									}
								</div>
							</div>
						</Control>
					}

				</Section>

				<Section icon={icons.tools} label={__('Advanced', 'eightshift-forms')}>
					<IconToggle
						icon={icons.cursorDisabled}
						label={__('Disabled', 'eightshift-forms')}
						checked={selectIsDisabled}
						onChange={(value) => setAttributes({ [getAttrKey('selectIsDisabled', attributes, manifest)]: value })}
						disabled={isOptionDisabled(getAttrKey('selectIsDisabled', attributes, manifest), selectDisabledOptions)}
					/>

					<IconToggle
						icon={icons.search}
						label={__('Search', 'eightshift-forms')}
						checked={selectUseSearch}
						onChange={(value) => setAttributes({ [getAttrKey('selectUseSearch', attributes, manifest)]: value })}
						disabled={isOptionDisabled(getAttrKey('selectUseSearch', attributes, manifest), selectDisabledOptions)}
					/>

					<IconToggle
						icon={icons.files}
						label={__('Allow multi selection', 'eightshift-forms')}
						checked={selectIsMultiple}
						onChange={(value) => {
							setAttributes({ [getAttrKey('selectIsMultiple', attributes, manifest)]: value });
							setAttributes({ [getAttrKey('selectMaxCount', attributes, manifest)]: undefined });
							setAttributes({ [getAttrKey('selectMinCount', attributes, manifest)]: undefined });
						}}
						disabled={isOptionDisabled(getAttrKey('selectIsMultiple', attributes, manifest), selectDisabledOptions)}
						noBottomSpacing
					/>
				</Section>

				<Section icon={icons.alignHorizontalVertical} label={__('Tracking', 'eightshift-forms')} noBottomSpacing collapsable>
					<TextControl
						label={<IconLabel icon={icons.googleTagManager} label={__('GTM tracking code', 'eightshift-forms')} />}
						value={selectTracking}
						onChange={(value) => setAttributes({ [getAttrKey('selectTracking', attributes, manifest)]: value })}
						disabled={isOptionDisabled(getAttrKey('selectTracking', attributes, manifest), selectDisabledOptions)}
						className='es-no-field-spacing'
					/>
				</Section>
			</PanelBody>

			<ConditionalTagsOptions
				{...props('conditionalTags', attributes, {
					conditionalTagsBlockName: selectName,
					conditionalTagsIsHidden: checkAttr('selectFieldHidden', attributes, manifest),
				})}
			/>
		</>
	);
};
