<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>GSM Module Test</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="/css/gsm.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Bootstrap theme</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav pull-right">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>

    <div class="container">
      <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="text-center">Name</th>
              <th class="text-center">Meter No.</th>
              <th class="text-center">Energy Value</th>
              <th class="text-center">Remaining Balance</th>
            </tr>
          </thead>
          <tbody>
            @foreach($clients as $client)
            <tr class="text-center">
              <td>{{ $client->name }}</td>
              <td>{{ $client->meter_no }}</td>
              <td>{{ $client->energy_value }}</td>
              <td>{{ $client->remaining_balance }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>   
    </div>


    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>
