<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use Validator;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Season;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class ScheduleController extends Controller
{

    /**
     * @var Schedule
     */
    private $schedule;

    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ScheduleRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['quantity'] = (float) bntoen($request->input('quantity1') . '.' . $request->input('quantity2'));
        $request['discount'] = (float) bntoen($request->input('discount1') . '.' . $request->input('discount2'));
        $request['advance']  = (float) bntoen($request->input('advance1')  . '.' . $request->input('advance2'));

        $validation = Validator::make(
            $request->except([
                'quantity1', 'quantity2', 'discount1', 'discount2', 'advance1', 'advance2', '_token'
            ]),
            [
            'season_id'    => 'required',
            'business_id'  => 'required',
            'customer_id'  => 'required',
            'event_date'   => 'required|date',
            'quantity'     => 'required|numeric',
            'advance'      => 'numeric',
            'discount'      => 'numeric',
        ]);

        if($validation->fails())
        {
            return response()->json(['error' => $validation->errors()]);
        }

        $advance = $request->input('advance');

        $schedule = $this->schedule->create($request->all());

        if( $advance && (float) $advance > 0)
        {
            Payment::create([
                "schedule_id" => $schedule->id,
                "amount"      => $advance,
            ]);
        }


        \Session::flash('success', 'New Schedule created !');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($business, $start = null, $end = null)
    {
       $start = $start ? $start . ' 00:00:01' : null;
       $end   = $end ? $end . ' 23:59:59' : ($start ? $start . ' 23:59:59' : null);


       $schedules = $this->schedule
                        ->with('payments', 'customer', 'business')
                        ->whereHas("season", function($query){
                            $query->where('active', 1);
                        })
                        ->where('business_id', $business);

       if($start && $end)
       {
            $schedules = $schedules->whereBetween('event_date', [Carbon::parse($start), Carbon::parse($end)]);
       }else
       {
           $active = Season::where('active', 1)->first();

           $start = $active->start_date->format('Y-m-d 00:00:01' );
           $end   = $active->end_date ? $active->end_date->format('Y-m-d 23:59:59' ) : Carbon::today()->addMonth();

           $schedules  = $schedules->whereBetween('event_date', [$start, $end]);
       }

       $schedules = $schedules->get();

       $result = "সিডিউলের তারিখ  : " . entobn(Carbon::parse($start)->format('M d, Y')) . " - " . entobn(Carbon::parse($end)->format('M d, Y'));



       return view('schedules.search', compact('schedules', 'result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = $this->schedule->find($id);

        return view('schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ScheduleRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request['quantity'] = (float) bntoen($request->input('quantity1') . '.' . $request->input('quantity2'));
        $request['discount'] = (float) bntoen($request->input('discount1') . '.' . $request->input('discount2'));

        $schedule = $this->schedule->find($id);

        $schedule->update($request->all());

        return response()->json(['success' => 'schedule updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = $this->schedule->find($id);

        $schedule->delete();

        \Session::flash('success', 'Schedule deleted successfully!');

        return response()->json(['success', 'schedule deleted'], 200);
    }
}
