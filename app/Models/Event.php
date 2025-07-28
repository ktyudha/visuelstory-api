<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Event extends Model
{
    use HasUuids;

    protected $fillable = [
        'package_id',
        'invoice_id',
        'note',
        'date',
        'location',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
