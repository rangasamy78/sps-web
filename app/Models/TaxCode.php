<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxCode extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tax_codes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sort_order',
        'tax_code',
        'tax_code_label',
        'notes',
        'is_sale_use',
        'effective_date'
    ];

    public function tax_code_component()
    {
        return $this->hasMany(TaxCodeComponent::class);
    }
    public function opportunity()
    {
        return $this->hasMany(Opportunity::class, 'sales_tax_id');
    }
}
