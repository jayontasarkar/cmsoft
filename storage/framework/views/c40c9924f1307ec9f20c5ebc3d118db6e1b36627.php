<div class="modal fade" id="edit-area">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">সদস্যর তথ্য পরিবর্তন/এডিট করুণ</h4>
            </div>
            <form action="<?php echo e(url('customer')); ?>" method="POST" class="form-horizontal" id="edit-customer-form" role="form">
                <?php echo e(csrf_field()); ?>

                <?php echo e(method_field('PATCH')); ?>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="control-label col-md-3">সদস্যর নাম</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" id="name" name="name" value=""
                                       class="form-control" required autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label col-md-3">মোবাইল নং</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon">+88</span>
                                <input type="text" id="phone" name="phone" value=""
                                       class="form-control" required autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label col-md-3">সদস্যর ঠিকানা</label>
                        <div class="col-md-8">
                            <textarea name="address" id="address" cols="30" rows="4" class="form-control">
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="area_id" class="control-label col-md-3">এলাকার নাম</label>
                        <div class="col-md-8">
                            <?php echo $__env->make('templates.composers.areaSelect', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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