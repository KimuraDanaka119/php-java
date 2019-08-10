<?php
namespace PHPJava\Kernel\Mnemonics;

final class _aload_2 extends AbstractOperationCode implements OperationInterface
{
    use \PHPJava\Kernel\Core\Accumulator;
    use \PHPJava\Kernel\Core\ConstantPool;

    public function getOperands(): ?Operands
    {
        parent::getOperands();
        return $this->operands ?? new Operands();
    }

    /**
     * load a reference onto the stack from local variable 2.
     */
    public function execute(): void
    {
        parent::execute();
        $index = 2;
        $this->pushToOperandStack($this->getLocalStorage($index));
    }
}
