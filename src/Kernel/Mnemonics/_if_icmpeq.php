<?php
namespace PHPJava\Kernel\Mnemonics;

use PHPJava\Exceptions\NotImplementedException;
use PHPJava\Utilities\Extractor;

final class _if_icmpeq implements OperationInterface
{
    use \PHPJava\Kernel\Core\Accumulator;
    use \PHPJava\Kernel\Core\ConstantPool;

    public function execute(): void
    {
        $offset = $this->readShort();

        $rightOperand = Extractor::getRealValue($this->popFromOperandStack());
        $leftOperand = Extractor::getRealValue($this->popFromOperandStack());

        if ($leftOperand == $rightOperand) {
            $this->setOffset($this->getProgramCounter() + $offset);
        }
    }
}
