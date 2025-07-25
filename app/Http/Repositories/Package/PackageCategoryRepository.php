<?php

namespace App\Http\Repositories\Package;

use App\Http\Repositories\BaseRepository;
use App\Models\Package\PackageCategory;

class PackageCategoryRepository extends BaseRepository
{
    public function __construct(protected PackageCategory $packageCategory)
    {
        parent::__construct($packageCategory);
    }
}
