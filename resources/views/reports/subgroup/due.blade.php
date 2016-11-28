@extends('templates.master')

@section('page')
    বকেয়া অর্থের রিপোর্ট  । প্রকল্প : {{ $business->name }}
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'বকেয়া অর্থের রিপোর্ট  । প্রকল্প #' . $business->name . '#', 'links' => [
	    'রিপোর্ট' => 'sub',
	    $business->name => 'sub/'.$business->id.'/due'
	]])
@stop

@section('box-title')
	@include('templates._partials.sub-reports-nav', ['id' => $business->id])
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h4><b class="text-aqua">প্রকল্প: {{ $business->name }}</b> &nbsp;|&nbsp; সিজন :
                {{ $season['name'] }}
                ({{ entobn($season['start_date']->format('d M, Y')) }} -
                {{ $season['end_date'] ? entobn($season['end_date']->format('M d, Y')) : 'বর্তমান ' }})
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
                <th>সদস্যর নাম</th>
                <th>মোবাইল নং</th>
                <th>সেচের তারিখ</th>
                <th class="text-center">বকেয়া টাকার পরিমাণ</th>
                <th class="text-center">মোট পরিমাণ</th>
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
                            <td>{{ entobn($result['event']) }}</td>
                            <?php
                            $due =  ($result['rate'] * $result['qty']) -
                                    $result['rate'] * $result['qty'] * $result['discount']/100 -
                                    $result['amount'];
                            ?>
                            <td class="text-center">
                                {{ entobn($due) }}/=
                            </td>
                            <?php $total += $due; ?>
                            <td class="text-center">{{ entobn($total)  }}/=</td>
                        </tr>
                    @endforeach
                @endforeach
                <tr style="background-color: #e1e1e1; color: #000;">
                    <td></td>
                    <td></td>
                    <td class="text-center">সর্বমোট : </td>
                    <td class="text-center">{{ entobn($total) }}/=</td>
                    <td></td>
                </tr>
            @else
                <tr>
                    <td colspan="7" class="text-center">No Due amount was found in the criteria!!</td>
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

                window.location.href = "{{ url('sub/'.$business->id.'/due') }}" + "/" + id;
            });

            @if(count($dues))

            var title = " বকেয়া অর্থের রিপোর্ট  । সিজন : {{ $season['name'] }}";
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