# PHPJava - JVM Emulator by PHP
[![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/dwyl/esta/issues)
![Compatibility](https://img.shields.io/badge/Compatibility-7.2%20and%20greater-green.svg) 
[![Build Status](https://travis-ci.org/memory-agape/php-java.png?branch=master)](https://travis-ci.org/memory-agape/php-java)
[![Total Downloads](https://poser.pugx.org/memory-agape/php-java/downloads)](https://packagist.org/packages/memory-agape/php-java)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)
<p align="center"><img src="./docs/img/phpjava.jpg" height="300"></p>

# What is the PHPJava?
The PHPJava is experimental library which emulate JVM (a.k.a. Java Virtual Machine) by PHP 🐘
The PHPJava proceed to read binary from pre-compiled Java file(s) ☕
This project reference to [Java Virtual Machine Specification](https://docs.oracle.com/javase/specs/jvms/se11/html/index.html) documentation when We makes.

We welcoming to contributions this project 💪

## Requirements
- PHP >= 7.2
- Composer
- ext-zip

## Not currently supported
Sorry, I do not have enough time (T_T) 

- Inner classes
- Annotations
- Extends other class
- Implements
- Outer classes
- Event
- Java Archive
- double/float calculation.
- Many built-in libraries (ex. java.lang.xxx, java.io.xxx and so on) 
- etc...

## Quick start
- 1) Install the PHPJava into your project.
```
$ composer require memory-agape/php-java
```

- 2) Write Java
```java
class HelloWorld 
{
    public static void main(String[] args)
    {
        System.out.println(args[0] + " " + args[1]);
    }
}
```

- 3) Compile Java
```
$ javac -UTF8 /path/to/HelloWorld.java
```

- 4) Call to main method as following.

```php
<?php
use PHPJava\Core\JavaClass;
use PHPJava\Core\JavaClassReader;

(new JavaClass(new JavaClassReader('/path/to/HelloWorld.class')))
    ->getInvoker()
    ->getStatic()
    ->getMethods()
    ->call(
        'main',
        ["Hello", 'World']
    );
```

- 5) Get a result
```
$ php /path/to/HelloWorld.php
Hello World
```

### Get/Set a static fields

- ex) Set or Get a static fields as follows.

```php
<?php
use PHPJava\Core\JavaClass;
use PHPJava\Core\JavaClassReader;

$staticAccessor = (new JavaClass(new JavaClassReader('/path/to/HelloWorld.class')))
    ->getInvoker()
    ->getStatic()
    ->getFields();

// Set
$staticAccessor->set('fieldName', 'value');

// Get
echo $staticAccessor->get('fieldName');
```

### Call to a static method

- ex) Call to static method as follows.

```php
<?php
use PHPJava\Core\JavaClass;
use PHPJava\Core\JavaClassReader;

(new JavaClass(new JavaClassReader('/path/to/HelloWorld.class')))
    ->getInvoker()
    ->getStatic()
    ->getMethods()
    ->call(
        'methodName',
        $firstArgument,
        $secondArgument,
        $thirdArgument,
        ...
    );

// Or if called method have return value then you can store to variable.
$result = (new JavaClass(new JavaClassReader('/path/to/HelloWorld.class')))
   ->getInvoker()
   ->getStatic()
   ->getMethods()
   ->call(
       'methodWithSomethingReturn',
       $firstArgument,
       $secondArgument,
       $thirdArgument,
       ...
   );

// The $result you want is output.
echo $result;
```


### Get/Set a dynamic fields
TBD

### Call to a dynamic method
TBD

### Output PHPJava operations
TBD

## PHP problems
TBD

## Run unit tests

```
./vendor/bin/phpunit tests
```

## Reference
- [Java Virtual Machine Specification](https://docs.oracle.com/javase/specs/jvms/se11/html/index.html)

## License
MIT