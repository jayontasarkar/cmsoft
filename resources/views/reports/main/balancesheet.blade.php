@extends('templates.master')

@section('page')
    প্রধান ব্যালেন্স সীট
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'প্রধান ব্যালেন্স সীট রিপোর্ট', 'links' => [
	    'রিপোর্ট' => 'report',
	    'ব্যালেন্স সীট' => 'report/balance'
	]])
@stop

@section('box-title')
	@include('templates._partials.main-reports-nav')
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h4> প্রধান ব্যালেন্স সীট রিপোর্ট ।  সিজনের নাম :
                {{ $season['name'] }}
                ({{ entobn($season['start_date']->format('d M, Y')) }} -
                {{ $season['end_date'] ? entobn($season['end_date']->format('d M, Y')) : 'বর্তমান ' }})
            </h4>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                @include('templates.composers.seasonSelect', ['id' => Request::segment(3) ? Request::segment(3) : null])
            </div>
        </div>
    </div>
    <hr>
    @if(array_sum($balancesheet) == 0 )
        <div class="text-center text-danger" style="font-size: 19px;">
            ব্যালেন্স শিটের জন্য কোন ট্রানজেকশন পাওয়া যায় নি !
        </div>
    @else
    <div class="table-responsive">
        <table class="table table-hover dataTable" style="font-size: 19px;">
            <thead>
            <tr>
                <th colspan="2" class="text-center">
                    সর্বমোট টাকার পরিমাণ : {{ entobn($balancesheet['total']) }}/= &nbsp; এবং  &nbsp;
                    সেচের জমির পরিমাণ : {{ entobn($balancesheet['quantity']) }} একর
                </th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">সর্বমোট টাকা কালেকশন  : {{ entobn($balancesheet['payment']) }}/=</td>
                    <td class="text-center"> সর্বমোট খরচ     : {{ entobn($balancesheet['expense']) }}/=</td>
                </tr>
                <tr>
                    <td class="text-center">বকেয়া টাকার পরিমাণ  : {{ entobn($balancesheet['due']) }}/=</td>
                    <td class="text-center"> সর্বমোট ডিস্কাউন্ট : {{ entobn($balancesheet['discount']) }}/=</td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#select-season").on('change', function(){
                var id = $(this).val();

                window.location.href = "{{ url('report/balance') }}" + "/" + id;
            });
        });
    </script>
@stop