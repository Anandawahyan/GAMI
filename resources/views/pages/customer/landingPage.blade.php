
@extends('layouts.customer_app')

@section('title', 'GAMI')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('css/landingPage.css') }}" />
@endpush

@section('main')
    <main class="px-md-5 px-1">
      <section id="HeroBanner" class="mx-5 my-5" >
        <div class="container-fluid">
          <div id="Hero" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#Hero" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#Hero" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#Hero" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="{{asset('img/itemImages/Banner1.png')}}" class="img-fluid" alt="...">
                <div class="carousel-caption col-md-4 h-75" >
                  <h1 class="text-start">CREATE YOUR
                    STYLE WITH 
                    GAMI</h1>
                    <a href="../Catalog/tengah.html">
                    <button class="btn btn-dark d-flex justify-content-start">SHOP NOW</button>
                  </a>
                </div>
              
                
              </div>
              <div class="carousel-item">
                <img src="{{asset('img/itemImages/Banner3.png')}}" class="d-block w-100" alt="...">
                
              </div>
              <div class="carousel-item">
                <img src="{{asset('img/itemImages/Banner2.png')}}" class="d-block w-100" alt="...">
                
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#Hero" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#Hero" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </section>
      <section id="CategoryCard" class="my-5" >
          <h1 class="d-flex justify-content-center my-4 mt-5" style="font-weight:700;">New Item In Store</h1>
       <div class="container-fluid">
          <div class="card-group mx-lg-auto">
            <div class="card mx-5">
              <img src="{{ asset('img/itemImages/card1.png') }}" class="card-img img-fluid" alt="...">
              <div class="card-img-overlay d-flex">
                <button type="button" class="btn btn-dark align-self-end mx-auto">Pants</button>
              </div>
            </div>
            <div class="card mx-5">
              <img src="{{ asset('img/itemImages/card2.png') }}" class="card-img img-fluid" alt="...">
              <div class="card-img-overlay d-flex">
                <button type="button" class="btn btn-dark align-self-end mx-auto">Shoes</button>
              </div>
            </div>
            <div class="card mx-5">
              <img src="{{ asset('img/itemImages/card3.png') }}" class="card-img img-fluid" alt="...">
              <div class="card-img-overlay d-flex">
                <button type="button" class="btn btn-dark align-self-end mx-auto">Shirts</button>
              </div>
          </div>
        </div>
          </div>
      </section>
      <section id="banner2" class="mx-5 my-5">
        <div class="container-fluid ">         
              <div class="card justify-content-center">
                <img src="{{ asset('img/itemImages/Banner2.png') }}" class="card-img img-fluid" alt="...">
                <div class="card-img-overlay d-flex">
                  <h1 class="card-title align-self-end mx-auto">Product That Suits You</h1>
                </div>
                
              </div>       
      </div>
      </section>
      <section id="carouselCard" class="justify-content-center mx-5 my-5 p-5">
        <div id="mycarousel1" class="carousel-dark carousel slide" data-bs-ride="carousel">  
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="card-group">
                @for ($i  = 0; $i < 4; $i++)
                <div class="card">
                  <img style="object-fit: cover; max-height: 300px;" src="{{ url('storage/img/itemImages/' . $products[$i]->image_url) }}" class="card-img-top img-fluid" alt="{{ $products[$i]->name }}">
                  <div class="card-body">
                    <h4 class="card-title"><a style="text-decoration: none; color: #000;" href="/barang/{{ $products[$i]->id }}">{{ $products[$i]->name }}</a></h4>
                    <p class="card-text" style="font-weight: 400;">{{ $products[$i]->category_name }}</p>
                    <p class="card-text" style="font-weight: 500;">{{ convertToRupiah($products[$i]->price) }}</p>
                  </div>
                </div>
                @endfor
              </div>
            </div>
        
        
            
            <div class="carousel-item">
              <div class="card-group">
                @for ($i  = 4; $i < 8; $i++)
                  <div class="card">
                    <img style="object-fit: cover; max-height: 300px;" src="{{ url('storage/img/itemImages/' . $products[$i]->image_url) }}" class="card-img-top img-fluid" alt="{{ $products[$i]->name }}">
                    <div class="card-body">
                      <h4 class="card-title"><a style="text-decoration: none; color: #000;" href="/barang/{{ $products[$i]->id }}">{{ $products[$i]->name }}</a></h4>
                      <p class="card-text" style="font-weight: 400;">{{ $products[$i]->category_name }}</p>
                      <p class="card-text" style="font-weight: 500;">{{ convertToRupiah($products[$i]->price) }}</p>
                    </div>
                  </div>
                @endfor
              </div>
            </div>
        
            
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#mycarousel1" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#mycarousel1" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </section>
      
      <section id="banner3" class="mx-5 my-5">
        <div class="container-fluid">
        <div class="card justify-content-center">
            <img src="{{ asset('img/itemImages/Banner3.png') }}" class="card-img img-fluid" alt="...">
            <div class="card-img-overlay d-flex">
              <h1 class="card-title align-self-end mx-auto">Hot Product</h1>
            </div>
          </div>
          </div>
      </section>
    
    <section id="carouselCard2" class="justify-content-center mx-5 my-5 p-5">
      <div id="mycarousel2" class="carousel-dark carousel slide" data-bs-ride="carousel">  
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="card-group">
            @for ($i = 8; $i < 12; $i++)
                  <div class="card">
                    <img style="object-fit: cover; max-height: 300px;" src="{{ url('storage/img/itemImages/' . $products[$i]->image_url) }}" class="card-img-top img-fluid" alt="{{ $products[$i]->name }}">
                    <div class="card-body">
                      <h4 class="card-title"><a style="text-decoration: none; color: #000;" href="/barang/{{ $products[$i]->id }}">{{ $products[$i]->name }}</a></h4>
                      <p class="card-text" style="font-weight: 400;">{{ $products[$i]->category_name }}</p>
                      <p class="card-text" style="font-weight: 500;">{{ convertToRupiah($products[$i]->price) }}</p>
                    </div>
                  </div>
                @endfor
              </div>
          </div>
      
      
          
          <div class="carousel-item">
            <div class="card-group">
              @for ($i = 8; $i < 12; $i++)
                  <div class="card">
                    <img style="object-fit: cover; max-height: 300px;" src="{{ url('storage/img/itemImages/' . $products[$i]->image_url) }}" class="card-img-top img-fluid" alt="{{ $products[$i]->name }}">
                    <div class="card-body">
                      <h4 class="card-title"><a style="text-decoration: none; color: #000;" href="/barang/{{ $products[$i]->id }}">{{ $products[$i]->name }}</a></h4>
                      <p class="card-text" style="font-weight: 400;">{{ $products[$i]->category_name }}</p>
                      <p class="card-text" style="font-weight: 500;">{{ convertToRupiah($products[$i]->price) }}</p>
                    </div>
                  </div>
                @endfor
            </div>
          </div>
      
          
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#mycarousel2" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mycarousel2" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </section>
    </main>
@endsection
