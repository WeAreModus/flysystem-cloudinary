<?php

namespace WeAreModus\Flysystem\Cloudinary\Test\Plugin;

use League\Flysystem\Filesystem;
use PHPUnit\Framework\TestCase;
use WeAreModus\Flysystem\Cloudinary\ApiFacade;
use WeAreModus\Flysystem\Cloudinary\CloudinaryAdapter;
use WeAreModus\Flysystem\Cloudinary\Plugin\GetVersionedUrl;

class GetVersionedUrlTest extends TestCase
{
    public function testPassesVersionToUrl()
    {
        list ($filesystem, $facade) = $this->mockFacade();
        $version = time();
        $options = ['version' => $version];
        $facade->url('test.jpg', $options)->willReturn("http://cloudinary.url/v{$version}/test");

        $content = $filesystem->getVersionedUrl('test.jpg', $options);
        $this->assertEquals("http://cloudinary.url/v{$version}/test", $content);
    }

    public function resourceResponseProvider()
    {
        return [
            [['version' => $version = time()], $version],
            [[], 1],
        ];
    }

    /**
     * @param $resourceResponse
     * @param $version
     *
     * @dataProvider resourceResponseProvider
     */
    public function testVersionedUrlWithoutVersionOption($resourceResponse, $version)
    {
        list ($filesystem, $facade) = $this->mockFacade();

        $facade->resource('test.jpg')->willReturn($resourceResponse);

        $facade->url('test.jpg', ['version' => $version])->willReturn("http://cloudinary.url/v{$version}/test");

        $content = $filesystem->getVersionedUrl('test.jpg');
        $this->assertEquals("http://cloudinary.url/v{$version}/test", $content);
    }

    private function mockFacade()
    {
        $api = $this->prophesize(ApiFacade::class);

        $filesystem = new Filesystem(new CloudinaryAdapter($api->reveal()), ['disable_asserts' => true]);
        $filesystem->addPlugin(new GetVersionedUrl($api->reveal()));

        return [$filesystem, $api];
    }
}
