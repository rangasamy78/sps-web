<?php

namespace App\Services\SupplierInvoicePackingItem;

use App\Models\Customer;
use Illuminate\Support\Arr;
use App\Traits\BarcodeTrait;
use Illuminate\Support\Facades\Log;
use App\Models\PurchaseOrderProduct;
use App\Models\SupplierInvoicePackingItem;

class SupplierInvoicePackingItemService
{
    use BarcodeTrait;

    public function getCustomers()
    {
        return Customer::query()->pluck('customer_name', 'id');
    }

    public function getSupplierInvoiceAddPackingItem($data)
    {
        $productRowId = $data['row_id'];
        $data = $this->__extractData($data, $productRowId);
        list($lotBlockFirst, $lotBlockSecond)       = $this->__extractNumberFromString($data['lot_block']);
        list($bundleFirst, $bundleSecond)           = $this->__extractNumberFromString($data['bundle']);
        list($supplierRefFirst, $supplierRefSecond) = $this->__extractNumberFromString($data['supplier_ref']);

        $insertData = $this->__generatePackingItems(
            $data['po_product_id'],
            $data['product_id'],
            $data['po_id'],
            $data['unit_type_name'],
            $data['unit_pack_length'],
            $data['unit_pack_width'],
            $data['pack_length'],
            $data['pack_width'],
            $data['rec_length'],
            $data['rec_width'],
            $data['transaction_no'],
            $data['serial_no'],
            $lotBlockFirst,
            $lotBlockSecond,
            $bundleFirst,
            $bundleSecond,
            $supplierRefFirst,
            $supplierRefSecond,
            $data['bin_type_id'],
            $data['bin_type_name'],
            $data['present_location'],
            $data['notes'],
            $data['count'],
            $data['isSeqBlock'],
            $data['isSeqBundle'],
            $data['isSeqSupplier']
        );
        // Insert the generated packing items into the database
        SupplierInvoicePackingItem::insert($insertData);
        $packingItemDetails = $this->getPackingItemDetails($data, $productRowId);
        return [
            $packingItemDetails['records'],
            $packingItemDetails['productRowId'],
            $packingItemDetails['maxSerialNo'],
            $packingItemDetails['maxLotBlock'],
            $packingItemDetails['maxBundle'],
            $packingItemDetails['maxSupplierRef']
        ];
    }

    public function getPackingItemDetails($data, $productRowId)
    {
        if(isset($data['update']) && !empty($data['update'])) {
            $records = SupplierInvoicePackingItem::query()
            ->whereIn('id', $data['id'])
            ->get();
        } else {
            $records = SupplierInvoicePackingItem::query()
            ->where('po_product_id', $productRowId)
            ->where('po_id', $data['po_id'])
            ->where('product_id', $data['product_id'])
            ->get();
        }

        $maxLotBlock = $maxBundle = $maxSupplierRef = '';

        if ($records->isNotEmpty()) {
            $lastRecord = $records->last();
            $maxLotBlock = $this->generateNewCode($lastRecord->lot_block, $data['isSeqBlock']??'');
            $maxBundle = $this->generateNewCode($lastRecord->bundle, $data['isSeqBundle']??'');
            $maxSupplierRef = $this->generateNewCode($lastRecord->supplier_ref, $data['isSeqSupplier']??'');
        }

        if (empty($data['update'])) {
            $maxSerialNo = $this->__getMaxSerialNo($data['po_id']);
        }

        return [
            'records' => $records,
            'productRowId' => $productRowId,
            'maxSerialNo' => empty($data['update']) ? $maxSerialNo : '',
            'maxLotBlock' => $maxLotBlock,
            'maxBundle' => $maxBundle,
            'maxSupplierRef' => $maxSupplierRef
        ];
    }

    private function generateNewCode($currentValue, $isSequential)
    {
        [$prefix, $number] = $this->extractNumberFromString($currentValue);
        return $prefix . '-' . ($isSequential ? $number + 1 : $number);
    }

