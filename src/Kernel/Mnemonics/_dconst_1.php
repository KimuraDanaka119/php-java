<?php
namespace PHPJava\Kernel\Mnemonics;

final class _dconst_1 implements OperationInterface
{
    use \PHPJava\Kernel\Core\Accumulator;
    use \PHPJava\Kernel\Core\ConstantPool;

    public function execute(): void
    {
        $this->pushToOperandStack(1);
    }
}
