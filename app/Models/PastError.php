<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastError extends Model
{
    use HasFactory;

    protected $table = 'past_errors';


    protected $fillable = [
        'host_name',
        'error',
    ];
}
