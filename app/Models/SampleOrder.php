<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleOrder extends Model
{
    use HasFactory;

    protected $fillable = ['opportunity_id', 'sample_order_label', 'sample_order_date', 'sample_order_time', 'sales_person_id', 'delivery_type', 'delivery_attn', 'delivery_tracking', 'delivery_address', 'delivery_suite', 'delivery_city', 'delivery_state', 'delivery_zip', 'delivery_country_id', 'delivery_county_id', 'document_footer_id', 'sample_order_printed_notes', 'sample_order_special_instructions', 'probability_close_id', 'status', 'total'];

    protected $table = 'sample_orders';
    const STATUS_CREATED = 'created';
    const STATUS_READY_TO_SHIP = 'ready_to_ship';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_CLOSED = 'closed';

    public static $statuses = [
        self::STATUS_CREATED,
        self::STATUS_READY_TO_SHIP,
        self::STATUS_SHIPPED,
        self::STATUS_CLOSED,
    ];
    public function opportunities()
    {
        return $this->belongsTo(Opportunity::class, 'opportunity_id');
    }

    public function sample_order_products()
    {
        return $this->hasMany(SampleOrderProduct::class, 'sample_order_id');
    }

    public function sample_order_services()
    {
        return $this->hasMany(SampleOrderService::class, 'sample_order_id');
    }
}
