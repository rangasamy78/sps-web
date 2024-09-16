<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LinkedAccount extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'linked_accounts';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_code',
        'account_name',
        'account_type',
        'account_sub_type',
    ];

    protected function accountName(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value),
        );
    }

    function expense_category()
    {
        return $this->hasMany(ExpenseCategory::class);
    }

    function payment_method()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    function linked_account_type()
    {
        return $this->belongsTo(AccountType::class, 'account_type');
    }

    function linked_account_sub_type()
    {
        return $this->belongsTo(AccountSubType::class, 'account_sub_type');
    }
}
