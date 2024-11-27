<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpportunityStage extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'opportunity_stages';
   /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
   protected $fillable = [
       'opportunity_stage'
   ];

    protected function opportunityStage(): Attribute
    {
       return Attribute::make(
           get: fn (string $value) => ucfirst($value),
       );
    }

    public function Opportunity()
    {
        return $this->hasMany(Opportunity::class, 'opportunity_stage_id');
    }

}
