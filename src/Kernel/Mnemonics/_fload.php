<?php
namespace PHPJava\Kernel\Mnemonics;

use PHPJava\Kernel\Types\_Float;

final class _fload extends AbstractOperationCode implements OperationCodeInterface
{
    protected $isStackingOperation = true;

    public function getOperands(): ?Operands
    {
        parent::getOperands();
        if ($this->operands !== null) {
            return $this->operands;
        }
        $index = $this->readUnsignedByte();

        return $this->operands = new Operands(
            ['index', $index, ['index']]
        );
    }

    public function execute(): void
    {
        parent::execute();
        $index = $this->getOperands()['index'];
        $this->pushToOperandStack(
            _Float::get(
                $this->getLocalStorage($index)
            )
        );
    }
}
