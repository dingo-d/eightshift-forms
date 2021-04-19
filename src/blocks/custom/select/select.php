<?php
/**
 * Template for the Select Block view.
 *
 * @package EightshiftForms\Blocks.
 */

namespace EightshiftForms\Blocks;

use EightshiftForms\Helpers\Components;

$attributes['innerBlockContent'] = $inner_block_content ?? '';

echo \wp_kses_post( Components::render( 'select', $attributes ) );
