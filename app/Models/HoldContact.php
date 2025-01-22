<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoldContact extends Model
{
    use HasFactory;
    protected $fillable = ['hold_id', 'contact_id'];
    protected $table = 'hold_contacts';

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
