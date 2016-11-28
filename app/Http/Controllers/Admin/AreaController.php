<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['only' => [
            'store', 'edit', 'update'
        ]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Area::with('business')->orderBy('name')->get();

        return view('areas.index', compact('areas'));
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
        $validation = Validator::make($request->all(), [
            'name'        => 'required|unique:areas,name',
            'business_id' => 'required|exists:businesses,id',
        ]);

        if($validation->fails())
        {
            return response()->json(['error' => $validation->errors()]);
        }

        Area::create($request->all());

        \Session::flash('success', 'New Area created successfully!');

        return response()->json(['success' => 'Area Created Successfully!'], 200);
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
        $area = Area::find($id);

        return response()->json([$area], 200);
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
        $validation = Validator::make($request->all(), [
            'name'        => 'required|unique:areas,name,' . $id,
            'business_id' => 'required|exists:businesses,id',
        ]);

        if($validation->fails())
        {
            return response()->json(['error' => $validation->errors()]);
        }

        $area = Area::find($id);

        $area->update($request->all());

        \Session::flash('success', "`{$area->name}` Area updated successfully!");

        return response()->json(['success' => 'Area Updated Successfully!'], 200);
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

    public function listCustomers($id)
    {
        $area = Area::with('customers')->whereId($id)->first();

        return view('areas.customers', compact('area'));
    }
}
