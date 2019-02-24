<?php
namespace PHPJava\Kernel\Mnemonics;

use PHPJava\Exceptions\NotImplementedException;
use PHPJava\Utilities\BinaryTool;

final class _aaload implements OperationInterface
{
    use \PHPJava\Kernel\Core\Accumulator;
    use \PHPJava\Kernel\Core\ConstantPool;

    /**
     * load onto the stack a reference from an array
     */
    public function execute(): void
    {
        $index = $this->getStack();
        $arrayref = $this->getStack();

        if (!isset($arrayref[$index])) {
            throw new \PHPJava\Bridge\java\lang\ArrayIndexOutOfBoundsException('Array Index ' . $index . ' out of bounds.');
        }
        $this->pushStack($arrayref[$index]);
    }
}
