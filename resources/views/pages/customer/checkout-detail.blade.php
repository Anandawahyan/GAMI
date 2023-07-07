<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Checkout</title>

    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&display=swap"
      rel="stylesheet"
    />
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
        <link rel="stylesheet"
        href="{{ asset('css/layout.css') }}">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="form-validation.css" rel="stylesheet">
  </head>
  <body class="bg-light">
  
    
<div class="container">
  <main>
    <div class="py-5 text-center">
      <h2 class="fw-semibold">Checkout form</h2>
    </div>

    <div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your cart</span>
          <span class="badge bg-primary rounded-pill">{{ count($items) }}</span>
        </h4>
        <ul class="list-group mb-3">
          @foreach ($items as $item)          
            <li class="list-group-item d-flex justify-content-between lh-sm">
              <div>
                <h6 class="my-0">{{ $item->name }}</h6>
              </div>
              <span class="text-muted">{{ convertToRupiah($item->price) }}</span>
            </li>
          @endforeach
          @if($discount) 
          <li class="list-group-item d-flex justify-content-between bg-light">
            <div class="text-success">
              <h6 class="my-0">Promo code</h6>
              <small>{{ $discount->name }}</small>
            </div>
            <span class="text-success">−{{ convertToRupiah(calculateDiskon($total_price, $discount->percentage)) }}</span>
          </li>
          @endif
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Ongkir</h6>
            </div>
            <span id="ongkirText" class="text-muted">{{ convertToRupiah(0) }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Total (IDR)</span>
            @if($discount) 
            <strong id="totalPriceText">{{ convertToRupiah(calculatePriceAfter($total_price, $discount->percentage)) }}</strong>
            @else
            <strong id="totalPriceText">{{ convertToRupiah(calculatePriceAfter($total_price, 0)) }}</strong>
            @endif
          </li>
        </ul>

      </div>
      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Billing address</h4>
        <form class="needs-validation" action="{{ route('payment.store') }}" method="POST">
          @csrf
          <input type="hidden" name="diskonId" value="{{ $discount ? $discount->id : null }}">
          <input type="hidden" name="ongkir" id="ongkirInput">
          <input type="hidden" name="totalPrice" id="totalPrice" value="{{ $discount ? calculatePriceAfter($total_price, $discount->percentage) : calculatePriceAfter($total_price, 0) }}">
          
          <div class="row g-3">
            <div class="col-sm-12">
              <label for="nama" class="form-label">Full Name</label>
              <input name="nama" type="text" class="form-control" id="firstName" placeholder="" value="{{ $name }}" required>
              <div class="invalid-feedback">
                Valid first name is required.
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" placeholder="you@example.com" value="{{ $email }}" required>
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <select id="alamatId" name="alamat" class="form-select" aria-label="address">
              </select>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>
          </div>
          <div class="mt-2">
            <button type="button" data-bs-toggle="modal" data-bs-target="#alamatModal" class="btn btn-primary">Tambah Alamat Baru</button>
          </div>

          <hr class="my-4">



          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to payment</button>
        </form>
      </div>
    </div>
  </main>

  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2017–2021 Company Name</p>
    <ul class="list-inline">
      <li class="list-inline-item"><a href="#">Privacy</a></li>
      <li class="list-inline-item"><a href="#">Terms</a></li>
      <li class="list-inline-item"><a href="#">Support</a></li>
    </ul>
  </footer>
</div>
<div class="modal fade" id="alamatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="alamatBaruForm" action="" method="POST">
          @csrf
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Alamat :</label>
            <input name="alamatBaru" type="text" class="form-control" id="alamatBaru">
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Kabupaten/kota: </label>
            <select name="kotaBaru" class="d-block w-100 selectpicker" data-live-search="true" aria-label="address" id="kotaBaru">
              @foreach($daftar_kota as $kota)
                <option value="{{ $kota['city_id'] }}">{{ $kota['type'] .' '. $kota['city_name'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Submit</button>
          </div>
          </form>
      </div>
  </div>
</div>
</div>


<script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
      <script>
        
      </script>
      <script src="{{ asset('js/page/checkout.js') }}"></script>
  </body>
</html>
