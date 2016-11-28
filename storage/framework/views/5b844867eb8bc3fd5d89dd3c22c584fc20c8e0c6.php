<?php $__env->startSection('page'); ?>
    সফটওয়্যার ড্যাশবোর্ড
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
	<?php echo $__env->make('templates._partials.breadcrumb', ['title' => 'সফটওয়্যার ড্যাশবোর্ড '], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('box-title'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<h2 class="text-center">স্বাগতম, <?php echo e(auth()->user()->name); ?></h2>
    <hr>
    <h3 class="text-center text-blue">প্রকল্প অনুসারে আজকের সেচের সিডিউল ( <?php echo e(entobn(date('M d, Y'))); ?>)</h3>
	<div class="row">
		<div class="col-md-12">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <?php $i = 0; ?>
                <?php foreach($businesses as $business): ?>
				<div class="panel panel-default">
					<div class="box-header with-border panel-heading" role="tab" id="heading<?php echo e($business->id); ?>">
						<h3 class="box-title panel-title"><?php echo e($business->name); ?></h3>

						<div class="box-tools pull-right">
							<button type="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo e($business->id); ?>" aria-expanded="<?php echo e($i == 0 ? 'true' : 'false'); ?>" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						</div>
						<!-- /.box-tools -->
					</div>
					<div id="collapse<?php echo e($business->id); ?>" class="panel-collapse collapse <?php echo e($i = 0 ? 'in' : ''); ?>" role="tabpanel" aria-labelledby="heading<?php echo e($business->id); ?>">
						<div class="panel-body">
						    <?php if(count($business->schedules)): ?>
                                <?php foreach($business->schedules as $schedule): ?>

                                    <a tabindex="0" class="btn btn-lg btn-link popover-btn" role="button" data-toggle="popover"
                                       data-trigger="focus" data-placement="top"
                                       title="<?php echo e($schedule->customer->name); ?> (<?php echo e(entobn($schedule->customer->phone)); ?>)"
                                       data-content="জমির পরিমাণ :
                                       <?php echo e(entobn($schedule->quantity)); ?>  একর |
                                       <?php if($schedule->description): ?> জমির বিবরণ : <?php echo e($schedule->description); ?> <?php endif; ?>"
                                    >
                                            <?php echo e($schedule->customer->name); ?>

                                    </a>

                                <?php endforeach; ?>
                                <h5>
                                    <a href="<?php echo e(url('dashboard/schedule/print/' . $business->id)); ?>" target="_blank"
                                       class="btn btn-link pull-right">
                                        <i class="fa fa-print"></i> প্রিন্ট শিডিউল লিস্ট
                                    </a>
                                </h5>
                            <?php else: ?>
                                <h4 class="text-aqua text-center">
                                    <?php echo e(entobn(date('M d, Y'))); ?> তারিখে "<?php echo e($business->name); ?>" প্রকল্পে কোন শিডিউল  নেই |
                                </h4>
                            <?php endif; ?>
                        </div>
					</div>
				</div>
                <?php $i++; ?>
                <?php endforeach; ?>
            </div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    $(function () {
        $('[data-toggle="popover"]').popover();
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>