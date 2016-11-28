@extends('templates.master')

@section('page')
    অর্থ কালেকশন রিপোর্ট । প্রকল্পের নাম : {{ $business->name }}
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', [
	    'title' => 'অর্থ কালেকশন রিপোর্ট #' . $business->name . '#', 'links' => [
	    'রিপোর্ট ' => 'sub',
	    'কালেকশন রিপোর্ট ' => 'sub/'.Request::segment(2).'/income'
	]])
@stop

@section('box-title')
	@include('templates._partials.sub-reports-nav', ['id' => Request::segment(2)])
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h4><b class="text-aqua"> প্রকল্প : {{ $business->name }}</b> &nbsp;|&nbsp; <b>সিজন</b> :
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
        <table class="table table-hover dataTable">
            <thead>
            <tr>
                <th>সদস্যর নাম</th>
                <th>মোবাইল নং.</th>
                <th>সেচের তারিখ</th>
                <th>প্রদানের তারিখ</th>
                <th class="text-center">টাকার পরিমাণ</th>
                <th class="text-center">মোট পরিমাণ</th>
            </tr>
            </thead>
            <tbody>
            @if(count($collections))
                <?php $total = 0; ?>
                @foreach($collections as $collection)
                    <tr>
                        <td>{{ $collection->schedule->customer->name }}</td>
                        <td>{{ $collection->schedule->customer->phone }}</td>
                        <td>{{ entobn($collection->schedule->event_date->format('M d, Y')) }}</td>
                        <td>{{ entobn($collection->created_at->format('M d, Y')) }}</td>
                        <td class="text-center">{{ entobn($collection->amount) }}/=</td>
                        <?php $total = $total + $collection->amount; ?>
                        <td class="text-center">{{ entobn($total) }}/=</td>
                    </tr>
                @endforeach
                <tr style="background-color: #e1e1e1;color: #000;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center">সর্বমোট : </td>
                    <td class="text-center">{{ entobn($total) }}/=</td>
                    <td></td>
                </tr>
            @else
                <tr>
                    <td colspan="7" class="text-center">এই প্রকল্পের কোন অর্থ কালেকশন নেই ।!</td>
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

                window.location.href = "{{ url('sub/'.Request::segment(2).'/income') }}" + "/" + id;
            });

            @if(count($collections))
            $('.dataTable').dataTable({
                "bSort" : false,
                dom: 'Brtp<"bottom"l>',
                "lengthMenu": [[100, 200, 300, -1], [100, 200, 300, "All"]],
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: ''
                    },
                    {
                        extend: 'pdfHtml5',
                        title: ''
                    },
                    {
                        extend: 'print',
                        customize: function (win) {
                            $(win.document.body)
                                    .css('font-size', '11pt')
                        }
                    }
                ]
            });
            @endif
        });
    </script>
@stop