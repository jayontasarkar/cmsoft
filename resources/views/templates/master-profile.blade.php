<!DOCTYPE html>
<html ng-app="CMAPP">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
    @yield('page')
  </title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
  <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <script type="text/javascript">
    var TOKEN = "{{ csrf_token() }}";
  </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  @include('templates._partials.header')

  @include('templates._partials.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('breadcrumb')
    <!-- Main content -->
    <section class="content">
      @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible flash-message">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Successfull!</h4>
            {{ Session::get('success') }}
        </div>
      @endif

      @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('templates._partials.footer')

  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/theme.js') }}"></script>

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

@yield('script')
</body>
</html>
