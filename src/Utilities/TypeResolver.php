<?php
namespace PHPJava\Utilities;

use PHPJava\Core\JavaClass;
use PHPJava\Exceptions\TypeException;
use PHPJava\Kernel\Types\Type;

class TypeResolver
{
    const PHP_TYPE_MAP = [
        'integer' => 'I',
        'float' => 'F',
        'double' => 'F',
        'string' => 'Ljava.lang.String',
    ];

    const AMBIGUOUS_TYPES_ON_PHP = [
        'long'   => 'int',
        'double' => 'float',
        'char'   => 'java.lang.String',
        'byte'   => 'int',
        'short'  => 'int',
    ];

    const SIGNATURE_MAP = [
        'B' => 'byte',
        'C' => 'char',
        'D' => 'double',
        'F' => 'float',
        'I' => 'int',
        'J' => 'long',
        'S' => 'short',
        'V' => 'void',
        'Z' => 'boolean',
        'L' => 'class',
    ];

    /**
     * @param $signature
     * @return string
     * @throws TypeException
     */
    public static function getMappedSignatureType($signature): string
    {
        if (isset(static::SIGNATURE_MAP[$signature])) {
            return static::SIGNATURE_MAP[$signature];
        }
        throw new TypeException('Passed undefined signature ' . $signature);
    }

    public static function resolve($type): string
    {
        $flipped = array_flip(static::SIGNATURE_MAP);
        if (isset($flipped[$type])) {
            return $flipped[$type];
        }
        return 'L' . $type;
    }

    public static function convertJavaTypeSimplyForPHP($type): string
    {
        return static::AMBIGUOUS_TYPES_ON_PHP[$type] ?? $type;
    }

    public static function convertPHPtoJava($arguments, $defaultJavaArgumentType = 'java.lang.String'): array
    {
        $phpType = gettype($arguments);
        $deepArray = 0;
        if ($phpType === 'array') {
            $deepArray++;
            $getNestedValues = [];
            foreach ($arguments as $argument) {
                $getNestedValues[] = static::convertPHPtoJava($argument);
            }
            if (empty($getNestedValues)) {
                $flipped = array_flip(static::PHP_TYPE_MAP);
                $resolveType = static::SIGNATURE_MAP[static::resolve($defaultJavaArgumentType)[0]];
                if ($resolveType === 'class') {
                    return [
                        'type' => $resolveType,
                        'class_name' => $defaultJavaArgumentType,
                        'deep_array' => $deepArray,
                    ];
                }
                return [
                    'type' => $resolveType,
                    'deep_array' => $deepArray,
                ];
            }
            $firstParameter = $getNestedValues[0];

            // TODO: Validate Parameters
            $firstParameter['deep_array'] += $deepArray;
            return $firstParameter;
        }
        if ($phpType === 'object') {
            if ($arguments instanceof JavaClass) {
                return [
                    'type' => 'class',
                    'class_name' => $arguments->getClassName(false),
                    'deep_array' => $deepArray,
                ];
            }
            if ($arguments instanceof Type) {
                return [
                    'type' => $arguments->getTypeNameInJava(),
                    'deep_array' => $deepArray,
                ];
            }
            throw new TypeException(get_class($arguments) . ' does not supported to convert to Java\'s argument.');
        }
        $resolveType = static::SIGNATURE_MAP[static::PHP_TYPE_MAP[$phpType][0]] ?? null;
        if ($resolveType === 'class') {
            return [
                'type' => $resolveType,
                'class_name' => substr(static::PHP_TYPE_MAP[$phpType], 1),
                'deep_array' => $deepArray,
            ];
        }
        return [
            'type' => $resolveType,
            'deep_array' => $deepArray,
        ];
    }
}
