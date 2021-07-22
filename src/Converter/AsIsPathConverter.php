<?php

namespace WeAreModus\Flysystem\Cloudinary\Converter;

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
    public function pathToId($path)
    {
        return $path;
    }

    /**
     * Converts id to path
     *
     * @param array|\Cloudinary\Api\ApiResponse $id
     *
     * @return string
     */
    public function idToPath($id)
    {
        return $id['public_id'];
    }
}
