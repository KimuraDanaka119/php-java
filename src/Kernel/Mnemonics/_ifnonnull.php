<?php
declare(strict_types=1);
namespace PHPJava\Kernel\Mnemonics;

final class _ifnonnull extends AbstractOperationCode implements OperationCodeInterface
{
    public function getOperands(): ?Operands
    {
        parent::getOperands();
        if ($this->operands !== null) {
            return $this->operands;
        }
        $branchbyte = $this->readShort();

        return $this->operands = new Operands(
            ['branchbyte', $branchbyte, ['branchbyte1', 'branchbyte2']]
        );
    }

    public function execute(): void
    {
        parent::execute();
        $offset = $this->getOperands()['branchbyte'];
        $operand = $this->popFromOperandStack();

        if ($operand !== null) {
            $this->setOffset($this->getProgramCounter() + $offset);
        }
    }
}
