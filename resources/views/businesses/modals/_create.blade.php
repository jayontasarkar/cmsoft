<div class="modal fade" id="create-business">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> নতুন প্রকল্প যোগ করুন </h4>
            </div>
            <form action="{{ url('business') }}" method="POST" class="form-horizontal" id="new-business" role="form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="control-label col-md-3"> নতুন প্রকল্পের নাম </label>
                        <div class="col-md-8">
                            <input type="text" id="name" name="name" class="form-control" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label col-md-3"> প্রকল্পের বর্ণনা </label>
                        <div class="col-md-8">
                            <textarea name="description" id="description" cols="30" rows="4" class="form-control">
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="business_id" class="control-label col-md-3"> প্রধান ব্যবসা প্রকল্পের নাম </label>
                        <div class="col-md-8">
                            @include('templates.composers.businessSelect')
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rate" class="control-label col-md-3"> পানির রেট/একর </label>
                        <div class="col-md-8">
                            <div class='input-group'>
                                <input type='text' class="form-control" name="rate" />
                                <span class="input-group-addon">
                                    /একর
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ক্লোজ</button>
                    <button type="submit" class="btn btn-primary ladda" data-style="expand-right">
                        সেভ করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>