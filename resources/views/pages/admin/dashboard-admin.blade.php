@extends('layouts.app')

@section('title', 'Ecommerce Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/flag-icon-css/css/flag-icon.min.css') }}">
@endpush

@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-archive"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pesanan Minggu ini</h4>
                            </div>
                            <div class="card-body">
                                {{ $sales_count }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pendapatan Minggu Ini</h4>
                            </div>
                            <div class="card-body">
                                {{ $this_week_revenue }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Produk</h4>
                            </div>
                            <div class="card-body">
                                {{ $total_products }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Keuntungan Bulan Ini</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart"
                                height="158"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-square-check"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pesanan Dikemas</h4>
                            </div>
                            <div class="card-body">
                                {{ $confirmed_products }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-rectangle-xmark"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pesanan Ditolak</h4>
                            </div>
                            <div class="card-body">
                                {{ $declined_products }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pesanan Diantar</h4>
                            </div>
                            <div class="card-body">
                                {{ $delivering_products }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-people-carry-box"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pesanan Diterima</h4>
                            </div>
                            <div class="card-body">
                                {{ $delivered_products }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Order</h4>
                            <div class="card-header-action">
                                <a href="{{ route('order.index') }}"
                                    class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive table-invoice">
                                <table class="table-striped table">
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                        <th>Due Date</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach($onGoingItems as $onGoingItem)
                                    <tr>
                                        <td><a class="text-reset" style="text-decoration: none" href="/admin/order/{{ $onGoingItem->id }}">{{ $onGoingItem->id }}</a></td>
                                        <td class="font-weight-600">{{ $onGoingItem->name }}</td>
                                        <td>
                                               @if ($onGoingItem->status == 1)
                                               <div class="badge badge-warning bg-warning">Dikemas</div>
                                               @elseif ($onGoingItem->status == 2)
                                               <div class="badge badge-danger">Ditolak</div>
                                               @elseif ($onGoingItem->status == 3)
                                               <div class="badge badge-info">Diantar</div>
                                               @elseif ($onGoingItem->status == 4)
                                               <div class="badge badge-success">Diterima</div>
                                               @else
                                               <div class="badge badge-primary bg-primary">Belum bayar</div>
                                               @endif
                                        </td>
                                        <td>{{ convertDateToIndo($onGoingItem->date) }}</td>
                                        <td>
                                            <a href="/admin/order/{{ $onGoingItem->id }}"
                                                class="btn btn-primary">Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-hero">
                        <div class="card-header">
                            <div class="card-icon">
                                <i class="far fa-question-circle"></i>
                            </div>
                            <h4>{{ count($messages) }}</h4>
                            <div class="card-description">Customers need help</div>
                        </div>
                        <div class="card-body p-0">
                            <div class="tickets-list">
                                @foreach ($messages as $message)                                  
                                <a href="/admin/ticket/{{ $message->message_id }}"
                                    class="ticket-item">
                                    <div class="ticket-title">
                                        <h4>{{$message->title}}</h4>
                                    </div>
                                    <div class="ticket-info">
                                        <div>{{$message->name}}</div>
                                        <div class="bullet"></div>
                                        <div class="text-primary">1 min ago</div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.js') }}"></script>
    <script src="{{ asset('library/owl.carousel/dist/owl.carousel.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-slider.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index.js') }}"></script>
    
@endpush
