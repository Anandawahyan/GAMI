@extends('layouts.customer_app')

@section('title', 'GAMI')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<div class="mx-auto mt-4" style="width: 100%; max-width: 675px;">
  <a href="/user/invoices" style="width: fit-content" class="btn btn-light d-block mb-4"><i class="fas fa-arrow-left"></i> Back</a>
</div>
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
            <p class="float-end">{{ convertToRupiah(calculateDiskon($totalPriceBeforeDiscount, $discount->percentage)) }}
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
          @elseif ($order->status_id == 3)
          <form id="gantiStatusForm" action="{{ route('payment.update', $order->id) }}" method="POST">
            @method('PUT')
            @csrf
            <input type="hidden" name="statusId" value="4">
            <button type="button" class="btn btn-success" id="lanjutkan">Pesanan Diterima</button>
          </form>
          @elseif ($order->status_id == 4)
          @if(count($reviews) > 0)
            <div>
              <p>Rating : {{ $reviews[0]->rating }}</p>
              <p>{{ $reviews[0]->review_text }}</p>
            </div>
          @else
          <button type="button" data-bs-toggle="modal" data-bs-target="#alamatModal" class="btn btn-success">Beri Review</button>
          @endif
          @endif
          @if($order->status_id != 2 && $order->status_id != 4)
          <form id="batalinOrderForm" action="{{ route('payment.update', $order->id) }}" method="POST">
            @method('PUT')
            @csrf
            <input type="hidden" name="statusId" value="2">
            <button type="button" id="batalkan" class="btn btn-danger">Batalkan Pesanan</button>
          </form>
          @endif
        </div>
        <div class="text-center" style="margin-top: 90px;">
          <p>GAMI &#169;</p>
        </div>
  
      </div>
    </div>
  </div>
  <div class="modal fade" id="alamatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Alamat</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="reviewForm" action="{{ route('review.store', $order->id) }}" method="POST">
            @csrf
            <div class="mb-3">
              <div class="card">
                <div class="card-body text-center"> 
                 <span class="myratings">4.5</span>
                    <h4 class="mt-1">Rate us</h4>

                    <div class="star-rating" style="color: #FFD95A">
                      <span class="fa fa-star-o" data-rating="1"></span>
                      <span class="fa fa-star-o" data-rating="2"></span>
                      <span class="fa fa-star-o" data-rating="3"></span>
                      <span class="fa fa-star-o" data-rating="4"></span>
                      <span class="fa fa-star-o" data-rating="5"></span>
                      <input type="hidden" name="rating" class="rating-value" value="2">
                    </div>
                </div>
            </div>
            </div>
            <div class="mb-3">
              <label for="komen" class="form-label">Komen</label>
              <textarea placeholder="Berikan komentar anda disini..." name="komen" class="form-control" id="komen" rows="5"></textarea>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Submit</button>
            </div>
          </form>
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
      const buttonLanjut = document.querySelector('#lanjutkan');
      const buttonBatalkan = document.querySelector('#batalkan')

      if(buttonLanjut) {
        buttonLanjut.addEventListener('click', function(e) {
          e.preventDefault();
          $('#gantiStatusForm').trigger('submit');
        });
      }

      if(buttonBatalkan) {
        buttonBatalkan.addEventListener('click', function(e) {
          e.preventDefault();
          $('#batalinOrderForm').trigger('submit');
        });
      }

      if(payButton) {
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
      }
  </script>
  <script>
    var $star_rating = $('.star-rating .fa');

var SetRatingStar = function() {
  return $star_rating.each(function() {
    if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
      return $(this).removeClass('fa-star-o').addClass('fa-star');
    } else {
      return $(this).removeClass('fa-star').addClass('fa-star-o');
    }
  });
};

$star_rating.on('click', function() {
  $star_rating.siblings('input.rating-value').val($(this).data('rating'));
  $('.myratings').text($(this).data('rating'));
  return SetRatingStar();
});

SetRatingStar();
$(document).ready(function() {

});
  </script>
  @endpush