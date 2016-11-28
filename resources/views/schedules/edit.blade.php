@extends('templates.master')

@section('page')
    সিডিউল ম্যানেজমেন্ট
@stop

@section('breadcrumb')
    @include('templates._partials.breadcrumb', ['title' => 'সিডিউল ম্যানেজমেন্ট', 'links' => ['সিডিউল' => 'schedule', 'এডিট' => 'schedule/' . $schedule->id . '/edit']])
@stop

@section('box-title')
    সিডিউলের তথ্য পরিবর্তন/এডিট করুণ
@stop

@section('content')
<form action="{{ url('schedule/' . $schedule->id) }}" method="POST" role="form" id="frm-schedule" class="form-horizontal">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
	<div class="form-group">
		<label for="season_id" class="control-label col-md-2"> সিজন সিলেক্ট করুন </label>
		<div class="col-md-6">
            @include('templates.composers.seasonSelect', ['id' => $schedule->season_id])
        </div>
	</div>
    <div class="form-group">
        <label for="business_id" class="control-label col-md-2"> প্রকল্প সিলেক্ট করুন </label>
        <div class="col-md-6">
            @include('templates.composers.businessSelect', ['id' => $schedule->business_id])
        </div>
    </div>
    <div class="form-group">
        <label for="customer_id" class="control-label col-md-2"> সদস্যর নাম সিলেক্ট করুন </label>
        <div class="col-md-6">
            @include('templates.composers.customerSelect', ['id' => $schedule->customer_id])
        </div>
    </div>

    <div class="form-group">
        <label for="event_date" class="control-label col-md-2"> সিডিউলের তারিখ </label>
        <div class="col-md-6">
            <div class='input-group date' id='datetimepicker1'>
                <input type='text' class="form-control" name="event_date" id="event_date"
                       value="{{ $schedule->event_date->format('m/d/Y H:i:s') }}" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="qty" class="control-label col-md-2">জমির পরিমাণ (একর)</label>
        <div class="col-md-6">
            <div class='input-group'>
                <input type='text'
                       style="width: 60px; text-align: center; border: 1px solid #d2d6de;height: 34px;padding: 6px; background: #fff;"
                       name="quantity1"
                       value="{{ entobn(parseNumber($schedule->quantity)[0]) }}"
                />
                <label>&nbsp; <b>.</b>   &nbsp;</label>
                <input type='text'
                       style="width: 60px; text-align: center; border: 1px solid #d2d6de;height: 34px;padding: 6px; background: #fff;"
                       name="quantity2"
                       value="{{ entobn(parseNumber($schedule->quantity)[1]) }}"
                />
                <span class="input-group-addon">
                   (একর)
                </span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="discount" class="control-label col-md-2">ডিস্কাউন্ট</label>
        <div class="col-md-6">
            <div class='input-group'>
                <input type='text'
                       style="width: 60px; text-align: center; border: 1px solid #d2d6de;height: 34px;padding: 6px; background: #fff;"
                       name="discount1"
                       value="{{ entobn(parseNumber($schedule->discount)[0]) }}"
                />
                <label>&nbsp; <b>.</b>   &nbsp;</label>
                <input type='text'
                       style="width: 60px; text-align: center; border: 1px solid #d2d6de;height: 34px;padding: 6px; background: #fff;"
                       name="discount2"
                       value="{{ entobn(parseNumber($schedule->discount)[1]) }}"
                />
                <span class="input-group-addon">
                   %
                </span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="control-label col-md-2">বিষদ বিবরণ</label>
        <div class="col-md-6">
            <textarea name="description" class="form-control" id="description"  rows="3">{{ $schedule->description }}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="completed" class="control-label col-md-2">
            (সেচ সম্পন্ন হলে)
        </label>
        <div class="col-md-6">
            <div class="checkbox icheck">
                <label>
                    <input type="checkbox"
                           name="completed"
                           value="{{ $schedule->completed }}"
                           class="completed"
                           {{ $schedule->completed ? 'checked' : '' }}
                    /> &nbsp;&nbsp;
                    সেচ প্রদান সম্পন্ন হলে ক্লিক করুন
                </label>
            </div>
        </div>
    </div>
    <hr>

    <div class="form-group">
        <div class="col-md-10 col-md-offset-2">
            <button type="submit" class="btn btn-primary"> সেভ করুন </button>
        </div>
    </div>

</form>
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#datetimepicker1').datetimepicker({
                defaultDate: new Date(),
                ignoreReadonly: true
            });

            var form = $("#frm-schedule"),
                    url  = form.attr('action');

            form.on('submit', function(event){
                event.preventDefault();

                var qty  = $('input[name="quantity1"]').val() + "." + $('input[name="quantity2"]').val(),
                    dis  = $('input[name="discount1"]').val() + "." + $('input[name="discount2"]').val(),
                    nam  = $('select[name="customer_id"] :selected').text(),
                    pro  = $('select[name="business_id"] :selected').text()  ;

                swal({
                    title: "<strong style='font-size: 16px;'> প্রকল্প : " + pro + "<br> সদস্য : " + nam + "</strong>",
                    text: "জমি : " + qty + " একর, " + "ডিস্কাউন্ট : " + dis + "%",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Create!",
                    cancelButtonText: "No, Cancel",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    html : true
                },function() {
                    $.post(url, form.serialize(), function (response) {
                        swal({
                            title: "Success",
                            text: "সিডিউল আপডেট করা হল",
                            type: "success",
                            timer: 2500,
                            showConfirmButton: false
                        }, function(){
                            window.location.href = "{{ url('schedule/search/' . $schedule->business_id) }}";
                        });
                    });
                });
            });

            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
@stop