<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class ExpenseController extends Controller
{
    /**
     * @var Expense
     */
    private $expense;

    public function __construct(Expense $expense)
    {

        $this->expense = $expense;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = $this->expense
                    ->with('user', 'season', 'business')
                    ->whereHas('season', function($query){
                        $query->where('active', 1);
                    })
                    ->orderBy('created_at', 'DESC')
                    ->get();

        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExpenseRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        $request['user_id'] = auth()->user()->id;

        if($request->input('expense_date') && !empty($request->input('expense_date')))
            $request['created_at'] = Carbon::parse(( ! $request->input('expense_date') ? date('Y-m-d') : $request->input('expense_date')) . " 14:00:00");

        $this->expense->create($request->all());

        \Session::flash('success', 'New expense bill created successfully!');

        return redirect('expense');
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
        $expense = $this->expense->find($id);

        return view('expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExpenseRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseRequest $request, $id)
    {
        $expense = $this->expense->find($id);

        $expense->update($request->all());

        \Session::flash('success', 'Expense bill updated successfully!');

        return redirect('expense');
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
