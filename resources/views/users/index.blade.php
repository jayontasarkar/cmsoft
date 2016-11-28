@extends('templates.master')

@section('page')
	সফটওয়্যার বাবহারকারীর তালিকা
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'এডমিন ইউজার ম্যানেজমেন্ট ', 'links' => ['ইউজার ম্যানেজমেন্ট' => 'users' ]])
@stop

@section('box-title')
	সফটওয়্যার বাবহারকারীর তালিকা
@stop

@section('content')
	<div class="table-responsive">
		<table class="table table-hover dataTable">
			<thead>
				<tr>
					<th>বাবহারকারীর নাম</th>
					<th>ইউজারনেম</th>
					<th>মোবাইল নং.</th>
					<th>ইউজার টাইপ</th>
					<th>অ্যাক্টিভ / ব্লক</th>
					<th>যোগদানের তারিখ </th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@if(count($users))
                @foreach($users as $user)
				<tr class="{{ $user->active ? '' : 'danger' }}">
					<td>{{ $user->name }}</td>
					<td>{{ $user->username }}</td>
					<td>{{ entobn($user->phone) }}</td>
					<td>{{ ucfirst($user->type) }}</td>
					<td>
                        @if($user->active == 1)
                            <span class="text-success">অ্যাক্টিভ</span>
                        @else
                            <span class="text-warning">ব্লক</span>
                        @endif
                    </td>
					<td>{{ ucfirst(entobn($user->created_at->format('M d, Y'))) }}</td>
                    <td>
                        <a href="{{ url('users/' . $user->id . '/edit') }}" 
                           class="btn bg-purple btn-round" 
                           data-toggle="tooltip" 
                           data-placement="top"
                           title="এডিট  : &nbsp;&nbsp;{{$user->name}}"
                        >
                            <i class="fa fa-edit"></i>
                        </a>
                        @if($user->active == 1)
                        <a href="{{ url('users/' . $user->id) }}" class="btn bg-orange btn-round disable">
                            <i class="fa fa-close"></i>
                        </a>
                        @else
                            <a href="{{ url('users/' . $user->id) }}" class="btn bg-olive btn-round activate">
                                <i class="fa fa-close"></i>
                            </a>
                        @endif
                    </td>
				</tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center"> অন্য কোন লগইন ইউজার খুঁজে পাওয়া যায় নি </td>
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
               "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 2, 3, 4,5,6 ] }]
           });

           $('.disable, .activate').on('click', function(e){
               e.preventDefault();
               var $this = $(this);
               var url   = $this.attr('href');

               swal({
                   title: "Are you sure about this??",
                   text: "Submitting OK, User status will change automatically.",
                   type: "warning",
                   showCancelButton: true,
                   closeOnConfirm: false,
                   showLoaderOnConfirm: true
               }, function(){
                   $.ajax({
                       url : url,
                       type : 'DELETE',
                       data : { _token : TOKEN },
                       success : function(result){
                            swal({
                                title: "Success!!",
                                text: "User status changed successfully.",
                                type: "success"
                            }, function(){
                                location.reload();
                            });
                       }
                   });
               });

           });
        });
    </script>
@stop