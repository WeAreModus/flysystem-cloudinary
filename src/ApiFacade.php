<?php

namespace WeAreModus\Flysystem\Cloudinary;

use Cloudinary\Api\Admin\AdminApi;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use WeAreModus\Flysystem\Cloudinary\Converter\AsIsPathConverter;
use WeAreModus\Flysystem\Cloudinary\Converter\PathConverterInterface;

/**
 * Class ApiFacade.
 */
class ApiFacade
{
    /**
     * @var PathConverterInterface
     */
    private PathConverterInterface $converter;
    private array $uploadOptions;

    /**
     * @param array                       $cloudinaryOptions
     * @param PathConverterInterface|null $converter
     */
    public function __construct(array $cloudinaryOptions = [], array $uploadOptions = [], PathConverterInterface $converter = null)
    {
        if (count($cloudinaryOptions)) {
            $this->configure($cloudinaryOptions);
        }

        $this->uploadOptions = $uploadOptions;
        $this->converter = $converter ?: new AsIsPathConverter();
    }

    /**
     * @param array $options
     *                       The most important options are:
     *                       * string $cloud_name Your cloud name
     *                       * string $api_key Your api key
     *                       * string $api_secret You api secret
     *                       * boolean $overwrite Weather to overwrite existing file by rename or copy?
     */
    public function configure(array $options = [])
    {
        Configuration::instance($options);
    }

    /**
     * Sets the options for resource deleting operation.
     *
     * @param array $options
     */
    public function setDeleteOptions(array $options)
    {
        $this->deleteOptions = $options;
    }

    /**
     * @param       $path
     * @param array $options
     *
     * @return array
     */
    public function resource($path, $options = [])
    {
        $resource = (new AdminApi())->asset($this->converter->pathToId($path));

        return $this->addPathToResource($resource);
    }

    public function resources($options = [])
    {
        $response = (new AdminApi())->assets($options);
        $response['resources'] = array_map([$this, 'addPathToResource'], $response['resources']);

        return $response;
    }

    public function deleteFile($path, array $options = [])
    {
        return (new UploadApi())->destroy($this->converter->pathToId($path), $options);
    }

    public function deleteResourcesByPrefix($prefix, $options = [])
    {
        return (new AdminApi())->deleteAssetsByPrefix($prefix, $options);
    }

    /**
     * @param string $path
     * @param string $contents
     * @param bool   $overwrite
     *
     * @return array
     */
    public function upload(string $path, string $contents, bool $overwrite = false)
    {
        $options = array_merge([
            'resource_type' => 'auto',
            'public_id'     => $this->converter->pathToId($path),
            'overwrite'     => $overwrite,
        ], $this->uploadOptions);

        return $this->addPathToResource((new UploadApi())->upload(new DataUri($contents), $options));
    }

    /**
     * @param string $path
     * @param string $newPath
     *
     * @return array
     */
    public function rename(string $path, string $newPath)
    {
        $resource = (new UploadApi())->rename(
            $this->converter->pathToId($path),
            $this->converter->pathToId($newPath)
        );

        return $this->addPathToResource($resource);
    }

    /**
     * Returns content of file with given public id.
     *
     * @param string $path
     * @param array  $options
     *
     * @return resource
     */
    public function content(string $path, array $options = [])
    {
        return fopen($this->url($path, $options), 'r');
    }

    /**
     * Returns URL of file with given public id and transformations.
     *
     * @param string $path
     * @param array  $options
     *
     * @return string
     */
    public function url(string $path, array $options = []): string
    {
        return cloudinary_url($this->converter->pathToId($path), $options);
    }

    /**
     * @param $resource
     *
     * @return mixed
     */
    private function addPathToResource($resource)
    {
        $resource['path'] = $this->converter->idToPath($resource);

        return $resource;
    }
}
