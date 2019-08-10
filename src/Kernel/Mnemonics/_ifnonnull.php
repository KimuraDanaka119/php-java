<?php
namespace PHPJava\Kernel\Mnemonics;

final class _ifnonnull extends AbstractOperationCode implements OperationCodeInterface
{
    use \PHPJava\Kernel\Core\Accumulator;
    use \PHPJava\Kernel\Core\ConstantPool;

    public function getOperands(): ?Operands
    {
        parent::getOperands();
        if ($this->operands !== null) {
            return $this->operands;
        }
        return $this->operands = new Operands();
    }

    public function execute(): void
    {
        parent::execute();
        $offset = $this->readShort();
        $operand = $this->popFromOperandStack();

        if ($operand !== null) {
            $this->setOffset($this->getProgramCounter() + $offset);
        }
    }
}
