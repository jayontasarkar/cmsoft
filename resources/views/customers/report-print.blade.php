@extends('templates.master-printable')

@section('title')
    {{ $business->title }}
@stop

@section('content')
        <!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> {{ $business->name }}
                <small class="pull-right">তারিখ : {{ entobn(date('d/m/Y')) }}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-6 invoice-col">
            <address>
                <strong>{{ $business->name }}</strong><br>
                {{ $business->address }}
                মোবাইল : <br> +88০১৭১২৯২৪১৬১, +88০১৭৩৩২৫৪৭২০
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-6 invoice-col pull-right">
            <address>
                <strong>{{ $customer->name }}</strong><br>
                {{ $customer->address }} <br>
                মোবাইল : {{ $customer->phone }}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-xs-12 text-center">
            <b> <strong>  সিজন </strong>:
                {{ $info->name }}
                ({{ entobn($info->start_date->format('M d, Y')) }} &nbsp;-&nbsp;
                {{ entobn($info->end_date ? $info->end_date->format('M d, Y') : 'বর্তমান') }})
            </b>
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
                    <th class="text-center">#</th>
                    <th class="text-center">গভীর নলকূপ</th>
                    <th class="text-center">জমি (একর)</th>
                    <th class="text-center">সাপ্লাইয়ের তারিখ</th>
                    <th class="text-center">টাকার পরিমাণ</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; $total_paid = 0; $total_discount = 0; $grand = 0;?>
                @foreach($customer->schedules as $schedule)
                    <tr>
                        <?php 
                            $sub = $schedule->quantity * $schedule->business->rate; 
                            $discount = $schedule->discount ? $sub * $schedule->discount / 100 : '০.০০';
                            $paid = sumPayments($schedule->payments->toArray());
                            $total = $sub - $discount - $paid;
                        ?>
                        <td style="display: table-cell; vertical-align: middle; text-align: center;">
                            {{ entobn($i) }}
                        </td>
                        <td style="display: table-cell; vertical-align: middle; text-align: center;">
                            {{ $schedule->business->name }}
                        </td>
                        <td style="display: table-cell; vertical-align: middle; text-align: center;">
                            {{ entobn($schedule->quantity) }}
                        </td>
                        <td style="display: table-cell; vertical-align: middle; text-align: center;">
                            {{ entobn($schedule->event_date->format('d-M-Y')) }}
                        </td>
                        <td style="margin: 0;padding: 0;">
                            <table class="table table-bordered" style="margin: 0;padding: 0;">
                                <tr>
                                    <td>মোট পরিমাণ</td>
                                    <td>{{ entobn($sub) }}/=</td>
                                </tr>
                                <tr>
                                    <td>প্রদান</td>
                                    <td>{{ entobn($paid) }}/=</td>
                                </tr>
                                <tr>
                                    <td>ডিস্কাউন্ট</td>
                                    <td>{{ entobn($discount)  }}/=</td>
                                </tr>
                                <tr>
                                    <td>বকেয়া</td>
                                    <td>{{ entobn($total) }}/=</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php $i++; $total_paid += $paid; $total_discount += $discount; $grand += $total; ?>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-7">

        </div>
        <!-- /.col -->
        <div class="col-xs-5">

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:80%">সমগ্র প্রদান :</th>
                        <td>{{ entobn($total_paid) }}/=</td>
                    </tr>
                    <tr>
                        <th style="width:80%">সমগ্র ডিস্কাউন্ট :</th>
                        <td>{{ $total_discount > 0 ? entobn($total_discount) : '০.০০' }}/=</td>
                    </tr>
                    <tr>
                        <th style="width:80%">সমগ্র বকেয়া :</th>
                        <td>{{ entobn($grand) }}/=</td>
                    </tr>

                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@stop
