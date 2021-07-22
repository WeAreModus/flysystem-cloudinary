<?php

namespace WeAreModus\Flysystem\Cloudinary;

use WeAreModus\Flysystem\Cloudinary\Test\ApiFacadeTest;

function cloudinary_url(string $path, array $parameters = [])
{
    return ApiFacadeTest::$cloudinary_url_result;
}

function fopen(string $path, string $attributes)
{
    return ApiFacadeTest::$fopen_result;
}
