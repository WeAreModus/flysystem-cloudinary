<?php

namespace WeAreModus\Flysystem\Cloudinary\Test\AdapterAction;

use PHPUnit\Framework\TestCase;
use WeAreModus\Flysystem\Cloudinary\ApiFacade;
use WeAreModus\Flysystem\Cloudinary\CloudinaryAdapter;

abstract class ActionTestCase extends TestCase
{
    /**
     * @return [CloudinaryAdapter, ApiFacade]
     */
    final protected function buildAdapter(): array
    {
        $api = $this->prophesize(ApiFacade::class);

        return [new CloudinaryAdapter($api->reveal()), $api];
    }
}
