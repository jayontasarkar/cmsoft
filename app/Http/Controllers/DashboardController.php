<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Season;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class DashboardController extends Controller
{

    public function index()
    {

        $businesses = $this->getBusinessScheduleByDate()->where('id', '!=', 1)->get();

        return view('dashboard.index', compact('businesses'));
    }

    public function printSchedule($id)
    {
        $business = $this->getBusinessScheduleByDate()->where('id', $id)->first();

        return view('dashboard.schedule-print', compact('business'));

    }

    /**
     * @param $id
     * @return $this|\Illuminate\Database\Eloquent\Builder|static
     */
    private function getBusinessScheduleByDate()
    {
        $id = Season::where('active', 1)->first()['id'];

        return Business::with('schedules.customer')->with(['schedules' => function ($query) use ($id) {
            $query->where('season_id', 1)->whereBetween('event_date', [
                Carbon::today()->addSeconds(1), Carbon::today()->addHours(23)->addMinutes(59)->addSeconds(59)
            ]);
        }]);
    }

}
