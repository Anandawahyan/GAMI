@extends('layouts.app')

@section('title', 'Invoice')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Invoice</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Invoice</div>
                </div>
            </div>

            <div class="section-body">
                <div class="invoice">
                    <div class="invoice-print">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="invoice-title">
                                    <h2>Invoice</h2>
                                    <div class="invoice-number">Order #{{ $order->order_id }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <address>
                                            <strong>Shipped To:</strong><br>
                                            {{$order->name}}<br>
                                            {{$order->address}}
                                        </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                        <address>
                                            <strong>Order Date:</strong><br>
                                            {{convertDateToIndo($order->date)}}<br><br>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="section-title">Order Summary</div>
                                <p class="section-lead">All items here cannot be deleted.</p>
                                <div class="table-responsive">
                                    <table class="table-striped table-hover table-md table">
                                        <tr>
                                            <th data-width="40">#</th>
                                            <th>Item</th>
                                            <th class="text-right">Price</th>
                                        </tr>
                                        @for ($i = 0; $i < count($items); $i++)
                                        <tr>
                                            <td>{{ $i+1 }}</td>
                                            <td>{{ $items[$i]->name }}</td>
                                            <td class="text-right">{{ convertToRupiah($items[$i]->price) }}</td>
                                        </tr>
                                        @endfor
                                    </table>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 text-right">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Subtotal</div>
                                            <div class="invoice-detail-value">{{ convertToRupiah($subtotal) }}</div>
                                        </div>
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Diskon</div>
                                            <div class="invoice-detail-value">{{ convertToRupiah(calculateDiskon($subtotal, $order->diskon)) }}</div>
                                        </div>
                                        <hr class="mt-2 mb-2">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Total</div>
                                            <div class="invoice-detail-value invoice-detail-value-lg">{{ convertToRupiah(calculatePriceAfter($subtotal, $order->diskon)) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-md-left">
                        <div class="mb-3">
                            <button id="buttonTolak" type="submit" class="btn btn-danger btn-icon icon-left">Tolak Barang</button>
                            <button id="buttonKirim" type="submit" class="btn btn-primary icon-left">Kirim Barang</button>
                            <button id="buttonTerima" type="submit" class="btn btn-success icon-left">Barang telah diterima</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
