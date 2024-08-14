<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SelectTypeSubCategory extends Model
{
    use HasFactory;
    
    protected $table = 'select_type_sub_categories';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'select_type_category_id',
        'select_type_sub_category_name',
    ];    
}