    private function extractNumberFromString($value)
    {
        preg_match('/^(.*?)-(\d+)$/', $value, $matches);
        return $matches ? [$matches[1], (int)$matches[2]] : [$value, 0];
    }

    private function __extractData($data, $productRowId)
    {
        return [
            'po_product_id'    => $productRowId ?? null,
            'product_id'       => $data['product_id'] ?? null,
            'po_id'            => $data['po_id'] ?? null,
            'unit_type_name'   => $data['unit_type_name'] ?? null,
            'unit_pack_length' => $data['unit_pack_length'] ?? null,
            'unit_pack_width'  => $data['unit_pack_width'] ?? null,
            'pack_length'      => $data['pack_length'] ?? null,
            'pack_width'       => $data['pack_width'] ?? null,
            'rec_length'       => $data['rec_length'] ?? null,
            'rec_width'        => $data['rec_width'] ?? null,
            'transaction_no'   => $data['transaction_no'] ?? null,
            'serial_no'        => $data['serial_no'] ?? null,
            'lot_block'        => $data['lot_block'] ?? null,
            'bundle'           => $data['bundle'] ?? null,
            'supplier_ref'     => $data['supplier_ref'] ?? null,
            'bin_type_id'      => $data['bin_type_id'] ?? null,
            'bin_type_name'    => $data['bin_type_name'] ?? null,
            'present_location' => $data['present_location'] ?? null,
            'notes'            => $data['notes'] ?? null,
            'count'            => $data['count'] ?? 1,
            'isSeqBlock'       => $data['isBlockCheck'] ?? false,
            'isSeqBundle'      => $data['isBundleCheck'] ?? false,
            'isSeqSupplier'    => $data['isSuppRefCheck'] ?? false,
        ];
    }

    private function __generatePackingItems(
        $productRowId,
        $productId,
        $poId,
        $unitTypeName,
        $unitPackLength,
        $unitPackWidth,
        $packLength,
        $packWidth,
        $recLength,
        $recWidth,
        $transactionNo,
        $serialNo,
        $lotBlockFirst,
        $lotBlockSecond,
        $bundleFirst,
        $bundleSecond,
        $supplierRefFirst,
        $supplierRefSecond,
        $binTypeId,
        $binTypeName,
        $presentLocation,
        $notes,
        $count,
        $isSeqBlock,
        $isSeqBundle,
        $isSeqSupplier
    ) {
        // Generate the packing items using Laravel collections for better readability
        return collect(range(0, $count - 1))->map(function ($i) use (
            $productRowId,
            $productId,
            $poId,
            $unitTypeName,
            $unitPackLength,
            $unitPackWidth,
            $packLength,
            $packWidth,
            $recLength,
            $recWidth,
            $transactionNo,
            $serialNo,
            $lotBlockFirst,
            $lotBlockSecond,
            $bundleFirst,
            $bundleSecond,
            $supplierRefFirst,
            $supplierRefSecond,
            $binTypeId,
            $binTypeName,
            $presentLocation,
            $notes,
            $count,
            $isSeqBlock,
            $isSeqBundle,
            $isSeqSupplier,
        ) {
            $currentSerialNo = $serialNo + $i;
            $barcodes = $this->generateBarcodes( $count );
            return [
                'unit_type_name'     => $unitTypeName,
                'seq_no'             => $this->__generateNextSerialNo($transactionNo, $serialNo, $i),
                'bar_code_no'        => $barcodes[$i],
                'packing_list_sizes' => $this->__calculatePackingSize($packLength, $packWidth),
                'received_sizes'     => $this->__calculatePackingSize($recLength, $recWidth),
                'po_product_id'      => $productRowId,
                'product_id'         => $productId,
                'po_id'              => $poId,
                'lot_block'          => $this->__generateItemIdentifier($lotBlockFirst, $lotBlockSecond, $isSeqBlock, $i),
                'bundle'             => $this->__generateItemIdentifier($bundleFirst, $bundleSecond, $isSeqBundle, $i),
                'supplier_ref'       => $this->__generateItemIdentifier($supplierRefFirst, $supplierRefSecond, $isSeqSupplier, $i),
                'unit_pack_length'   => $unitPackLength,
                'unit_pack_width'    => $unitPackWidth,
                'pack_length'        => $packLength,
                'pack_width'         => $packWidth,
                'rec_length'         => $recLength,
                'rec_width'          => $recWidth,
                'transaction_no'     => $transactionNo,
                'serial_no'          => $currentSerialNo,
                'bin_type_id'        => $binTypeId,
                'bin_type_name'      => $binTypeName,
                'present_location'   => $presentLocation,
                'notes'              => $notes,
                'isSeqBlock'         => isset($isSeqBlock) ? 1 : 0,
                'isSeqBundle'        => isset($isSeqBundle) ? 1 : 0,
                'isSeqSupplier'      => isset($isSeqSupplier) ? 1 : 0,
                'created_at'         => now(),
                'updated_at'         => now(),
            ];
        })->toArray();
    }

