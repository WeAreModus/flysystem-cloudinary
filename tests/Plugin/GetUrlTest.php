<?php

namespace WeAreModus\Flysystem\Cloudinary\Test\Plugin;

use League\Flysystem\Filesystem;
use PHPUnit\Framework\TestCase;
use WeAreModus\Flysystem\Cloudinary\ApiFacade;
use WeAreModus\Flysystem\Cloudinary\CloudinaryAdapter;
use WeAreModus\Flysystem\Cloudinary\Plugin\GetUrl;

class GetUrlTest extends TestCase
{
    public function testPassesTransformationToUrl()
    {
        list ($filesystem, $facade) = $this->mockFacade();
        $transformations = ['width' => 600, 'height' => 600];
        $facade->url('test.jpg', $transformations)->willReturn('http://cloudinary.url/test');

        $content = $filesystem->getUrl('test.jpg', $transformations);
        $this->assertEquals('http://cloudinary.url/test', $content);
    }

    private function mockFacade()
    {
        $api = $this->prophesize(ApiFacade::class);

        $filesystem = new Filesystem(new CloudinaryAdapter($api->reveal()), ['disable_asserts' => true]);
        $filesystem->addPlugin(new GetUrl($api->reveal()));

        return [$filesystem, $api];
    }
}
