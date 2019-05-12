<?php
namespace PHPJava\Tests;

class ArrayTest extends Base
{
    protected $fixtures = [
        'ArrayTest',
    ];

    private function call($method)
    {
        return $this->initiatedJavaClasses['ArrayTest']
            ->getInvoker()
            ->getStatic()
            ->getMethods()
            ->call($method);
    }

    public function testCreateIntArray()
    {
        $actual = $this->call('createIntArray');

        $this->assertEquals(3, $actual->count());
        $this->assertEquals(1, $actual->offsetGet(0)->getValue());
        $this->assertEquals(2, $actual->offsetGet(1)->getValue());
        $this->assertEquals(3, $actual->offsetGet(2)->getValue());
    }

    public function testCreateStringArray()
    {
        $actual = $this->call('createStringArray');

        $this->assertEquals(3, $actual->count());
        $this->assertEquals('foo', $actual->offsetGet(0));
        $this->assertEquals('bar', $actual->offsetGet(1));
        $this->assertEquals('baz', $actual->offsetGet(2));
    }

    public function testCreateLongArray()
    {
        $actual = $this->call('createLongArray');

        $this->assertEquals(3, $actual->count());
        $this->assertEquals('1', $actual->offsetGet(0));
        $this->assertEquals('2', $actual->offsetGet(1));
        $this->assertEquals('3', $actual->offsetGet(2));
    }

    public function testCreateFloatArray()
    {
        $actual = $this->call('createFloatArray');

        $this->assertEquals(3, $actual->count());
        $this->assertEquals('1.5', $actual->offsetGet(0));
        $this->assertEquals('2.5', $actual->offsetGet(1));
        $this->assertEquals('3.5', $actual->offsetGet(2));
    }

    public function testCreateDoubleArray()
    {
        $actual = $this->call('createDoubleArray');

        $this->assertEquals(3, $actual->count());
        $this->assertEquals('1.5', $actual->offsetGet(0));
        $this->assertEquals('2.5', $actual->offsetGet(1));
        $this->assertEquals('3.5', $actual->offsetGet(2));
    }

    public function testCreateBooleanArray()
    {
        $actual = $this->call('createBooleanArray');

        $this->assertEquals(3, $actual->count());
        $this->assertEquals('1', $actual->offsetGet(0));
        $this->assertEquals('0', $actual->offsetGet(1));
        $this->assertEquals('1', $actual->offsetGet(2));
    }

    public function testCreateCharArray()
    {
        $actual = $this->call('createCharArray');

        $this->assertEquals(3, $actual->count());
        $this->assertEquals('A', $actual->offsetGet(0));
        $this->assertEquals('B', $actual->offsetGet(1));
        $this->assertEquals('C', $actual->offsetGet(2));
    }

    public function testCreateByteArray()
    {
        $actual = $this->call('createByteArray');

        $this->assertEquals(3, $actual->count());
        $this->assertEquals('1', $actual->offsetGet(0));
        $this->assertEquals('2', $actual->offsetGet(1));
        $this->assertEquals('3', $actual->offsetGet(2));
    }
}
