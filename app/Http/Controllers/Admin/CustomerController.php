<?php

namespace App\Http\Controllers\Admin;

use App\Models\Business;
use App\Models\Season;
use Validator;
use App\Models\Customer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * @var Customer
     */
    private $customer;

    public function __construct(Customer $customer)
    {

        $this->customer = $customer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = $this->customer->with('area')->orderBy('name')->get();

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['phone'] = bntoen($request->input('phone'));

        $validator = Validator::make($request->all(), [
           'name'      => 'required|min:4',
           'phone'     => 'required|min:11|max:11|unique:users,phone',
           'area_id'   => 'required|exists:areas,id'
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => $validator->errors()]);
        }

        $this->customer->create($request->all());

        \Session::flash('success', 'New Customer created successfully');

        return response()->json(['success', 'New Customer created successfully!'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $current = Season::where('active', 1)->first()['id'];

        $info = $this->getSeasonInfo($current);

        $customer = $this->customer
            ->with('area', 'schedules.payments', 'schedules.business', 'schedules.season')
            ->with(['schedules' => function($query) use($current) {
                $query->where('season_id', $current);
            }])
            ->find($id);

        return view('customers.profile', compact('customer', 'info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = $this->customer->find($id);

        return response()->json([$customer], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|min:4',
            'phone'     => 'required|min:11|max:11|unique:customers,phone,' . $id,
            'area_id'   => 'required|exists:areas,id'
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => $validator->errors()]);
        }

        $customer = $this->customer->find($id);

        $customer->update($request->all());

        \Session::flash('success', 'Customer information edited successfully');

        return response()->json(['success', 'Customer information updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function previousReports($id, $season = null)
    {
        $season = $season ? $season : Season::where('active', 1)->first()['id'];

        $info = $this->getSeasonInfo($season);

        $customer = $this->customer
            ->with('area', 'schedules.payments', 'schedules.business')
            ->with(['schedules' => function($query) use ($id, $season) {
                $query->where('schedules.customer_id', $id)
                    ->where('schedules.season_id', $season);
            }])
            ->find($id);

        return view('customers.reports', compact('customer', 'info'));
    }

    public function printReport($id, $season)
    {
        $business = Business::find(1);

        $info = $this->getSeasonInfo($season);

        $customer = $this->customer
            ->with('area', 'schedules.payments', 'schedules.business')
            ->with(['schedules' => function($query) use ($id, $season) {
                $query->where('schedules.customer_id', $id)
                    ->where('schedules.season_id', $season);
            }])
            ->find($id);

        return view('customers.report-print', compact('customer', 'business', 'info'));
    }

    private function getSeasonInfo($id)
    {
        return Season::where('id', $id)->first();
    }
}
