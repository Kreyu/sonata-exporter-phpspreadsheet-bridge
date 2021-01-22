<?php

declare(strict_types=1);

namespace Kreyu\SonataExporterPhpSpreadsheetBridge;

class XlsxWriter extends AbstractWriter
{
    public function getDefaultMimeType(): string
    {
        return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    }

    public function getFormat(): string
    {
        return 'xlsx';
    }
}
