@extends('templates.master')

@section('page')
	এডিট ইউজার : {{ $user->name }}
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'এডিট ইউজার', 'links' => ['ইউজার প্রোফাইল' => 'users', 'এডিট' => 'users/' . $user->id . '/edit']])
@stop

@section('box-title')
 এডিট ইউজার প্রোফাইল :  {{ $user->name }}
@stop

@section('content')
	<form action="{{ url('users/' . $user->id) }}" method="POST" class="form-horizontal" role="form">
		{{ csrf_field() }}
		{{ method_field('PATCH') }}
		<input type="hidden" name="id" value="{{ $user->id }}">
		<div class="form-group{{ $errors->first('name') ? ' has-error' : '' }}">
			<label for="Name" class="control-label col-md-2">নাম</label>
			<div class="col-md-5">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa fa-user"></i></span>
					<input type="text" class="form-control" id="Name" name="name"
						   value="{{ old('name') ? old('name') : $user->name }}" placeholder="Enter User's Full Name">
				</div>
			</div>
            @if($errors->first('name'))
                <div class="alert-msg">{{ $errors->first('name') }}</div>
            @endif
		</div>
		<div class="form-group{{ $errors->first('username') ? ' has-error' : '' }}">
			<label for="Username" class="control-label col-md-2"> ইউজারনেম</label>
			<div class="col-md-5">
				<div class="input-group">
					<span class="input-group-addon">@</span>
					<input type="text" class="form-control" id="Username" name="username"
						   value="{{ old('username') ? old('username') : $user->username }}"
						   placeholder="Enter User's Login UserName">
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
						   value="{{ old('phone') ? old('phone') : $user->phone }}"
						   placeholder="Enter User's Phone Number">
				</div>
			</div>
            @if($errors->first('phone'))
                <div class="alert-msg">{{ $errors->first('phone') }}</div>
            @endif
		</div>
		<div class="form-group">
			<label for="address" class="control-label col-md-2">ঠিকানা</label>
			<div class="col-md-5">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-home"></i></span>
					<textarea name="address" id="address" cols="30" rows="4" class="form-control">
						{{ old('address') ? old('address') : $user->address }}
					</textarea>
				</div>
			</div>
		</div>
		<div class="form-group{{ $errors->first('type') ? ' has-error' : '' }}">
			<label for="type" class="control-label col-md-2">ইউজার টাইপ </label>
			<div class="col-md-5">
				<label>
					<input type="radio" name="type" value="regular" class="square-blue"
						   {{ (old('type') == 'regular' || $user->type == 'regular') ? 'checked' : '' }}> রেগুলার ইউজার
				</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label>
					<input type="radio" name="type" value="administrator" class="square-blue"
						  {{ (old('type') == 'administrator' || $user->type == 'administrator')  ? 'checked' : '' }}> এডমিন ইউজার
				</label>
			</div>
            @if($errors->first('type'))
                <div class="alert-msg">{{ $errors->first('type') }}</div>
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