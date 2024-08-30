<?php

namespace App\Services\ProductType;

use App\Models\ProductType;

class ProductTypeService
{

    public function getDefaultGLAccounts($inventory_gl_account, $sales_gl_account, $cogs_gl_account)
    {
        $account = "<div style=''><span style='display: inline-block; width: 100px;'>Inventory&nbsp;:</span> " . ($inventory_gl_account ?? 'N/A') . "<br>";
        $account .= "<span style='display: inline-block; width: 100px;'>Sales&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</span> " . ($sales_gl_account ?? 'N/A') . "<br>";
        $account .= "<span style='display: inline-block; width: 100px;'>COGS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</span> " . ($cogs_gl_account ?? 'N/A') . "</div>";
        return $account;
    }
    public function getDefaultValues($indivisible, $non_serialized, $id)
    {
        $isIndivisibleChecked = !empty($indivisible) && $indivisible == 1 ? 'checked' : '';
        $isNonSerializedChecked = !empty($non_serialized) && $non_serialized == 1 ? 'checked' : '';

        $defaultaccount = "<div class='form-check form-check-inline mt-3'>
        <input class='form-check-input' type='checkbox' id='indivisible-" . $id . "' name='indivisible[" . $id . "]' value='1' " . $isIndivisibleChecked . " onclick='savedefaultValuesChange(this, \"" . $id . "\", \"indivisible\")' />
        <label class='form-check-label' for='indivisible-" . $id . "'>Indivisible</label>
        </div>
        <div class='form-check form-check-inline'>
            <input class='form-check-input' type='checkbox' id='non_serialized-" . $id . "' name='non_serialized[" . $id . "]' value='1' " . $isNonSerializedChecked . " onclick='savedefaultValuesChange(this, \"" . $id . "\", \"non_serialized\")' />
            <label class='form-check-label' style='color:red' for='non_serialized-" . $id . "'>Non Serialized</label>
        </div>";
        return $defaultaccount;
    }

    public function saveDefaultValue($request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:product_types,id',
            'type' => 'required|string|in:indivisible,non_serialized',
            'checked' => 'required|boolean',
        ]);

        $productType = ProductType::find($validatedData['id']);
        if (!$productType) {
            return response()->json(['error' => 'Product Type not found.'], 404);
        }

        if ($validatedData['type'] === 'indivisible') {
            $productType->indivisible = $validatedData['checked'];
        } elseif ($validatedData['type'] === 'non_serialized') {
            $productType->non_serialized = $validatedData['checked'];
        }

        $productType->save();
        return response()->json(['status' => 'success', 'msg' => $validatedData['type'] === 'indivisible' ? 'Indivisible updated successfully.' : 'Non serialized updated successfully.']);
    }
}
