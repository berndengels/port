<?php
namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use Carbon\Carbon;
use App\Models\CaravanDates;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class AdminDashboardController extends AdminController
{
//    protected $caravansFromToday;
/*
    public function __construct()
    {
        $today = Carbon::today()->format('Y-m-d');
        $data = CaravanDates::with('caravan')
            ->whereRaw('DATE(?) BETWEEN `from` AND `until`', [$today])
            ->get();
        if($data->count() > 0) {
            $this->caravansFromToday = $data->map(
                function ($item) {
                    return $item->caravan->carnumber;
                }
            )->sort();
        }
    }
*/
    public function show()
    {
        return view('admin.vue-dashboard');
    }
}
