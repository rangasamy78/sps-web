<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpportunityContact extends Model
{
    use HasFactory;

    protected $fillable = ['opportunity_id', 'contact_id'];
    protected $table = 'opportunity_contacts';

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
