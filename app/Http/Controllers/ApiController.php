<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Schedule;
use Illuminate\Http\Request;

use App\Http\Requests;

class ApiController extends Controller
{
    public function areasByBusiness($id)
    {
        $areas = Area::where('business_id', $id)->get();

        return response()->json([$areas], 200);
    }

    public function completeSchedule(Request $request)
    {
        foreach($request->input('data') as $id)
        {
            $schedule = Schedule::find($id['id']);

            $schedule->completed = 1;

            $schedule->save();
        }

        \Session::flash('success', 'Selected schedules are completed');

        return response()->json(['success' => 'selected schedules'], 200);
    }

    public function IncompleteSchedule($id)
    {
        $schedule = Schedule::find($id);

        $schedule->completed = 0;

        $schedule->save();

        \Session::flash('success', 'Schedule status changed successfully!');

        return response()->json(['success' => 'selected schedules'], 200);
    }

}
