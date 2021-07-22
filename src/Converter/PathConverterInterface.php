<?php

namespace WeAreModus\Flysystem\Cloudinary\Converter;

/**
 * This interface is used to convert given path to cloudinary public id and vice versa
 *
 * Implementation of the interface SHOULD be non-destructive: e.g.
 *
 * ```
 * $converter->idToPath($converter->pathToId($path)) === $path
 * ```
 */
interface PathConverterInterface
{
    /**
     * Converts path to public Id
     *
     * @param string $path
     *
     * @return string
     */
    public function pathToId(string $path): string;

    /**
     * Converts id to path
     *
     * @param array $id
     *
     * @return string
     */
    public function idToPath(array $id): string;
}
