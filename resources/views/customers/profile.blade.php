@extends('templates.master')

@section('page')
	{{ $customer->name }} | কাস্টমার প্রোফাইল
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'সদস্যর প্রোফাইল ', 'links' => [$customer->name => 'customer/' . $customer->id]])
@stop

@section('box-title')
    {{ ucwords($customer->name) }} &nbsp;&nbsp;
    <small>মোবাইল নং : {{ entobn($customer->phone) }} &nbsp;&nbsp;</small>
@stop

@section('content')
<h4>
    বর্তমান/অ্যাক্টিভ সিজনের ট্রানজেকশন রিপোর্ট :
    ({{ entobn($info['start_date']->format('M d, Y')) }} &nbsp;-&nbsp;
    {{ $info['end_date'] ?
            entobn($info['end_date']->format('M d, Y')) : 'বর্তমান' }})
</h4>
<div class="table-responsive">
    <table class="table table-bordered tbl-transaction">
        <thead >
            <tr>
                <th class="text-center"></th>
                <th class="text-center">সেচ প্রকল্পের নাম</th>
                <th class="text-center">জমির পরিমাণ (একর)</th>
                <th class="text-center">সেচের তারিখ</th>
                <th class="text-center"> ট্রানজেকশন রিপোর্ট</th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; $total_payments = 0; $total_due = 0;?>
        @if(count($customer->schedules))
        @foreach($customer->schedules as $schedule)
            @if($schedule->business && $schedule->payments)
                <tr>
                    <td style="display: table-cell; vertical-align: middle;">{{ entobn($i) }}</td>
                    <td style="display: table-cell; vertical-align: middle;" class="text-center">
                        {{ $schedule->business->name }} ({{ entobn($schedule->business->rate)  }} টাকা/একর)
                    </td>
                    <td style="display: table-cell; vertical-align: middle;font-weight: bold;" class="text-center">
                        {{ entobn($schedule->quantity) }} একর
                    </td>
                    <td style="display: table-cell; vertical-align: middle;" class="text-center">
                        {{ entobn($schedule->event_date->format("m/d/Y")) }}
                    </td>
                    <td style="margin: 0;padding: 0;">
                        <table class="table table-bordered" style="margin: 0; padding: 0;">
                            <?php $total = 0; ?>
                            @foreach($schedule->payments as $payment)
                            <tr>
                                <td style="text-align: center;">{{ entobn($payment->created_at->format("M d, Y")) }}</td>
                                <td style="text-align: right;">{{ entobn($payment->amount) }}/=</td>
                            </tr>
                            <?php $total = $total + $payment->amount?>
                            @endforeach
                            <?php $total_payments += $total; ?> 
                                <tr>
                                    <td><b>মোট প্রদান : </b></td>
                                    <td style="text-align: right;">{{ $total ? entobn($total) : '০.০০' }}/=</td>
                                </tr>
                        </table>
                    </td>
                    <td style="margin: 0; padding: 0">
                       <table class="table">
                           <tr>
                               <td>মোট পরিমাণ :</td>
                               <td style="text-align: right;">{{ entobn($schedule->business->rate * $schedule->quantity) }}/=</td>
                           </tr>
                           <tr>
                               <td>ডিস্কাউন্ট ({{entobn($schedule->discount)}}%):</td>
                               <td style="text-align: right;">
                                   {{ $schedule->discount ? entobn(($schedule->discount * $schedule->business->rate)/100) : '০.০০' }}/=
                               </td>
                           </tr>
                           <tr>
                               <td>প্রদান :</td>
                               <td style="text-align: right;">
                                   {{ $total ? entobn($total) : '০.০০' }}/=
                               </td>
                           </tr>
                           <tr>
                               <td>বকেয়া :</td>
                               <?php $dues = ($schedule->business->rate * $schedule->quantity) - ( $total + ($schedule->discount * $schedule->business->rate)/100) ?>
                               <td style="text-align: right;">{{ entobn($dues) }}/=</td>
                           </tr>
                       </table>
                    </td>
                </tr>
            @endif
         <?php $i++; $total_due += $dues; ?>
        @endforeach
        <tfoot>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">সর্বমোট  প্রদান : {{ entobn($total_payments) }}/=</td>
            <td class="text-right"> সর্বমোট বকেয়া : {{ entobn($total_due) }}/=</td>
          </tr>
        </tfoot>
        @else
            <tr>
                <td colspan="6" class="text-center text-danger" style="font-size: 19px;">
                    কোন ট্রানজেকশন রিপোর্ট খুঁজে পাওয়া যায় নি
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-md-6">
        <span style="font-size: 19px;">
            <a href="{{ url('customer/'.$customer->id.'/report') }}">সকল সিজনের ট্রানজেকশন রিপোর্ট</a>
        </span>
    </div>
    <div class="col-md-6" style="text-align: right;">
        @if(count($customer->schedules))
        <a href="{{ url('customers/'.$customer->id.'/reports/'.$info['id'].'/print') }}"
           target="_blank" class="btn btn-default">
            <i class="fa fa-print"></i> প্রিন্ট রিপোর্ট
        </a>
        @endif
    </div>
</div>


@stop


@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.collapsible').collapsible({

            });
        });
    </script>
@stop