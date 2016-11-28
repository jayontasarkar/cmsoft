@extends('templates.master')

@section('page')
    অ্যাডজাস্ট / এডিট ট্রানজেকশন
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'অ্যাডজাস্ট / এডিট ট্রানজেকশন', 'links' => ['পেমেন্ট' => 'payment/lists']])
@stop

@section('box-title')
    সকল সদস্যর অর্থ প্রদানের ট্রানজেকশন
@stop

@section('content')
<div class="table-responsive">
	<table class="table table-hover table-bordered" id="dataTable">
		<thead>
		<tr>
			<th class="text-center"> সদস্যর নাম  </th>
			<th class="text-center"> মোবাইল নং </th>
			<th class="text-center">প্রকল্পের নাম (টাকা/একর) </th>
			<th class="text-center"> জমির পরিমাণ </th>
      <th class="text-center"> সেচের তারিখ </th>
			<th class="text-center"> প্রদানের তারিখ </th>
			<th class="text-center"> টাকার পরিমাণ </th>
			<th class="text-center"></th>
		</tr>
		</thead>
		<tbody>
		@if(count($payments))
			@foreach($payments as $payment)
				<tr>
					<td class="text-center">{{ $payment->schedule->customer->name }}</td>
					<td class="text-center">{{ entobn($payment->schedule->customer->phone) }}</td>
					<td class="text-center">
                        {{ $payment->schedule->business->name }}
                        ({{entobn($payment->schedule->business->rate)}}/=)
                    </td>
					<td class="text-center">{{ entobn($payment->schedule->quantity) }} একর</td>
          <td class="text-center">{{ entobn($payment->schedule->event_date->format('M d, Y')) }}</td>
					<td class="text-center">{{ entobn($payment->created_at->format('M d, Y')) }}</td>
					<td class="text-center">{{ entobn($payment->amount) }}/=</td>
					<td class="text-center" style="width: 12%">
						<a href="{{ url('payment/edit/' . $payment->id ) }}" data-amount="{{ entobn($payment->amount) }}"
                           data-toggle="tooltip" data-placement="top"
                           title="এডিট ট্রানজেকশন : {{ $payment->schedule->customer->name }}"
                           data-id="{{ $payment->id }}" class="btn btn-round bg-blue-gradient edit">
							<i class="fa fa-edit"></i>
						</a>
                        &nbsp;&nbsp;
                        <a href="{{ url('payment/delete/' . $payment->id ) }}"
                           data-toggle="tooltip" data-placement="top"
                           title="{{ $payment->schedule->customer->name }} এর  ট্রানজেকশন বাতিল করুন"
                           class="btn btn-round bg-red delete">
                            <i class="fa fa-close"></i>
                        </a>
					</td>
				</tr>
			@endforeach
		@else
			<tr>
				<td colspan="7" class="text-center"> কোন অর্থ প্রদানের ট্রানজেকশন পাওয়া যায় নি </td>
			</tr>
		@endif
		</tbody>
	</table>
</div>
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $('#dataTable').dataTable({
            "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 3, 4, 5, 6 ] }],
            "lengthMenu": [[ 25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]]
        });

        $('.edit').on('click', function(event){
           event.preventDefault();

           var $this  = $(this),
               amount = $this.attr('data-amount'),
               url    = $this.attr('href'),
               text   = $this.attr('title'),
               input  = 0.00;
           swal({
               title: "টাকার পরিমাণ : " + amount + "/=",
               text: text,
               type: "input",
               showCancelButton: true,
               closeOnConfirm: false,
               animation: "slide-from-bottom",
               confirmButtonText: " পরিশোধিত বিল ",
               cancelButtonText: " বাতিল করুন ",
               inputPlaceholder: "পরিশোধিত টাকার পরিমাণ",
           }, function(inputValue){
               if (inputValue === false) return false;
               if (inputValue === "") {
                   swal.showInputError("You need to provide payment amount!");
                   return false
               }
               $.ajax({
                   type : 'PATCH',
                   url  : url,
                   data : { _token : TOKEN, amount : inputValue },
                   success : function(result){
                       location.reload();
                   }
               });
           })
        });

        $(".delete").on('click', function(event){
            event.preventDefault();

            var $this = $(this),
                url   = $this.attr('href'),
                title = $this.attr('title');

            swal({
                title: title,
                text: " এই ট্রানজেকশন সম্পূর্ণভাবে বাতিল করতে চান ? " ,
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function(){
                $.ajax({
                    type : 'DELETE',
                    url  : url,
                    data : { _token : TOKEN },
                    success : function(result){
                        location.reload();
                    }
                });
            });
        })
    });
</script>
@stop