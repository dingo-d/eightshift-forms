<?php

namespace Tests\Unit\AdminMenus;

use EightshiftForms\AdminMenus\FormAdminBarMenu;
use EightshiftForms\Settings\Listing\FormListingInterface;
use Mockery;

use function Brain\Monkey\Functions\when;
use function Tests\mock;

beforeEach(function () {
    $this->formListing = Mockery::mock(FormListingInterface::class);
    $this->formAdminBarMenu = new FormAdminBarMenu($this->formListing);
});

afterEach(function() {
    Mockery::close();
});

it('can be instantiated', function() {
    $this->assertTrue($this->formAdminBarMenu instanceof FormAdminBarMenu);
});

it('adds menu items', function() {
    // Mock the `getFormsList` method to return a predefined array
    $this->formListing->shouldReceive('getFormsList')->andReturn([
        [
            'id' => '1',
            'title' => 'Form 1',
            'editLink' => 'http://example.com/edit-form-1'
        ],
        [
            'id' => '2',
            'title' => 'Form 2',
            'editLink' => 'http://example.com/edit-form-2'
        ],
    ]);

    // Mock the WP_Admin_Bar object
    $adminBar = Mockery::mock('overload:WP_Admin_Bar')->makePartial();
    $adminBar->shouldReceive('add_menu')->twice();

    // Mock is_network_admin() function to return false
    when('is_network_admin')->justReturn(false);
    when('current_user_can')->justReturn(true);
    when('get_admin_url')->alias(function($blogId, $path) {
		return "http://example.com/{$path}";
	});

    // Call the method that adds the menu items
    $this->formAdminBarMenu->getTopBarMenu($adminBar);

    // Assert that `getFormsList` and `add_menu` were called
    $this->formListing->shouldHaveReceived('getFormsList');
    $adminBar->shouldHaveReceived('add_menu');
});