    public function __extractNumberFromString($input)
    {
        preg_match('/([A-Za-z0-9-]+)-(\d+)$/', $input, $matches);
        if (isset($matches[1]) && isset($matches[2])) {
            return [$matches[1], (int)$matches[2]];
        }
        return [];
    }

    public function convertInchesToSquareFeet($length, $width, $height)
    {
        $totalSquareInches = $length * $width * $height;
        $squareFeet        = $totalSquareInches / 144;
        return number_format($squareFeet, 2);
    }

    private function __generateNextSerialNo($transactionNo, $serialNo, $index)
    {
        return $transactionNo . '-' . ($serialNo + $index);
    }

    public function __calculatePackingSize($lengthInches, $widthInches)
    {
        $squareFeet = ($lengthInches * $widthInches) / 144;

        $squareFeetFormatted = number_format($squareFeet, 2);
        return "{$lengthInches}\" x {$widthInches}\" = {$squareFeetFormatted} SF";
    }

    private function __generateItemIdentifier($firstPart, $secondPart, $isSequential, $index)
    {
        return $firstPart . '-' . ($isSequential ? $secondPart + $index : $secondPart);
    }

    public function __getMaxSerialNo(string $poId)
    {
        $maxSerialNo = SupplierInvoicePackingItem::query()
            ->where('po_id', $poId)
            ->count();
        return $maxSerialNo ? $maxSerialNo + 1 : 1;
    }

    public function __getSupplierInvoicePackingItem($data)
    {
        return SupplierInvoicePackingItem::query()
            ->where('po_product_id', $data['formId'])
            ->where('po_id', $data['po_id'])
            ->where('product_id', $data['product_id'])
            ->get();
    }

    public function getSupplierInvoiceEditPackingItem( $data ){
        $records = collect($data)->only(['po_id','product_id','formId']);
        $results = $this->__getSupplierInvoicePackingItem($records);
        return [$results];
    }

    public function getSupplierInvoiceUpdatePackingItem( $data ){
        //dd($data);
        $selectedData = $data['selectedData'];
        $firstRow = collect($selectedData)->first();
        $record['id'] = collect($selectedData)->pluck('id')->all();
        $record['update'] = 'update';
        $productRowId = $firstRow['row_id'];
        if (!empty($selectedData)) {
            $this->updatePackingItems($selectedData);
        }
        return $this->fetchUpdatedPackingItemDetails($selectedData, $productRowId);
    }

    public function findOrFail(int $id)
    {
        return SupplierInvoicePackingItem::query()
                ->whereHas('product')
                ->with(['product', 'product.product_price','product.product_type', 'product.product_category', 'product.product_sub_category','product.product_group','product.supplier'
                ])
                ->findOrFail($id);
    }

