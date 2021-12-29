<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GasPrice extends Model
{
    use HasFactory;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'wei',
        'time',
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];
}
