# General PHP notes from books and courses

Notes that aren't directly related to course content about stuff that is surprising or new to me (or just as a reminder of things I rarely used)

## Stuff recently learned / newly discovered
### static variables in functions

Static variables can be defined in a function and the initial value is only is remembered / not initialized again on subsequent function calls.

    function doStuff() {
      static $cache = null;

      if ($cache === null) {
        $cache = '%heavy database stuff or something%';
      }

      // code using $cache
    }

[From Stackoverflow](https://stackoverflow.com/questions/6188994/static-keyword-inside-function)


### self vs static

- `self` indicates the class where it is written in the code (resolved at compile time)
- `static`indicates the class that is using it at runtime (meaning it can refer to subclasses)


    class A {
        public static function get_self() {
            return new self();
        }

        public static function get_static() {
            return new static();
        }
    }

    class B extends A {}

    echo get_class(B::get_self());  // A
    echo get_class(B::get_static()); // B
    echo get_class(A::get_self()); // A
    echo get_class(A::get_static()); // A

[From Stackoverflow](https://stackoverflow.com/questions/5197300/new-self-vs-new-static/5197655)

### Callable formats

Callable can either be a string indicating the function name, a variable an (anonymous) function is assigned to or an array indicating the class (in case of static functions) or object as the first entry and the function as a second.

Examples from [php.net](https://www.php.net/manual/en/language.types.callable.php):

    // Type 1: Simple callback
    call_user_func('my_callback_function');

    // Type 2: Static class method call
    call_user_func(array('MyClass', 'myCallbackMethod'));

    // Type 3: Object method call
    $obj = new MyClass();
    call_user_func(array($obj, 'myCallbackMethod'));

    // Type 4: Static class method call
    call_user_func('MyClass::myCallbackMethod');


### Shorthand for assigning instance variables in constructor (PHP8 only)

    class Product {
      public function __construct(public string $name, public float $price) {}
    }

is the same as

    class Product {
      public string $name;
      public float $price;

      public function __construct(string $name, float $price) {
        $this->name = $name;
        $this->price = $price;
      }
    }

Not sure if i like this.

### No objects as array keys

Use [https://www.php.net/manual/en/function.spl-object-hash.php](https://www.php.net/manual/en/function.spl-object-hash.php) instead.

Values of course can be objects.


### Most basic autoloader

    spl_autoload_register(function ($class_name) {
        include $class_name . '.php';
    });

### Clone objects with clone keyword

    function nextDay(\DateTime $date) {
      $interval = new DateInterval('P1D');
      $nextDay = clone $date;
      // Mutate the given date
      return $nextDay->add($interval);
    }

Aside: PHP provides als a DateTimeImmutable class:

    function nextDay(DateTimeImmutable $date) {
      $interval = new DateInterval('P1D');
      // DateTimeImmutable makes a new object.
      return $date->add($interval);
    }

Taken from: https://www.phparch.com/2021/05/fiendish-functions-filtering-fact-from-fiction/

### curly braces inside Strings

Old one but never really used it until i got used to the someqhat similar way you can do it in javascript when using backticks (
  
Javascript:

    console.log(`var is ${var}`);

PHP:

    echo "\$var is {$var}";

Useful for complex expressions such as method calls or without space between variable and surrounding text.






## Other notes

### Learning goals

#### Frameworks

- Laravel
- Codeigniter
- Laminas (= Zend)
- Dive deeper into Slim

