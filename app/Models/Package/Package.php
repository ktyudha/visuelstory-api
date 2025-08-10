<?php

namespace App\Models\Package;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Package extends Model
{
    use HasUuids;

    protected $fillable = [
        'package_category_id',
        'name',
        'description',
        'price',
        'discount',
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

    public function getFinalPriceAttribute()
    {
        $discountAmount = ($this->price * $this->discount) / 100;
        return max($this->price - $discountAmount, 0);
    }

    public function packageCategory()
    {
        return $this->belongsTo(PackageCategory::class);
    }
}
