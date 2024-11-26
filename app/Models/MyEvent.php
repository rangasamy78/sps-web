<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MyEvent extends Model
{
    use HasFactory;
    protected $table = 'events';
   /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
   protected $fillable = [
       'event_type_id', 'entered_by_id', 'assigned_to_id', 'schedule_date', 'schedule_time', 'event_title', 'follower_id', 'party_name', 'party_name_id', 'description', 'product_id', 'price'
   ];
   public function users()
   {
       return $this->belongsTo(User::class, 'entered_by_id');
   }
   public function assigned()
   {
       return $this->belongsTo(User::class, 'assigned_to_id');
   }
   public function follower()
   {
       return $this->hasMany(User::class, 'id');
   }
   public function type()
   {
       return $this->belongsTo(ProductType::class, 'event_type_id');
   }
   public function product()
   {
       return $this->hasMany(Product::class, 'product_id');
   }
   public function search_product()
   {
       return $this->belongsTo(Product::class, 'product_name');
   }
   public function event_type()
   {
       return $this->belongsTo(EventType::class, 'event_type_id');
   }
}
