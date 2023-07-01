@extends('layouts.customer_app')

@section('title', 'GAMI')

@section('main')
    <section class="h-100 gradient-custom mb-auto my-auto">
      <div class="container py-5">
        <div class="row d-flex justify-content-center my-4">
          <div class="col-md-8">
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="mb-3 fw-bolder fs-3">Cart - {{ count($cart_items) <= 1 ? count($cart_items) . ' item' : count($cart_items) . ' items' }}</h5>
                <hr>
                <!-- Single item -->
                @if (count($cart_items) < 1)
                  <div class="row">
                    <p class="text-center">No item in your cart</p>
                  </div>

                @else
                  @foreach ($cart_items as $cart_item)
                    <div class="row mb-2">
                      <div class="col-4 mb-lg-0">
                        <!-- Image -->
                        <div
                          class="bg-image hover-overlay hover-zoom ripple rounded"
                          data-mdb-ripple-color="light"
                        >
                          <img
                          src="{{ Storage::exists('public/img/itemImages/' . $cart_item->image_url) ? url('storage/img/itemImages/' . $cart_item->image_url) : 'https://dummyimage.com/400x300/bababa/000000&text=No+image+Available' }}"
                            class="img-fluid"
                            alt="{{$cart_item->name}}"
                          />
                          <a href="#!">
                            <div
                              class="mask"
                              style="background-color: rgba(251, 251, 251, 0.2)"
                            ></div>
                          </a>
                        </div>
                        <!-- Image -->
                      </div>  
                      <div class="col-sm-8 gx-2 align-items-md-center col mb-4 mb-lg-0 d-flex flex-md-row justify-content-between">
                        <!-- Data -->
                        <div>
                          <p class="mb-1 fs-4">{{ $cart_item->name }}</p>
                          <span class="d-inline-block mb-2">{{convertToRupiah($cart_item->price)}}</span>
                        </div>
                        <div>
                          <!-- Quantity -->
                          <form action="{{ route('cart.delete', $cart_item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="d-flex justify-content-start" style="max-height: 35px"> 
                              <button
                              type="submit"
                              class="btn btn-danger px-auto me-2"
                              data-mdb-toggle="tooltip"
                              title="Remove item"
                              ><i class="fas fa-trash"></i>
                              </button>
                            </div>
                        </form>
                        </div>
                      </div>
                    </div>                    
                  @endforeach
                
                @endif
                
                <!-- Single item -->
    
                <hr class="my-4" />
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card bg-light">
              <div class="card-body">
                <form action="{{ route('checkout.store') }}" method="POST">
                  @csrf
                <h5 class=" fw-bolder fs-3">Summary</h5>
                <hr>
                <ul class="list-group list-group-flush bg-light">
                  <li
                    class="list-group-item bg-light d-flex justify-content-between align-items-center border-0 px-0 pb-0 fs-6"
                  >
                    Products
                    <span>{{ convertToRupiah($total_price) }}</span>
                  </li>
                  <li
                    class="list-group-item bg-light px-0 fs-6"
                  >
                    <span class="d-inline-block mb-2">Discount</span>
                    <select id="discountForm" name="discountId" class="form-select" aria-label="shipping type" {{ count($cart_items) < 1 || Auth::check() == false ? 'disabled' : '' }}>
                    </select>
                  </li>
                  <li
                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3 bg-light"
                  >
                    <div>
                      <strong>Total amount</strong>
                      <strong>
                        <p class="mb-0">(including VAT)</p>
                      </strong>
                    </div>
                    <span><strong id="priceText">{{ convertToRupiah($total_price) }}</strong></span>
                  </li>
                </ul>
                
                <input name="totalPrice" type="hidden" id="totalPriceBeforeDiscount" value="{{ $total_price }}">
                <input type="hidden" id="discountPercentage" value="">
                <button type="submit" class="btn btn-dark btn-lg btn-block" {{ count($cart_items) < 1 ? 'disabled' : '' }}>
                  Go to checkout
                </button>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection

@push('scripts')
  <script src="{{ asset('js/page/cart.js') }}"></script>
@endpush