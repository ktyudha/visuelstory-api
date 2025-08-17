<?php

namespace App\Http\Repositories\Package;

use App\Http\Repositories\BaseRepository;
use App\Models\Package\PackageAddOn;

class PackageAddOnRepository extends BaseRepository
{
    public function __construct(protected PackageAddOn $packageAddOn)
    {
        parent::__construct($packageAddOn);
    }
}
