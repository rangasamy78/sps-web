<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

trait BarcodeTrait
{
    public function generateBarcodes(
        int $totalItems,
        string $basePrefix = null,
        int $startSerial = null,
        int $maxSerial = null,
        string $tableName = null,
        string $columnName = null
    ): array {
        $basePrefix = $basePrefix ?? $this->basePrefix ?? 'AA';
        $startSerial = $startSerial ?? $this->startSerial ?? 1;
        $maxSerial = $maxSerial ?? $this->maxSerial ?? 9999999;
        $tableName = $tableName ?? $this->tableName ?? 'supplier_invoice_packing_items';
        $columnName = $columnName ?? $this->columnName ?? 'bar_code_no';

        if ($totalItems <= 0) {
            throw new \InvalidArgumentException("Total items must be greater than zero.");
        }

        if (strlen($basePrefix) < 2 || !ctype_alpha($basePrefix)) {
            throw new \InvalidArgumentException("Base prefix must be at least two alphabetic characters.");
        }

        $barcodes = [];
        $currentSerial = $startSerial;

        try {
            for ($i = 0; $i < $totalItems; $i++) {
                do {
                    if ($currentSerial > $maxSerial) {
                        $basePrefix = $this->getNextPrefix($basePrefix);
                        $currentSerial = 1;
                    }

                    $barcode = $basePrefix . str_pad($currentSerial, 7, '0', STR_PAD_LEFT);

                    $exists = DB::table($tableName)->where($columnName, $barcode)->exists();

                    if ($exists) {
                        $currentSerial++;
                    }
                } while ($exists);

                $barcodes[] = $barcode;

                $currentSerial++;
            }
        } catch (QueryException $e) {
            Log::error('Database error during barcode generation: ' . $e->getMessage());
            throw new \RuntimeException('Error generating barcodes. Please try again later.');
        }

        return $barcodes;
    }

    private function getNextPrefix(string $currentPrefix): string
    {
        $lastChar = substr($currentPrefix, -1);
        $firstPart = substr($currentPrefix, 0, -1);
        $nextChar = chr(ord($lastChar) + 1);
        if ($lastChar === 'Z') {
            $nextChar = 'A';
            $firstPart = chr(ord($firstPart) + 1);
        }

        return $firstPart . $nextChar;
    }
}
