<?php
namespace PHPJava\Kernel\OpCode;

use PHPJava\Exceptions\NotImplementedException;
use PHPJava\Utilities\BinaryTool;
use PHPJava\Utilities\Formatter;

final class _invokevirtual implements OpCodeInterface
{
    use \PHPJava\Kernel\Core\Accumulator;
    use \PHPJava\Kernel\Core\ConstantPool;

    public function execute(): void
    {
        $cpInfo = $this->getConstantPool()->getEntries();
        $cp = $cpInfo[$this->readUnsignedShort()];
        $class = $cpInfo[$cpInfo[$cp->getClassIndex()]->getClassIndex()]->getString();
        $nameAndTypeIndex = $cpInfo[$cp->getNameAndTypeIndex()];

        // signature
        $signature = Formatter::parseSignature($cpInfo[$nameAndTypeIndex->getDescriptorIndex()]->getString());
        $arguments = [];

        for ($i = 0; $i < $signature['argumentsCount']; $i++) {
            $arguments[] = $this->getStack();
        }
        
        $invokerClass = $this->getStack();
        var_dump($invokerClass);

        if ($invokerClass instanceof \JavaClass) {
            $result = call_user_func_array(array(

                $invokerClass->getMethodInvoker(),
                $cpInfo[$cpInfo[$cp->getNameAndTypeIndex()]->getNameIndex()]->getString()

            ), $arguments);
        } else {
            $invokerClassName = '\\PHPJava\\Bridge\\' . str_replace('/', '\\', $class);

            $result = call_user_func_array(array(
                
                $invokerClass,
                $cpInfo[$cpInfo[$cp->getNameAndTypeIndex()]->getNameIndex()]->getString()

            ), $arguments);
        }

        if ($signature[0]['type'] !== 'void') {
            $this->pushStack($result);
        }
    }
}
