<?php
declare(strict_types=1);
namespace PHPJava\Kernel\Mnemonics;

use PHPJava\Kernel\Filters\Normalizer;
use PHPJava\Kernel\Types\Int_;

final class _l2i extends AbstractOperationCode implements OperationCodeInterface
{
    protected $isStackingOperation = true;

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
        $value = Normalizer::getPrimitiveValue(
            $this->popFromOperandStack()
        );

        $this->pushToOperandStack(Int_::get($value));
    }
}
