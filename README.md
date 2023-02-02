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

### Example

```php
use BerryDoc\Php\DocumentGenerator;

// Payload can have any structure you want, as long as that structure is respected in the template.
$payload = [
  "title" => "Document title", 
  "section-1" => "Section 1 content",
  "section-2" => "Section 2 content",
  "indent" => [
    "indent-1" => "Indent 1 content",
    "indent-2" => "Indent 2 content",
    "indent-3" => "Indent 3 content",
  ],
]

$generator = new DocumentGenerator($email, $password);
$pdfFile = $generator->generate("5e32dce4-bb9e-44a3-93f4-248a9716e16c", $payload, "pdf", "file");
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email info@hudlajf.com instead of using the issue tracker.

## Credits

- [Luka](https://github.com/berrydoc)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
