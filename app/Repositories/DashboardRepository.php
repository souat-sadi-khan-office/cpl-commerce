<?php

namespace App\Repositories;

use App\Repositories\Interface\DashboardRepositoryInterface;


class DashboardRepository implements DashboardRepositoryInterface
{
    public function index($request)
    {
        return 1;
    }
    
}