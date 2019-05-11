<?php
namespace PHPJava\Kernel\Mnemonics;

use PHPJava\Kernel\Types\_Int;
use PHPJava\Utilities\BinaryTool;
use PHPJava\Utilities\Extractor;

final class _idiv implements OperationInterface
{
    use \PHPJava\Kernel\Core\Accumulator;
    use \PHPJava\Kernel\Core\ConstantPool;

    public function execute(): void
    {
        $value2 = $this->popFromOperandStack();
        $value1 = $this->popFromOperandStack();

        $this->pushToOperandStack(
            _Int::get(
                (int) BinaryTool::div(
                    Extractor::getRealValue($value1),
                    Extractor::getRealValue($value2)
                )
            )
        );
    }
}
