@extends('layouts.app')

@section('title', 'Buat Barang Baru')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="../"
                        class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>Tambah Barang Baru</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Barang</a></div>
                    <div class="breadcrumb-item">Tambah Barang</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Tambah Barang</h2>
                <p class="section-lead">
                    Tambah barang baru disini
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Masukkan data barang</h4>
                            </div>
                            <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                            <div class="card-body">
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto Barang</label>
                                    <div class="col-sm-12 col-md-7">
                                        <div id="image-preview"
                                            class="image-preview">
                                            <label for="image-upload"
                                                id="image-label">Choose File</label>
                                            <input type="file"
                                                name="image"
                                                id="image-upload" class="@error('image') is-invalid @enderror" />
                                                @error('image')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Barang</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input name="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" value="{{ $barang->name }}">
                                            @error('name')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="number"
                                            name="price" class="form-control @error('price') is-invalid @enderror" value="{{ $barang->price }}">
                                            @error('price')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kondisi</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text"
                                            name="condition"
                                            class="form-control @error('condition') is-invalid @enderror" value="{{ $barang->condition }}">
                                            @error('condition')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
                                    <div class="col-sm-12 col-md-7">
                                        <textarea name="description" class="summernote-simple @error('description') is-invalid @enderror">
                                        {{ $barang->description }}
                                        </textarea>
                                        @error('description')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select name="category" class="form-control selectric @error('category') is-invalid @enderror">
                                            @foreach ($categories as $category)
                                                @if ($category->id == $barang->category_id)
                                                    <option selected value="{{ $category->id }}">{{ $category->name }}</option>
                                                @else
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('category')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Warna</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select name="color" class="form-control selectric @error('color') is-invalid @enderror">
                                            @foreach ($colors as $color)
                                                @if ($color->id == $barang->color_id)
                                                    <option selected value="{{ $color->id }}">{{ $color->name }}</option>
                                                @else
                                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                @endif 
                                            @endforeach
                                        </select>
                                        @error('color')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tipe</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select name="sex" class="form-control selectric @error('sex') is-invalid @enderror">
                                            <option {{ $barang->sex == 'Laki-laki' ? 'selected' : '' }} value="Laki-laki">Laki-laki</option>
                                            <option {{ $barang->sex == 'Perempuan' ? 'selected' : '' }} value="Perempuan">Perempuan</option>
                                            <option {{ $barang->sex == 'Unisex' ? 'selected' : '' }} value="Unisex">Unisex</option>
                                        </select>
                                        @error('sex')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Size</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select name="size" class="form-control selectric @error('size') is-invalid @enderror">
                                            <option {{ $barang->size == 'S' ? 'selected' : '' }} value="S">S</option>
                                            <option {{ $barang->size == 'M' ? 'selected' : '' }} value="M">M</option>
                                            <option {{ $barang->size == 'L' ? 'selected' : '' }} value="L">L</option>
                                            <option {{ $barang->size == 'XL' ? 'selected' : '' }} value="XL">XL</option>
                                            <option {{ $barang->size == 'XXL' ? 'selected' : '' }} value="XXL">XXL</option>
                                        </select>
                                        @error('size')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Origin</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select name="region_of_origin" class="form-control selectric @error('region_of_origin') is-invalid @enderror">
                                            <option {{ $barang->region_of_origin == 'US' ? 'selected' : '' }} value="US">US</option>
                                            <option {{ $barang->region_of_origin == 'Europe' ? 'selected' : '' }} value="Europe">Europe</option>
                                            <option {{ $barang->region_of_origin == 'Asia' ? 'selected' : '' }} value="Asia">Asia</option>
                                        </select>
                                        @error('region_of_origin')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button id="buttonSubmit" type="submit" class="btn btn-primary">Edit Barang</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/upload-preview/upload-preview.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-post-create.js') }}"></script>
@endpush
