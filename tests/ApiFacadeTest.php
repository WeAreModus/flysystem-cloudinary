<?php

namespace WeAreModus\Flysystem\Cloudinary\Test;

use Cloudinary\Configuration\Configuration;
use PHPUnit\Framework\TestCase;
use WeAreModus\Flysystem\Cloudinary\ApiFacade;

/**
 * Class ApiFacadeTest
 * Almost all the tests here a very simple just because
 * ApiFacade delegates everything to different parts of Cloudinary API library
 * @package WeAreModus\Flysystem\Cloudinary\Test
 */
class ApiFacadeTest extends TestCase
{
    public static $cloudinary_url_result;
    public static $fopen_result;

    public static function setUpBeforeClass(): void
    {
        require_once __DIR__ . '/fixtures/functions.php';
    }

    public function testContent()
    {
        self::$cloudinary_url_result = 'something';
        self::$fopen_result = $expected = 'test';

        $api = new ApiFacade();

        $this->assertEquals($expected, $api->content('path'));
    }

    public function testUrl()
    {
        self::$cloudinary_url_result = $expected = 'test';

        $api = new ApiFacade();

        $this->assertEquals($expected, $api->url('path'));
    }

    public function testConfigure()
    {
        $api = new ApiFacade();
        $api->configure(['api' => ['callback_url' => 'http://test.test']]);

        $this->assertEquals('http://test.test', Configuration::instance()->api->callbackUrl);
    }
}
