<?php

class TestCallOutsideStatementOfClasses
{
    /**
     * @param \PHPJava\Packages\java\lang\_String[] $args
     */
    public function main($args)
    {
        echo 'Dont show.';
    }
}

echo 'Hello World!';
