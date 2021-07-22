<?php

namespace WeAreModus\Flysystem\Cloudinary\Test\AdapterAction;

use Cloudinary\Api\Exception\ApiError;

class DeleteTest extends ActionTestCase
{
    public function testReturnsFalseOnFailure()
    {
        list($cloudinary, $api) = $this->buildAdapter();
        $api->deleteFile('file')->willReturn(['result' => 'not found']);
        $this->assertFalse($cloudinary->delete('file'));
    }

    public function testReturnsFalseOnException()
    {
        list($cloudinary, $api) = $this->buildAdapter();
        $api->deleteFile('file')->willThrow(ApiError::class);
        $this->assertFalse($cloudinary->delete('file'));
    }

    public function testReturnsTrueOnSuccess()
    {
        list($cloudinary, $api) = $this->buildAdapter();
        $api->deleteFile('file.jpg')->willReturn(['result' => 'ok']);
        $this->assertTrue($cloudinary->delete('file.jpg'));
    }

    public function testDeleteDirSuccess()
    {
        list($cloudinary, $api) = $this->buildAdapter();
        $api->deleteResourcesByPrefix('path/')->willReturn(['deleted' => []]);

        $this->assertTrue($cloudinary->deleteDir('path'));
        $this->assertTrue($cloudinary->deleteDir('path/'), 'deleteDir must be idempotent');
    }

    public function testDeleteDirFailure()
    {
        list($cloudinary, $api) = $this->buildAdapter();
        $api->deleteResourcesByPrefix('path/')->willThrow(ApiError::class);
        $this->assertFalse($cloudinary->deleteDir('path/'));
    }
}
