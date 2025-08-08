<?php

use PHPUnit\Framework\TestCase;

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__);
}

if (!function_exists('add_action')) {
    function add_action(...$args) {
        // no-op stub for WordPress hook registration.
    }
}

if (!function_exists('get_stylesheet_directory')) {
    function get_stylesheet_directory() {
        return dirname(__DIR__);
    }
}

require_once dirname(__DIR__) . '/functions.php';

class GetViteAssetTest extends TestCase
{
    private $theme;
    private $method;

    protected function setUp(): void
    {
        $this->theme = DoryoTheme::get_instance();
        $reflection = new ReflectionClass($this->theme);
        $this->method = $reflection->getMethod('get_vite_asset');
        $this->method->setAccessible(true);
    }

    public function test_missing_manifest_returns_false(): void
    {
        $dist = get_stylesheet_directory() . '/dist';
        $manifest = $dist . '/manifest.json';

        if (file_exists($manifest)) {
            unlink($manifest);
        }

        $result = $this->method->invoke($this->theme, 'assets/js/main.ts');

        $this->assertFalse($result);
    }

    public function test_returns_entry_from_manifest(): void
    {
        $dist = get_stylesheet_directory() . '/dist';
        if (!is_dir($dist)) {
            mkdir($dist, 0777, true);
        }

        $manifestFile = $dist . '/manifest.json';
        $manifestData = [
            'assets/js/main.ts' => [
                'file' => 'assets/js/main-123.js',
            ],
        ];

        file_put_contents($manifestFile, json_encode($manifestData));

        $result = $this->method->invoke($this->theme, 'assets/js/main.ts');

        $this->assertIsArray($result);
        $this->assertSame('assets/js/main-123.js', $result['file']);

        unlink($manifestFile);
        rmdir($dist);
    }
}
