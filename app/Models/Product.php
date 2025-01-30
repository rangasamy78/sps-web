<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'product_sku',
        'product_kind_id',
        'product_alternate_name',
        'product_type_id',
        'product_base_color_id',
        'product_origin_id',
        'product_category_id',
        'product_sub_category_id',
        'product_group_id',
        'product_thickness_id',
        'product_finish_id',
        'product_series_name',
        'unit_of_measure_id',
        'product_weight',
        'product_size',
        'indivisible',
        'manufactured',
        'generic',
        'select_slab',
        'gl_inventory_link_account_id',
        'gl_income_account_id',
        'gl_cogs_account_id',
        'safety_stock',
        'safety_stock_value',
        'reorder_qty',
        'reorder_qty_value',
        'lead_time',
        'assign_bin_id',
        'preferred_supplier_id',
        'brand_or_manufacturer_id',
        'generic_name',
        'generic_sku',
        'purchasing_unit_id',
        'purchasing_unit_cost',
        'avg_est_cost',
        'new_product_flag',
        'hide_on_website_or_guest_book',
        'is_featured',
        'web_user_name',
        'description_on_web',
        'notes',
        'special_intstruction',
        'disclaimer',
        'homeowner_price',
        'bundle_price',
        'special_price',
        'loose_slab_price',
        'bundle_price_sqft',
        'special_price_per_sqft',
        'owner_approval_price',
        'loose_slab_per_slab',
        'bundle_price_per_slab',
        'special_price_per_slab',
        'owner_approval_price_per_slab',
        'price12',
        'price_range',
        'uom_one_id',
        'uom_one_value',
        'uom_two_id',
        'uom_two_value',
        'uom_three_id',
        'uom_three_value',
        'uom_four_id',
        'uom_four_value',
        'uom_five_id',
        'uom_five_value',
        'uom_six_id',
        'uom_six_value',
        'minimum_packing_unit_id',
        'minimum_packing_unit_value',
        'image'
    ];


    public function product_type()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
    public function product_sub_category()
    {
        return $this->belongsTo(ProductSubCategory::class);
    }
    public function product_group()
    {
        return $this->belongsTo(ProductGroup::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'product_origin_id');
    }
    public function product_price()
    {
        return $this->hasOne(ProductPrice::class);
    }
    public function price()
    {
        return $this->hasOne(ProductPrice::class);
    }
    public function product_color()
    {
        return $this->belongsTo(ProductColor::class, 'product_base_color_id');
    }
    public function unit_measure()
    {
        return $this->belongsTo(UnitMeasure::class, 'unit_of_measure_id');
    }
    public function product_kind()
    {
        return $this->belongsTo(ProductKind::class, 'product_kind_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'preferred_supplier_id');
    }
    public function preferred_brand()
    {
        return $this->belongsTo(Supplier::class, 'brand_or_manufacturer_id');
    }
    public function event()
    {
        return $this->hasMany(Event::class, 'product_id');
    }
    public function visit_product()
    {
        return $this->hasMany(VisitProduct::class, 'product_id');
    }
    public function product_item()
    {
        return $this->hasMany(SupplierInvoicePackingItem::class, 'product_id');
    }

}
