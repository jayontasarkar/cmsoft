@extends('templates.master')

@section('page')
	এরিয়া / এলাকা ব্যবস্থাপনা
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'এরিয়া / এলাকা', 'links' => ['এরিয়া / এলাকা' => 'area']])
@stop

@section('box-title')
	নতুন এরিয়া / এলাকা ব্যবস্থাপনা
@stop

@section('content')
    <a class="btn btn-primary" data-toggle="modal" href="#create-area">
        <i class="fa fa-plus"></i> নতুন এরিয়া / এলাকা
    </a>
    @include('areas.modals._create')
    @include('areas.modals._edit')
    <hr>
    <div class="table-responsive">
		<table class="table table-bordered dataTable">
			<thead>
			<tr>
				<th>এলাকার নাম </th>
				<th style="width: 40%;">এলাকার বিবরণ</th>
				<th>শাখা ব্যবসার নাম</th>
				<th> কস্টমারের সংখ্যা </th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			@if(count($areas))
				@foreach($areas as $area)
					<tr>
						<td>{{ $area->name }}</td>
						<td style="width: 40%;">{{ $area->description }}</td>
						<td>{{ $area->business->name }}</td>
						<td class="text-center">
                        @if(count($area->customers))
                            <a href="{{ url('area/'. $area->id .'/customers') }}" class="badge">
                                {{ $area->customers->count() }}
                              জন </a>
                        @else
                            কাস্টমার নেই    
                        @endif    
                        </td>
						<td>
							<a href="{{ url('area/' . $area->id . '/edit') }}" class="btn bg-purple btn-round edit">
								<i class="fa fa-edit"></i>
							</a>
						</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="7" class="text-center">কোন এলাকা পাওয়া যায় নি</td>
				</tr>
			@endif
			</tbody>
		</table>
	</div>
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.dataTable').dataTable({
                "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 1, 3, 4 ] }]
            });

            var lada = $( '.ladda' ).ladda();
            $("#new-area").on('submit', function(e){
                e.preventDefault();
                var $this = $(this);
                lada.ladda('start');
                $.ajax({
                    url     : $this.attr('action'),
                    type    : 'POST',
                    data    : $this.serialize(),
                    success : function(response){
                        if(response.success) {
                            $("#create-area").modal('hide');
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
                var form = $("#edit-area-form");
                e.preventDefault();
                $('#edit-area').modal('show');
                $.get($(this).attr('href'), function(response){
                    var obj = response[0];
                    form.attr('action', form.attr('action') + "/" + obj.id);
                    form.find('input[name="name"]').val(obj.name);
                    form.find('textarea[name="description"]').val(obj.description);
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
                                $("#edit-area").modal('hide');
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