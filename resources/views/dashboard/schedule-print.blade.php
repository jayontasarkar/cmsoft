@extends('templates.master-printable')

@section('title')
    {{ $business->title }}
@stop

@section('content')
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> {{ $business->name }}
                <small class="pull-right"> তারিখ : {{ entobn(date('d/m/Y')) }}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-12 invoice-col">
            <strong> প্রকল্প অনুসারে আজকের সেচের সিডিউল </strong><br>
            তারিখ : {{ entobn(date('m/d/Y')) }}
        </div>
    </div>
    <!-- /.row -->
    <hr>
    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center"> সদস্যর নাম </th>
                    <th class="text-center"> মোবাইল নং </th>
                    <th class="text-center"> সেচের জমির বিষদ বিবরণ </th>
                    <th class="text-center"> জমির পরিমাণ </th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;?>
                @foreach($business->schedules as $schedule)
                    <tr>
                        <td class="text-center">{{ entobn($i) }}</td>
                        <td class="text-center">{{ $schedule->customer->name }}</td>
                        <td class="text-center">{{ entobn($schedule->customer->phone) }}</td>
                        <td class="text-center">
                            {{ $schedule->description ? $schedule->description : ' বিষদ বিবরণ দেয়া হয় নি ' }}
                        </td>
                        <td class="text-center">{{ entobn($schedule->quantity) }} একর</td>
                    <?php $i++; ?>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
@stop
