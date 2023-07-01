@extends('layouts.customer_app')

@section('title', 'GAMI')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<div class="card mx-auto my-4" style="width: 100%; max-width: 675px;">
    <div class="card-body mx-4">
      <div class="container">
        <p class="my-5 text-center" style="font-size: 30px;">Invoice</span> #12345</p>
        <div class="row">
          <ul class="list-unstyled">
            <li class="text-black d-flex justify-content-between mb-2">
                <span class="fw-bolder">John Doe</span>
                <span>April 17 2021</span>
            </li>
            <li class="text-black">Jln Pemuda</li>
            <li class="text-muted mt-1"><span class="text-black"></li>
          </ul>
          <hr>
          <div class="col-xl-10">
            <p>Pro Package</p>
          </div>
          <div class="col-xl-2">
            <p class="float-end">$199.00
            </p>
          </div>
          <hr>
        </div>
        <div class="row">
          <div class="col-xl-10">
            <p>Consulting</p>
          </div>
          <div class="col-xl-2">
            <p class="float-end">$100.00
            </p>
          </div>
          <hr>
        </div>
        <div class="row">
          <div class="col-xl-10">
            <p>Support</p>
          </div>
          <div class="col-xl-2">
            <p class="float-end">$10.00
            </p>
          </div>
          <hr style="border: 2px solid black;">
        </div>
        <div class="row text-black">
  
          <div class="col-xl-12">
            <p class="float-end fw-bold">Total: $10.00
            </p>
          </div>
          <hr style="border: 2px solid black;">
        </div>
        <div class="text-center">
            <p>Status : Belum Dibayar</p>
        </div>
        <div class="text-center d-flex justify-content-center">
          @if ($order->status_id == 5)
          <form action="">
            <button type="button" class="btn btn-primary" id="pay-button">Lanjutkan Pembayaran</button>
          </form>
        @elseif($order->status_id == 3)
            Payment successful
        @endif
            <button class="btn btn-danger">Batalkan Pesanan</button>
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
                  /* You may add your own js here, this is just example */
                  // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                  console.log(result)
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