    public function getSupplierInvoicePackingItemFetchAll( $data ){

        $products = [];
        if (empty($data['products'])) {
            return response()->json(['message' => 'No products provided.'], 400);
        }
        $i = 1;
        foreach ($data['products'] as $product) {
            $records = collect($product)->only(['id','po_id','product_id']);
            $packingItemDetails = $this->getPackingItemDetails($records,  $i);
            $products[] = $packingItemDetails;
            $i++;
        }

        return $products;
    }

    protected function updatePackingItems(array $selectedData)
    {
        foreach ($selectedData as $record) {
            $this->updateSinglePackingItem($record);
        }
    }

    protected function updateSinglePackingItem(array $record)
    {
        $item = SupplierInvoicePackingItem::find($record['id']);
        if ($item) {
            try {
                $item->lot_block   = $record['lot_block'];
                $item->bundle       = $record['bundle'];
                $item->supplier_ref = $record['supplier_ref'];
                $item->pack_length  = $record['pack_length'];
                $item->pack_width   = $record['pack_width'];
                $item->rec_length   = $record['rec_length'];
                $item->rec_width    = $record['rec_width'];
                $item->notes        = $record['notes'];
                $item->save();
            } catch (\Exception $e) {
                Log::error("Error updating record ID {$record['id']}: " . $e->getMessage());
            }
        } else {
            Log::warning("Record with ID {$record['id']} not found.");
        }
    }

    protected function fetchUpdatedPackingItemDetails(array $selectedData, int $productRowId)
    {
        $record = [
            'id' => collect($selectedData)->pluck('id')->all(),
            'update' => 'update',
        ];

        $packingItemDetails = $this->getPackingItemDetails($record, $productRowId);

        return [
            $packingItemDetails['records'],
            $packingItemDetails['productRowId'],
            $packingItemDetails['maxSerialNo'],
            $packingItemDetails['maxLotBlock'],
            $packingItemDetails['maxBundle'],
            $packingItemDetails['maxSupplierRef'],
        ];
    }

    public function updateNote(array $record)
    {
        $item = SupplierInvoicePackingItem::find($record['id']);
        if ($item) {
            try {
                $item->updateNoteItem(collect($record)->except('id','_token')->toArray());
            } catch (\Exception $e) {
                Log::error("Error updating Note record ID {$record['id']}: " . $e->getMessage());
            }
        } else {
            Log::warning("Note Record with ID {$record['id']} not found.");
        }
    }

    public function updateSlabItemMultiple(array $data)
    {
        ['product_id' => $product_id, 'items' => $items] = $data;
        if($items){
            $itemsArray = is_string($items) ? explode(',', $items) : (array) $items;
            collect($itemsArray)->map(function($item) use ($product_id) {
                $model = SupplierInvoicePackingItem::find($item);
                if ($model) {
                    $model->product_id = $product_id;
                    $model->save();
                }
            });
            return true;
        } else {
            return false;
        }
    }

    public function updateAssignSlabMultiple( array $data ){
        $poId = Arr::get($data,'po_id.0');
        $excludeProductId = Arr::get($data,'product_id.0');
        $slabRecords = PurchaseOrderProduct::query()
            ->where('po_id', $poId)
            ->with(['product','product.product_type'])
            ->whereHas('product.product_type', function ($query) {
                $query->where('product_type', 'slab');
            })
            ->get()
            ->filter(function ($item) use ($excludeProductId) {
                return $item->product_id != $excludeProductId;
            });
            $i = 1;
            $records = $slabRecords->map(function ($slab) use (&$i)  {
                return [
                    'id' => $i++,
                    'product_id' => $slab->product_id,
                    'product_name' => optional($slab->product)->product_name ?? '', // Default value if product is null
                ];
            })->values()->toArray();
        return [$records , $data['selectedItemIds']];
    }

    public function delete(int $id)
    {
        $products = PurchaseOrderProduct::where('id', $id)->get();
        if ($products->isNotEmpty()) {
            return response()->json(['status' => 'error', 'msg' => 'The product cannot be deleted because it is associated with SIPL.'], 200);
        } else {
            $this->findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'msg' => 'Select Product deleted successfully.'], 200);
        }
    }
}
