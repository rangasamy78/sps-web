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
   public function quote()
   {
      return $this->hasMany(Quote::class, 'end_use_segment_id', 'id');
   }
   public function sample_order()
   {
      return $this->hasMany(SampleOrder::class, 'end_use_segment_id', 'id');
   }
   public function visit()
   {
      return $this->hasMany(Visit::class, 'end_use_segment_id', 'id');
   }
}
