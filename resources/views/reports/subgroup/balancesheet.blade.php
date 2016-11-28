@extends('templates.master')

@section('page')
	{{ $business->name }} ব্যালেন্স শিট
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => $business->name . ' ব্যালেন্স শিট', 'links' => [
	    'রিপোর্ট' => 'sub',
	    $business->name => 'sub/'.$business->id.'/balance'
	]])
@stop

@section('box-title')
	@include('templates._partials.sub-reports-nav', ['id' => $business->id ])
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h4><b class="text-aqua">{{ $business->name }}</b> &nbsp;|&nbsp; সিজন :
                {{ $season['name'] }}
                ({{ entobn($season['start_date']->format('d M, Y')) }} -
                {{ $season['end_date'] ? entobn($season['end_date']->format('d M, Y')) : 'বর্তমান ' }})
            </h4>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                @include('templates.composers.seasonSelect', ['id' => Request::segment(4) ? Request::segment(4) : null])
            </div>
        </div>
    </div>
    <hr>
    @if(array_sum($balancesheet) == 0 )
        <div class="text-center text-danger" style="font-size: 19px;">
            এই প্রকল্পের ব্যালেন্স শিটের জন্য কোন ট্রানজেকশন পাওয়া যায় নি
        </div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered dataTable" style="font-size: 19px;">
            <thead>
            <tr>
                <th colspan="2" class="text-center">
                    মোট টাকার পরিমাণ  : {{ entobn($balancesheet['total']) }}/=
                    &nbsp; এবং  &nbsp; সেচের জমির পরিমাণ : {{ entobn($balancesheet['quantity']) }} একর </th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">সর্বমোট টাকা কালেকশন : {{ entobn($balancesheet['payment']) }}/=</td>
                    <td class="text-center"> সর্বমোট খরচ     : {{ entobn($balancesheet['expense']) }}/=</td>
                </tr>
                <tr>
                    <td class="text-center"> বকেয়া টাকার পরিমাণ  : {{ entobn($balancesheet['due']) }}/=</td>
                    <td class="text-center">সর্বমোট ডিস্কাউন্ট : {{ entobn($balancesheet['discount']) }}/=</td>
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

                window.location.href = "{{ url('sub/'.$business->id.'/balance') }}" + "/" + id;
            });
        });
    </script>
@stop