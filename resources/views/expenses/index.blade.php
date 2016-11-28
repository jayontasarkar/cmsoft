@extends('templates.master')

@section('page')
    প্রকল্প ব্যয়
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'প্রকল্প ব্যয় ', 'links' => ['প্রকল্প ব্যয়' => 'expense']])
@stop

@section('box-title')
    প্রকল্প ব্যয়ের হিসাব
@stop

@section('content')
	<div class="table-responsive">
		<table class="table table-bordered dataTable">
			<thead>
			<tr>
				<th>ব্যয়ের কারণ </th>
				<th>বিষদ বিবরণ</th>
				<th>প্রকল্পের নাম</th>
				<th>অপারেটর</th>
				<th>ব্যয়ের তারিখ</th>
				<th>টাকার পরিমাণ</th>
                <th></th>
			</tr>
			</thead>
			<tbody>
			@if(count($expenses))
                <?php $total = 0; ?>
				@foreach($expenses as $expense)
					<tr>
						<td>{{ $expense->name }}</td>
						<td>{{ $expense->description ? $expense->description : 'বিষদ বিবরণ  নেই'}}</td>
						<td>{{ $expense->business->name }}</td>
						<td>{{ $expense->user->name }}</td>
						<td>{{ entobn($expense->created_at->format('M d, Y')) }}</td>
						<td class="text-center">{{ entobn($expense->amount) }}/=</td>
						<td>
							<a href="{{ url('expense/' . $expense->id . '/edit') }}" data-id="{{ $expense->id }}" class="btn btn-round bg-blue-gradient edit">
								<i class="fa fa-edit"></i>
							</a>
						</td>
					</tr>
                    <?php $total += $expense->amount; ?>
				@endforeach
			@else
				<tr>
					<td colspan="7" class="text-center"> প্রকল্প ব্যয়ের কোন হিসাব পাওয়া যায় নি !!</td>
				</tr>
			@endif
			</tbody>
            @if(count($expenses))
            <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th> সর্বমোট  :  </th>
                <th class="text-center">{{ entobn($total) }}/=</th>
                <th></th>
            </tr>
            </tfoot>
            @endif
		</table>
	</div>
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.dataTable').dataTable({
                "bSort" : false,
                "lengthMenu": [[50, 75, 100, -1], [50, 75, 100, "All"]],
            });
        });
    </script>
@stop