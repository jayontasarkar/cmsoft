@extends('templates.master-profile')

@section('page')
    {{ $profile->name }} এর মেসেজ বক্স
@stop

@section('breadcrumb')
    @include('templates._partials.breadcrumb', ['title' => 'মেসেজ বক্স', 'links' => [$profile->name => 'profile', 'ইনবক্স' => 'inbox']])
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ asset('img/user4-128x128.jpg') }}" alt="User profile picture">

                    <h3 class="profile-username text-center">
                        <a href="{{ url('profile') }}">{{ $profile->name }}</a>
                    </h3>

                    <p class="text-muted text-center">+88{{ entobn($profile->phone) }}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>ইউজারনেম</b> <a class="pull-right"> {{ $profile->username }} </a>
                        </li>
                        <li class="list-group-item">
                            <b>যোগদান : </b> <a class="pull-right">{{ entobn($profile->created_at->format('M d, Y')) }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>ইউজার টাইপ </b> <a class="pull-right">{{ ucfirst($profile->type) }}</a>
                        </li>
                    </ul>
                    <a href="{{ url('profile') }}" class="btn btn-primary btn-block block-me">
                        <i class="fa fa-hand-o-left"></i>&nbsp;<b>প্রোফাইল পেজ</b>
                    </a>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <!-- The timeline -->
            <ul class="timeline timeline-inverse">
                <!-- timeline time label -->
                <li class="time-label">
            <span class="bg-red">
              {{ entobn(date('d  M  Y')) }}
            </span>
                </li>
                <!-- /.timeline-label -->
                @if(count($messages))
                @foreach($messages as $message)
                        <!-- timeline item -->
                <li class="msg-item box-message">
                    <i class="fa fa-envelope bg-blue"></i>

                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> {{ $message->created_at->diffForHumans() }}</span>

                        <h3 class="timeline-header"><a>{{ $message->sender->name }}</a> sent you a message</h3>

                        <div class="timeline-body">
                            <p>
                                <b>{{ $message->subject }}</b>
                            </p>
                            <p>
                                {{ $message->message }}
                            </p>
                        </div>
                        <div class="timeline-footer">
                            <a href="{{ url('message/destroy/' . $message->id) }}"
                               class="btn btn-danger btn-xs btn-delete-msg">Delete</a>
                        </div>
                    </div>
                </li>
                @endforeach
                @else
                <li>
                    <i class="fa fa-envelope bg-blue"></i>
                    <div class="timeline-item" style="background-color: #fff;">
                        <h3 class="text-center">আপনার ইনবক্স এ কোন মেসেজ নেই</h3>
                    </div>
                </li>
                @endif
            </ul>

        </div>
    </div>    

@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            
            $('.btn-delete-msg').on('click', function(e){
                e.preventDefault();
                var $this  = $(this);
                
                swal({
                    title: "Are you sure?",
                    text: "Sure to delete this Message from your Message Inbox?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Delete Message!",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },function(){
                    $.get($this.attr('href'), function(data) {
                        swal({
                            title: "Success?",
                            text: "Message deleted from your Message Inbox",
                            type: "success",
                            timer: 2000,   
                            showConfirmButton: false
                        });
                        $this.closest('li.box-message').fadeOut(700);
                    });
                });
            });
        });
    </script>
@stop
