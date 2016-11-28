<?php $__env->startSection('page'); ?>
    সকল প্রকল্প সদস্যর তালিকা
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
	<?php echo $__env->make('templates._partials.breadcrumb', ['title' => 'প্রকল্প সদস্যর তালিকা', 'links' => ['সদস্যর তালিকা' => 'customer' ]], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('box-title'); ?>
    সকল প্রকল্প সদস্যর তালিকা
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <a class="btn btn-primary" data-toggle="modal" href="#create-customer">
        <i class="fa fa-plus"></i> &nbsp;নতুন সদস্য যোগ করুন</a>
    <hr>
    <?php echo $__env->make('customers.modals._create', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('customers.modals._edit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

	<div class="table-responsive">
		<table class="table table-hover" id="dataTable">
			<thead>
				<tr>
					<th>সদস্যর নাম</th>
					<th>মোবাইল নং</th>
					<th style="width : 25%;">সদস্যর ঠিকানা</th>
					<th>রেজিস্ট্রেশনের তারিখ</th>
					<th>এলাকার নাম</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php if(count($customers)): ?>
                <?php foreach($customers as $customer): ?>
				<tr>
					<td><a href="<?php echo e(url('customer/' . $customer->id)); ?>"><?php echo e($customer->name); ?></a></td>
					<td><?php echo e(entobn($customer->phone)); ?></td>
					<td style="width : 25%;"><?php echo e($customer->address ? $customer->address : 'No address details provided'); ?></td>
					<td><?php echo e(entobn($customer->created_at->format('M d,  Y'))); ?></td>
					<td><?php echo e($customer->area->name); ?></td>
                    <td style="width: 11%;">
                        <a href="<?php echo e(url('customer/' . $customer->id . '/edit')); ?>" class="edit btn bg-blue-gradient btn-round" data-toggle="tooltip" data-placement="top"
                           title="এডিট  : &nbsp;&nbsp; <?php echo e($customer->name); ?> ?">
                            <i class="fa fa-edit"></i>
                        </a>&nbsp;&nbsp;&nbsp;
                        <a  href="<?php echo e(url('customer/' . $customer->id)); ?>" 
                            data-toggle="tooltip" 
                            data-placement="top"
                            title="প্রোফাইল  : &nbsp;&nbsp;<?php echo e($customer->name); ?> " 
                            class="btn bg-aqua btn-round"
                        >
                            <i class="fa fa-search-plus"></i>
                        </a>
                    </td>
				</tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">কোন সদস্য খুঁজে পাওয়া যায় নি</td>
                </tr>
            <?php endif; ?>
			</tbody>
		</table>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        $(document).ready(function(){
           $('#dataTable').dataTable({
               "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 2, 3, 5 ] }],
			   "lengthMenu": [[50, 75, 100, -1], [50, 75, 100, "All"]]
           });
            var lada = $( '.ladda' ).ladda();
            $("#new-customer").on('submit', function(e){
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
                                $this.find('input[name="name"]').closest('.form-group').removeClass('has-error').addClass('has-error');
                                $this.find('input[name="name"]')
                                        .append('<span class="help-block">' + response.error.name[0] + '</span>');
                            }
                            if(response.error.phone)
                            {
                                $this.find('input[name="phone"]').closest('.form-group').removeClass('has-error').addClass('has-error');
                                $this.find('input[name="phone"]')
                                        .append('<span class="help-block">' + response.error.phone[0] + '</span>');
                            }
                        }else{
                            $("#create-customer").modal('hide');
                            location.reload();
                        }
                        lada.ladda('stop');
                    }
                });
            });

            $(".edit").on('click', function(e){
                e.preventDefault();
                var form = $("#edit-customer-form");
                $('#edit-area').modal('show');
                $.get($(this).attr('href'), function(response){
                    var obj = response[0];
                    form.attr('action', form.attr('action') + "/" + obj.id);
                    form.find('input[name="name"]').val(obj.name);
                    form.find('input[name="phone"]').val(obj.phone);
                    form.find('textarea[name="address"]').val(obj.address);
                    form.find('#select-area option').each(function(){
                        if($(this).val() == obj.area_id){
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
                                if(response.error.phone) {
                                    $this.find('input[name="phone"]').closest('.form-group').addClass('has-error');
                                    $this.find('input[name="phone"]')
                                            .append('<span class="help-block">' + response.error.phone[0] + '</span>');
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>