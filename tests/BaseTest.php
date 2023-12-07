<?php

namespace Tests;

use Yoast\WPTestUtils\BrainMonkey\TestCase;

#[AllowDynamicProperties]
class BaseTest extends TestCase
{
	protected function set_up()
	{
		parent::set_up();

		$this->stubTranslationFunctions();
		$this->stubEscapeFunctions();
	}

	protected function tear_down()
	{
		parent::tear_down();
	}
}
