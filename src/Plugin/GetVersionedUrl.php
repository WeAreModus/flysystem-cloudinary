<?php

namespace WeAreModus\Flysystem\Cloudinary\Plugin;

class GetVersionedUrl extends AbstractPlugin
{
    const VERSION_OPTION = 'version';

    /**
     * Get the method name.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return 'getVersionedUrl';
    }

    /**
     * Returns url with version.
     * If no version was passed to $options, than the latest version will be used.
     * Note that getting latest version is one more api call. Make sure you won't exceed
     * api calls limit of your cloudinary plan.
     *
     * @param string $path
     * @param array  $options
     *
     * @return string
     */
    public function handle(string $path, array $options = []): string
    {
        $options[self::VERSION_OPTION] = $options[self::VERSION_OPTION] ?? $this->getLatestVersion($path);

        return $this->apiFacade->url($path, $options);
    }

    /**
     * @param string $path
     *
     * @return int|mixed
     */
    private function getLatestVersion(string $path): mixed
    {
        $resource = $this->apiFacade->resource($path);

        return array_key_exists(self::VERSION_OPTION, $resource)
            ? $resource[self::VERSION_OPTION]
            : 1;
    }
}
