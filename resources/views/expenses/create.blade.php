@extends('templates.master')

@section('page')
    প্রকল্প ব্যয় যোগ করুন
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'প্রকল্প ব্যয় যোগ করুন', 'links' => ['প্রকল্প ব্যয়' => 'expense', 'নতুন ব্যয়' => 'expense/create']])
@stop

@section('box-title')
    প্রকল্প ব্যয় যোগ করুন
@stop

@section('content')
	<form action="{{ url('expense') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}
		<div class="form-group{{ $errors->first('name') ? ' has-error' : '' }}">
            <label for="name" class="control-label col-md-2"> ব্যয়ের কারণ </label>
            <div class="col-md-5">
                <input type="text" class="form-control" name="name" autocomplete="off" autofocus value="{{ old('name') }}">
            </div>
            @if($errors->first('name'))
                <div class="alert-msg">{{ $errors->first('name') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="description" class="control-label col-md-2">ব্যয়ের বিবরণ </label>
            <div class="col-md-5">
                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            </div>
        </div>
        <div class="form-group{{ $errors->first('season_id') ? ' has-error' : '' }}">
            <label for="season_id" class="control-label col-md-2">সিজন সিলেক্ট করুন</label>
            <div class="col-md-5">
                @include('templates.composers.seasonSelect')
            </div>
            @if($errors->first('season_id'))
                <div class="alert-msg">{{ $errors->first('season_id') }}</div>
            @endif
        </div>
        <div class="form-group{{ $errors->first('business_id') ? ' has-error' : '' }}">
            <label for="business_id" class="control-label col-md-2"> প্রকল্পের নাম </label>
            <div class="col-md-5">
                @include('templates.composers.businessSelect')
            </div>
            @if($errors->first('business_id'))
                <div class="alert-msg">{{ $errors->first('business_id') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="expense-date" class="control-label col-md-2">
                পূরাতন ব্যয়ের ক্ষেত্রে
                <input type="checkbox" name="check" {{ old('check') ? 'checked' : '' }} id="check" value="1">
            </label>
            <div class="col-md-5 calendar-content">

            </div>
        </div>
        <div class="form-group{{ $errors->first('amount') ? ' has-error' : '' }}">
            <label for="amount" class="control-label col-md-2"> ব্যয়ের পরিমাণ </label>
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-addon">( টাকায়)</span>
                    <input type="text" class="form-control" id="amount" name="amount"
                           value="{{ old('amount') }}" aria-describedby="inputGroupSuccess3Status">
                </div>
            </div>
            @if($errors->first('amount'))
                <div class="alert-msg">{{ $errors->first('amount') }}</div>
            @endif
        </div>
        <br><br>
        <div class="form-group">
            <div class="col-md-5 col-md-offset-2">
                <button type="submit" class="btn btn-flat bg-blue"> সেভ করুন </button>
            </div>
        </div>
	</form>
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#check").on('change', function(){
                if($(this).is(':checked') )
                {
                    $(this).attr('checked');
                    $('.calendar-content').empty().html(
                            '<input type="text" value="{{ date('Y-m-d') }}" class="form-control expense-date" name="expense_date" required>'
                    );
                }else{
                    $(this).removeAttr('checked');
                    $('.calendar-content').empty();
                }
            });
            $(document).on('focus', '.expense-date', function(){
                $(this).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    format: 'yyyy-mm-dd'
                });
            });
        });
    </script>
@stop