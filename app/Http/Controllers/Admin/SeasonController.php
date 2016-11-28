<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use Illuminate\Http\Request;

use Validator;

use App\Http\Requests;

class SeasonController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['except' => [
            'store', 'edit', 'update', 'destroy'
        ]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seasons = Season::orderBy('start_date', 'DESC')->get();
        return view('seasons.index', compact('seasons'));
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
        $validator = Validator::make($request->all(), [
           'name' => 'required|min:3',
            'start_date' => 'required'
        ]);

        if($validator->fails())
        {
            return response()-json([$validator->errors()]);
        }

        Season::create($request->all());

        \Session::flash('success', 'New season created successfully!');

        return response()->json(['success' => 'new season created'], 200);
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
        $season = Season::find($id);

        return response()->json([$season], 200);
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
            'name' => 'required|min:3',
            'start_date' => 'required'
        ]);

        if($validator->fails())
        {
            return response()-json([$validator->errors()]);
        }

        $season = Season::find($id);

        $season->update($request->all());

        \Session::flash('success', 'Season updated successfully!');

        return response()->json(['success' => 'season updated'], 200);
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
