@extends('templates.master')

@section('page')
    সফটওয়্যার ড্যাশবোর্ড
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'সফটওয়্যার ড্যাশবোর্ড '])
@stop

@section('box-title')

@stop

@section('content')
	<h2 class="text-center">স্বাগতম, {{ auth()->user()->name }}</h2>
    <hr>
    <h3 class="text-center text-blue">প্রকল্প অনুসারে আজকের সেচের সিডিউল ( {{ entobn(date('M d, Y')) }})</h3>
	<div class="row">
		<div class="col-md-12">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <?php $i = 0; ?>
                @foreach($businesses as $business)
				<div class="panel panel-default">
					<div class="box-header with-border panel-heading" role="tab" id="heading{{ $business->id }}">
						<h3 class="box-title panel-title">{{ $business->name }}</h3>

						<div class="box-tools pull-right">
							<button type="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $business->id }}" aria-expanded="{{ $i == 0 ? 'true' : 'false' }}" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						</div>
						<!-- /.box-tools -->
					</div>
					<div id="collapse{{ $business->id }}" class="panel-collapse collapse {{ $i = 0 ? 'in' : '' }}" role="tabpanel" aria-labelledby="heading{{ $business->id }}">
						<div class="panel-body">
						    @if(count($business->schedules))
                                @foreach($business->schedules as $schedule)

                                    <a tabindex="0" class="btn btn-lg btn-link popover-btn" role="button" data-toggle="popover"
                                       data-trigger="focus" data-placement="top"
                                       title="{{ $schedule->customer->name }} ({{ entobn($schedule->customer->phone) }})"
                                       data-content="জমির পরিমাণ :
                                       {{ entobn($schedule->quantity) }}  একর |
                                       @if($schedule->description) জমির বিবরণ : {{ $schedule->description }} @endif"
                                    >
                                            {{ $schedule->customer->name }}
                                    </a>

                                @endforeach
                                <h5>
                                    <a href="{{ url('dashboard/schedule/print/' . $business->id) }}" target="_blank"
                                       class="btn btn-link pull-right">
                                        <i class="fa fa-print"></i> প্রিন্ট শিডিউল লিস্ট
                                    </a>
                                </h5>
                            @else
                                <h4 class="text-aqua text-center">
                                    {{ entobn(date('M d, Y')) }} তারিখে "{{ $business->name }}" প্রকল্পে কোন শিডিউল  নেই |
                                </h4>
                            @endif
                        </div>
					</div>
				</div>
                <?php $i++; ?>
                @endforeach
            </div>
		</div>
	</div>
@stop

@section('script')
<script type="text/javascript">
    $(function () {
        $('[data-toggle="popover"]').popover();
    })
</script>
@stop