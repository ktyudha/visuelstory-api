<?php

namespace App\Models\Package;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PackageAddOn extends Model
{
    use HasUuids;

    protected $table = 'package_addons';

    protected $fillable = [
        'name',
        'price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function scopeFilters($query, array $filters): void
    {
        // Filter name
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
    }
}
