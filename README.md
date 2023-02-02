# Document generator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/berrydoc/php.svg?style=flat-square)](https://packagist.org/packages/berrydoc/php)
[![Total Downloads](https://img.shields.io/packagist/dt/berrydoc/php.svg?style=flat-square)](https://packagist.org/packages/berrydoc/php)

Introducing the Docx (Word) based Twig template engine for generating documents effortlessly. With Document generator, you can now create professional and high-quality documents without the hassle of programing HTML/CSS and converting it to PDF. Create docx template with Twig, provide your data payload and generate the document. Experience the full range of features, including the ability to use charts, shapes, headers/footers, and much more.

## Installation

You can install the package via composer:

```bash
composer require berrydoc/php
```

## Usage

```php
use BerryDoc\Php\DocumentGenerator;

$generator = new DocumentGenerator($email, $password);
```

Getting template records

```php
// List of all templates
$templatesList = $generator->getTemplates();

// Paginated list of template, with 10 items per page
$templatesList = $generator->getTemplates($per_page = 10, $page = 1);
```

Getting template record

```php
// Generating template with provided $payload
$file = $generator->generate($id, $payload, $format = "docx", $output = "file");

// Format: pdf, docx
// Output: file, base64
$base64 = $generator->generate($id, $payload, $format = "pdf", $output = "base64");
```

Possible formats

- `source`: Returns in same format as template (docx -> docx)
- `pdf`: Convert to PDF

Possible outputs

- `file`: Get file content
- `base64`: Get base64 encoded content

## Example

```php
use BerryDoc\Php\DocumentGenerator;

$payload = [...];

$generator = new DocumentGenerator('<email>', '<password>');
$pdfFile = $generator->generate("<id>", $payload, "pdf", "file");
```

## Known issues

Placing single quote in Word will sometimes cause it to be converted to a different quote character. Make sure it is a single quote ( ' ). You might need to copy paste it.

When copy pasting to Word, make sure you are not copying the formatting.

## Creating templates (with Twig)

Please check our [examples](https://github.com/berrydoc/examples) to see how templates are created.

When creating your own template refer to [Twig documentation](https://twig.symfony.com/doc/3.x/) for more information.

## Other

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
