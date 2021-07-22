<?php

namespace WeAreModus\Flysystem\Cloudinary\Test\Converter;

use PHPUnit\Framework\TestCase;
use WeAreModus\Flysystem\Cloudinary\Converter\PathConverterInterface;
use WeAreModus\Flysystem\Cloudinary\Converter\TruncateExtensionConverter;

class TruncateExtensionConverterTest extends TestCase
{
    private PathConverterInterface $converter;

    protected function setUp(): void
    {
        $this->converter = new TruncateExtensionConverter();
    }

    public function testPathToId()
    {
        $this->assertEquals('file', $this->converter->pathToId('file.png'));
    }

    public function testIdToPath()
    {
        $this->assertEquals('file.png', $this->converter->idToPath([
            'public_id' => 'file',
            'format'    => 'png',
        ]));
    }

    public function testNonDestructive()
    {
        $resource = [
            'public_id' => 'file',
            'format'    => 'png',
        ];

        $path = $this->converter->idToPath($resource);
        $id = $this->converter->pathToId($path);

        $this->assertEquals('file', $id);
    }
}
