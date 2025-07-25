<?php

namespace App\Http\Repositories\Package;

use App\Http\Repositories\BaseRepository;
use App\Models\Package\Package;

class PackageRepository extends BaseRepository
{
    public function __construct(protected Package $package)
    {
        parent::__construct($package);
    }
}
