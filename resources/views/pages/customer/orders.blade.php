@extends('layouts.customer_app')

@section('title', 'Catalog')

@push('style')
    <!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('css/invoices.css') }}">
@endpush
@section('main')
<div class="container my-4" style="min-height: 190px">
    <a href="/" style="width: fit-content" class="btn btn-light d-block mb-4"><i class="fas fa-arrow-left"></i> Back</a>
    <h2 class="mb-2">Riwayat</h2>
    <div class="row">
        @if(count($orders) == 0)
        <p class="text-center">Tidak ada item</p>
        @else
        @foreach($orders as $order)
        <div class="col-xl-12">
            <div class="card mb-3 card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <a href="/user/invoices/{{ $order->id }}">
                          @if ($order->status_id == 5)
                          <div class="d-flex justify-content-center align-items-center width-90 rounded-3 bg-warning">
                            <span style="font-size: 32px; color: #fff">
                                <i class="fas fa-credit-card"></i>
                            </span>
                          </div>
                          @elseif ($order->status_id == 1)
                          <div class="d-flex justify-content-center align-items-center width-90 rounded-3 bg-info">
                            <span style="font-size: 32px; color: #fff">
                                <i class="fas fa-box"></i>
                            </span>
                          </div>
                          @elseif ($order->status_id == 3)
                          <div class="d-flex justify-content-center align-items-center width-90 rounded-3 bg-primary">
                            <span style="font-size: 32px; color: #fff">
                                <i class="fas fa-truck-fast"></i>
                            </span>
                          </div>
                          @elseif ($order->status_id == 4)
                          <div class="d-flex justify-content-center align-items-center width-90 rounded-3 bg-success">
                            <span style="font-size: 32px; color: #fff">
                                <i class="fas fa-people-carry-box"></i>
                            </span>
                          </div>
                          @endif
                        </a>
                    </div>
                    <div class="col">
                        <div class="overflow-hidden flex-nowrap">
                            <h6 class="mb-1">
                                <a href="/user/invoices/{{ $order->id }}" class="text-reset">Order {{ $order->id }}</a>
                            </h6>
                            <span class="text-muted d-block mb-2 small">
                            Est Arrival : {{ convertDateToIndo($order->est_arrival_date) }}
                          </span>
                          <span class="small badge bg-secondary">
                            {{ $order->status }}
                          </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection