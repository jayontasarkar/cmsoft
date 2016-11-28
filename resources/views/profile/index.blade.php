@extends('templates.master-profile')

@section('page')
	{{ $profile->name }}
@stop

@section('breadcrumb')
	@include('templates._partials.breadcrumb', ['title' => 'ইউজার প্রোফাইল', 'links' => [$profile->name => 'profile']])
@stop

@section('content')
	<div class="row">
		<div class="col-md-3">

			<!-- Profile Image -->
			<div class="box box-primary">
				<div class="box-body box-profile">
					<img class="profile-user-img img-responsive img-circle" src="{{ asset('img/user4-128x128.jpg') }}" alt="User profile picture">

					<h3 class="profile-username text-center">
                        {{ $profile->name }}
                    </h3>

					<p class="text-muted text-center">+88{{ $profile->phone }}</p>

					<ul class="list-group list-group-unbordered">
						<li class="list-group-item">
							<b>ইউজারনেম :</b> <a class="pull-right"> {{ $profile->username }} </a>
						</li>
						<li class="list-group-item">
							<b>যোগদান : </b> <a class="pull-right">{{ entobn($profile->created_at->format('M d, Y')) }}</a>
						</li>
						<li class="list-group-item">
							<b>টাইপ : </b> <a class="pull-right">{{ ucfirst($profile->type) }}</a>
						</li>
					</ul>
					<a href="{{ url('profile/block') }}" class="btn btn-primary btn-block block-me">
                        <b>অ্যাকাউন্ট ব্লক</b>
                    </a>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->
		<div class="col-md-9">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active">
                        <a href="#timeline" data-toggle="tab">টাইমলাইন</a>
                    </li>
					<li>
                        <a href="#activity" data-toggle="tab"> মেসেজ পাঠান</a>
                    </li>
					<li>
                        <a href="#settings" data-toggle="tab">প্রোফাইল পরিবর্তন</a>
                    </li>
                    <li>
                        <a href="#password" data-toggle="tab">পাসওয়ার্ড পরিবর্তন </a>
                    </li>
				</ul>
				<div class="tab-content">

					<div class="active tab-pane" id="timeline">
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
                            @foreach($messages->take(6) as $message)
							<!-- timeline item -->
							<li class="msg-item box-msg">
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
                                           class="btn btn-danger btn-xs delete-msg btn-delete-msg"
                                        >Delete</a>
									</div>
								</div>
							</li>
                            @endforeach
                            @else
                                <li>
                                    <i class="fa fa-envelope bg-blue"></i>
                                    <div class="timeline-item" style="background-color: #fff;">
                                         <h3 class="text-center">No messages found in your Inbox</h3>
                                    </div>
                                </li>
                            @endif
							<!-- END timeline item -->
                            @if(count($messages) > 6)
                                <li class="load-all-messages">
                                    <i class="fa fa-envelope bg-blue"></i>
                                    <div class="timeline-item text-center" style="font-size: 19px; background-color: #fff;border: none;">
                                        <a href="{{ url('messages/inbox') }}" class="btn btn-round text-center btn-primary">
                                            সকল মেসেজ দেখুন...
                                        </a>
                                    </div>
                                </li>
                            @endif
						</ul>

					</div>
					<!-- /.tab-pane -->

                    <div class="tab-pane" id="activity">

                        <form class="form-horizontal" method="POST" action="{{ url('profile/message') }}">

                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="user_id" class="col-sm-2 control-label">নাম (যাকে পাঠাবেন) :</label>

                                <div class="col-sm-10">
                                    @include('templates.composers.userSelect')
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subject" class="col-sm-2 control-label"> মেসেজ সাবজেক্ট :</label>

                                <div class="col-sm-10">
                                    <input type="text" name="subject" class="form-control" required min="5"
                                           id="subject" placeholder="Message Subject">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message" class="col-sm-2 control-label"> মেসেজ :</label>

                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="6" name="message" required
                                              id="message" placeholder="Message"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-info btn-round"> মেসেজ পাঠান</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- /.tab-pane -->

					<div class="tab-pane" id="settings">
						<form class="form-horizontal" method="post" action="{{ url('profile/settings/' . $profile->id) }}"
                              id="frm-settings">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <input type="hidden" name="id" value="{{ $profile->id }}">
							<div class="form-group">
								<label for="inputName" class="col-sm-2 control-label">নাম :</label>

								<div class="col-sm-10">
									<input type="text" name="name"  class="form-control" id="inputName"
                                           placeholder="Name" value="{{ $profile->name }}">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail" class="col-sm-2 control-label">ইউজারনেম :</label>

								<div class="col-sm-10">
									<input type="text" name="username" class="form-control" id="inputEmail"
                                           placeholder="Username" value="{{ $profile->username }}">
								</div>
							</div>
							<div class="form-group">
								<label for="inputName" class="col-sm-2 control-label">মোবাইল নং.</label>

								<div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon">+88</span>
                                        <input type="text" class="form-control" id="inputName" name="phone"
                                               placeholder="Phone Number" value="{{ $profile->phone }}">
                                    </div>
								</div>
							</div>
							<div class="form-group">
								<label for="inputExperience" class="col-sm-2 control-label">ঠিকানা :</label>

								<div class="col-sm-10">
									<textarea class="form-control" id="inputExperience" name="address" maxlength="300"
                                              placeholder="Experience">{{ $profile->address }}</textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-danger">সেভ করুন</button>
								</div>
							</div>
						</form>
					</div>
					<!-- /.tab-pane -->
                    <div class="tab-pane" id="password">
                        <form class="form-horizontal" method="post" action="{{ url('profile/change/password/' . $profile->id) }}"
                              id="frm-pwd">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <input type="hidden" name="id" value="{{ $profile->id }}">
                            <div class="form-group">
                                <label for="old" class="col-sm-3 control-label">বর্তমান পাসওয়ার্ড :</label>

                                <div class="col-sm-9">
                                    <input type="password" name="old_password"  class="form-control" id="old"
                                           placeholder="Current Password" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new" class="col-sm-3 control-label"> নতুন পাসওয়ার্ড :</label>

                                <div class="col-sm-9">
                                    <input type="password" name="password" class="form-control" id="inputEmail"
                                           placeholder="New Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm" class="col-sm-3 control-label">কনফার্ম পাসওয়ার্ড :</label>

                                <div class="col-sm-9">
                                    <input type="password" name="password_confirmation" class="form-control" id="confirm"
                                           placeholder="Password Confirmation">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-danger">সেভ করুন</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
				</div>
				<!-- /.tab-content -->
			</div>
			<!-- /.nav-tabs-custom -->
		</div>
		<!-- /.col -->
	</div>
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            var block  = $('.block-me');

            block.on('click', function(e){
                e.preventDefault();

                swal({
                    title: "Are you sure?",
                    text: "Blocking your account you can't access your account again!! Wish to continue?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Block my account!",
                    closeOnConfirm: false
                },function(){
                    window.location.href = block.attr('href');
                });
            });

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
                        if( $this.parents('.timeline').children('li.box-msg').length < 7) {
                            $('.load-all-messages').fadeOut(700);
                        }
                        $this.closest('li.box-msg').fadeOut(700);
                    });
                });
            });
        });
    </script>
    {!! JsValidator::formRequest('App\Http\Requests\ProfileUpdateRequest', '#frm-settings') !!}
    {!! JsValidator::formRequest('App\Http\Requests\PasswordChangeRequest', '#frm-pwd') !!}
@stop