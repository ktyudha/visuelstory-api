<?php

namespace App\Models\Package;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PackageAddOn extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
