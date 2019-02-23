<?php
namespace PHPJava\Kernel\Structures;

use PHPJava\Exceptions\NotImplementedException;
use PHPJava\Utilities\BinaryTool;

class _String implements StructureInterface
{
    use \PHPJava\Kernel\Core\BinaryReader;
    use \PHPJava\Kernel\Core\ConstantPool;

    private $StringIndex = null;
    public function execute(): void
    {
        $this->StringIndex = $this->readUnsignedShort();
    }
    public function getStringIndex()
    {
        return $this->StringIndex;
    }
}
