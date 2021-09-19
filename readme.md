PHP notes from courses and web finds.

<!-- START doctoc -->
<!-- END doctoc -->

# PHP language related and other tips

## static variables in functions

Static variables can be defined in a function and the initial value is only is remembered / not initialized again on
subsequent function calls.

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

  class A { public static function get_self() { return new self(); }

        public static function get_static() {
            return new static();
        }
  }

  class B extends A {}

  echo get_class(B::get_self()); // A echo get_class(B::get_static()); // B echo get_class(A::get_self()); // A echo
  get_class(A::get_static()); // A

[From Stackoverflow](https://stackoverflow.com/questions/5197300/new-self-vs-new-static/5197655)

## Callable formats

Callable can either be a string indicating the function name, a variable an (anonymous) function is assigned to or an
array indicating the class (in case of static functions) or object as the first entry and the function as a second.

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

## Shorthand for assigning instance variables in constructor (PHP8 only)

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

Not sure if I like this.

## No objects as array keys

Use [https://www.php.net/manual/en/function.spl-object-hash.php](https://www.php.net/manual/en/function.spl-object-hash.php)
instead.

Values of course can be objects.

## Arrays are assigned by value

As this works differently than in most other languages where lists / arrays are just objects like any other, it needs to
be repeated that in php arrays are assigned by value by default and must be explicitely assigned with `&` if passing by
reference is desired:

    $a = [1,2,3];
    $b = $a;
    $a[] = 4; // $a = [1,2,3,4]
    print_r($b); // [1,2,3];
    $b = &$a; // $b = [1,2,3,4];
    $a[0] = 99;
    print_r($b); // [99,2,3,4];
    $a = [5,6,7];
    // surprising as you would expect [5,6,7] to have a new reference:
    print_r($b); // [5,6,7];

## modify array in foreach loop

Items in an array can be modified directly in a foreach loop can be modified when using `&`:

    foreach ($prices2 as &$price) {
        $price = addTax($price, 10);
    }

## array_map with multiple arguments

Additional arguments can be passed to the callback function using an array of values as the third parameter:

    $prices = array_map('addTax', $prices, [20]);

If (and only if) the function takes multiple arguments, **the array keys of an associative array aren't preserved**.

## Most basic autoloader

    spl_autoload_register(function ($class_name) {
        include $class_name . '.php';
    });

## Clone objects with clone keyword

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

## curly braces inside Strings

Old one but never really used it until i got used to the someqhat similar way you can do it in javascript when using
backticks (

Javascript:

    console.log(`var is ${var}`);

PHP:

    echo "\$var is {$var}";

Useful for complex expressions such as method calls or without space between variable and surrounding text.

## Array dereferencing (=destructuring / unpacking)

Arrays can be dereferenced (=destructured) like in JS.

    $info = getimagesize('files/hoover.jpg');
    
    /* $info:
    array(7) {
      [0]=>
      int(500)
      [1]=>
      int(332)
      [2]=>
      int(2)
      [3]=>
      string(24) "width="500" height="332""
      ["bits"]=>
      int(8)
      ["channels"]=>
      int(3)
      ["mime"]=>
      string(10) "image/jpeg"
    }
     */
    
    // Dereferencung directly from function (nothing special about this):
    $bits = getimagesize('files/hoover.jpg')["bits"];
    
    [$w, $h] = $info; // $w = 500, $h = 332
    
    // using list:
    list($w, $h) = $info;
    
    // using non-numerical keys
    [3 => $imgTagSizes, "mime" => $mimeType] = $info;
    echo($imgTagSizes); // width="500" height="332"
    echo($mimeType); // image/jpeg
    
    // another example with foreach
    $p = [
    ['item'=>'a', 'price'=>'1.99'],
    ['item'=>'b', 'price'=>'2.99'],
    ['item'=>'c', 'price'=>'3.99']
    ];
    
    foreach($p as ['item'=>$item, 'price'=>$price]) {
        echo "{$item}: {$price}<br>";
    }
    
    // skipping elements:
    [$w, , , $imgTagSizes] = $info;

This can also be used to swap array elements in place without a temp var:

    [$ar[2], $ar[0]] = [$ar[0], $ar[2]];

## Splat operator / unpacking arrays and traversable objects

Like in JS, `...` can be used to either receive a variable function of arguments in variadic functions:

    function add(...$nums) {
        return array_sum($sum);
    }
    echo add(1, 2, 3, 4); // 10

Or passing arguments to a function using an array:

    function sum($a, $b, $c) {
        return $a + $b + $c;
    }
    
    $values = [1, 2, 3];
    echo sum(...$values);

Both can be used as the last argument in addition to named arguments too:

    function sum($a, $b, ...$moreValues)
    sum($a, ...[1, 2]);

To pass an array by reference, use & as usual:

    function sum($a, $b, &...$moreValues)

Contrary to JS, this does NOT work:

    //Fatal error: Spread operator is not supported in assignments
    [$a, $b, ...$rest] = [1, 2, 3, 4, 5];

PHP has the splat operator since 5.6

Variadic functions were possible before 5.6:

    function test($vals) {
        print_r(func_get_args()); // ( [0] => 1 [1] => 2 [2] => 3 )
        echo func_num_args(); // 3
    }
    
    test(1,2,3);

## Variable functions

To use functions in variables, they must be assigned as strings (unlike python / javascript):

    $imageOutput['image/gif'] = "imagecreatefromgif";
    $imageOutput['image/jpeg'] = "imagecreatefromjpeg";
    $imageOutput['image/png'] = "imagecreatefrompng";

    $images[] = $imageOutput[$mime]($image->getRealPath());

    // another example
    foreach (new FilesystemIterator('files') as $image) {
        if ($image->isFile() && in_array(strtolower($image->getExtension()), ['png', 'jpg', 'gif'])) {
            ["mime" => $mime] = getimagesize($image->getRealPath());
            $imgFunc = "imagecreatefrom" . substr($mime, strpos($mime, '/') + 1);
            $images[] = $imgFunc($image->getRealPath());
        }
    }

## Reminder: arrays are not like other objects

Arrays are always passed as values (unless `&` is used in the method / function declaration)

## var_export vs var_dump

var_dump shows a readable representation of a variable, array or object; var_export does the same but the output is
valid parsable PHP.

## Iterate over the last X lines of a SplFileObject

    $error_log_path = '/opt/lampp/logs/php_error_log';
    
    $log = new SplFileObject($error_log_path); // hack - go way beyond actual file length and php will correct it to the
    actual last line $log->seek(PHP_INT_MAX); $lastLine = $log->key();
    
    $lines = new LimitIterator($log, $lastLine - 100, $lastLine);
    foreach ($lines as $line) {
      echo $line;
    }

[From stackoverflow, Wallace Maxters/OnoSendai](https://stackoverflow.com/questions/2961618/how-to-read-only-5-last-line-of-the-text-file-in-php)

## str_replace accepts also arrays for all of its arguments

Replace multiple strings in one source string:

    $inlineSvg = str_replace(['%09', '%20', '%3D', '%3A', '%2F', '%22', '%0A', '%0D'],
                [' ', ' ', '=', ':', '/', "'"],
                $inlineSvg);

Replace an occurence in multiple source strings

    $s1 = "hello";
    $s2 = "there";
    
    [$news1, $news2] = str_replace("e", "3", [$s1, $s2,]); // $news1 = "h3llo", $news2 = "th3r3"

Replace mutliple strings with one replacement string:

    echo str_replace([' ', ',', '.', ';', '!', '?'], "_", "this sentence; is NOT! a good filename.");
    // this_sentence__is_NOT__a_good_filename_

## Regex capture groups with preg_replace

`preg_replace` can use arrays just like str_replace (see above).

Use `$1`, `$2` etc. in replace function to insert capture groups:

    function smartQuotes($text) {
        $pattern2replacement = [
          // \1 = repeat first capturing group: "
          '/(")([^"]+?)\1/'       => "\u{201C}$2\u{201D}", // double quotes
  
          // (?<!\w) = negative look behind (doesn't start with a word)
          // ' = '
          // (?=\w) = positive lookahead (must continue with a word)
          "/(?<!\w)'(?=\w)/"      => "\u{2018}", // left single quote
          "/(?<=\w)'(?=\w)/"      => "\u{2019}", // apostrophe
          // positive look behind and negative lookahead
          "/(?<=[\w,.!?])'(?!\w)/" => "\u{2019}" // right single quote
        ];
    
        return preg_replace(array_keys($pattern2replacement), array_values($pattern2replacement), $text);
    }

## type hinting in foreach loops

    /** @var SplFileInfo $svg */
    foreach ($svgs as $svg) {
        echo $svg->getFilename() . '</br>'; // code completion works now
    }

## authentication / pw hashing

- use 255 characters for hashed password
- use PASSWORD_DEFAULT in [password_hash](https://www.php.net/manual/en/function.password-hash.php) to always use the
  current most secure algorithm
- `password_hash` can't be used to check the password against the stored encrypted pw as php now uses a randomly
  generated salt; use [password_verify](https://www.php.net/manual/en/function.password-verify.php) instead.
- see password_hashing for example implementation

## preventing xss attacks

Always check if the current form address page is the intended address to avoid cross site scripting:

        if($_SERVER['PHP_SELF'] !== '/phptips/form.php') {
            // redirect or other
        }

Never trust $_SERVER variables like $_SERVER['PHP_SELF'].

Works with POST and GET ans PHP_SELF doesn't return query parameters.

## redirecting

Always use a fully qualified URL for redirects:

        header('Location: http://localhost/index.php')

instead of

        header('Location: /index.php'); // will not work

## DateTime magic

Relative datetime format syntax (such as "second monday of october") in
detail [here](https://www.php.net/manual/en/datetime.formats.relative).

    $now = new DateTime();
    $expire = new DateTime('+ 3 months');
    echo $expire->format('d.m.Y'); // 05.11.2021 (when done in august 5th 2021)
    $formatForDB = $expire->format('Y-m-d H:i:s'); // 2021-11-05 08:47:47
    
    $expire = new DateTime('last day of this month + 12 months');
    echo $expire->format('Y-m-d'); // 2022-08-31 (when done on any day in august 2021)
    
    $thanksgiving_ca = new DateTime('second Monday of October 2022');
    echo $thanksgiving_ca->format('Y-m-d'); // 2022-10-10

## Email header injection attacks

The 4th parameter of PHP's `mail` function allows additional headers to be set; when adding these from user / form
input, e.g. `mail('me@example.com', 'Form feedback', $message, "Reply-to: $email");`,
use `$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);`

`filter_input` returns false on invalid input, so check if it's false before doing anything with it.

Also note not to use the `From:` field to avoid the mail bouncing, see `email_header_injection.php`.

## Backticks

[Backticks in PHP are identical to using shell_exec!](https://www.php.net/manual/en/language.operators.execution.php)

## Disable dangerous PHP functions

Functions can be disabled in php.ini using `disable_functions` with a comma separated list of function names, e.g.

    disable_functions =exec,passthru,shell_exec,system,proc_open,popen,curl_exec,curl_multi_exec,parse_ini_file,show_source

Related recommended security setting:

    allow_url_fopen=Off
    allow_url_include=Off

## Variable variables

They exist and this is all one should know about it. Don't use them. It's not 2001 and form elements are not registered
anymore as global variables.

## DateTime from unix timestamp

To create a DateTime object from a unix timestamp, the timestamp must be preceded by an **@**:

    $now = new DateTime();
    $files = new CallbackFilterIterator($files, function (SplFileInfo $file) use ($now) {
        $modified = new DateTime('@' . $file->getMTime());
        return $modified->diff($now)->days > 180;
    });

## Sort arrays on multiple criteria (PHP5+) and spaceship operator (php7+)

The spaceship `<=>` return

-1 if the left side is smaller than the right 0 if equel 1 if right is smaller than the left

    // -1   0   1  
    //  <   =   >
    usort($members, function ($a, $b) {
        return $a['last_name'] <=> $b['last_name'];
    });
    
    // same as (PHP < 7):
    usort($members, function ($a, $b) {
        if($a['last_name'] == $b['last_name']) {
            return 0;
        }
        return $a['last_name'] < $b['last_name'] ? -1 : 1;
    });

**It is possible to compare arrays with diminishing priority**:

    // including first name as second priority:
    usort($members, function ($a, $b) {
        return [$a['last_name'], $a['first_name']] <=> [$b['last_name'], $b['first_name']];
    });

This also works in PHP < 7 with normal comparison functions:

    usort($members, function ($a, $b) {
        if([$a['last_name'], $a['first_name']] == [$b['last_name'], $b['first_name']]) {
            return 0;
        }
        return [$a['last_name'], $a['first_name']] < [$b['last_name'], $b['first_name']] ? -1 : 1;
    });

## Generators

As Python and JS, PHP has generators now (since 5.5).

Generators are iterators and can be used for co-routines and asynchronous PHP.

Assigning the generator to a variable gives access to the generators methods.

`yield from` can pass execution to another generator.

In PHP5, `return` can't be used with a value in a generator.

To check if the iterator has been closed, use `valid()`. To get the next available value and move to the one following,
use 'current()'.

    function counter($num): Generator  {
      $i=1;
      $total = 0;
      while ($i <= $num) {
          $total += $i;
          yield $i++;
      }
      yield from theEnd();
  
      return $total; // final value
    }
    
    function theEnd(): Generator
    {
        yield 'this';
        yield 'is';
        yield 'the';
        yield 'end';
    }
    
    foreach (counter(3) as $value) {
        echo '<br>', $value;
    }
    // 123
    
    $count = counter(5);
    
    foreach ($count as $value) {
        echo '<br>', $value;
    }
    echo '<br>', $count->getReturn(); // 15
    /*
    1
    2
    3
    this
    is
    the
    end
    1
    2
    3
    4
    5
    this
    is
    the
    end
    15
    */

## Web scraping

PHP has an in-built dom library:

    // PHP uses xml internally and html is mostly not strictly xml compliant
    libxml_use_internal_errors(true);
    
    $doc = new DOMDocument();
    if( ! $doc->loadHTMLFile('attractions.html')) {
        // or
        // $doc->loadHTMLFile('http://localhost' . dirname($_SERVER['PHP_SELF']) . '/attractions.html');
        echo "couldn't load file";
    } else {
        $links = $doc->getElementsByTagName('a');
        /**
         * @ @var $link DOMElement
         */
        foreach ($links as $link) {
            $href = $link->getAttribute('href');
            $linkText = $link->textContent;
            echo "{$href} text: $linkText<br>";
        }
    }

Further request and parsing libraries to check:

[Goutte with "browser simulation" methods such as "click"](https://github.com/FriendsOfPHP/Goutte)

[Requests](https://requests.ryanmccue.info/)

[Guzzle](https://docs.guzzlephp.org/en/latest/)

[simplehtmldom](https://simplehtmldom.sourceforge.io/)

[hQuery](https://github.com/duzun/hQuery.php)

[ReactPHP](https://sergeyzhuk.me/reactphp-series)

Good post:
https://www.scrapingbee.com/blog/web-scraping-php/

## sscanf to extract parts of a string without regex

`sscanf` can be used in the opposite way of `sprintf` (or printf) to extract parts of a string:

    $colorString = 'rgb(23, 129, 162)'; // spaces are ignored
    $var = sscanf($colorString, 'rgb(%3d,%3d,%3d)', $r, $g, $b);
    // $a = 23, $b = 129, $c = 162
    $hex = sprintf("#%2x%2x%2x", $r, $g, $b); // x automatically converts to hexadecimal
    echo $hex; // #1781a2

## Randomization

PHP7+:

Don't use mt_rand anymore; use `random_int` (or `random_bytes`)instead (greater value range and cryptographically safe).
Shuffle isn't cryptographically safe either (and was shit from the get go as it created biases in randomization).

# Intellij / PHPStorm related

## resolving tables sql

Set project SQL dialect:

View > tool windows -> database > [+] database  
Settings > Languages & Frameworks > SQL Resolution Scopes  
Settings > Languages & Frameworks > SQL Dialects

# Database centric PHP stuff

## PDO prepared statements debugging

Since PHP 7.2, `$stmt->debugDumpParams();` displays the prepared statements with the values as they are sent to the
database.

## insert or update if exists

- `INSERT IGNORE INTO [...]` inserts if id doesn't exist
- `INSERT INTO [the rest of the statement like usual] ON DUPLIKATE KEY UPDATE name="peer" lastname="teer" [rest of normal SQL statement]`

## Auto incremented indexes out of range

When deleting the content of a table and repopulating it, the autoindexing continues at the last index given (which
makes sense to avoid inconsistencies when referencing deleted entries from outside / as foreign keys), so don't use a
too small type such as `tinyint(3)` OR drop and recreate the table instead of deleting all entries.

## use exceptions to avoid unnoticed errors

    $db = new PDO('mysql:dbname=excel2db;host=localhost', 'root', 'root',
      array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

# PHP and Database version upgrades

## Upgrading from PHP 5 to 7

Main breaking changes:

- original `mysql_*` functions are removed and must be converted to `msqli` or `PDO`
- all `ereg*` functions including `split()`, `spliti()` and `sql_regcase()`; use `preg*` functions instead
- hexadecimal numbers (e.g. `0xff`) are now treated as a string literal when surrounded with quotes (`'0xff'`) so to use
  them in calculations they must be used either without quotes or converted using `hexdec()`
- ONLY `<?php` tags are accepted

# Security

Mostly notes from "php - creating secure websites" by Kevin Skoglund on linkedin learning

## Overview

- Awareness + protection = security
- Security should match needs and goals (e.g. a site without PI or other sensitive information needs less security for
  protecting access to the database than one with financial, medical or just personal information)
- Focus on the areas that need to be secured
- Reevaluate periodically for changes in
    - the areas that need protection (the site might now store email addresses for a newsletter function that it didn't
      before)
    - newly discovered attack schemes and vulnerabilities of the underlying software
    - raised / changing awareness of what kind of information is sensitive
- small sites are targeted as often as large sites
- PHP frameworks can help as they follow security best practices and is better tested

Primary security principles:

- least privilege:
    - give a user account only essential rights to make it work (e.g. HR doesn't need access to accounting data and vice
      versa)
    - code should limit which functions are exposed for other code to use
- simple is more secure
- never trust users, admins and contractors as their accounts can be hacked or they themselves might have malicious
  intents
- expect the unexpected: try to hack your own code
- defense in depth: add multiple security layers. Example would be a 2 factor authorization that, even if circumvented,
  doesn't give the hacker access to sensitive information that is not needed for the hacked user acccount
- security through obscurity: Don't give the hacker any information like "the password is wrong" or "user doesn't exist"
  as this can narrow their angle of attack
- allow and deny lists: e.g. the database should check that connections come only from a known whitelisted host
  (allow list), an IP of a suspected hack attempt can be added to a blacklist (deny list)
- map exposure points and data passageways (where can information be entered, e.g. forms or web services, what kind of
  information can come back)

## Securing the PHP installation

## Keeping versions up to date

## $_SERVER variable

Copied from https://www.php.net/manual/en/reserved.variables.server.php, Vladimir Korneas comment:

1. All elements of the $_SERVER array whose keys begin with 'HTTP_' come from HTTP request headers and are not to be
   trusted.

2. All HTTP headers sent to the script are made available through the $_SERVER array, with names prefixed by 'HTTP_'.

3. $_SERVER['PHP_SELF'] is dangerous if misused. If login.php/nearly_arbitrary_string is requested, $_SERVER['PHP_SELF']
   will contain not just login.php, but the entire login.php/nearly_arbitrary_string. If you've printed $_
   SERVER['PHP_SELF'] as the value of the action attribute of your form tag without performing HTML encoding, an
   attacker can perform XSS attacks by offering users a link to your site such as this:

   <a href='http://www.example.com/login.php/"><script type="text/javascript">...</script><span a="'>Example.com</a>

The javascript block would define an event handler function and bind it to the form's submit event. This event handler
would load via an <img> tag an external file, with the submitted username and password as parameters.

Use $_SERVER['SCRIPT_NAME'] instead of $_SERVER['PHP_SELF']. HTML encode every string sent to the browser that should
not be interpreted as HTML, unless you are absolutely certain that it cannot contain anything that the browser can
interpret as HTML.

# Frameworks

- Laravel
- Codeigniter
- Laminas (= Zend)
- Dive deeper into Slim

