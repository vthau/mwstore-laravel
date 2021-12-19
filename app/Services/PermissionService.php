<?php

namespace App\Services;

use App\Repositories\PermissionRepository;

class PermissionService
{
    protected $sliderRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAll()
    {
        return $this->permissionRepository->getAll();
    }
}
