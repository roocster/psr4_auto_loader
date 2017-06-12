# PSR4AutoLoader

Implementation of the [PSR-4 autoloading standard](http://www.php-fig.org/psr/psr-4/).

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![Version](https://img.shields.io/badge/version-2.0-brightgreen.svg)](https://github.com/roocster/psr4_auto_loader/)

### Requirements

 - PHP >=7.1 (for PHP >=5.6 support use [version 1.0](https://github.com/roocster/psr4_auto_loader/tree/v1))
 - PHPUnit >=5.7 (for running tests)

### Installation

Via [Composer](https://getcomposer.org/):

```sh
composer require "rooc/psr4_auto_loader"
```

### Usage

For example, in the project root we have "src" folder that contains our own code of classes, interfaces, traits etc. Let's load all of them:

```php
$autoLoader = new \Rooc\PSR4AutoLoader\PSR4AutoLoader('/src', 'App');
$autoLoader->register();
```

If your code are in several directories, e. g. "Classes" and "Interfaces", you need register both:

```php
use Rooc\PSR4AutoLoader\PSR4AutoLoader;

// Load classes
(new PSR4AutoLoader('/Classes', 'App'))->register();

// Load interfaces
(new PSR4AutoLoader('/Interfaces', 'App'))->register();
```

> Note that you should follow the PSR-4 class naming rules: http://www.php-fig.org/psr/psr-4/#specification

License
----

MIT