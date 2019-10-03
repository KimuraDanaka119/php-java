<?php
namespace PHPJava\Kernel\Resolvers;

use PHPJava\Exceptions\ResolverException;
use PHPJava\Kernel\Maps\OpCode;
use PHPJava\Kernel\Types\_Byte;
use PHPJava\Kernel\Types\_Char;
use PHPJava\Kernel\Types\_Double;
use PHPJava\Kernel\Types\_Float;
use PHPJava\Kernel\Types\_Int;
use PHPJava\Kernel\Types\_Long;
use PHPJava\Kernel\Types\_Short;

class MnemonicResolver
{
    public static function resolveTypeByOpCode(int $opcode): string
    {
        switch ($opcode) {
            case OpCode::_iload:
            case OpCode::_iload_1:
            case OpCode::_iload_2:
            case OpCode::_iload_3:
                return _Int::class;
            case OpCode::_fload:
            case OpCode::_fload_1:
            case OpCode::_fload_2:
            case OpCode::_fload_3:
                return _Float::class;
            case OpCode::_dload:
            case OpCode::_dload_1:
            case OpCode::_dload_2:
            case OpCode::_dload_3:
                return _Double::class;
            case OpCode::_lload:
            case OpCode::_lload_1:
            case OpCode::_lload_2:
            case OpCode::_lload_3:
                return _Long::class;
        }

        throw new ResolverException(
            sprintf(
                'Unable to resolve type by opcode: 0x%X',
                $opcode
            )
        );
    }

    public static function resolveStoreByNumberAndType(int $number, string $classType): int
    {
        $prefix = static::getAmbiguousOperationCodePrefixByType($classType);
        $suffix = '';
        if (static::inDefaultLocalStorageNumber($number)) {
            $suffix = '_' . $number;
        }

        $operationName = $prefix . 'store' . $suffix;

        return (new OpCode())
            ->getValue(
                '_' . $operationName
            );
    }

    public static function resolveLoadByNumberAndType(int $number, string $classType): int
    {
        $prefix = static::getAmbiguousOperationCodePrefixByType($classType);
        $suffix = '';
        if (static::inDefaultLocalStorageNumber($number)) {
            $suffix = '_' . $number;
        }

        $operationName = $prefix . 'load' . $suffix;

        return (new OpCode())
            ->getValue(
                '_' . $operationName
            );
    }

    protected static function getAmbiguousOperationCodePrefixByType(string $classType): string
    {
        $prefix = 'a';
        switch ($classType) {
            case _Int::class:
            case _Short::class:
            case _Byte::class:
            case _Char::class:
                $prefix = 'i';
                break;
            case _Long::class:
                $prefix = 'l';
                break;
            case _Float::class:
                $prefix = 'f';
                break;
            case _Double::class:
                $prefix = 'd';
                break;
        }

        return $prefix;
    }

    public static function isLDCOperation(int $opcode)
    {
        return $opcode === OpCode::_ldc
            || $opcode === OpCode::_ldc_w
            || $opcode === OpCode::_ldc2_w;
    }

    public static function inDefaultLocalStorageNumber(int $localStorageNumber): bool
    {
        return $localStorageNumber <= 3;
    }
}
