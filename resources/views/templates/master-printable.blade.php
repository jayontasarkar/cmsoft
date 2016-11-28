<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>@yield('title')</title>
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        @page {
            size: auto;  /* auto is the initial value */
            margin: 0mm; /* this affects the margin in the printer settings */
        }
        html {
            background-color: #FFFFFF;
            margin: 0px; /* this affects the margin on the HTML before sending to printer */
        }
        body {
            margin: 10mm 15mm 10mm 15mm; /* margin you want for the content */
        }
    </style>
</head>
<body onload="window.print();">
<div class="wrapper">
    <section class="invoice">
        @yield('content')
    </section>
</div>
<!-- ./wrapper -->
</body>
</html>
