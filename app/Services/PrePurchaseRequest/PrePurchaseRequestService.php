<?php

namespace App\Services\PrePurchaseRequest;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\PrintDocDisclaimer;

class PrePurchaseRequestService
{
    public function getSupplierAddress($supplierId)
    {
        $supplier = Supplier::find($supplierId);
        $contacts = Contact::query()
                    ->where('type', Contact::SUPPLIER)
                    ->where('type_id', $supplierId)
                    ->get();
        if (!$supplier) {
            return [ 'error' => 'supplier not found'];
        }
        return [
            'name' => $supplier->supplier_name,
            'supplier_address' => $supplier->remit_address,
            'supplier_suite' => $supplier->remit_suite,
            'supplier_city' => $supplier->remit_city,
            'supplier_state' => $supplier->remit_state,
            'supplier_zip' => $supplier->remit_zip,
            'supplier_country_id' => $supplier->remit_country_id,
            'payment_term_id' => $supplier->payment_terms_id,
            'shipment_term_id' => $supplier->shipment_terms_id,
            'contacts' => $contacts,
        ];
    }

    public function getSupplierPrimaryAddress($contactId)
    {
        $contacts = Contact::query()
                    ->where('type', Contact::SUPPLIER)
                    ->find( $contactId);

        if (!$contacts) {
            return [ 'error' => 'contacts not found'];
        }
        return [
            'address' => $contacts->address,
            'address2' => $contacts->address_2,
            'city' => $contacts->city,
            'state' => $contacts->state,
            'zip' => $contacts->zip,
            'country_id' => $contacts->country_id,
        ];
    }

    public function getPurchaseLocationAddress($companyId)
    {
        $company = Company::find($companyId);
        if (!$company) {
            return [ 'error' => 'Purchase location address not found'];
        }
        return [
            'address' => $company->address_line_1,
            'city' => $company->city,
            'state' => $company->state,
            'zip' => $company->zip,
            'country_id' => Country::where('country_name', Country::UNITED_STATES)->value('id'),
        ];
    }

    public function getShipToLocationAddress($companyId)
    {
        $company = Company::find($companyId);
        if (!$company) {
            return [ 'error' => 'Ship to location address not found'];
        }
        return [
            'address' => $company->address_line_1,
            'city' => $company->city,
            'state' => $company->state,
            'zip' => $company->zip,
            'country_id' => Country::where('country_name', Country::UNITED_STATES)->value('id'),
        ];
    }

    public function getPrePurchaseTermPolicy($prePurchaseTermId)
    {
        $result = PrintDocDisclaimer::find($prePurchaseTermId);
        if (!$result) {
            return [ 'error' => 'policy not found'];
        }
        return [
            'policy' => strip_tags($result->policy),
        ];
    }

    public function getPrePurchaseRequestProductDetails($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return [ 'error' => 'product not found'];
        }
        return [
            'product_name' => $product->product_name,
            'product_sku' => $product->product_sku,
            'purchasing_unit_id' => $product->purchasing_unit_id,
            'avg_est_cost' => $product->avg_est_cost ? $product->avg_est_cost : "57.75",
            'length' => 126,
            'width' => 63,
        ];
    }

    public function getContactAddress($contactId)
    {
        $contact = Contact::query()
                    ->where('type', Contact::SUPPLIER)
                    ->where('id', $contactId)
                    ->first();

        if (!$contact) {
            return [ 'error' => 'contact not found'];
        }
        return [
            'email' => $contact->email,
        ];
    }
}
