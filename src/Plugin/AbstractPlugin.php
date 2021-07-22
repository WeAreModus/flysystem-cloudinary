<?php

namespace WeAreModus\Flysystem\Cloudinary\Plugin;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\PluginInterface;
use WeAreModus\Flysystem\Cloudinary\ApiFacade;

abstract class AbstractPlugin implements PluginInterface
{
    protected FilesystemInterface $filesystem;

    protected ApiFacade $apiFacade;

    public function __construct(ApiFacade $facade)
    {
        $this->apiFacade = $facade;
    }

    /**
     * Set the Filesystem object.
     *
     * @param FilesystemInterface $filesystem
     */
    public function setFilesystem(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }
}
