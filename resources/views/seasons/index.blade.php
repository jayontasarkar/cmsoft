@extends('templates.master')

@section('page')
    সেচ প্রকল্প সিজন ম্যানেজমেন্ট
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'সিজন ম্যানেজমেন্ট ', 'links' => ['season' => 'season']])
@stop

@section('box-title')
    সেচ প্রকল্পের সিজন ম্যানেজমেন্ট
@stop

@section('content')
    <a class="btn btn-primary" data-toggle="modal" href="#create-season">
        <i class="fa fa-plus"></i>&nbsp; নতুন সিজন যোগ করুণ
    </a>
    @include('seasons.modals._create')
    @include('seasons.modals._edit')
    <hr>
    <div class="table-responsive">
		<table class="table table-hover dataTable">
			<thead>
			<tr>
				<th>সিজনের নাম</th>
				<th> শুরুর তারিখ </th>
				<th> শেষের তারিখ </th>
				<th> সিজন স্ট্যাটাস </th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			@if(count($seasons))
				@foreach($seasons as $season)
					<tr>
						<td>{{ $season->name }}</td>
						<td>{{ entobn($season->start_date->format('M d, Y')) }}</td>
						<td>{{ entobn($season->end_date ? $season->end_date->format('M d, Y') : 'বর্তমান') }}</td>
						<td>{{ $season->active == 1 ? 'বর্তমান সিজন ' : ' ক্লোজড / শেষ' }}</td>
						<td>
							<a href="{{ url('season/' . $season->id . '/edit') }}" class="btn bg-purple btn-round edit">
								<i class="fa fa-edit"></i>
							</a>
						</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="7" class="text-center">No Business Season found in the System!!</td>
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
                "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 0, 1, 2, 3 ] }]
            });

            var dateNow = new Date();
            $('.datepicker').datetimepicker({
                format: 'YYYY-MM-DD 00:00:01'
            });

            var lada = $( '.ladda' ).ladda();
            $("#new-season").on('submit', function(e){
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
                        }else{
                            $("#create-season").modal('hide');
                            location.reload();
                        }
                        lada.ladda('stop');
                    }
                });
            });

            $(".edit").on('click', function(e){
                var form = $("#edit-season-form");
                e.preventDefault();
                $('#edit-season').modal('show');
                $.get($(this).attr('href'), function(response){
                    var obj = response[0];
                    form.attr('action', form.attr('action') + "/" + obj.id);
                    form.find('input[name="name"]').val(obj.name);
                    form.find('input[name="start_date"]').val(obj.start_date);
                    form.find('input[name="end_date"]').val(obj.end_date ? obj.end_date : null);
                    if(obj.active == 1)
                    {
                        form.find('select option[value="1"]').attr('selected', true);
                    }else{
                        form.find('select option[value="0"]').attr('selected', true);
                    }
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
                                $("#edit-season").modal('hide');
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