# PHP Enum

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/ekvedaras/php-enum.svg?style=flat)](https://packagist.org/packages/ekvedaras/php-enum)
[![Total Downloads](https://img.shields.io/packagist/dt/ekvedaras/php-enum.svg?style=flat)](https://packagist.org/packages/ekvedaras/php-enum)
![Tests](https://github.com/ekvedaras/php-enum/workflows/run-tests/badge.svg)

Original idea taken from [happy-types/enumerable-type](https://packagist.org/packages/happy-types/enumerable-type), so take a look, it may suit your needs better.
This package adds `meta` field, provides a few more methods like `options`, `keys`, `json`, etc. 
and there are `array` and illuminate `collection` implementations to choose from. 

## Benefits

* Enums in general allow to avoid [magic values](https://en.wikipedia.org/wiki/Magic_number_(programming)#Unnamed_numerical_constants)
* By type hinting forces only allowed values to be passed to methods (or returned)
* Easy way to list all possible values
* More feature rich and flexible then other enum implementations
* IDE friendly, so auto complete, usage analysis and refactorings all work

## Usage

Create enums by extending either `EKvedaras\PHPEnum\PHPArray\Enum` or `EKvedaras\PHPEnum\Illuminate\Collection\Enum`.

```php
<?php

use EKvedaras\PHPEnum\PHPArray\Enum;

class PaymentStatus extends Enum {
    /**
     * @return static
     */
    final public static function pending(): self
    {
        return static::get('pending', 'Payment is pending');
    }

    /**
     * @return static
     */
    final public static function completed(): self
    {
        return static::get('completed', 'Payment has been processed');
    }
    
    /**
     * @return static
     */
    final public static function failed(): self
    {
        return static::get('failed', 'Payment has failed');
    }
}
```
