<?php

namespace GetCandy\Licensing\Tests\Unit;

use GetCandy\Licensing\License;
use GetCandy\Licensing\LicenseManager;
use GetCandy\Licensing\Tests\TestCase;
use Illuminate\Support\Facades\Http;

/**
 * @group hub.menu
 */
class LicenseTest extends TestCase
{
    /** @test */
    public function can_initialise_a_license()
    {
        $license = new License;
        $this->assertInstanceOf(License::class, $license);
    }

    /** @test */
    public function can_check_a_license_domain()
    {
        $license = new License;
        $license->fill([
            'domain' => 'https://foobar.com',
        ]);

        $domains = [
            'http://localhost' => true,
            'https://localhost' => true,
            'localhost' => true,
            'foo.test' => true,
            'http://someothertestdomain.test' => true,
            'http://foobar.com' => true,
            'http://notavalid.com' => false,
        ];

        foreach ($domains as $domain => $expectedResult) {
            $this->assertEquals(
                $expectedResult,
                $license->checkDomain($domain),
            );
        }
    }
}
