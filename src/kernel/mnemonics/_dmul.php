<?php
namespace PHPJava\Kernel\Mnemonics;

use \PHPJava\Exceptions\NotImplementedException;

final class _dmul implements MnemonicInterface
{
    use \PHPJava\Kernel\Core\Accumulator;

    public function execute(): void
    {    
        $value1 = $this->getStack();
        $value2 = $this->getStack();

        $this->pushStack(BinaryTools::multiply($value1, $value2, 8));
        
        
        
    }

}   
