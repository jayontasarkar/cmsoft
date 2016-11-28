@extends('templates.master')

@section('page')
    শাখা ব্যবসার (প্রকল্প) তথ্য
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'শাখা ব্যবসার তথ্য ', 'links' => ['প্রকল্প' => 'business']])
@stop

@section('box-title')
    শাখা ব্যবসার(প্রকল্প) তথ্য   এবং বিবরণী
@stop

@section('content')
    <a class="btn btn-primary btn-flat" data-toggle="modal" href="#create-business">
        <i class="fa fa-plus"></i>&nbsp;&nbsp;নতুন প্রকল্প যোগ করুন
    </a>

    @include('businesses.modals._create')
    @include('businesses.modals._edit')

	<div class="table-responsive">
		<table class="table table-bordered dataTable">
			<thead>
			<tr>
				<th class="text-center">সেচ প্রকল্পের নাম</th>
				<th class="text-center">সেচ প্রকল্পের বর্ণনা</th>
				<th class="text-center">সেচ প্রকল্পের অধীনস্থ এলাকাসমূহ </th>
				<th class="text-center">শুরুর তারিখ</th>
				<th class="text-center">রেট/একর</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			@if(count($businesses))
				@foreach($businesses as $business)
					<tr>
						<td class="text-center">{{ $business->name }}</td>
						<td class="text-center">{{ $business->description }}</td>
						<td style="width: 40%;">
							@foreach($business->areas as $area)
                                <span class="badge">{{ $area->name }}</span>
							@endforeach
						</td>
						<td class="text-center">{{ entobn($business->created_at->format('M d, Y')) }}</td>
						<td class="text-center">{{ entobn($business->rate) }}/=</td>
						<td class="text-center">
                            <a href="{{ url('business/' . $business->id . '/edit') }}"
                               data-id="{{ $business->id }}"
                               class="btn btn-round bg-blue-gradient edit"
                            >
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="7" class="text-center">No Business was found in the System!!</td>
				</tr>
			@endif
			</tbody>
		</table>
    </div>
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            var lada = $( '.ladda' ).ladda();
            $("#new-business").on('submit', function(e){
                e.preventDefault();
                var $this = $(this);
                lada.ladda('start');
                $.ajax({
                    url     : $this.attr('action'),
                    type    : 'POST',
                    data    : $this.serialize(),
                    success : function(response){
                        if(response.success) {
                            $("#create-business").modal('hide');
                            location.reload();
                        }
                        if(response.error) {
                            if(response.error.name) {
                                $this.find('input[name="name"]').closest('.form-group').addClass('has-error');
                                $this.find('input[name="name"]')
                                     .append('<span class="help-block">' + response.error.name[0] + '</span>');
                            }
                        }
                        lada.ladda('stop');
                    }
                });
            });

            $(".edit").on('click', function(e){
                var form = $("#edit-business-form");
                e.preventDefault();
                $('#edit-business').modal('show');
                $.get($(this).attr('href'), function(response){
                    var obj = response[0];
                    form.attr('action', form.attr('action') + "/" + obj.id);
                    form.find('input[name="name"]').val(obj.name);
                    form.find('textarea[name="description"]').val(obj.description);
                    form.find('input[name="rate"]').val(obj.rate);
                    form.find('#select-business option').each(function(){
                        if($(this).val() == obj.business_id){
                            $(this).attr('selected', 'selected');
                        }
                    });
                });
                form.on('submit', function(e){
                    e.preventDefault();
                    var $this = $(this);
                    lada.ladda('start');
                    $.ajax({
                        url     : $this.attr('action'),
                        type    : 'POST',
                        data    : $this.serialize(),
                        success : function(response){
                            if(response.error) {
                                if(response.error.name) {
                                    $this.find('input[name="name"]').closest('.form-group').addClass('has-error');
                                    $this.find('input[name="name"]')
                                            .append('<span class="help-block">' + response.error.name[0] + '</span>');
                                }
                            }else {
                                $("#edit-business").modal('hide');
                                location.reload();
                            }
                            lada.ladda('stop');
                        }
                    });
                });
            });
        });
    </script>
@stop