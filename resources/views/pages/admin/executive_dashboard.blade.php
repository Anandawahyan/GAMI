@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Sales</h4>
                            </div>
                            <div class="card-body">
                                {{ $total_sales }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Average Transactions Value</h4>
                            </div>
                            <div class="card-body">
                                {{ $avg_trans_value }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Customer Satisfaction Score</h4>
                            </div>
                            <div class="card-body">
                                {{ str_replace('.','',$satisfaction_score) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="h3 text-primary" style="font-weight: bold;">Sales Section</h2>
            <div class="row">
                <div class="col-lg-7 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pendapatan per minggu</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart1"
                                height="210"></canvas>
                            <div class="statistic-details mt-sm-4">
                                <div class="statistic-details-item">
                                    <span class="text-muted">
                                        @if ($sales_per_period_percentage['today'] > 0)
                                        <span class="text-primary"><i class="fas fa-caret-up"></i></span> {{  number_format($sales_per_period_percentage['today'],1,',') }}</span>
                                        @else
                                        <span class="text-danger"><i class="fas fa-caret-down"></i></span> {{  number_format($sales_per_period_percentage['today']*-1,1,',') }}</span>
                                        @endif
                                    <div class="detail-value">{{ convertToRupiah($sales_per_period['today']) }}</div>
                                    <div class="detail-name">Today's Sales</div>
                                </div>
                                <div class="statistic-details-item">
                                    <span class="text-muted">
                                        @if ($sales_per_period_percentage['week'] > 0)
                                        <span class="text-primary"><i class="fas fa-caret-up"></i></span> {{  number_format($sales_per_period_percentage['week'],1,',') }}</span>
                                        @else
                                        <span class="text-danger"><i class="fas fa-caret-down"></i></span> {{  number_format($sales_per_period_percentage['week']*-1,1,',') }}</span>
                                        @endif
                                    <div class="detail-value">{{ convertToRupiah($sales_per_period['week']) }}</div>
                                    <div class="detail-name">This Week's Sales</div>
                                </div>
                                <div class="statistic-details-item">
                                    <span class="text-muted">
                                        @if ($sales_per_period_percentage['month'] > 0)
                                        <span class="text-primary"><i class="fas fa-caret-up"></i></span> {{  number_format($sales_per_period_percentage['month'],1,',') }}</span>
                                        @else
                                        <span class="text-danger"><i class="fas fa-caret-down"></i></span> {{  number_format($sales_per_period_percentage['month']*-1,1,',') }}</span>
                                        @endif
                                    <div class="detail-value">{{ convertToRupiah($sales_per_period['month']) }}</div>
                                    <div class="detail-name">This Month's Sales</div>
                                </div>
                                <div class="statistic-details-item">
                                    <span class="text-muted">
                                        @if ($sales_per_period_percentage['year'] > 0)
                                        <span class="text-primary"><i class="fas fa-caret-up"></i></span> {{  number_format($sales_per_period_percentage['year'],1,',') }}</span>
                                        @else
                                        <span class="text-danger"><i class="fas fa-caret-down"></i></span> {{  number_format($sales_per_period_percentage['year']*-1,1,',') }}</span>
                                        @endif
                                    <div class="detail-value">{{ convertToRupiah($sales_per_period['year']) }}</div>
                                    <div class="detail-name">This Year's Sales</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Top Sales by Category & Color</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart2"></canvas>
                            </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Customer Retention Rate</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart3"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="h3 text-primary" style="font-weight: bold;">Customer Segmentation Section</h2>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Customer by Gender</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart4"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Customer by Age Group</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart5"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Customer Segment based on RFM</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart6"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Customer Segment based on Total Spending</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart7"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="h3 text-primary" style="font-weight: bold;"> Analysis</h2>
            <div class="row">
                <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Marketing Analysis</h4>
                    </div>
                    <div class="card-body">
                        <p style="font-size: 16px" class="marketing-analysis">Please wait...</p>
                    </div>
                </div>
                </div>
                <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Customer RFM Analysis</h4>
                    </div>
                    <div class="card-body">
                        <p style="font-size: 16px" class="rfm-analysis">Please wait...</p>
                    </div>
                </div>
                </div>
                <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Product Review Analysis</h4>
                    </div>
                    <div class="card-body">
                        <p style="font-size: 16px" class="review-analysis">Please wait...</p>
                    </div>
                </div>
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
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script> 
@endpush
