<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountFile extends Model
{
    use HasFactory;

    protected $fillable = ['file_name', 'notes', 'account_id'];
    protected $table = 'account_files';
}
