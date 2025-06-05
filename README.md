[![Packagist License](https://img.shields.io/packagist/l/imponeer/symfony-translations-constants-loader)](https://github.com/imponeer/symfony-translations-constants-loader/blob/main/LICENSE) [![Packagist Version](https://img.shields.io/packagist/v/imponeer/symfony-translations-constants-loader)](https://packagist.org/packages/imponeer/symfony-translations-constants-loader) [![Packagist Dependency Version](https://img.shields.io/packagist/dependency-v/imponeer/symfony-translations-constants-loader/php)](https://github.com/imponeer/symfony-translations-constants-loader/blob/main/composer.json)


# Symfony Translations Constants Loader

Extension for [symfony/translation](https://symfony.com/doc/current/translation.html) package to load translations defined as constants list in PHP file.

## Installation

To install and use this package, we recommend to use [Composer](https://getcomposer.org):

```bash
composer require imponeer/symfony-translations-constants-loader
```

Otherwise you need to include manualy files from `src/` directory. 

## Usage Example

### 1. Create a file with `define()` constants:

```php
// translations/en/messages.php

define('HELLO', 'Hello!');
define('GOODBYE', 'Goodbye!');
```

> 💡 You can create separate files for other locales, such as `translations/fr/messages.php`.

### 2. Load the constants using the PHPFileLoader:

```php
use Symfony\Component\Translation\Translator;
use Imponeer\SymfonyTranslationsConstantsLoader\PHPFileLoader;

$translator = new Translator('en');

// Register the loader for the 'php_consts' format
$translator->addLoader('php_consts', new PHPFileLoader());

// Add your translation resource
$translator->addResource('php_consts', __DIR__ . '/translations/en/messages.php', 'en');

// Use translations
echo $translator->trans('HELLO');   // Outputs: Hello!
echo $translator->trans('GOODBYE'); // Outputs: Goodbye!
```


## Development

### Code Style

This project follows the [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standard. To check your code for style issues:

```bash
composer phpcs
```

To automatically fix most coding standards issues:

```bash
composer phpcbf
```

### Testing

To run the test suite, execute:

```bash
vendor/bin/phpunit
```

This will run all tests in the `tests/` directory.

## How to contribute?

If you want to add some functionality or fix bugs, you can fork, change and create pull request. If you not sure how this works, try read [GitHub documentation about git](https://docs.github.com/en/get-started/using-git).

Please make sure your code follows the PSR-12 coding standard by running the code style checks before submitting a pull request.

If you found any bug or have some questions, use [issues tab](https://github.com/imponeer/symfony-translations-constants-loader/issues) and write there your questions.
