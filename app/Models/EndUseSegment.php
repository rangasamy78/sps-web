<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EndUseSegment extends Model
{
   use HasFactory;
   /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'end_use_segments';
   /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $fillable = [
      'end_use_segment'
   ];

   public function opportunity()
   {
      return $this->hasMany(Opportunity::class, 'project_type_id');
   }
}
