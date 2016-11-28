@extends('templates.master')

@section('page')
    সদস্যর নগদ পেমেন্ট
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'সদস্যর নগদ পেমেন্ট ', 'links' => ['নগদ পেমেন্ট ' => 'payment']])
@stop

@section('box-title')
    সদস্যর নগদ প্রদান
@stop

@section('content')

<div class="form-group text-center" style="width: 250px;">
    @include('templates.composers.businessSelect', ['id' => Request::segment(2) ? Request::segment(2) : 1])
</div>

<hr>

<div class="table-responsive">
	<table class="table table-bordered dataTable">
		<thead>
		<tr>
			<th> সদস্যর নাম </th>
			<th> মোবাইল নং </th>
			<th> প্রকল্পের নাম (/একর) </th>
			<th>জমি (একর)</th>
			<th> সেচের তারিখ </th>
			<th> মোট - ডিস্কাউন্ট - প্রদান</th>
			<th> বকেয়া বিল </th>
			<th></th>
		</tr>
		</thead>
        <tbody>
        @if($payments)
        @foreach($payments as $payment)
        <tr>
            <td>{{ $payment->customer->name }}</td>
            <td>{{ entobn($payment->customer->phone) }}</td>
            <td>
                <a data-placement="top" title="{{$payment->description}}"
                   data-toggle="tooltip">
                {{ $payment->business->name }} ({{ entobn($payment->business->rate) }}/=)
                </a>
            </td>
            <td class="text-center">{{ entobn($payment->quantity) }} একর</td>
            <td>{{ entobn($payment->event_date->format('M d, Y')) }}</td>
            <td>
                {{ entobn($payment->business->rate * $payment->quantity) }} -
                {{ entobn($payment->business->rate * $payment->quantity * $payment->discount / 100) }} -
                {{ entobn(sumPayments($payment->payments->toArray()) )}}
                <?php $due = ($payment->business->rate * $payment->quantity) -
                        ($payment->business->rate * $payment->quantity * $payment->discount / 100) -
                        sumPayments($payment->payments->toArray());
                ?>
            </td>
            <td>    {{ entobn($due)  }}/= </td>
            <td>
                @if( $due > 0 )
                <a href="{{ url('payment') }}" data-id="{{ $payment->id }}" class="btn btn-info btn-round payment"
                   data-due="{{ entobn($due) }}" data-name="{{ $payment->customer->name }}">
                    <i class="fa fa-money"></i> বিল প্রদান
                </a>
                @else
                    <span class="badge"> পরিশোধ করা হয়েছে </span>
                @endif
            </td>
        </tr>
        @endforeach
        @else
            <tr>
                <td colspan="7" class="text-danger text-center">No Customer/Schedule found for payments</td>
            </tr>
        @endif
        </tbody>
	</table>
</div>
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        // Datatable Initialize
        $('.dataTable').dataTable({
            "bSort"     : false,
            "lengthMenu": [[ 25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            oLanguage: {
                sProcessing: "<img src={{ asset('img/loader.gif') }}>"
            },
            processing : true
        });

        /** Make Payment Functionalities **/
        $('.payment').on('click', function(event){
           event.preventDefault();

           var $this = $(this),
                id   = $this.attr('data-id'),
                url  = $this.attr('href'),
                due  = $this.attr('data-due'),
                name = $this.attr('data-name');


            swal({
                title: "<strong style='font-size: 20px;'>সদস্যর নাম  : " + name + "</strong>",
                text: "বকেয়া বিল : " + due + "/=",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                confirmButtonText: "বিল প্রদান",
                cancelButtonText: " বাতিল করুন ",
                animation: "slide-from-bottom",
                inputPlaceholder: "টাকার পরিমাণ",
                html : true
            }, function(inputValue){
                if (inputValue === false) return false;

                if (inputValue === "" ) {
                    swal.showInputError("You need to provide amount");
                    return false;
                }

                var data = {
                    _token : TOKEN,
                    id     : id,
                    name   : name,
                    amount : inputValue
                };

                $.post(url, data, function(result){
                    swal({
                        title: "Success!",
                        text: "পেমেন্ট সম্পূর্ণ হয়েছে ",
                        type: "success"
                    }, function(){
                        location.reload();
                    });
                });
            });
        });
        /** Search using Select Business Options **/
        $("#select-business").on('change', function(){
            var id = $(this).val(),
               url = "{{ url('payment') }}/" +id;
             window.location.href = url;
        });
    });
</script>
@stop