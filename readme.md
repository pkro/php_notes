# General PHP notes from books and courses

Notes that aren't directly related to course content about stuff that is surprising or new to me (or just as a reminder of things I rarely used)

## static variables in functions

Static variables can be defined in a function and the initial value is only is remembered / not initialized again on subsequent function calls.

    function doStuff() {
      static $cache = null;

      if ($cache === null) {
        $cache = '%heavy database stuff or something%';
      }

      // code using $cache
    }

[From Stackoverflow](https://stackoverflow.com/questions/6188994/static-keyword-inside-function)


## self vs static

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

## Callable formats

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