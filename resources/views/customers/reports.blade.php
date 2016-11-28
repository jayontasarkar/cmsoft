@extends('templates.master')

@section('page')
	{{ $customer->name }} | কাস্টমার প্রোফাইল
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', [
	    'title' => 'সদস্যর প্রোফাইল ',
	    'links' => [$customer->name => 'customer/' . $customer->id, 'রিপোর্ট' => '#']
	])
@stop

@section('box-title')
    {{ ucwords($customer->name) }}&nbsp;&nbsp;
    <small>মোবাইল নং : {{ entobn($customer->phone) }} &nbsp;&nbsp; </small>
@stop

@section('content')
<div class="form-group">
    <div class="col-md-5" style="font-weight: bold; font-size: 19px;">
        রিপোর্ট দেখার জন্য সিজন সিলেক্ট করুন :
    </div>
    <div class="col-md-4">
        @include('templates.composers.seasonSelect', ['id' => Request::segment(4) ? Request::segment(4) : 1])
    </div>
</div>
<br><br>
<h4 class="text-center">
    {{ $info['name'] }} ({{ entobn($info['start_date']->format('M d, Y')) }} &nbsp;-&nbsp;
    {{ $info['end_date'] ?
            entobn($info['end_date']->format('M d, Y')) : 'বর্তমান' }}) &nbsp;&nbsp;  সিজনের ট্রানজেকশন রিপোর্ট
</h4>
<div class="table-responsive">
    <table class="table table-bordered tbl-transaction">
        <thead >
            <tr>
                <th class="text-center"></th>
                <th class="text-center">সেচ প্রকল্পের নাম</th>
                <th class="text-center">জমির পরিমাণ(একর)</th>
                <th class="text-center"> সেচের তারিখ </th>
                <th class="text-center"> ট্রানজেকশন রিপোর্ট </th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; $total_paid = 0; $total_discount = 0; $total_due = 0; ?>
        @if(count($customer->schedules))
        @foreach($customer->schedules as $schedule)
            @if($schedule->business && $schedule->payments && $schedule->season)
                <tr>
                    <td style="display: table-cell; vertical-align: middle;">{{ entobn($i) }}</td>
                    <td style="display: table-cell; vertical-align: middle;">
                        {{ $schedule->business->name }} ( {{ entobn($schedule->business->rate) }} টাকা/একর))
                    </td>
                    <td style="display: table-cell; vertical-align: middle;font-weight: bold;">
                        {{ entobn($schedule->quantity) }} একর
                    </td>
                    <td style="display: table-cell; vertical-align: middle;">
                        {{ entobn($schedule->event_date->format("M d, Y")) }}
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
                               <?php $qty = $schedule->business->rate * $schedule->quantity; ?>
                               <td style="text-align: right;">{{ entobn($qty) }}/=</td>
                           </tr>
                           <tr>
                               <td>ডিস্কাউন্ট ({{entobn($schedule->discount)}}%):</td>
                               <?php $dis = $schedule->discount ? ($schedule->discount * $schedule->business->rate)/100 : '0.00'; ?>
                               <td style="text-align: right;">
                                   {{ entobn($dis) }}/=
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
                               <?php
                                $due = ($schedule->business->rate * $schedule->quantity) -
                                       ( $total + ($schedule->discount * $schedule->business->rate)/100);
                               ?>
                               <td style="text-align: right;">{{ entobn($due) }}/=</td>
                           </tr>
                       </table>
                    </td>
                </tr>
            @endif
         <?php $i++; $total_paid += $qty; $total_discount += $dis; $total_due += $due; ?>
        @endforeach
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right">সর্বমোট  প্রদান : {{ entobn($total_paid) }}/=</td>
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
            /** Search using Select Business Options **/
            $("#select-season").on('change', function(){
                var id = $(this).val(),
                   url = "{{ url('customer/' . $customer->id) }}/report/" +id;

                window.location.href = url;
            });
        });
    </script>
@stop