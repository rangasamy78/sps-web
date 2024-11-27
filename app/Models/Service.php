<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    public const IMAGE_FOLDER = 'service';

    protected $fillable = [
        'service_name',
        'service_sku',
        'unit_of_measure_id',
        'service_category_id',
        'service_type_id',
        'service_group_id',
        'expenditure_id',
        'avg_est_cost',
        'gl_sales_account_id',
        'gl_cost_of_sales_account_id',
        'is_taxable_item',
        'frequent_in_so',
        'frequent_in_customer_cm',
        'frequent_in_po',
        'frequent_in_supplier_cm',
        'notes',
        'internal_instruction',
        'disclaimer',
        'service_image',
        'status'
    ];
    public function unit_measures()
    {
        return $this->belongsTo(UnitMeasure::class, 'unit_of_measure_id');
    }
    public function service_categories()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }
    public function service_types()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }
    public function service_group()
    {
        return $this->belongsTo(ProductGroup::class);
    }
    public function service_price()
    {
        return $this->hasOne(ServicePrice::class, 'service_id', 'id');
    }
    public function Service_expenditure()
    {
        return $this->belongsTo(Expenditure::class);
    }
    public function visit_service()
    {
        return $this->hasMany(VisitService::class, 'service_id');
    }
}
