<?php

declare(strict_types=1);

namespace Kreyu\SonataExporterPhpSpreadsheetBridge;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;
use Sonata\Exporter\Writer\TypedWriterInterface;

abstract class AbstractWriter implements TypedWriterInterface
{
    protected $spreadsheet;
    protected $filename;
    protected $showHeaders;
    protected $row = 0;

    public function __construct(string $filename, bool $showHeaders = true)
    {
        $this->filename = $filename;
        $this->showHeaders = $showHeaders;

        if (is_file($filename)) {
            throw new \RuntimeException(sprintf('The file %s already exists', $filename));
        }
    }

    public function open()
    {
        $this->spreadsheet = new Spreadsheet();
        $this->row = 0;
    }

    public function write(array $data): void
    {
        if (null === $this->spreadsheet) {
            $this->open();
        }

        if ($this->showHeaders && 0 === $this->row) {
            $this->writeRow(array_keys($data));
        }

        $this->writeRow(array_values($data));
    }

    public function close(): void
    {
        if (null === $this->spreadsheet) {
            return;
        }

        $writer = $this->getInnerWriter();
        $writer->save($this->filename);
    }

    protected function getInnerWriter(): IWriter
    {
        return IOFactory::createWriter($this->spreadsheet, $this->getFormat());
    }

    protected function writeRow(array $data): void
    {
        $sheet = $this->spreadsheet->getActiveSheet();

        $this->row++;

        $columnIndex = 0;

        foreach ($data as $value) {
            $sheet->setCellValueByColumnAndRow(++$columnIndex, $this->row, $value);
        }
    }
}
