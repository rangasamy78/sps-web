<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_category_name'
    ];

    public function sub_categories()
    {
        return $this->hasMany(ProductSubCategory::class);
    }


}