<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Season;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class SubReportController extends Controller
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

    public function listSubgroups()
    {
        $businesses = Business::where('id', '!=', 1)->get();

        return view('reports.subgroup.index', compact('businesses'));
    }

    public function expense($group, $id = null)
    {
        $id = $id ? $id : $this->activeSeasonId()['id'];

        $season = $id ? $this->getSeasonInfo($id) : $this->activeSeasonId();

        $business = $this->getBusinessInfo($group);

        $expenses = Expense::with('business', 'season', 'user')
                        ->where('season_id', $id)
                        ->where('business_id', $group)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('reports.subgroup.expense', compact('expenses', 'season', 'business'));
    }

    public function income($group, $id = null)
    {
        $id = $id ? $id : $this->activeSeasonId()['id'];

        $season = $id ? $this->getSeasonInfo($id) : $this->activeSeasonId();
        $business = $this->getBusinessInfo($group);

        $collections = Payment::with('schedule.season', 'schedule.business', 'schedule.customer')
            ->whereHas('schedule', function($q) use ($group, $id) {
                $q->where('season_id', $id);
                $q->where('business_id', $group);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reports.subgroup.income', compact('collections', 'season', 'business'));
    }

    public function due($group, $id = null)
    {
        $id = $id ? $id : $this->activeSeasonId()['id'];

        $season = $id ? $this->getSeasonInfo($id) : $this->activeSeasonId();
        $business = $this->getBusinessInfo($group);

        $dues = Schedule::
                        with('customer', 'payments', 'season', 'business')
                        ->where('season_id', $id)
                        ->where('business_id', $group)
                        ->get();

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

        return view('reports.subgroup.due', compact('dues', 'season', 'business'));
    }

    public function balanceSheet($group, $id = null)
    {
        $id = $id ? $id : $this->activeSeasonId()['id'];

        $season = $id ? $this->getSeasonInfo($id) : $this->activeSeasonId();
        $business = $this->getBusinessInfo($group);
        $balances = Schedule::with('business', 'payments')
                        ->where('business_id', $group)
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

        $expenses = Expense::where('season_id', $id)->where('business_id', $group)->sum('amount');

        $balancesheet = [
            'quantity' => $qty, 'total'   => $total, 'discount' => $discount,
            'payment'  => $pay, 'expense' => $expenses, 'due'   => $total - ($discount + $pay)
        ];

        return view('reports.subgroup.balancesheet', compact('balancesheet', 'season', 'business'));

    }

    private function activeSeasonId()
    {
        return $this->season->where('active', 1)->first();
    }

    private function getSeasonInfo($id)
    {
        return $this->season->find($id);
    }

    private function getBusinessInfo($id)
    {
        return Business::find($id);
    }
}
