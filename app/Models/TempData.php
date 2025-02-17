<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempData extends Model
{
    const UPDATED_AT = null;
    use HasFactory;
    protected $fillable = [
        'id',
        'host_id',
        'host_name',
        'ms',
        'created_at',
    ];
}
