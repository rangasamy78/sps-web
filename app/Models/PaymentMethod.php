<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_methods';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'payment_method_name',
        'linked_account_id',
        'account_type_id',
        'is_transaction_required',
    ];

    protected function paymentMethodName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
        );
    }

    function linked_account()
    {
        return $this->belongsTo(Account::class);
    }

    function account_type()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function getLinkedAccountDetailsAttribute()
    {
        $linkedAccount = $this->linked_account()->first();
        return $linkedAccount ? $linkedAccount->account_code . '-' . $linkedAccount->account_name : '';
    }
}
