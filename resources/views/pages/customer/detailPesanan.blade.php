
@extends('layouts.customer_app')

@section('title', 'GAMI')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('css/fitAssistant.css') }}">
@endpush

@section('main')
        <!-- Product section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0 rounded" src="{{ Storage::exists('public/img/itemImages/' . $product->image_url) ? url('storage/img/itemImages/' . $product->image_url) : 'https://dummyimage.com/600x400/bababa/000000&text=No+image+Available' }}" alt="{{ $product->name }}" /></div>
                    <div class="col-md-6">
                        <span class="badge bg-secondary mb-2">{{ $product->category_name }}</span>
                        <h1 class="display-5 fw-bolder">{{ $product->name }}</h1>
                        <div class="fs-5 mb-5">
                            <span>{{ convertToRupiah($product->price) }}</span>
                        </div>
                        {!! $product->description !!} <br>
                        <span><strong>Type : </strong>{{ $product->sex}}</span> <br>
                        <span><strong>Color : </strong>{{ $product->color_name}}</span> <br>
                        <span><strong>Size : </strong>{{ $product->size}}</span> <br>
                        <span><strong>Condition : </strong>{{ $product->condition}}</span> <br>
                        <span><strong>Origin : </strong>{{ $product->region_of_origin}}</span> <br>
                        <button class="btn btn-primary" data-bs-target="#BMImodal" data-bs-toggle="modal">Fit Asisstant</button>
                        <div class="d-flex mt-2">
                          <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button id="addToCart" class="btn btn-outline-dark flex-shrink-0" type="submit">
                                <i class="bi-cart-fill me-1"></i>
                                Add to cart
                            </button>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Related items section-->
        <section class="py-5 bg-light">
            <div class="container px-4 px-lg-5 mt-5">
                <h2 class="fw-bolder mb-4">Related products</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                  @foreach ($recommendedProducts as $rec_product)
                      <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="{{ Storage::exists('public/img/itemImages/' . $rec_product->image_url) ? url('storage/img/itemImages/' . $rec_product->image_url) : 'https://dummyimage.com/400x300/bababa/000000&text=No+image+Available' }}" alt="{{ $rec_product->name }}" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ $rec_product->name }}</h5>
                                    <!-- Product price-->
                                    <span>{{ convertToRupiah($rec_product->price) }}</span>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="/barang/{{$rec_product->id}}">View Details</a></div>
                            </div>
                        </div>
                    </div>
                  @endforeach
                </div>
            </div>
        </section>
        <div class="modal fade" id="BMImodal" aria-hidden="true" aria-labelledby="BMI" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content container">
                
                <div class="modal-body">
                  <div class="container-fluid text-center mx-auto px-4">
                    <div class="row">
                      <div class="col-md-1 ms-auto "><button type="button" class="btn-close d-flex justify-content-end " data-bs-dismiss="modal" aria-label="Close"></button></div>
                    </div>
                    <div class="row">
                      <div class="col"><h5>Fit Assistant</h5></div>
                    </div>
                  
                  <div class="row">
                    <div class="col"> <p>Temukan pakaian yang PAS untukmu</p></div>
                  </div>
                  <form class="input-group-lg  row-gap-5" id="BMI" method="post">
                  <div class="row mb-4" id="BMI">
                    
                        <label for="umurInput"><h6>UMUR</h6></label>
                        <br>
                        <input max="3" min="1" class="col p-md-3 inputText" id="umurInput" type="number" aria-required="true" maxlength="3" required>
                        <span class="col-md-1 ms-auto"><Strong>Tahun</Strong></span>
                  </div>
                  <div class="row mb-4">
                        <label for="tinggiInput"><h6>TINGGI</h6></label>
                        <br>
                        <input max="3" min="1" class="col p-md-3 inputText" id="tinggiInput" type="number" aria-required="true" maxlength="3" required>
                        <span class="col-md-1 ms-auto"><strong>CM</strong></span>
                  </div>
                        <div class="row">
                        <label for="beratInput"><h6>BERAT</h6></label>
                        <br>
                        <input max="3" min="1" class="col p-md-3 inputText" id="beratInput" type="number" aria-required="true" maxlength="3" required>
                        <span class="col-md-1 ms-auto"><Strong>KG</Strong></span>
    
                </div>
              </form>
                <div class="row">
                  <div class="col-md-3 ms-auto"><button onclick="submitFormBmi()" class="btn btn-dark" data-bs-target="#SizePerut" data-bs-toggle="modal">Continue</button></div>      
                </div>
              </div>
                </div>
              </div>
            </div>
          </div>
    
          <div class="modal fade" id="SizePerut" aria-hidden="true" aria-labelledby="FPref" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="container-fluid text-center">
                    <div class="row">
                      <div class="col-md-1 ms-auto "><button type="button" class="btn-close d-flex justify-content-end " data-bs-dismiss="modal" aria-label="Close"></button></div>
                    </div>
                    <div class="row gy-2 gx-3 align-items-center">
                      <div class="col"><h5>Bentuk Perut Anda</h5></div>
                    </div>
                    <div class="row mb-3 pb-3">
                      <div id="SizePerutCar" class="carousel" data-bs-theme="dark">
                        <div class="carousel-inner">
                          <div class="carousel-item active">
                            <img src="{{asset('img/fat/M.28.B1.png')}}" class="w-50 img-fluid" alt="...">
                          </div>
                          <div class="carousel-item">
                            <img src="{{asset('img/fat/M.28.B2.png')}}" class="w-50 img-fluid" alt="...">
                          </div>
                          <div class="carousel-item">
                            <img src="{{asset('img/fat/M.28.B3.png')}}" class="w-50 img-fluid" alt="...">
                          </div>
                        </div>
                      </div>
                    </div>
                    <form class="row pb-3" id="perutForm"> 
                      <div class="col form-check"> 
                        <input data-bs-target="#SizePerutCar" data-bs-slide-to="0" aria-current="true" aria-label="Slide 1" type="button" value="slimmer" name="perut" id="perut1" >
                      </div>  
                      <div class="col form-check">
                        <input data-bs-target="#SizePerutCar" data-bs-slide-to="1" aria-label="Slide 2" type="button" value="average" name="perut" id="perut2">
                      </div>
                      <div class="col form-check">
                        <input data-bs-target="#SizePerutCar" data-bs-slide-to="2" aria-label="Slide 3" type="button" value="rounder" name="perut" id="perut3">
                      </div>
                    </form>
                    
                  
                
    
    
                    <div class="row justify-content-evenly">
                      
                      <div class="col"> <button class="btn btn-dark" data-bs-target="#BMImodal" data-bs-toggle="modal">Back</button></div>
                      <div class="col"><button onclick="submitFormPerut()" data-bs-target="#SizeDada" data-bs-toggle="modal" class = "btn btn-dark">Continue</button>  </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    
          <div class="modal fade" id="SizeDada" aria-hidden="true" aria-labelledby="FPref" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="container-fluid text-center">
                    <div class="row">
                      <div class="col-md-1 ms-auto "><button type="button" class="btn-close d-flex justify-content-end " data-bs-dismiss="modal" aria-label="Close"></button></div>
                    </div>
                    <div class="row gy-2 gx-3 align-items-center">
                      <div class="col"><h5>Bentuk Dada Anda</h5></div>
                    </div>
                    <div class="row mb-3 pb-3">
                      <div id="SizeDadaCar" class="carousel slide" data-bs-theme="dark">
                        <div class="carousel-inner">
                          <div class="carousel-item">
                            <img src="{{asset('img/fat/M.28.B3.C1.png')}}" class="w-50 img-fluid" alt="...">
                          </div>
                          <div class="carousel-item active">
                            <img src="{{asset('img/fat/M.28.B3.C2.png')}}" class="w-50 img-fluid" alt="...">
                          </div>
                          <div class="carousel-item">
                            <img src="{{asset('img/fat/M.28.B3.C3.png')}}" class="w-50 img-fluid" alt="...">
                          </div>
                        </div>
                        
                      </div>
                    </div>
                    <form class="row pb-3" id="dadaForm"> 
                    
                      <div class="col form-check "> 
                           
                          
                            <input data-bs-target="#SizeDadaCar" data-bs-slide-to="0" aria-current="true" aria-label="Slide 1" type="button" value="slimmer" name="dada" id="dada1" >
                          </div>  
    
                      <div class="col form-check">
                          <input data-bs-target="#SizeDadaCar" data-bs-slide-to="1" aria-label="Slide 2" type="button" value="average"  name="dada" id="dada2">
                      </div>
                      <div class="col form-check">
                        
                          <input data-bs-target="#SizeDadaCar"   data-bs-slide-to="2" aria-label="Slide 3" type="button" value="broader"  name="dada" id="dada3">
                      </div>
                   
                  </form> 
                  
                
    
    
                    <div class="row justify-content-evenly">
                      
                      <div class="col"> <button class="btn btn-dark" data-bs-target="#SizePerut" data-bs-toggle="modal">Back</button></div>
                      <div class="col"><button onclick="submitFormDada()" type="submit" data-bs-target="#FitPref" data-bs-toggle="modal" class = "btn btn-dark">Continue</button>  </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="FitPref" aria-hidden="true" aria-labelledby="Fpref" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="container-fluid text-center">
                    <div class="row">
                      <div class="col-md-1 ms-auto "><button type="button" class="btn-close d-flex justify-content-end " data-bs-dismiss="modal" aria-label="Close"></button></div>
                    </div>
                    <div class="row gy-2 gx-3 align-items-center">
                      <div class="col"><h5>Preferensi Pakaian</h5></div>
                    </div>
                    <div class="row my-5">
                      <div class="col slider" id="prefForm">
                        <p id="slider-value">Pas</p>
                        <input type="range" id="prefslider" class="form-range custom-range" min="1" max="5" step="1"></div>
                    </div>
                    
    
                    <div class="row justify-content-evenly mt-5">
                      
                      <div class="col"> <button class="btn btn-dark" data-bs-target="#SizeDada" data-bs-toggle="modal">Back</button></div>
                      <div class="col"><button onclick="sliderValue(); processInput();" type="submit" data-bs-target="#HasilFit" data-bs-toggle="modal" class = "btn btn-dark">Continue</button>  </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    
          <div class="modal fade" id="HasilFit" aria-hidden="true" aria-labelledby="Fpref" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="container-fluid text-center">
                    <div class="row">
                      <div class="col-md-1 ms-auto "><button type="button" class="btn-close d-flex justify-content-end " data-bs-dismiss="modal" aria-label="Close"></button></div>
                    </div>
                    <div class="row gy-2 gx-3 align-items-center">
                      <div class="col"><h5>Rekomendasi Size</h5></div>
                    </div>
                    <div class="row my-5">
                      <div class="col" >
                        <p id="output">Please wait...</p>
                    </div>
                    
                  </div>
                    <div class="row justify-content-evenly mt-5">
                      
                      <div class="col"> <button class="btn btn-dark" data-bs-target="#FitPref" data-bs-toggle="modal">Try Again</button></div>
                      <div class="col"><button type="submit"  class = "btn btn-dark">Continue Shopping</button>  </div>
                    </div>
                  
                </div>
              </div>
            </div>
          </div>
          </div>
@endsection

@push('scripts')
        <script src="{{ asset('js/page/fitaModal.js') }}">
          
        </script>
@endpush