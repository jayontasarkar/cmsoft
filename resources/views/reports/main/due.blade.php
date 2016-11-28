@extends('templates.master')

@section('page')
    বকেয়া অর্থের রিপোর্ট
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'বকেয়া অর্থের পরিমাণ রিপোর্ট', 'links' => [
	    'রিপোর্ট' => 'report',
	    'বকেয়া অর্থ' => 'report/due'
	]])
@stop

@section('box-title')
	@include('templates._partials.main-reports-nav')
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h4> সকল বকেয়া অর্থের পরিমাণ  ।  সিজনের নাম  :
                {{ $season['name'] }}
                ({{ entobn($season['start_date']->format('d M, Y')) }} -
                {{ $season['end_date'] ? entobn($season['end_date']->format('M d, Y')) : 'বর্তমান ' }})
            </h4>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                @include('templates.composers.seasonSelect', ['id' => Request::segment(3) ? Request::segment(3) : null])
            </div>
        </div>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table table-hover dataTable">
            <thead>
            <tr>
                <th> সদস্যর নাম </th>
                <th>মোবাইল নং.</th>
                <th> প্রকল্পের নাম </th>
                <th> সেচের তারিখ </th>
                <th> টাকার পরিমাণ </th>
                <th>মোট পরিমাণ</th>
            </tr>
            </thead>
            <tbody>
            @if(count($dues))
                <?php $total = 0; ?>
                @foreach($dues as $due)
                    @foreach($due as $result)
                        <tr>
                            <td><a href="{{ url('customer/' . $result['id']) }}">{{ $result['name'] }}</a></td>
                            <td>{{ $result['phone'] }}</td>
                            <td>{{ $result['business'] }}</td>
                            <td>{{ entobn($result['event']) }}</td>
                            <?php
                            $due =  ($result['rate'] * $result['qty']) -
                                    $result['rate'] * $result['qty'] * $result['discount']/100 -
                                    $result['amount'];
                            ?>
                            <td class="text-center">
                                {{ entobn($due) }}/=
                            </td>
                            <?php $total = $total + $due; ?>
                            <td class="text-center">{{ entobn($total)  }}/=</td>
                        </tr>
                    @endforeach
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
                    <td colspan="6" class="text-center"> কোন বকেয়া অর্থ নেই!!</td>
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

                window.location.href = "{{ url('report/due') }}" + "/" + id;
            });

            @if(count($dues))

            var title = "সকল বকেয়া অর্থের রিপোর্ট ।  সিজনের নাম  : {{ $season['name'] }}";
            $('.dataTable').dataTable({
                "bSort" : false,
                dom: 'Brtp<"bottom"l>',
                "lengthMenu": [[100, 200, 300, -1], [100, 200, 300, "All"]],
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
                                        '<h3 style="text-align: center;">'+ title +'</h3>'
                                );
                        }
                    }
                ]
            });
            @endif
        });
    </script>
@stop