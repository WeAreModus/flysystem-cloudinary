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
    public function pathToId(string $path): string
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return $extension
            ? substr($path, 0, -(strlen($extension) + 1))
            : $path;
    }

    /**
     * Converts id to path
     *
     * @param array $id
     *
     * @return string
     */
    public function idToPath(array $id): string
    {
        return $id['public_id'] . '.' . $id['format'];
    }
}
