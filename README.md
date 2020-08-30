# PHP Enum

![Tests](https://github.com/ekvedaras/php-enum/workflows/run-tests/badge.svg)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/ekvedaras/php-enum.svg?style=flat)](https://packagist.org/packages/ekvedaras/php-enum)
[![Total Downloads](https://img.shields.io/packagist/dt/ekvedaras/php-enum.svg?style=flat)](https://packagist.org/packages/ekvedaras/php-enum)

![Twitter Follow](https://img.shields.io/twitter/follow/ekvedaras?style=plastic)

Big thanks [happy-types/enumerable-type](https://packagist.org/packages/happy-types/enumerable-type) for the original idea. Take a look if it suits your needs better.

This package adds `meta` field, provides a few more methods like `options`, `keys`, `json`, etc. 
and there are `array` and illuminate `collection` implementations to choose from. 

## Benefits

* Enums in general allow to avoid [magic values](https://en.wikipedia.org/wiki/Magic_number_(programming)#Unnamed_numerical_constants)
* By type hinting forces only allowed values to be passed to methods (or returned)
* Easy way to list all possible values
* More feature rich and flexible then other enum implementations
* Works with strict (`===`) operator
* IDE friendly, so auto complete, usage analysis and refactorings all work

## Defining enums

Create enums by extending either `EKvedaras\PHPEnum\PHPArray\Enum` or `EKvedaras\PHPEnum\Illuminate\Collection\Enum`.

```php
<?php

use EKvedaras\PHPEnum\PHPArray\Enum;

class PaymentStatus extends Enum 
{
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

Integers can be used as IDs instead of string values if you prefer.

## Usage

### Retrieving and comparing enum values

```php
// Retrieving value statically
$status1 = PaymentStatus::completed();

// Retrieving value dynamically from ID
$status2 = PaymentStatus::from('completed');

// Strict comparison is supported
var_dump($status1 === $status2); // true
```

### Accessing value properties

```php
$status = PaymentStatus::copmleted();

$status->id();   // 'completed'
$status->name(); // 'Payment has been processed'
$status->meta(); // null
```

### Listing enum values

There are two implementations provided:

#### PHP array

To use PHP array your enums should extend `EKvedaras\PHPEnum\PHPArray\Enum` class

```php
var_dump(PaymentStatus::enum());
/*
array(3) {
  'pending' =>
  class PaymentStatus#12 (3) {
    protected $id =>
    string(7) "pending"
    protected $name =>
    string(18) "Payment is pending"
    protected $meta =>
    NULL
  }
  'completed' =>
  class PaymentStatus#363 (3) {
    protected $id =>
    string(9) "completed"
    protected $name =>
    string(26) "Payment has been processed"
    protected $meta =>
    NULL
  }
  'failed' =>
  class PaymentStatus#13 (3) {
    protected $id =>
    string(6) "failed"
    protected $name =>
    string(18) "Payment has failed"
    protected $meta =>
    NULL
  }
}
 */
```

```php
var_dump(PaymentStatus::options());
/*
array(3) {
  'pending' =>
  string(18) "Payment is pending"
  'completed' =>
  string(26) "Payment has been processed"
  'failed' =>
  string(18) "Payment has failed"
}
*/
```

```php
var_dump(PaymentStatus::keys());
/*
array(3) {
  [0] =>
  string(7) "pending"
  [1] =>
  string(9) "completed"
  [2] =>
  string(6) "failed"
}
*/
```

```php
var_dump(PaymentStatus::json()); // Will include meta if defined
```
```json
{
    "pending": {
        "id": "pending",
        "name": "Payment is pending"
    },
    "completed": {
        "id": "completed",
        "name": "Payment has been processed"
    },
    "failed": {
        "id": "failed",
        "name": "Payment has failed"
    }
}
```

```php
var_dump(PaymentStatus::jsonOptions());
```
```json
{
    "pending": "Payment is pending",
    "completed": "Payment has been processed",
    "failed": "Payment has failed"
}
```

#### Illuminate Collection

**Either `illuminate/support` or `illuminate/collections` package is required which is not installed by default.**

To use Illuminate Collection your enums should extend `EKvedaras\PHPEnum\Illuminate\Collection\Enum` class.

The only difference is `enum`, `options` and `keys` methods will return `Collection` instances instead of arrays.
The rest works exactly the same.

```php
var_dump(PaymentStatus::enum());
/*
class Illuminate\Support\Collection#362 (1) {
  protected $items =>
  array(3) {
    'pending' =>
    class PaymentStatus#12 (3) {
      protected $id =>
      string(7) "pending"
      protected $name =>
      string(18) "Payment is pending"
      protected $meta =>
      NULL
    }
    'completed' =>
    class PaymentStatus#363 (3) {
      protected $id =>
      string(9) "completed"
      protected $name =>
      string(26) "Payment has been processed"
      protected $meta =>
      NULL
    }
    'failed' =>
    class PaymentStatus#13 (3) {
      protected $id =>
      string(6) "failed"
      protected $name =>
      string(18) "Payment has failed"
      protected $meta =>
      NULL
    }
  }
}
 */
```

```php
var_dump(PaymentStatus::options());
/*
class Illuminate\Support\Collection#368 (1) {
  protected $items =>
  array(3) {
    'pending' =>
    string(18) "Payment is pending"
    'completed' =>
    string(26) "Payment has been processed"
    'failed' =>
    string(18) "Payment has failed"
  }
}
*/
```

```php
var_dump(PaymentStatus::keys());
/*
class Illuminate\Support\Collection#13 (1) {
  protected $items =>
  array(3) {
    [0] =>
    string(7) "pending"
    [1] =>
    string(9) "completed"
    [2] =>
    string(6) "failed"
  }
}
*/
```

### Meta

Meta field is intentionally left as mixed type as it could be used for various reasons.
For example linking enum options with a specific implementation:

```php
<?php

use EKvedaras\PHPEnum\PHPArray\Enum;

class PaymentMethod extends Enum
{
    final public static function payPal(): self
    {
        return static::get('paypal', 'PayPal', PayPalHandler::class);
    }
    
    final public static function stripe(): self
    {
        return static::get('stripe', 'Stripe', StripeHandler::class);
    }
}
```

Resolving payment handler in Laravel:

```php
$method = PaymentMethod::from($request['method_id']);

$handler = app($method->meta());
```

Meta could also be used as a more in detail description of each option that could be displayed to users
or some other object linking other classes, resources together.

Furthermore, in some cases it is useful to resolve enum option from meta. That is also possible:
```php
$method = PaymentMethod::from(StripeHandler::class);
```

## Things to know

### `final public static function`

Only methods marked as `final public static` will be considered as possible values of enum. Other methods are still there, but
they will not be returned in `enum` / `keys` / `options`, etc. results and won't be considered as valid values. However, this allows
to extend enums and make them more useful. For example:

```php
<?php

use EKvedaras\PHPEnum\Illuminate\Collection\Enum;
use Illuminate\Support\Collection;

class PaymentMethods extends Enum
{
    /**
     * @return static
     */
    final public static function payPal(): self
    {
        return static::get('paypal', 'PayPal');
    }
    
    /**
     * @return static
     */
    final public static function stripe(): self
    {
        return static::get('stripe', 'Stripe');
    }
    
    /**
     * @return static
     */
    final public static function mollie(): self
    {
        return static::get('mollie', 'Mollie');
    }
    
    /**
     * Returns only enabled payment methods. Useful for validation or rendering payments UI
     * @return Collection|static[]
     */
    public static function enabled(): Collection
    {
        return static::enum()->only(config('payments.enabled'));
    }
}
```

### `from($id)` only allows valid IDs

Well, this is expected. Calling `PaymentMethod::from('ideal')` will throw `OutOfBoundsException`. 

### No serialization

Enum object instances cannot be serialized. Deserialized objects would get a different address in memory therefore, `===` would no longer work.
Calling `serialize(PaymentMethod::stripe())` will throw a `RuntimeException`.

As a workaround it is better to store the ID instead of object itself. You still get the bonus of setters only accepting valid values.

```php
<?php

class Payment 
{
    /** @var string */
    private $method;

    public function setMethod(PaymentMethod $method)
    {
        $this->method = $method->id();
    }
    
    public function getMethod(): PaymentMethod
    {
        return PaymentMethod::from($this->method);
    }
}
```

## Coming soon

* Laravel package to integrate this with automated casting in model values
* More implementations of collections in other frameworks

## Changelog

See changes in changelog files:

* [v1 changelog](CHANGELOG-1.x.md)
