<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model {
    use HasFactory;

    protected $table = 'overtimes';

    protected $fillable = [
        'name',
        'dept',
        'ot_date',
        'salary',
        'in_time',
        'out_time',
        'hrs',
        'amount',
        'description',
    ];

    protected $casts = [
        'ot_date' => 'date',
        'salary'  => 'decimal:2',
        'hrs'     => 'decimal:2',
        'amount'  => 'decimal:2',
    ];
}
