<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaxCodeComponent extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tax_code_components';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tax_code_id',
        'tax_component_id',
        'rate',
        'gl_account_name',
    ];

    public function tax_code()
    {
        return $this->belongsTo(TaxCode::class, 'tax_code_id');
    }
}
