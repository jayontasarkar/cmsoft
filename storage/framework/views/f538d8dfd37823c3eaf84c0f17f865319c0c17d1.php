<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo e(asset('img/user2-160x160.jpg')); ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo e(auth()->user()->name); ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class="treeview">
        <a href="<?php echo e(url('dashboard')); ?>">
          <i class="fa fa-dashboard"></i> <span>এডমিন ড্যাশবোর্ড</span>
        </a>
      </li>
      <?php if(auth()->user()->type == 'administrator'): ?>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-user"></i>
          <span> ইউজার ম্যানেজমেন্ট  </span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="<?php echo e(url('users')); ?>"><i class="fa fa-circle-o"></i> লগইন ইউজার লিস্ট </a>
            </li>
            <li>
                <a href="<?php echo e(url('users/create')); ?>"><i class="fa fa-circle-o"></i> নতুন লগইন ইউজার </a>
            </li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
            <i class="fa fa-cogs"></i>
            <span> সফটওয়্যার সেটিংস </span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo e(url('business')); ?>"><i class="fa fa-circle-o"></i> প্রকল্পের সেটিংস </a></li>
            <li><a href="<?php echo e(url('season')); ?>"><i class="fa fa-circle-o"></i> সিজন সেটিংস </a></li>
            <li><a href="<?php echo e(url('area')); ?>"><i class="fa fa-circle-o"></i> এরিয়া সেটিংস </a></li>
        </ul>
      </li>
      <?php endif; ?>
      <li class="treeview">
        <a href="<?php echo e(url('customer')); ?>">
            <i class="fa fa-user-secret"></i>
            <span> কাস্টমার ম্যানেজমেন্ট </span>
        </a>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i>
          <span> ডাটা এন্ট্রি অপারেশন </span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo e(url('schedule/search/1')); ?>"><i class="fa fa-circle-o"></i> বর্তমান সিজনের সিডিউল </a></li>
          <li><a href="<?php echo e(url('schedule/create')); ?>"><i class="fa fa-circle-o"></i> নতুন সিডিউল যুক্ত করুন </a></li>
          <li><a href="<?php echo e(url('payment')); ?>"><i class="fa fa-circle-o"></i> কাস্টমারের বিল পেমেন্ট </a></li>
          <?php if( auth()->user()->type == 'administrator' ): ?>
          <li>
              <a href="<?php echo e(url('payment/lists')); ?>"><i class="fa fa-circle-o"></i> পেমেন্ট আপডেট/পরিবর্তন </a>
          </li>
          <?php endif; ?>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i>
          <span> ব্যয়ের হিসাব </span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo e(url('expense')); ?>"><i class="fa fa-circle-o"></i> ব্যয়ের সকল হিসাব </a></li>
          <li><a href="<?php echo e(url('expense/create')); ?>"><i class="fa fa-circle-o"></i> নতুন ব্যয় যোগ করুন </a></li>
        </ul>
      </li>
        <?php if(auth()->user()->type == 'administrator'): ?>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-area-chart"></i>
                <span> প্রকল্পের  রিপোর্ট </span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?php echo e(url('report')); ?>"><i class="fa fa-circle-o"></i> ব্যবসার প্রধান রিপোর্ট </a></li>
                <li><a href="<?php echo e(url('sub')); ?>"><i class="fa fa-circle-o"></i> প্রকল্প অনুসারে রিপোর্ট </a></li>
            </ul>
        </li>
        <?php endif; ?>
    </ul>
  </section>
</aside>