<?php

class JavaStatement_iload_1 extends JavaStatement {

    public function execute () {

        $this->pushStack($this->getLocalstorage(1));
        
    }

}   
