<?php

namespace GetCandy\Licensing;

use Illuminate\Support\Facades\Http;

class LicenseManager
{
    protected static $host = 'https://getcandy.io';

    public static function fetch($package)
    {
        Http::fake([
            '*' => Http::response([
                'id' => '123456',
                'licensed' => (bool) ($package['license'] ?? false),
                'verified' => true,
                'url' => 'https://getcandy.io/getcandy/foo-bar',
                'seller' => 'GetCandy',
                'latestVersion' => '1.2.0',
                'domain' => 'http://myaddon.com',
            ], 200),
        ]);

        $response = Http::get(self::$host.'/licenses', [
            'package' => $package,
        ]);

        return (new License)->fill($response->json());
    }

    /**
     * TODO: This is for testing only and will never go to production.
     */
    public static function fetchFail($package)
    {
        Http::fake([
            '*' => Http::response([
                'id' => 7891011,
                'licensed' => false,
                'verified' => true,
                'slug' => 'foo-bar',
                'seller' => 'GetCandy',
                'current_version' => '1.0.0',
                'latest_version' => '1.2.0',
                'domain' => 'http://myaddon.com',
            ], 200),
        ]);

        $response = Http::get(self::$host.'/licenses/fail', [
            'package' => $package,
        ]);

        return (new License)->fill($response->json());
    }
}
