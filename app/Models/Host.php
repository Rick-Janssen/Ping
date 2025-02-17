<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'ip',
        'location',
        'provider_id',
        'provider_name',
        'type',

    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
