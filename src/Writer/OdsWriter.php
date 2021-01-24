<?php

declare(strict_types=1);

namespace Kreyu\SonataExporterPhpSpreadsheetBridge\Writer;

class OdsWriter extends AbstractWriter
{
    public function getDefaultMimeType(): string
    {
        return 'application/vnd.oasis.opendocument.spreadsheet';
    }

    public function getFormat(): string
    {
        return 'ods';
    }
}
