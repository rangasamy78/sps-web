<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierInvoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'po_id',
        'sipl_bill',
        'entry_date',
        'invoice',
        'supplier_so',
        'ship_date',
        'invoice_date',
        'po_expiry_date',
        'payment_term_id',
        'due_date',
        'eta_date',
        'container_number',
        'delivery_method',
        'shipment_term_id',
        'payment_hold',
        'payment_hold_reason',
        'supplier_id',
        'supplier_address',
        'supplier_suite',
        'supplier_city',
        'supplier_state',
        'supplier_zip',
        'supplier_country_id',
        'purchase_location_id',
        'purchase_location_address',
        'purchase_location_suite',
        'purchase_location_city',
        'purchase_location_state',
        'purchase_location_zip',
        'purchase_location_country_id',
        'ship_to_location_id',
        'ship_to_location_attn',
        'ship_to_location_address',
        'ship_to_location_suite',
        'ship_to_location_city',
        'ship_to_location_state',
        'ship_to_location_zip',
        'ship_to_location_country_id',
        'freight_forwarder_id',
        'printed_notes',
        'internal_notes',
        'vessel',
        'air_bill',
        'planned_ex_factory',
        'ex_factory_date',
        'departure_port_id',
        'discharge_port_id',
        'etd_port',
        'arrival_port_id',
        'eta_port',
        'wiring_instruction_id',
        'item_total',
        'other_total',
        'total',
    ];
    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function shipment_term()
    {
        return $this->belongsTo(ShipmentTerm::class, 'shipment_term_id');
    }
    public function location()
    {
        return $this->belongsTo(Company::class, 'ship_to_location_id');
       
    }
    public function purchase_locations()
    {
        return $this->belongsTo(Company::class, 'purchase_location_id');
       
    }
    public function ship_locations()
    {
        return $this->belongsTo(Company::class, 'ship_to_location_id');
       
    }
    public function payment_terms()
    {
        return $this->belongsTo(AccountPaymentTerm::class, 'payment_term_id');
       
    }
    public function expenditure()
    {
        return $this->belongsTo(Expenditure::class, 'freight_forwarder_id');
       
    }
    
}