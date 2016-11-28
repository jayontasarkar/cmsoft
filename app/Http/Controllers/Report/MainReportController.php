<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Season;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class MainReportController extends Controller
{
    /**
     * @var Season
     */
    private $season;

    public function __construct(Season $season)
    {
        $this->season = $season;

        $this->middleware('admin');
    }

    public function index($id = null)
    {
        $id = $id ? $id : $this->activeSeasonId()['id'];

        $season = $id ? $this->getSeasonInfo($id) : $this->activeSeasonId();

        $expenses = Expense::with('business', 'season', 'user')
                        ->where('season_id', $id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('reports.main.index', compact('expenses', 'season'));
    }

    public function income($id = null)
    {
        $id = $id ? $id : $this->activeSeasonId()['id'];

        $season = $id ? $this->getSeasonInfo($id) : $this->activeSeasonId();

        $collections = Payment::with('schedule.season', 'schedule.business', 'schedule.customer')
            ->whereHas('schedule', function($q) use ($id) {
                $q->where('season_id', $id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reports.main.income', compact('collections', 'season'));
    }

    public function due($id = null)
    {
        $id = $id ? $id : $this->activeSeasonId()['id'];

        $season = $id ? $this->getSeasonInfo($id) : $this->activeSeasonId();

        $dues = Schedule::with('customer', 'payments', 'season', 'business')->where('season_id', $id)->get();

        $result = [];
        $i = 0;

        foreach($dues as $due)
        {
            $result[$i] = [];

            $result[$i]['id'] = $due->customer->id;
            $result[$i]['name'] = $due->customer->name;
            $result[$i]['phone'] = $due->customer->phone;
            $result[$i]['business'] = $due->business->name;
            $result[$i]['rate'] = $due->business->rate;

            $amount = 0;

            if(is_array($due->payments->toArray()) && count($due->payments->toArray()))
            {

                foreach($due->payments->toArray() as $value)
                {
                    $amount += $value['amount'];
                }
            }

            $result[$i]['amount']  = $amount;
            $result[$i]['event']   = $due->event_date->format('M d, Y');
            $result[$i]['discount']   = $due->discount;
            $result[$i]['qty']   = $due->quantity;

            $i++;
        }

        $dues = collect($result)->groupBy('phone');

        return view('reports.main.due', compact('dues', 'season'));
    }

    public function balanceSheet($id = null)
    {
        $id = $id ? $id : $this->activeSeasonId()['id'];

        $season = $id ? $this->getSeasonInfo($id) : $this->activeSeasonId();

        $balances = Schedule::with('business', 'payments')
                        ->where('season_id', $id)
                        ->get();

        $qty   = 0;
        $total = 0;
        $discount = 0;
        $pay = 0;

        if(count($balances))
        {
            foreach($balances as $balance)
            {
                $qty += $balance->quantity;
                $total += $balance->quantity * $balance->business->rate;
                $discount += ($balance->quantity * $balance->business->rate * $balance->discount /100);

                if(count($balance->payments))
                {
                    foreach($balance->payments as $payment)
                    {
                        $pay += $payment->amount;
                    }
                }
            }
        }

        $expenses = Expense::where('season_id', $id)->sum('amount');

        $balancesheet = [
            'quantity' => $qty, 'total'   => $total, 'discount' => $discount,
            'payment'  => $pay, 'expense' => $expenses, 'due'   => $total - ($pay + $discount)
        ];

        return view('reports.main.balancesheet', compact('balancesheet', 'season'));

    }

    private function activeSeasonId()
    {
        return $this->season->where('active', 1)->first();
    }

    private function getSeasonInfo($id)
    {
        return $this->season->find($id);
    }
}
