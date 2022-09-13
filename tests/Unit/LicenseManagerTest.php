<?php

namespace GetCandy\Licensing\Tests\Unit;

use GetCandy\Licensing\License;
use GetCandy\Licensing\LicenseManager;
use GetCandy\Licensing\Tests\TestCase;
use Illuminate\Support\Facades\Http;

/**
 * @group hub.menu
 */
class LicenseManagerTest extends TestCase
{
    /** @test */
    public function can_get_addon_details()
    {
        $this->assertTrue(true);
        Http::fake([
            '*' => Http::response([
                'id' => 12345,
                'name' => 'Foo Bar',
                'valid' => true,
                'has_key' => false,
                'domain' => 'http://myaddon.com',
            ], 200),
        ]);

        $license = LicenseManager::fetch('foo/bar', [
            'key' => null,
        ]);

        $this->assertInstanceOf(License::class, $license);
    }
}
