<?php

class JavaMethodInvoker extends JavaInvoker {

    public function __call ($methodName, $arguments) {

        $cpInfo = $this->getClass()->getCpInfo();

        foreach ($this->getClass()->getMethods() as $methodInfo) {

            $cpMethodName = $cpInfo[$methodInfo->getNameIndex()]->getString();

            if ($methodName === $cpMethodName) {

                $accessFlag = new JavaMethodAccessFlagEnum();
                $accessibility = array();

                foreach ($accessFlag->getValues() as $value) {

                    if (($methodInfo->getAccessFlag() & $value) != 0) {

                        $accessibility[] = strtolower(preg_replace('/^CONSTANT_/', '', $accessFlag->getName($value)));

                    }

                }

                $javaArguments = JavaClass::parseSignature($cpInfo[$methodInfo->getDescriptorIndex()]->getString());

                if (sizeof($arguments) !== $javaArguments['argumentsCount']) {

                    // 引数の配列の大きさが違う
                    continue;

                } else {

                    foreach ($arguments as $argument) {

                        // 型比較


                    }

                }

                $this->getClass()->appendMethodTrace($methodName, $accessibility, $javaArguments);

                foreach ($methodInfo->getAttributes() as $attribute) {

                    $attributeData = $attribute->getAttributeData();

                    if ($attributeData instanceof \JavaCodeAttribute) {

                        // runnable code
                        $opCodes = $attributeData->getOpCodes();

                        $handle = fopen('php://memory', 'rw');
                        fwrite($handle, $attributeData->getCode());
                        rewind($handle);

                        $byteCodeStream = new JavaByteCodeStream($handle);

                        // 局所変数格納用
                        $localstorage = array(
                            0 => $this->getClass(),
                            1 => null,
                            2 => null,
                            3 => null
                        );

                        $i = 0;
                        foreach ($arguments as $argument) {

                            $localstorage[$i] = $argument;
                            $i++;

                        }

                        $stacks = array();

                        // code
                        // var_dump(implode(' ', str_split(bin2hex($attributeData->getCode()), 2)));

                        $mnemonic = new JavaMnemonicEnum();

                        for (; $byteCodeStream->getOffset() < $attributeData->getOpCodeLength(); ) {

                            $opcode = $byteCodeStream->readUnsignedByte();

                            $pointer = $byteCodeStream->getOffset() - 1;

                            $name = 'JavaStatement_' . preg_replace('/^MNEMONIC_/', '', $mnemonic->getName($opcode));

                            require_once dirname(__DIR__) . '/Statements/' . $name . '.php';

                            $statement = new $name($methodName, $this, $byteCodeStream, $stacks, $localstorage, $cpInfo, $attributeData, $pointer);
                            $returnValue = $statement->execute();

                            // write trace
                            $this->getClass()->appendTrace($opcode, $pointer, $stacks, $byteCodeStream->getOperands());

                            if ($returnValue !== null) {

                                $this->getClass()->traceCompletion();
                                return $returnValue;

                            }

                        }

                        $this->getClass()->traceCompletion();

                        return;

                    }

                }

            }


        }

        throw new JavaInvokerException('Unknown Error');

    }

    public function valueOf ($value) {

        return (int) $value;

    }

}