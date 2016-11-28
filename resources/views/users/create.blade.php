@extends('templates.master')

@section('page')
	নতুন লগইন ইউজার
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'নতুন লগইন ইউজার', 'links' => ['ইউজার' => 'users', 'নতুন বাবহারকারী' => 'users/create']])
@stop

@section('box-title')
 নতুন লগইন ইউজার এর তথ্য বিবরণী
@stop

@section('content')
	<form action="{{ url('users') }}" method="POST" class="form-horizontal" role="form">
		{{ csrf_field() }}
		<div class="form-group{{ $errors->first('name') ? ' has-error' : '' }}">
			<label for="Name" class="control-label col-md-2">বাবহারকারীর নাম</label>
			<div class="col-md-5">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa fa-user"></i></span>
					<input type="text" class="form-control" id="Name" name="name"
						   value="{{ old('name') }}" placeholder="Enter User's Full Name">
				</div>
			</div>
            @if($errors->first('name'))
                <div class="alert-msg">{{ $errors->first('name') }}</div>
            @endif
		</div>
		<div class="form-group{{ $errors->first('username') ? ' has-error' : '' }}">
			<label for="Username" class="control-label col-md-2">ইউজারনেম</label>
			<div class="col-md-5">
				<div class="input-group">
					<span class="input-group-addon">@</span>
					<input type="text" class="form-control" id="Username" name="username"
						   value="{{ old('username') }}" placeholder="Enter User's Login UserName (In English)">
				</div>
			</div>
            @if($errors->first('username'))
                <div class="alert-msg">{{ $errors->first('username') }}</div>
            @endif
		</div>
		<div class="form-group{{ $errors->first('phone') ? ' has-error' : '' }}">
			<label for="Phone" class="control-label col-md-2"> মোবাইল নং.</label>
			<div class="col-md-5">
				<div class="input-group">
					<span class="input-group-addon">+88</span>
					<input type="text" class="form-control" id="Phone" name="phone"
						   value="{{ old('phone') }}" placeholder="Enter User's Phone Number">
				</div>
			</div>
            @if($errors->first('phone'))
                <div class="alert-msg">{{ $errors->first('phone') }}</div>
            @endif
		</div>
		<div class="form-group">
			<label for="address" class="control-label col-md-2"> ঠিকানা</label>
			<div class="col-md-5">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-home"></i></span>
					<textarea name="address" id="address" cols="30" rows="4" class="form-control">{{ old('address') }}</textarea>
				</div>
			</div>
		</div>
		<div class="form-group{{ $errors->first('type') ? ' has-error' : '' }}">
			<label for="type" class="control-label col-md-2"> ইউজার টাইপ </label>
			<div class="col-md-5">
				<label>
					<input type="radio" name="type" value="regular" class="square-blue" checked> রেগুলার ইউজার
				</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label>
					<input type="radio" name="type" value="administrator" class="square-blue"> এডমিন ইউজার
				</label>
			</div>
            @if($errors->first('type'))
                <div class="alert-msg">{{ $errors->first('type') }}</div>
            @endif
		</div>
		<div class="form-group{{ $errors->first('password') ? ' has-error' : '' }}">
			<label for="password" class="control-label col-md-2"> লগইন  পাসওয়ার্ড</label>
			<div class="col-md-5">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-gear"></i></span>
					<input type="password" class="form-control" id="password" name="password"
						   value="" placeholder="Enter User's Login Password (In English)">
				</div>
			</div>
            @if($errors->first('password'))
                <div class="alert-msg">{{ $errors->first('password') }}</div>
            @endif
		</div>
		<div class="form-group{{ $errors->first('password_confirmation') ? ' has-error' : '' }}">
			<label for="password_confirm" class="control-label col-md-2"> কনফার্ম পাসওয়ার্ড</label>
			<div class="col-md-5">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-gear"></i></span>
					<input type="password" class="form-control" id="password_confirm" name="password_confirmation"
						   value="" placeholder="Retype provided Login Password (In English)">
				</div>
			</div>
            @if($errors->first('password'))
                <div class="alert-msg">{{ $errors->first('password') }}</div>
            @endif
		</div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-1">
                <hr>
            </div>
        </div>
		<div class="form-group">
			<div class="col-md-5 col-md-offset-2">
				<input type="submit" class="btn btn-flat btn-success" value=" সেভ করুন ">
			</div>
		</div>
	</form>
@stop

@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
			$('input').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square-blue',
				increaseArea: '30%' // optional
			});
		});
	</script>
@stop