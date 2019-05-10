<?php
namespace PHPJava\Kernel\Mnemonics;

use PHPJava\Core\JVM\Intern\StringIntern;

final class _aload_2 implements OperationInterface
{
    use \PHPJava\Kernel\Core\Accumulator;
    use \PHPJava\Kernel\Core\ConstantPool;

    /**
     * load a reference onto the stack from local variable 2.
     */
    public function execute(): void
    {
        $index = 2;
        $stringIntern = $this->javaClassInvoker
            ->getProvider('InternProvider')
            ->get(StringIntern::class);
        $internedValue = $stringIntern[spl_object_id($this->getLocalStorage($index))] ?? null;
        $this->pushToOperandStack($internedValue ?: $this->getLocalStorage($index));
    }
}
