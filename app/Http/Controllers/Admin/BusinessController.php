<?php

namespace App\Http\Controllers\Admin;

use App\Models\Business;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class BusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $businesses = Business::with('areas', 'parent')->where('id', '!=', 1)->get();

        return view('businesses.index', compact('businesses'));
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
        $request['rate'] = bntoen($request->input('rate'));

        $validation = Validator::make($request->all(), [
           'name'        => 'required|unique:businesses,name',
           'business_id' => 'required|exists:businesses,id',
           'rate' => 'required|numeric',
        ]);

        if($validation->fails())
        {
            return response()->json(['error' => $validation->errors()]);
        }

        Business::create($request->all());

        \Session::flash('success', 'New Business Subgroup created successfully!');

        return response()->json(['success' => 'Business Created Successfully!'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $business = Business::find($id);

        return response()->json([$business], 200);
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
        $request['rate'] = bntoen($request->input('rate'));

        $validation = Validator::make($request->all(), [
            'name'        => 'required|unique:businesses,name,' . $id,
            'business_id' => 'required|exists:businesses,id',
            'rate' => 'required|numeric',
        ]);

        if($validation->fails())
        {
            return response()->json(['error' => $validation->errors()]);
        }

        $business = Business::find($id);

        $business->update($request->all());

        \Session::flash('success', "`{$business->name}` Subgroup updated successfully!");

        return response()->json(['success', 'Business updated successfully'], 200);

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
}
