<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleOrderContact extends Model
{
    use HasFactory;
    protected $fillable = ['sample_order_id', 'contact_id'];
    protected $table = 'sample_order_contacts';

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
