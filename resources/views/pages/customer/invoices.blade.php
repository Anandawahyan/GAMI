@extends('layouts.customer_app')

@section('title', 'GAMI')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<div class="card mx-auto my-4" style="width: 100%; max-width: 675px;">
    <div class="card-body mx-4">
      <div class="container">
        <p class="my-5 text-center" style="font-size: 30px;">Invoice</span> #{{ $order->id }}</p>
        <div class="row">
          <ul class="list-unstyled">
            <li class="text-black d-flex justify-content-between mb-2">
                <span class="fw-bolder">{{$user_name}}</span>
                <span>{{convertDateToIndo($order->est_arrival_date)}}</span>
            </li>
            <li class="text-black">{{$alamat->alamat_rumah}}</li>
            <li class="text-muted mt-1"><span class="text-black"></li>
          </ul>
        </div>
          <hr>
          @foreach ($items as $item)
            <div class="row">
              <div class="col-xl-10">
                <p>{{ $item->name }}</p>
              </div>
              <div class="col-xl-2">
                <p class="float-end">{{ convertToRupiah($item->price) }}
                </p>
              </div>
            </div>
            <hr>
          @endforeach
        @if($order->discount_id)
        <div class="row">
          <div class="col-xl-10">
            <p>{{ $discount->name }}</p>
          </div>
          <div class="col-xl-2">
            <p class="float-end">{{ convertToRupiah(calculateDiskon($order->total_amount, $discount->percentage)) }}
            </p>
          </div>
          <hr>
        </div>
        @endif
        <div class="row">
          <div class="col-xl-10">
            <p>Ongkir</p>
          </div>
          <div class="col-xl-2">
            <p class="float-end">{{ convertToRupiah($order->ongkir) }}
            </p>
          </div>
          <hr style="border: 2px solid black;">
        </div>
        <div class="row text-black">
  
          <div class="col-xl-12">
            <p class="float-end fw-bold">Total: {{convertToRupiah($order->total_amount + $order->ongkir)}}
            </p>
          </div>
          <hr style="border: 2px solid black;">
        </div>
        <div class="text-center">
            <p>Status : {{$status->name}}</p>
        </div>
        <div class="text-center d-flex justify-content-center">
          @if ($order->status_id == 5)
          <form id="gantiStatusForm" action="{{ route('payment.update', $order->id) }}" method="POST">
            @method('PUT')
            @csrf
            <input type="hidden" name="statusId" value="1">
            <button type="button" class="btn btn-primary" id="pay-button">Lanjutkan Pembayaran</button>
          </form>
          @endif
          @if($order->status_id == 1 || $order->status_id == 5)
          <form id="batalinOrderForm" action="{{ route('payment.update', $order->id) }}" method="POST">
            @method('PUT')
            @csrf
            <input type="hidden" name="statusId" value="2">
            <button class="btn btn-danger">Batalkan Pesanan</button>
          </form>
          @endif
        </div>
        <div class="text-center" style="margin-top: 90px;">
          <p>GAMI &#169;</p>
        </div>
  
      </div>
    </div>
  </div>
  @endsection

  @push('scripts')
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
  </script>
  <script>
      const payButton = document.querySelector('#pay-button');
      payButton.addEventListener('click', function(e) {
          e.preventDefault();

          snap.pay('{{ $snap_token }}', {
              // Optional
              onSuccess: function(result) {
                console.log('pretty woman');
                $('#gantiStatusForm').trigger('submit');
                  
                  /* You may add your own js here, this is just example */
                  // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                  // console.log(result)
              },
              // Optional
              onPending: function(result) {
                  /* You may add your own js here, this is just example */
                  // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                  console.log(result)
              },
              // Optional
              onError: function(result) {
                  /* You may add your own js here, this is just example */
                  // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                  console.log(result)
              }
          });
      });
  </script>
  @endpush