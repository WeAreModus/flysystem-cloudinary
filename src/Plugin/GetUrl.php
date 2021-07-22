<?php

namespace WeAreModus\Flysystem\Cloudinary\Plugin;

class GetUrl extends AbstractPlugin
{
    /**
     * Get the method name.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return 'getUrl';
    }

    public function handle(string $path, array $options = []): string
    {
        return $this->apiFacade->url($path, $options);
    }
}
