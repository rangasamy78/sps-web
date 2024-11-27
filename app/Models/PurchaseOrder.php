<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $table = 'purchase_orders';

    protected $fillable = [
        'po_number',
        'po_date',
        'supplier_so_number',
        'required_ship_date',
        'eta_date',
        'po_expiry_date',
        'container_number',
        'shipment_term_id',
        'supplier_id',
        'supplier_address_id',
        'supplier_address',
        'supplier_suite',
        'supplier_city',
        'supplier_state',
        'supplier_zip',
        'supplier_country_id',
        'payment_term_id',
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
        'printed_notes',
        'internal_notes',
        'special_instruction_id',
        'special_instructions',
        'pre_purchase_term_id',
        'terms',
        'conversion_rate',
        'freight_forwarder_id',
        'vessel',
        'air_bill',
        'planned_ex_factory',
        'ex_factory_date',
        'departure_port_id',
        'arrival_port_id',
        'discharge_port_id',
        'etd_port',
        'eta_port',
        'wiring_instruction_id',
    ];
  
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
    public function payment_term()
    {
        return $this->belongsTo(AccountPaymentTerm::class, 'payment_term_id');
       
    }
}