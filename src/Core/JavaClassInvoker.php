<?php
namespace PHPJava\Core;

use PHPJava\Core\JVM\DynamicAccessor;
use PHPJava\Core\JVM\Intern\StringIntern;
use PHPJava\Core\JVM\StaticAccessor;
use PHPJava\Exceptions\IllegalJavaClassException;
use PHPJava\Kernel\Maps\FieldAccessFlag;
use PHPJava\Kernel\Provider\InternProvider;
use PHPJava\Kernel\Provider\ProviderInterface;
use PHPJava\Kernel\Structures\_FieldInfo;
use PHPJava\Kernel\Structures\_MethodInfo;

class JavaClassInvoker
{
    /**
     * @var JavaClass
     */
    private $javaClass;

    private $hiddenMethods = [];
    private $dynamicMethods = [];
    private $staticMethods = [];

    private $hiddenFields = [];
    private $dynamicFields = [];
    private $staticFields = [];

    private $debugTraces;

    /**
     * @var DynamicAccessor
     */
    private $dynamicAccessor;

    /**
     * @var StaticAccessor
     */
    private $staticAccessor;

    private $specialInvoked = [];

    private $options = [];

    private $providers = [];

    /**
     * JavaClassInvoker constructor.
     */
    public function __construct(
        JavaClass $javaClass,
        array $options
    ) {
        $this->javaClass = $javaClass;

        $this->options = $options;
        $cpInfo = $javaClass->getConstantPool();

        foreach ($javaClass->getDefinedMethods() as $methodInfo) {
            /**
             * @var _MethodInfo $methodInfo
             */
            $methodName = $cpInfo[$methodInfo->getNameIndex()]->getString();

            if (($methodInfo->getAccessFlag() & FieldAccessFlag::ACC_STATIC) !== 0) {
                $this->staticMethods[$methodName][] = $methodInfo;
            } elseif ($methodInfo->getAccessFlag() === 0 || ($methodInfo->getAccessFlag() & FieldAccessFlag::ACC_PUBLIC) !== 0) {
                $this->dynamicMethods[$methodName][] = $methodInfo;
            }
        }

        foreach ($javaClass->getDefinedFields() as $fieldInfo) {
            /**
             * @var _FieldInfo $fieldInfo
             */
            $fieldName = $cpInfo[$fieldInfo->getNameIndex()]->getString();

            if ($fieldInfo->getAccessFlag() === 0) {
                $this->dynamicFields[$fieldName] = $fieldInfo;
            } elseif (($fieldInfo->getAccessFlag() & FieldAccessFlag::ACC_STATIC) !== 0) {
                $this->staticFields[$fieldName] = $fieldInfo;
            }
        }

        // Intern provider registration.
        $this->providers = [
            'InternProvider' => (new InternProvider())
                ->add(
                    StringIntern::class,
                    new StringIntern()
                ),
        ];

        $this->dynamicAccessor = new DynamicAccessor(
            $this,
            $this->dynamicMethods,
            $this->options
        );

        $this->staticAccessor = new StaticAccessor(
            $this,
            $this->staticMethods,
            $this->options
        );
    }

    /**
     * @param array $arguments
     * @return JavaClassInvoker
     */
    public function construct(...$arguments): self
    {
        $this->dynamicAccessor = new DynamicAccessor(
            $this,
            $this->dynamicMethods,
            $this->options
        );

        if (isset($this->dynamicMethods['<init>'])) {
            $this->getDynamic()->getMethods()->call('<init>', ...$arguments);
        }

        return $this;
    }

    public function getJavaClass(): JavaClass
    {
        return $this->javaClass;
    }

    public function getDynamic(): DynamicAccessor
    {
        return $this->dynamicAccessor;
    }

    public function getStatic(): StaticAccessor
    {
        return $this->staticAccessor;
    }

    public function isInvoked(string $name, string $signature): bool
    {
        return in_array($signature, $this->specialInvoked[$name] ?? [], true);
    }

    /**
     * @return JavaClassInvoker
     */
    public function addToSpecialInvokedList(string $name, string $signature): self
    {
        $this->specialInvoked[$name][] = $signature;
        return $this;
    }

    /**
     * @param $providerName
     * @throws IllegalJavaClassException
     */
    public function getProvider($providerName): ProviderInterface
    {
        if (!isset($this->providers[$providerName])) {
            throw new IllegalJavaClassException($providerName . ' not provided.');
        }

        return $this->providers[$providerName];
    }
}
