<?php
namespace PHPJava\Kernel\Variables;

class TopVariableInfo implements VariableInfoInterface
{
    use \PHPJava\Kernel\Core\BinaryReader;
    use \PHPJava\Kernel\Core\ConstantPool;

    private $tag;

    public function execute(): void
    {
        $this->tag = $this->readUnsignedByte();
    }
}
