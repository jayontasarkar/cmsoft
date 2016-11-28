<section class="content-header">
  <h1>
    <?php echo e($title); ?>

  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo e(url('dashboard')); ?>"><i class="fa fa-dashboard"></i> হোমপেজ</a></li>
	<?php if(isset($links)): ?>
	    <?php foreach($links as $key => $value): ?>
	    	<li><a href="<?php echo e(url($value)); ?>"><?php echo e(ucfirst($key)); ?></a></li>
	    <?php endforeach; ?>
    <?php endif; ?>
  </ol>
</section>