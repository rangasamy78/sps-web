<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseCategory extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'expense_categories';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'expense_category_name',
        'expense_account',
    ];

    protected function expenseCategoryName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
        );
    }
    function linked_account()
    {
        return $this->belongsTo(LinkedAccount::class, 'expense_account');
    }
    
    public function getLinkedAccountDetailsAttribute()
    {
        $linkedAccount = $this->linked_account()->first();
        return $linkedAccount ? $linkedAccount->account_code . '-' . $linkedAccount->account_name : '';
    }
}
