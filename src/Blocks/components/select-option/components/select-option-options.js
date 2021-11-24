import React from 'react';
import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';
import { TextControl } from '@wordpress/components';
import {
	checkAttr,
	getAttrKey,
	icons,
	ComponentUseToggle,
	IconToggle,
	IconLabel
} from '@eightshift/frontend-libs/scripts';
import manifest from '../manifest.json';

export const SelectOptionOptions = (attributes) => {
	const {
		setAttributes,
	} = attributes;

	const selectOptionLabel = checkAttr('selectOptionLabel', attributes, manifest);
	const selectOptionValue = checkAttr('selectOptionValue', attributes, manifest);
	const selectOptionIsSelected = checkAttr('selectOptionIsSelected', attributes, manifest);
	const selectOptionIsDisabled = checkAttr('selectOptionIsDisabled', attributes, manifest);

	const [showAdvanced, setShowAdvanced] = useState(false);

	return (
		<>
			<TextControl
				label={<IconLabel icon={icons.fieldLabel} label={__('Label', 'eightshift-forms')} />}
				value={selectOptionLabel}
				onChange={(value) => setAttributes({ [getAttrKey('selectOptionLabel', attributes, manifest)]: value })}
				help={__('Set label used for select option.', 'eightshift-forms')}
			/>

			<ComponentUseToggle
				label={__('Show advanced options', 'eightshift-forms')}
				checked={showAdvanced}
				onChange={() => setShowAdvanced(!showAdvanced)}
				showUseToggle={true}
				showLabel={true}
			/>

			{showAdvanced &&
				<>
					<TextControl
						label={<IconLabel icon={icons.fieldValue} label={__('Value', 'eightshift-forms')} />}
						help={__('Provide value that is going to be used when user clicks on this field.', 'eightshift-forms')}
						value={selectOptionValue}
						onChange={(value) => setAttributes({ [getAttrKey('selectOptionValue', attributes, manifest)]: value })}
					/>

					<IconToggle
						icon={icons.checkSquare}
						label={__('Is Selected', 'eightshift-forms')}
						checked={selectOptionIsSelected}
						onChange={(value) => setAttributes({ [getAttrKey('selectOptionIsSelected', attributes, manifest)]: value })}
					/>

					<IconToggle
						icon={icons.fieldDisabled}
						label={__('Is Disabled', 'eightshift-forms')}
						checked={selectOptionIsDisabled}
						onChange={(value) => setAttributes({ [getAttrKey('selectOptionIsDisabled', attributes, manifest)]: value })}
					/>
				</>
			}
		</>
	);
};
