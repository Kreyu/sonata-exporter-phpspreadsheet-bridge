<?php

declare(strict_types=1);

namespace Kreyu\SonataExporterPhpSpreadsheetBridge\Writer;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception as PhpSpreadsheetWriterException;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;
use RuntimeException;
use Sonata\Exporter\Writer\TypedWriterInterface;

abstract class AbstractWriter implements TypedWriterInterface
{
    /** @var null|Spreadsheet */
    protected $spreadsheet;

    /** @var string */
    protected $filename;

    /** @var bool */
    protected $showHeaders;

    /** @var int */
    protected $row = 0;

    public function __construct(string $filename, bool $showHeaders = true)
    {
        $this->filename = $filename;
        $this->showHeaders = $showHeaders;

        if (is_file($filename)) {
            throw new RuntimeException(sprintf('The file %s already exists', $filename));
        }
    }

    public function open(): void
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
            $this->addRowFromArray(array_keys($data));
        }

        $this->addRowFromArray($data);
    }

    /**
     * @throws PhpSpreadsheetWriterException
     */
    public function close(): void
    {
        if (null === $this->spreadsheet) {
            return;
        }

        $writer = $this->getInnerWriter();
        $writer->save($this->filename);
    }

    /**
     * Create PhpSpreadsheet writer to use internally.
     *
     * @return IWriter
     * @throws PhpSpreadsheetWriterException
     */
    protected function getInnerWriter(): IWriter
    {
        return IOFactory::createWriter($this->spreadsheet, $this->getFormat());
    }

    /**
     * Add a row to the spreadsheet using given data.
     *
     * @param  array $data
     */
    protected function addRowFromArray(array $data): void
    {
        $sheet = $this->spreadsheet->getActiveSheet();

        $this->row++;

        $columnIndex = 0;

        foreach ($data as $value) {
            $sheet->setCellValueByColumnAndRow(++$columnIndex, $this->row, $value);
        }
    }
}
