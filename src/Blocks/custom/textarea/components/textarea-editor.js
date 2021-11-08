import React from 'react';
import { props } from '@eightshift/frontend-libs/scripts';
import { TextareaEditor as TextareaEditorComponent } from '../../../components/textarea/components/textarea-editor';

export const TextareaEditor = ({ attributes, setAttributes, clientId }) => {

	const {
		blockClass,
	} = attributes;

	return (
		<TextareaEditorComponent
			{...props('textarea', attributes, {
				setAttributes,
				blockClass,
				clientId,
			})}
		/>
	);
}
