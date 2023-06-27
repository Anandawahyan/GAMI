@extends('layouts.customer_app')

@section('title', 'Catalog')

@push('style')
    <!-- CSS Libraries -->

@endpush
@section('main')
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <span class="d-block mb-2" style="font-size: 52px;"><i class="fas fa-shirt"></i></span>
                    <h1 class="display-4 fw-bolder">Shop in style</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Gami provides everything you need from shoes, dress, t-shirts, you name it!</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-2 px-lg-3 mt-5">
                <div class="row justify-content-center">
                    <div class="col-3">
                        <button class="d-block btn btn-primary w-100" id="productFilterButton">
                            Filter Product
                        </button>
                    </div>
                    <div class="col-8">
                        <form action="{{ route('customer_barang.catalog') }}" method="GET">
                        <div class="input-group mb-3">
                            <input name="name" type="text" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="button-addon2">
                                <button aria-label="search button" class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                          </div>
                        </form>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-3">
                        <div class="filter" style="height: auto; overflow: hidden;">
                            <form action="{{ route('customer_barang.catalog') }}" method="GET">
                                <hr>
                                <h5 class="mb-3">Category</h5>
                                <div class="list-group mb-4">
                                        @foreach ($categories as $category)
                                            @if(array_key_exists('category_id', $inputs))
                                                <label class="list-group-item list-group-item-action bg-light rounded mb-2 border border-1">
                                                    <input class="form-check-input me-1" type="checkbox" name="category_id[]" value="{{ $category->id }}" {{ in_array($category->id, $inputs['category_id']) ? 'checked' : '' }}>
                                                    {{ $category->name }}
                                                </label>
                                            @else
                                                <label class="list-group-item list-group-item-action bg-light rounded mb-2 border border-1">
                                                    <input class="form-check-input me-1" type="checkbox" name="category_id[]" value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                </label>
                                            @endif
                                        @endforeach
                                </div>
                                <h5 class="mb-3">Color</h5>
                                <div class="list-group mb-4">
                                    @foreach ($colors as $color)
                                    @if(array_key_exists('color_id', $inputs))
                                        <label class="list-group-item list-group-item-action bg-light rounded mb-2 border border-1">
                                            <input class="form-check-input me-1" type="checkbox" name="color_id[]" value="{{ $color->id }}" {{ in_array($color->id, $inputs['color_id']) ? 'checked' : '' }}>
                                            {{ $color->name }}
                                        </label>
                                    @else
                                        <label class="list-group-item list-group-item-action bg-light rounded mb-2 border border-1">
                                            <input class="form-check-input me-1" type="checkbox" name="color_id[]" value="{{ $color->id }}">
                                            {{ $color->name }}
                                        </label>
                                    @endif
                                    @endforeach
                                </div>
                                <h5 class="mb-3">Size</h5>
                                <div class="list-group mb-4">
                                    @foreach ($sizes as $size)                                    
                                    @if(array_key_exists('size', $inputs))
                                        <label class="list-group-item list-group-item-action bg-light rounded mb-2 border border-1">
                                            <input class="form-check-input me-1" type="checkbox" name="size[]" {{ in_array($size, $inputs['size']) ? 'checked' : '' }} value="{{$size}}">
                                            {{$size}}
                                        </label>
                                    @else
                                        <label class="list-group-item list-group-item-action bg-light rounded mb-2 border border-1">
                                            <input class="form-check-input me-1" type="checkbox" name="size[]" value="{{ $size }}">
                                            {{ $size }}
                                        </label>
                                    @endif
                                    @endforeach
                                </div>
                                <h5 class="mb-3">Type</h5>
                                <div class="list-group mb-4">
                                    @foreach ($types as $type)                                    
                                    @if(array_key_exists('sex', $inputs))
                                        <label class="list-group-item list-group-item-action bg-light rounded mb-2 border border-1">
                                            <input class="form-check-input me-1" type="checkbox" name="sex[]" {{ in_array($type, $inputs['sex']) ? 'checked' : '' }} value="{{$type}}">
                                            {{$type}}
                                        </label>
                                    @else
                                        <label class="list-group-item list-group-item-action bg-light rounded mb-2 border border-1">
                                            <input class="form-check-input me-1" type="checkbox" name="sex[]" value="{{ $type }}">
                                            {{ $type }}
                                        </label>
                                    @endif
                                    @endforeach
                                </div>
                                <button class="btn btn-success d-block w-100" type="submit">
                                    Apply Filters
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-8">
                    <div class="row gx-4 gx-lg-3 row-cols-2 row-cols-md-3 row-cols-xl-3 justify-content-center">
                        @foreach ($itemsArray['data'] as $item)
                        <div class="col-12 col-sm mb-5">
                            <div class="card h-100">
                                <!-- Product image-->
                                <img class="card-img-top" style="height: 300px; object-fit: cover;" src="{{ Storage::exists('public/img/itemImages/' . $item['image_url']) ? url('storage/img/itemImages/' . $item['image_url']) : 'https://dummyimage.com/300x300/bababa/000000&text=No+image+Available' }}" alt="{{ $item['name'] }}" />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder text-truncate" style="font-size: 18px;">{{ $item['name'] }}</h5>
                                        <!-- Product price-->
                                        <span>{{ convertToRupiah($item['price']) }}</span>
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="/barang/{{ $item['id'] }}">View Details</a></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                </div>
                <nav aria-label="product pagination" class="row px-2 px-lg-5">
                    <ul class="pagination justify-content-end">
                        @if ($itemsArray['prev_page_url'])
                            <li class="page-item">
                                <a href="{{ $itemsArray['prev_page_url'] }}" class="page-link">Previous</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Previous</span>
                            </li>
                        @endif
                        @for($i = 1; $i < count($itemsArray['links']) - 1; $i++)
                            @if ($itemsArray['links'][$i]['label'] == strval($itemsArray['current_page'])) 
                                <li class="page-item active"><span class="page-link">{{$itemsArray['links'][$i]['label']}}</span></li>

                            @else
                                <li class="page-item"><a class="page-link" href="{{ $itemsArray['links'][$i]['url'] }}">{{$itemsArray['links'][$i]['label']}}</a></li>
                            @endif
                        @endfor
                        @if ($itemsArray['next_page_url'])
                            <li class="page-item">
                                <a href="{{ $itemsArray['next_page_url'] }}" class="page-link">Next</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Next</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </section>
    @endsection
    
    @push('scripts')
        <script>
            $('#productFilterButton').on('click', function() {
                console.log($('.filter').css('height'));
                if($('.filter').css('height') === '0px') {
                    $('.filter').css('height', 'auto');
                } else {
                    $('.filter').css('height', 0);
                }
            });
        </script>
    @endpush