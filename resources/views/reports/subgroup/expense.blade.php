@extends('templates.master')

@section('page')
    প্রকল্পের খরচ
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', [
	    'title' => 'প্রকল্পের নাম # ' . $business->name . ' #', 'links' => [
	        'রিপোর্ট' => 'sub',
	        $business->name => 'sub/'.$business->id.''
	]])
@stop

@section('box-title')
	@include('templates._partials.sub-reports-nav', ['id' => $business->id])
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h4>
                <b> সিজনের নাম </b> :
                {{ $season['name'] }}
                ({{ entobn($season['start_date']->format('M, Y')) }} -
                {{ $season['end_date'] ? entobn($season['end_date']->format('M, Y')) : 'বর্তমান ' }})
            </h4>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                @include('templates.composers.seasonSelect', ['id' => Request::segment(4) ? Request::segment(4) : null])
            </div>
        </div>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered dataTable">
            <thead>
            <tr>
                <th class="text-center">ব্যয়ের কারণ</th>
                <th class="text-center">ব্যয়ের  বিবরণ</th>
                <th class="text-center">অপারেটর </th>
                <th class="text-center">খরচের তারিখ</th>
                <th class="text-center"> খরচের পরিমাণ  </th>
                <th class="text-center">মোট  পরিমাণ </th>
            </tr>
            </thead>
            <tbody>
            @if(count($expenses))
                <?php $total = 0; ?>
                @foreach($expenses as $expense)
                    <tr>
                        <td class="text-center">{{ $expense->name }}</td>
                        <td class="text-center">{{ $expense->description ? $expense->description : 'ব্যয়ের  বিবরণ  নেই'}}</td>
                        <td class="text-center">{{ $expense->user->name }}</td>
                        <td class="text-center">{{ entobn($expense->created_at->format('M d, Y')) }}</td>
                        <td class="text-center">{{ entobn($expense->amount) }}/=</td>
                        <?php $total += $expense->amount; ?>
                        <td class="text-center">{{ entobn($total) }}/=</td>
                    </tr>
                @endforeach
                <tr style="background-color:#e1e1e1; color: #000;;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center">সর্বমোট : </td>
                    <td class="text-center">{{ entobn($total) }}/=</td>
                    <td></td>
                </tr>
            @else
                <tr>
                    <td colspan="7" class="text-center">এই প্রকল্পে কোন খরচ নেই!!</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#select-season").on('change', function(){
                var id = $(this).val();

                window.location.href = "{{ url('sub/' . Request::segment(2)) }}" + "/" + id;
            });

           @if(count($expenses))
           var title = "{{ $business->name }}  সিজনের নাম  : {{ $season['name'] }}";
            $('.dataTable').dataTable({
                "bSort" : false,
                dom: 'Brtip',
                "lengthMenu": [[100, 150, 200, -1], [100, 150, 200, "All"]],
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: title
                    },
                    {
                        extend: 'pdfHtml5',
                        title: title
                    },
                    {
                        extend: 'print',
                        customize: function (win) {
                            $(win.document.body)
                                .css('font-size', '11pt')
                                .prepend(
                                        '<h3>'+ title +'</h3>'
                                );
                        }
                    }
                ]
            });

            @endif
        });
    </script>
@stop