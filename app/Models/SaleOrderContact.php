<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleOrderContact extends Model
{
    use HasFactory;

    protected $fillable = ['sales_order_id', 'contact_id'];
    protected $table = 'sale_order_contacts';

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
