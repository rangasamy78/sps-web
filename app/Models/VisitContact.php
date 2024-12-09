<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitContact extends Model
{
    use HasFactory;

    protected $fillable = ['visit_id', 'contact_id'];
    protected $table = 'visit_contacts';

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
