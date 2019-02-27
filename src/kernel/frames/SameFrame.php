<?php
namespace PHPJava\Kernel\Frames;

use PHPJava\Exceptions\NotImplementedException;
use PHPJava\Utilities\BinaryTool;

class SameFrame implements FrameInterface
{
    use \PHPJava\Kernel\Core\BinaryReader;
    use \PHPJava\Kernel\Core\ConstantPool;

    private $frameType = null;

    public function execute(): void
    {
        $this->frameType = $this->readUnsignedByte();
    }
}
