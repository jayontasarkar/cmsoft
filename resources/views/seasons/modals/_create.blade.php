<div class="modal fade" id="create-season">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">প্রকল্পের নতুন সিজন যোগ করুণ</h4>
            </div>
            <form action="{{ url('season') }}" method="POST" class="form-horizontal" id="new-season" role="form">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="start_date" class="control-label col-md-3">শুরুর তারিখ</label>
                    <div class="col-md-8">
                        <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control datepicker" name="start_date" value="{{ date('Y-m-d') }}">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="control-label col-md-3"> সিজনের নাম</label>
                        <div class="col-md-8">
                            <input type="text" id="name" name="name" class="form-control" required autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ক্লোজ</button>
                    <button type="submit" class="btn btn-primary ladda" data-style="expand-right">সেভ করুন</button>
                </div>
            </form>
        </div>
    </div>
</div>