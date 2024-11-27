<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['entered_by_id', 'event_type_id', 'schedule_date', 'schedule_time', 'assigned_to_id', 'follower_id', 'event_title', 'party_name', 'product_id', 'price', 'description', 'type', 'type_id', 'mark_as_complete'];

    protected $table = 'events';

    const PREPURREQUEST = 'pre_purchase_request';

    public function user()
    {
        return $this->belongsTo(User::class, 'entered_by_id');
    }
    public function assigned_user()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }
    public function event_type()
    {
        return $this->belongsTo(EventType::class, 'event_type_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
