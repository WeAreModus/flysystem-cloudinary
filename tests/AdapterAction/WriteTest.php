<?php

namespace WeAreModus\Flysystem\Cloudinary\Test\AdapterAction;

use Cloudinary\Api\Exception\ApiError;
use League\Flysystem\Config;

class WriteTest extends ActionTestCase
{
    public function testReturnsFalseOnFailure()
    {
        list($cloudinary, $api) = $this->buildAdapter();
        $api->upload('path', 'contents', false)
            ->shouldBeCalled()
            ->willThrow(ApiError::class);

        $this->assertFalse($cloudinary->write('path', 'contents', new Config()));
    }

    public function testReturnsFalseOnFailureAndEmptyStream()
    {
        list($cloudinary, $api) = $this->buildAdapter();
        $api->upload('path', '', false)
            ->shouldBeCalled()
            ->willThrow(ApiError::class);

        $this->assertFalse($cloudinary->writeStream('path', fopen('php://memory', 'r+'), new Config()));
    }

    /**
     * @dataProvider writeParametersProvider
     *
     * @param $method
     * @param $path
     * @param $content
     */
    public function testReturnsNormalizedMetadataOnSuccess($method, $path, $content)
    {
        list($cloudinary, $api) = $this->buildAdapter();
        $api->upload($path, is_resource($content) ? stream_get_contents($content) : $content, false)->willReturn([
            'public_id' => $path,
            'path'      => $path,
            'bytes'     => 123123,
        ]);
        $response = $cloudinary->$method($path, $content, new Config());

        $this->assertEquals(123123, $response['size']);
        $this->assertEquals('test-path', $response['path']);
    }

    public function writeParametersProvider(): array
    {
        return [
            'write'       => ['write', 'test-path', 'content'],
            'writeStream' => ['writeStream', 'test-path', fopen('php://memory', 'r+')],
        ];
    }
}
