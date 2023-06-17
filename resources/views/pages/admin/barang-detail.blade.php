@extends('layouts.app')

@section('title', 'Detail Barang')

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
                    <a href="../barang"
                        class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>Detail Barang</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="/admin/barang">Barang</a></div>
                    <div class="breadcrumb-item">Detail Barang</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Detail Barang</h2>
                <p class="section-lead">
                    Detail barang {{ $barang->name }}
                </p>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto Barang</label>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="image-preview" id="image-preview">
                                            <img class="w-100" src="{{ url('storage/img/itemImages/'.$barang->image_url) }}">
                                        </div>
                                        </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Barang</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input name="name" type="text"
                                            class="form-control" 
                                            value="{{ $barang->name }}"
                                            disabled
                                            >
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text"
                                            name="price" class="form-control"
                                            value="{{ convertToRupiah($barang->price) }}"
                                            disabled
                                            >
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kondisi</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text"
                                            name="condition"
                                            class="form-control"
                                            value="{{ $barang->condition }}"
                                            disabled
                                            >
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
                                    <div class="col-sm-12 col-md-7">
                                        <p class="tmt-3">
                                            {!! $barang->description !!}
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text"
                                            name="condition"
                                            class="form-control"
                                            value="{{ $barang->category }}"
                                            disabled
                                            >
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Warna</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text"
                                            name="condition"
                                            class="form-control"
                                            value="{{ $barang->color }}"
                                            disabled
                                            >
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tipe</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text"
                                            name="condition"
                                            class="form-control"
                                            value="{{ $barang->sex }}"
                                            disabled
                                            >
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Size</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text"
                                            name="condition"
                                            class="form-control"
                                            value="{{ $barang->size }}"
                                            disabled
                                            >
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Origin</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text"
                                            name="condition"
                                            class="form-control"
                                            value="{{ $barang->region_of_origin }}"
                                            disabled
                                            >
                                    </div>
                                </div>
                            </div>
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
