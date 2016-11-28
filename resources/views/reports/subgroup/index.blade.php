@extends('templates.master')

@section('page')
    প্রকল্প রিপোর্টের ড্যাশবোর্ড
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'প্রকল্প রিপোর্টের ড্যাশবোর্ড '])
@stop

@section('box-title')
    রিপোর্ট দেখার জন্য প্রকল্প সিলেক্ট করুন
@stop

@section('content')
    @foreach($businesses as $business)
    <div class="col-md-4">
        <div class="small-box bg-red">
            <div class="inner">
                <h4 class="text-center">{{ $business->name }}</h4>

                <p>{{ $business->description }}</p>
            </div>
            <div class="icon">
                <i class="fa fa-pie-chart"></i>
            </div>
            <a href="{{ url('sub/' . $business->id) }}" class="small-box-footer">
                রিপোর্ট দেখুন <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    @endforeach
@stop

@section('script')

@stop