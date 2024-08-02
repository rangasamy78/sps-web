<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PickTicketRestriction extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pick_ticket_restrictions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enable_pick_ticket_restriction',
        'default_pick_ticket_restriction',
        'pick_ticket_restriction_required',
        'default_lot_restriction_based_on',
    ];
    
}
