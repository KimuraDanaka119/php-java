<?php
namespace PHPJava\Kernel\Mnemonics;

use PHPJava\Kernel\Filters\Normalizer;

final class _tableswitch extends AbstractOperationCode implements OperationInterface
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
        $key = Normalizer::getPrimitiveValue(
            $this->popFromOperandStack()
        );

        // padding data
        $paddingData = 4 - (($this->getOffset()) % 4);
        if ($paddingData != 4) {
            $this->read($paddingData);
        }

        $offsets = [];
        $offsets['default'] = $this->readInt();
        $lowByte = $this->readInt();
        $highByte = $this->readInt();

        for ($i = $lowByte; $i <= $highByte; $i++) {
            $offsets[$i] = $this->readInt();
        }

        if (isset($offsets[$key])) {
            // goto PC
            $this->setOffset($this->getProgramCounter() + $offsets[$key]);
            return;
        }

        // goto default
        $this->setOffset($this->getProgramCounter() + $offsets['default']);
    }
}
