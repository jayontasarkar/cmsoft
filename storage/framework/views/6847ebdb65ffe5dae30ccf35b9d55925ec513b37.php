<!DOCTYPE html>
<html ng-app="CMAPP">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
    <?php echo $__env->yieldContent('page'); ?>
  </title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="<?php echo e(asset('css/vendor.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/theme.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
  <script type="text/javascript">
    var TOKEN = "<?php echo e(csrf_token()); ?>";
  </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php echo $__env->make('templates._partials.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <?php echo $__env->make('templates._partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php echo $__env->yieldContent('breadcrumb'); ?>
    <!-- Main content -->
    <section class="content">

      <?php echo $__env->make('templates._partials.success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php echo $__env->make('templates._partials.error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">
            <?php echo $__env->yieldContent('box-title'); ?>
          </h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <?php echo $__env->yieldContent('content'); ?>
        </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php echo $__env->make('templates._partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<script src="<?php echo e(asset('js/vendor.js')); ?>"></script>
<script src="<?php echo e(asset('js/theme.js')); ?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
       $('.flash-message').fadeIn(500).delay(9000).fadeOut(500);
      $(".select2").select2({
          placeholder: {
              id: '-1',
              text: 'Select an Option'
          },
          width : '100%'
      });
    });
</script>

<?php echo $__env->yieldContent('script'); ?>
</body>
</html>
