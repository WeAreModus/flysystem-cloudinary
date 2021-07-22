<?php

namespace WeAreModus\Flysystem\Cloudinary\Converter;

class TruncateExtensionConverter implements PathConverterInterface
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
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return $extension
            ? substr($path, 0, -(strlen($extension) + 1))
            : $path;
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
        return $id['public_id'] . '.' . $id['format'];
    }
}
