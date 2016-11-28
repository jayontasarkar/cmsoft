<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Schedule;
use Illuminate\Http\Request;

use App\Http\Requests;

class PaymentController extends Controller
{
    /**
     * @var Payment
     */
    private $payment;
    /**
     * @var Schedule
     */
    private $schedule;

    public function __construct(Payment $payment, Schedule $schedule)
    {
        $this->payment = $payment;
        $this->schedule = $schedule;

        $this->middleware('admin', ['only' => [
            'listPayments', 'update', 'destroy'
        ]]);
    }

    public function index($id = null)
    {
        $payments = $this->schedule
                    ->orderBy('event_date', 'desc')
                    ->with('payments', 'customer', 'business')
                    ->whereHas("season", function($query){
                        $query->where('active', 1);
                    });

        if($id)
        {
            $payments = $payments->where('business_id', $id);
        }

        $payments = $payments->get();

        return view('payments.index', compact('payments'));
    }


    public function store(Request $request)
    {
        $request['schedule_id'] = $request->input('id');

        $this->payment->create(
            $request->only(['schedule_id', 'amount'])
        );

        \Session::flash('success', 'Payment completed for ' . $request->input('name'));

        return response()->json(['success' => $request->except(['_token'])], 200);
    }

    public function listPayments()
    {
        $payments = $this->payment
                        ->orderBy('created_at', 'desc')
                        ->with('schedule', 'schedule.business', 'schedule.customer')
                        ->whereHas('schedule.season', function($query){
                            $query->where('seasons.active', 1);
                        })->get();

        return view('payments.list', compact('payments'));
    }

    public function update(Request $request, $id)
    {
        $payment = $this->payment->find($id);

        $payment->update($request->only('amount'));

        \Session::flash('success', 'Payment transaction amount updated successfully!');

        return response()->json(['success', 'updated!']);
    }

    public function destroy($id)
    {
        $payment = $this->payment->find($id);

        $payment->delete();

        \Session::flash('success', 'Payment transaction deleted successfully!');

        return response()->json(['success', 'updated!']);
    }
}
