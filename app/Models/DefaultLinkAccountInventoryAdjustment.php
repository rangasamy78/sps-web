<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultLinkAccountInventoryAdjustment extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'default_link_account_inventory_adjustments';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'positive_adjustment_id',
        'inventory_write_off_id',
        'reclassify_renumbering_split_id',
        'revaluation_adjustment_id',
    ];
}
