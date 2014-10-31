# Veval (Virtual eval)

<img src="http://media.giphy.com/media/KzNCKU8wMNLnW/giphy.gif" alt="Virtual Eval" align="right" width=310/>

[![Master branch build status][ico-build]][travis]
[![Published version][ico-package]][package]
[![PHP ~5.4][ico-engine]][lang]
[![MIT Licensed][ico-license]][license]

**Veval** is an implementation of eval that uses a virtual file system to store
code for evaluation and then `require` it back out. It should work on PHP
installations that don't support or have disabled native `eval`.

It can be installed in whichever way you prefer, but I recommend
[Composer][package].
```json
{
    "require": {
        "adlawson/veval": "*"
    }
}
```

## Documentation
The **Veval** API is exposed as a collection of `Veval\` namespaced functions,
though you may prefer to use `Veval::` to take advantage of autoloading and
namespace aliasing (PHP < 5.6).
```php
<?php

// Evaluate some code
Veval\execute(<<<'EOF'
class Foo {
    public $name;
    public function __construct($name) {$this->name = $name;}
}
EOF
);

// Use your newly evaulated code
$foo = new Foo('bar');
$foo->name; // bar
```

### Debugging
Storing all of the "files" in memory is all fine if your evaluated code is
workng as you expect, but sometimes it's useful to read the generated code to
debug any problems. There are a few different debugging functions available to
suit your needs.
```php
<?php

// Debug all evaluated strings
Veval\debug(function ($name, $content) {
    // Debug some things here
});

// Iterate over all evaulated strings
foreach (Veval\iterator() as $name => $content) {
    // Debug some things here
}

// Dump all to path
Veval\dump(sys_get_temp_dir(), 'veval-%s.php');
```

### Warning
<img src="http://media.giphy.com/media/wuOtkQMVrqdRS/giphy.gif" alt="Eval Warning" align="right" width=140/>
Using **Veval**, just like eval, is considered dangerous to use if you're
evaluating user input. Always be careful not to do this as it can open up quite
a large hole in the security of your system.

## Contributing
Contributions are accepted via Pull Request, but passing unit tests must be
included before it will be considered for merge.
```bash
$ curl -O https://raw.githubusercontent.com/adlawson/vagrantfiles/master/php/Vagrantfile
$ vagrant up
$ vagrant ssh
...

$ cd /srv
$ composer install
$ vendor/bin/phpunit
```

### License
The content of this library is released under the **MIT License** by
**Andrew Lawson**.<br/> You can find a copy of this license in
[`LICENSE`][license] or at http://opensource.org/licenses/mit.

[travis]: https://travis-ci.org/adlawson/php-veval
[lang]: http://php.net
[package]: https://packagist.org/packages/adlawson/veval
[ico-license]: http://img.shields.io/packagist/l/adlawson/veval.svg?style=flat
[ico-package]: http://img.shields.io/packagist/v/adlawson/veval.svg?style=flat
[ico-build]: http://img.shields.io/travis/adlawson/php-veval/master.svg?style=flat
[ico-engine]: http://img.shields.io/badge/php-~5.4-8892BF.svg?style=flat
[issues]: https://github.com/adlawson/php-veval/issues
[license]: LICENSE
