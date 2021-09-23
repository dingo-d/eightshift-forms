<?php

/**
 * Interface that holds all labels.
 *
 * @package EightshiftLibs\Labels
 */

declare(strict_types=1);

namespace EightshiftForms\Labels;

/**
 * Labels Interface.
 */
interface InterfaceLabels
{
	/**
	 * Get all labels
	 *
	 * @return array
	 */
	public function getLabels(): array;

	/**
	 * Return one label by key
	 *
	 * @param string $key Label key.
	 * @param string $formId Form ID.
	 *
	 * @return string
	 */
	public function getLabel(string $key, string $formId): string;
}
