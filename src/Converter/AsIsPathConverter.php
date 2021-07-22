<?php

namespace WeAreModus\Flysystem\Cloudinary\Converter;

use Cloudinary\Api\ApiResponse;

/**
 * Class AsIsPathConverter
 * Default implementation of PathConverterInterface just does nothing.
 */
class AsIsPathConverter implements PathConverterInterface
{

    /**
     * Converts path to public Id
     *
     * @param string $path
     *
     * @return string
     */
    public function pathToId(string $path): string
    {
        return $path;
    }

    /**
     * Converts id to path
     *
     * @param ApiResponse $id
     *
     * @return string
     */
    public function idToPath(array $id): string
    {
        return $id['public_id'];
    }
}
