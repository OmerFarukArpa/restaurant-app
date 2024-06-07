@extends('admin.layouts.app')

@section('title')
    Gösterge Paneli
@endsection

@php
    $messageCount = \App\Models\Message::with('user')
    ->whereHas('user',function ($query){
        $query->where('user_name','!=','admin');
    })
    ->where('read_at',0)
    ->count();

    $pendingReservationsCount = \App\Models\Reservation::whereHas('reservationStatus', function($query) {
        $query->where('status', 'pending');
    })->count();

    $totalReservationCount = \App\Models\Reservation::count();
    $userCount = \App\Models\User::whereNot('id',1)->count()
@endphp

@section('css')
    <style>
        a,a:hover{
            color: inherit !important;
            text-decoration: none;
            transition: all 0.3s;
        }
        a:hover{
            transform: scale(1.04);
        }
    </style>
@endsection

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                    <a href="{{route('messages')}}" class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{$messageCount ?? 0}}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-success">
                                        <span class="mdi mdi-message-text-outline icon-item"></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Mesajlar</h6>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                    <a href="{{route('reservations')}}" class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{$pendingReservationsCount ?? 0}}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-success">
                                        <span class="mdi mdi-account-check icon-item"></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">İşlem yapılmamış <br> rezarvasyon sayısı</h6>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                    <a href="{{route('users')}}" class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{$userCount ?? 0}}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-success ">
                                        <span class="mdi mdi-account icon-item"></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Kullanıcı sayısı</h6>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Toplam Gelir</h4>
                            <canvas id="transaction-history" class="transaction-chart"></canvas>
                            <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                                <div class="text-md-center text-xl-left">
                                    <h6 class="mb-1">Toplam gelir</h6>
                                    <p class="text-muted mb-0">07 Jan 2019, 09:12AM</p>
                                </div>
                                <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                                    <h6 class="font-weight-bold mb-0">₺{{$totalPrice}}</h6>
                                </div>
                            </div>
                            <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                                <div class="text-md-center text-xl-left">
                                    <h6 class="mb-1">Toplam rezarvasyon sayısı</h6>
                                    <p class="text-muted mb-0">07 Jan 2019, 09:12AM</p>
                                </div>
                                <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                                    <h6 class="font-weight-bold mb-0">{{$totalReservationCount ?? 0}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between">
                                <h4 class="card-title mb-1">Mesajlar</h4>
                                <p class="text-muted mb-1">Son 5 mesaj</p>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="preview-list">
                                        @foreach($messages as $key => $message)
                                            <div class="preview-item {{$key != 4 ? 'border-bottom' : ''}}">
                                                <div class="preview-thumbnail">
                                                    <div class="preview-icon bg-primary">
                                                        <i class="mdi mdi-message-reply-text"></i>
                                                    </div>
                                                </div>
                                                <div class="preview-item-content d-sm-flex flex-grow">
                                                    <div class="flex-grow">
                                                        <h6 class="preview-subject">{{ $message->topic->name }}</h6>
                                                        <p class="text-muted mb-0">{{$message->message}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2024</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> <a href="https://www.firat.edu.tr/tr" target="_blank">Fırat Üniversitesi</a> Fonksiyonel Programlama Dersi</span>
            </div>
        </footer>
        <!-- partial -->
    </div>
@endsection

@section('js')
    <script>
        if ($("#transaction-history").length) {
            var areaData = {
                labels: ["Paypal", "Stripe","Cash"],
                datasets: [{
                    data: [55, 25, 20],
                    backgroundColor: [
                        "#111111","#00d25b","#ffab00"
                    ]
                }
                ]
            };
            var areaOptions = {
                responsive: true,
                maintainAspectRatio: true,
                segmentShowStroke: false,
                cutoutPercentage: 70,
                elements: {
                    arc: {
                        borderWidth: 0
                    }
                },
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: true
                }
            }
            var transactionhistoryChartPlugins = {
                beforeDraw: function(chart) {
                    var width = chart.chart.width,
                        height = chart.chart.height,
                        ctx = chart.chart.ctx;

                    ctx.restore();
                    var fontSize = 1;
                    ctx.font = fontSize + "rem sans-serif";
                    ctx.textAlign = 'left';
                    ctx.textBaseline = "middle";
                    ctx.fillStyle = "#ffffff";

                    var text = "₺{{$totalPrice}}",
                        textX = Math.round((width - ctx.measureText(text).width) / 2),
                        textY = height / 2.4;

                    ctx.fillText(text, textX, textY);

                    ctx.restore();
                    var fontSize = 0.75;
                    ctx.font = fontSize + "rem sans-serif";
                    ctx.textAlign = 'left';
                    ctx.textBaseline = "middle";
                    ctx.fillStyle = "#6c7293";

                    var texts = "Toplam",
                        textsX = Math.round((width - ctx.measureText(text).width) / 1.93),
                        textsY = height / 1.7;

                    ctx.fillText(texts, textsX, textsY);
                    ctx.save();
                }
            }
            var transactionhistoryChartCanvas = $("#transaction-history").get(0).getContext("2d");
            var transactionhistoryChart = new Chart(transactionhistoryChartCanvas, {
                type: 'doughnut',
                data: areaData,
                options: areaOptions,
                plugins: transactionhistoryChartPlugins
            });
        }
    </script>
@endsection
