<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialAccountType extends Model
{
    use HasFactory;
    protected $fillable = ['special_account_type_name'];
    protected $table = 'special_account_types';

    public function account()
    {
        return $this->hasMany(Account::class, 'special_account_type_id');
    }
}
