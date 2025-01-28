<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBinType extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'customer_bin_types';
   /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
   protected $fillable = [
       'label',
       'customer_id',
       'type',
       'x',
       'y',
       'z',
       'length',
       'width',
       'height',
       'zone',
       'bin_type_id',
       'entered_by_id',
       'notes'
   ];

    function bin_type()
    {
        return $this->belongsTo(BinType::class);
    }

    function user()
    {
        return $this->belongsTo(User::class, 'entered_by_id', 'id');
    }
}
