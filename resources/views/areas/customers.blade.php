@extends('templates.master')

@section('page')
    এলাকা অনুসারে সদস্যর তালিকা
@stop

@section('breadcrumb')
    @include('templates._partials.breadcrumb', ['title' => 'এলাকা অনুসারে সদস্যর তালিকা', 'links' => ['এলাকা' => 'area', 'সদস্যর তালিকা' => "area/" . $area->id . "/customers" ]])
@stop

@section('box-title')
    প্রকল্প এলাকা  : "{{ $area->name }}"
@stop

@section('content')
    <div class="table-responsive">
        <table class="table table-borderedda display nowrap" id="dataTable">
            <thead>
            <tr>
                <th>সদস্যর নাম</th>
                <th> মোবাইল নং </th>
                <th style="width: 40%;" class="text-center">ঠিকানা</th>
                <th class="text-center">রেজিস্ট্রেশনের তারিখ</th>
            </tr>
            </thead>
            <tbody>
            @if(count($area->customers))
                @foreach($area->customers as $customer)
                    <tr>
                        <td>
                            <a href="{{ url('customer/' . $customer->id) }}">{{ $customer->name }}</a>
                        </td>
                        <td>{{ $customer->phone }}</td>
                        <td style="width: 40%;">
                            {{ ! is_null($customer->address) ? $customer->address : 'কোন ঠিকানা নেই' }}
                        </td>
                        <td class="text-center">
                            {{ entobn($customer->created_at->format('M d,  Y')) }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center"> প্রকল্প এলাকা  "{{ $area->name }}"  তে কোন সদস্য খুঁজে পাওয়া যায় নি </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            var title = "Customer List of " + "{{ $area->name }}";
            $('#dataTable').DataTable({
                dom: 'Bfrtip',
                "lengthMenu": [[50, 75, 100, -1], [50, 75, 100, "All"]],
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
                ],
                "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 1, 2, 3 ] }]
            });
        });
    </script>
@stop