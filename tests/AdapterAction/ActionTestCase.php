<?php

namespace Enl\Flysystem\Cloudinary\Test\AdapterAction;

use Enl\Flysystem\Cloudinary\ApiFacade;
use Enl\Flysystem\Cloudinary\CloudinaryAdapter;

abstract class ActionTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return [CloudinaryAdapter, ApiFacade]
     */
    final protected function buildAdapter()
    {
        $api = $this->prophesize(ApiFacade::class);

        return [new CloudinaryAdapter($api->reveal()), $api];
    }
}
