<?php
namespace PHPJava\Kernel\Mnemonics;

use PHPJava\Kernel\Filters\Normalizer;

final class _ifne extends AbstractOperationCode implements OperationInterface
{
    use \PHPJava\Kernel\Core\Accumulator;
    use \PHPJava\Kernel\Core\ConstantPool;

    public function getOperands(): ?Operands
    {
        parent::getOperands();
        return $this->operands ?? new Operands();
    }

    public function execute(): void
    {
        parent::execute();
        $offset = $this->readShort();

        $operand = Normalizer::getPrimitiveValue($this->popFromOperandStack());

        if ($operand != 0) {
            $this->setOffset($this->getProgramCounter() + $offset);
        }
    }
}
