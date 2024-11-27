<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrintDocDisclaimer extends Model
{
    use HasFactory;

    protected $table = 'print_doc_disclaimers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'select_type_category_id',
        'select_type_sub_category_id',
        'policy',
    ];

    const PRE_PURCHASE_TERMS = "Pre Purchase Terms";

    public function select_type_category()
    {
        return $this->belongsTo(SelectTypeCategory::class);
    }

    public function select_type_sub_category()
    {
        return $this->belongsTo(SelectTypeSubCategory::class);
    }

}

