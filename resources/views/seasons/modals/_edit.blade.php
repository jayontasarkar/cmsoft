<div class="modal fade" id="edit-season">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> প্রকল্পের সিজন তথ্য পরিবর্তন/এডিট করুণ</h4>
            </div>
            <form action="{{ url('season') }}" method="POST" class="form-horizontal" id="edit-season-form" role="form">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="start_date" class="control-label col-md-3">শুরুর তারিখ</label>
                        <div class="col-md-8">
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" class="form-control datepicker" name="start_date"
                                       value="">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end_date" class="control-label col-md-3">শেষের তারিখ</label>
                        <div class="col-md-8">
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" class="form-control datepicker" name="end_date"
                                       value="">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="active" class="control-label col-md-3">সিজন স্ট্যাটাস</label>
                        <div class="col-md-8">
                            <select name="active" id="active" class="form-control">
                                <option value="1">বর্তমান সিজন</option>
                                <option value="0"> ক্লোজড / শেষ </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label col-md-3">সিজনের নাম</label>
                        <div class="col-md-8">
                            <input type="text" id="name" value="" name="name" class="form-control" required autocomplete="off">
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