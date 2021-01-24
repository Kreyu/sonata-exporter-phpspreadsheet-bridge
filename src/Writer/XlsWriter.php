<?php

declare(strict_types=1);

namespace Kreyu\SonataExporterPhpSpreadsheetBridge\Writer;

class XlsWriter extends AbstractWriter
{
    public function getDefaultMimeType(): string
    {
        return 'application/vnd.ms-excel';
    }

    public function getFormat(): string
    {
        return 'xls';
    }
}
