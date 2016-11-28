@extends('templates.master')

@section('page')
    সিডিউলের তথ্য সার্চ করুন
@stop

@section('breadcrumb')
    @include('templates._partials.breadcrumb', ['title' => 'সিডিউল সার্চ রেজাল্ট ', 'links' => ['সিডিউল' => '#']])
@stop

@section('box-title')
    {{ $result }}
@stop

@section('content')
    <form class="form-inline submit-search">
        <div class="form-group" style="margin-right: 9px;">
            @include('templates.composers.businessSelect', ['id' =>  Request::segment(3) ? Request::segment(3) : 2])
        </div>
        <div class="form-group">
            <input type="text" class="input-daterange from-date form-control form-elem text-center"
                   name="from_date" value="{{ Request::segment(4) ? Request::segment(4) : ''}}" />
        </div>
        <div class="form-group" style="margin-left: 6px ; margin-right: 6px;">
            <label>হইতে </label>
        </div>
        <div class="form-group">
            <input type="text" class="input-daterange to-date form-control form-elem text-center" name="to_date"
                   value="{{ Request::segment(5) ?  Request::segment(5) : ''}}" />
        </div>
        <div class="form-group" style="margin-left: 5px;">
            <button type="submit" class="btn btn-success btn-round">
                <i class="fa fa-search"></i> সার্চ
            </button>
        </div>
    </form>
    @if(count($schedules))
        <div class="form-group" style="position: absolute;right: 60px; top: 60px;">
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                    Completed
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <li role="presentation">
                        <a href="" role="menuitem" id="markAllCompleted" tabindex="-1">
                            <i class="fa fa-check-square-o"></i>&nbsp;Complete Selected
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    @endif
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered jambo_table bulk_action" id="schedule-table">
            <thead>
            <tr class="headings">
                <th class="sequence"><input type="checkbox" class="checkAll"></th>
                <th class="column-title"> সদস্যর নাম </th>
                <th class="column-title"> মোবাইল নং </th>
                <th class="column-title"> প্রকল্পের নাম (টাকা/একর)  </th>
                <th class="column-title"> জমির পরিমাণ </th>
                <th class="column-title advance"> প্রদান</th>
                <th class="column-title date">  সেচের তারিখ </th>
                <th class="column-title action">  </th>
            </tr>
            </thead>

            <tbody>
            @if(count($schedules))
                @foreach($schedules as $schedule)
                    <tr class="even pointer{{ $schedule->completed == 0 ? ' danger' : '' }}">
                        <td class="text-center"><input type="checkbox" data-id="{{$schedule->id}}"></td>
                        <td class="text-center">{{ $schedule->customer->name }}</td>
                        <td class="text-center">{{ entobn($schedule->customer->phone) }}</td>
                        <td class="text-center">{{ $schedule->business->name }} ({{ entobn($schedule->business->rate) }}/=)</td>
                        <td class="text-center">{{ entobn($schedule->quantity) }} একর</td>
                        <td class="text-center">{{ entobn(sumPayments($schedule->payments->toArray())) }}/=</td>
                        <td class="text-center">
                            {{ entobn($schedule->event_date->format('d M, Y')) }}
                        </td>
                        <td style="width: 15%;">
                            <a href="{{ url('schedule/' . $schedule->id . '/edit') }}"
                               class="btn btn-sm btn-info btn-round"
                               data-placement="top" title="Edit Schedule for {{$schedule->customer->name}}??"
                               data-toggle="tooltip">
                                <i class="fa fa-edit"></i>
                            </a>

                            @if(auth()->user()->type == "administrator")
                                &nbsp;|&nbsp;
                                <a href="{{ url('schedules/delete/'. $schedule->id) }}"
                                   data-placement="top" title="Wanna delete this schedule??" data-toggle="tooltip"
                                   class="btn btn-sm btn-danger btn-round del-schedule">
                                    <i class="fa fa-close"></i>
                                </a>
                            @endif
                            @if($schedule->completed == 1)
                                &nbsp;|&nbsp;
                                <a href="{{ url('schedules/incomplete/'. $schedule->id) }}"
                                   data-placement="top" title="Make This Schedule Pending??" data-toggle="tooltip"
                                   class="btn btn-sm btn-facebook btn-round btn-delete">
                                    <i class="fa fa-check"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="8" class="text-center" style="padding: 10px; font-weight: bold;font-style: italic;">
                        No Schedules found in the criteria you provided!!
                    </td></tr>
            @endif
            </tbody>
        </table>
    </div>
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            var baseUrl  = "{{ url('schedule/search') }}",
                business = $("#select-business");

            $('.input-daterange').each(function(){
               $(this).datetimepicker({
                   format : 'YYYY-MM-DD'
               });
            });

            @if(count($schedules))
            $("#schedule-table").dataTable({
               "bSort" : false
            });
            @endif
            $(".submit-search").on('submit', function(event){
                event.preventDefault();
                var url = baseUrl + "/" + business.find('option:selected').val() + "/";

                if( $('.from-date').val() != " " )
                {
                    url += $('.from-date').val() + "/";
                }

                if($('.to-date').val() != " ")
                {
                    url += $('.to-date').val();
                }

                window.location.href = url;
            });

            $('.checkAll').on('click', function(e){
                $(this).closest('#schedule-table').find('td input:checkbox').prop('checked', this.checked);
            });

            $("#markAllCompleted").on('click', function(event){
                event.preventDefault();
                var arr = [];
                $('#schedule-table tbody').find('td input:checkbox').each(function(){
                    if($(this).is(':checked'))
                    {
                        arr.push({ id : $(this).attr('data-id')});
                    }
                });
                if(arr.length > 0)
                {
                    $.ajax({
                        type : 'POST',
                        url  : "{{ url('api/schedules/completed') }}",
                        data : {_token : TOKEN, data : arr},
                        success : function(result)
                        {
                            location.reload();
                        }
                    })
                }else{
                    swal("Alert!!", 'No schedules selected to make completed!!', 'warning');
                }
            });

            $('.btn-delete').on('click', function(event){
                event.preventDefault();
                var $this = $(this);
                var link = $this.attr('href');
                swal({
                    title: "Are you sure about this?",
                    text: "this form will make status 'incompleted', want to proceed??",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function(){
                    $.ajax({
                        url : link,
                        type : 'GET',
                        data : {'_token' : TOKEN},
                        success : function(result){
                            swal({
                                title :"Great!!",
                                text  : "Schedule status changed to incomplete successfully!!",
                                type  :"success"
                            }, function(){
                                location.reload();
                            });
                        }
                    })
                });
            });

            /** Delete Schedule **/
            $('.del-schedule').on('click', function(event){
                event.preventDefault();
                var $this = $(this);
                var link = $this.attr('href');
                swal({
                    title: "Are you sure?",
                    text: "if you delete this schedule all payments of this schedule will also delete.",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function(){
                    $.ajax({
                        url : link,
                        type : 'GET',
                        data : {'_token' : TOKEN},
                        success : function(result){
                            swal({
                                title :"Great!!",
                                text  : "Schedule deleted successfully!!",
                                type  :"success"
                            }, function(){
                                location.reload();
                            });
                        }
                    })
                });
            });
        });
    </script>
@stop