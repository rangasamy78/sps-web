<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectType extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_types';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_type_name',
    ];

    protected function projectTypeName(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value),
        );
    }
    public function opportunity()
    {
        return $this->hasMany(Opportunity::class, 'end_use_segment_id');
    }

    public function quote()
    {
        return $this->hasMany(Quote::class, 'project_type_id', 'id');
    }
    public function hold()
    {
        return $this->hasMany(Hold::class, 'project_type_id');
    }
    public function visit()
    {
        return $this->hasMany(Visit::class, 'project_type_id');
    }
    public function sample_order()
    {
        return $this->hasMany(SampleOrder::class, 'project_type_id');
    }
}
