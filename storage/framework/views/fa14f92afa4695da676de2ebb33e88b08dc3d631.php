
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Customer Management | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo e(asset('css/vendor.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/theme.css')); ?>">
</head>

<body class="hold-transition login-page">
<?php echo $__env->make('templates._partials.error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo e(url('/')); ?>"><b>Customer</b>Management</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <?php if($errors->first('message')): ?>
      <p class="login-box-msg" style="color: darkred; font-style: italic; font-size: 17px;">
        <?php echo e($errors->first('message')); ?>

      </p>
    <?php else: ?>
      <p class="login-box-msg">Sign in to visit your admin panel</p>
    <?php endif; ?>

    <form action="<?php echo e(url('/')); ?>" method="post">
      <?php echo e(csrf_field()); ?>

      <div class="form-group has-feedback <?php echo e($errors->first('message') ? 'has-error' : ''); ?>">
        <input type="text" class="form-control" placeholder="Username" 
                name="username" autocomplete="off" autofocus required value="<?php echo e(old('username')); ?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember" value="1"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<?php echo $__env->make('sweet::alert', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<!-- jQuery 2.2.3 -->
<script src="<?php echo e(asset('js/vendor.js')); ?>"></script>
<script src="<?php echo e(asset('js/theme.js')); ?>"></script>

<script>
  $(function () {
    $('.flash-message').fadeIn(500).delay(9000).fadeOut(500);
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
