<?php

namespace WeAreModus\Flysystem\Cloudinary;

/**
 * Class DataUri
 * Creates DATA-URI formatted string from file content.
 *
 * @author Alex Panshin <deadyaga@gmail.com>
 *
 * @codeCoverageIgnore
 */
class DataUri
{
    private $content;
    private $finfo;

    /**
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return \finfo
     */
    private function getFileInfo()
    {
        if (!$this->finfo) {
            $this->finfo = new \finfo(FILEINFO_MIME_TYPE);
        }

        return $this->finfo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            'data:%s;base64,%s',
            $this->getFileInfo()->buffer(substr($this->content, 0, 1024 * 1024)),
            base64_encode($this->content)
        );
    }
}
