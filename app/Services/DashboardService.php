<?php

namespace App\Services;

use App\Models\Vistor;

/**
 * Class DashboardService.
 */
class DashboardService
{

    public static function todayVistors()
    {

        $todayVistors = number_format(Vistor::where('created_at', 'like', '%' . date('Y-m-d') . '%')->count());
        return $todayVistors;
    }
    public static function allVistors()
    {
        $allVistors =  Vistor::count();
        return $allVistors;
    }
}
