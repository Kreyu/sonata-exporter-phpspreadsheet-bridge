# Sonata Exporter PhpSpreadsheet Bridge

This package integrates [PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet) with [Sonata Exporter](https://github.com/sonata-project/exporter).

```
$ composer require kreyu/sonata-exporter-phpspreadsheet-bridge
```

### Supported writer formats

- xls
- xlsx
- ods
  
Note: default [Sonata Exporter's .xls writer](https://github.com/sonata-project/exporter/blob/2.x/src/Writer/XlsWriter.php) generates spreadsheet with HTML, which triggers warnings about "possibly corrupted file". Use xls writer from this package to get rid of that problem.

### Usage

```php
<?php

use Sonata\Exporter\Handler;
use Sonata\Exporter\Source\PDOStatementSourceIterator;
use Kreyu\SonataExporterPhpSpreadsheetBridge\Writer\XlsWriter;

// Prepare the data source
$dbh = new \PDO('sqlite:foo.db');
$stm = $dbh->prepare('SELECT id, username, email FROM user');
$stm->execute();

$source = new PDOStatementSourceIterator($stm);

// Prepare the writer
$writer = new XlsWriter('data.xls');

// Export the data
Handler::create($source, $writer)->export();
```
