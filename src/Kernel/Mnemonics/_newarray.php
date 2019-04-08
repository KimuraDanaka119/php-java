<?php
namespace PHPJava\Kernel\Mnemonics;

use PHPJava\Exceptions\NotImplementedException;
use PHPJava\Utilities\BinaryTool;
use PHPJava\Utilities\Extractor;

final class _newarray implements OperationInterface
{
    use \PHPJava\Kernel\Core\Accumulator;
    use \PHPJava\Kernel\Core\ConstantPool;

    public function execute(): void
    {
        $atype = $this->readUnsignedByte();
        $count = Extractor::realValue($this->popFromOperandStack());
        
        // need reference
        $ref = new \ArrayIterator(array_fill(0, $count, null));
        $this->pushToOperandStackByReference($ref);
    }
}
