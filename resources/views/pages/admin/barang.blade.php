@extends('layouts.app')

@section('title', 'Semua Barang')

@push('style')
    <!-- CSS Libraries -->
    
    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
        <link rel="stylesheet"
        href="{{ asset('library/ionicons201/css/ionicons.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Barang</h1>
                <div class="section-header-button">
                    <a href="barang/create"
                        class="btn btn-primary">Tambah Barang</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Barang</a></div>
                    <div class="breadcrumb-item">Semua Barang</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Barang</h2>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Semua Barang</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control"
                                                placeholder="Search"
                                                id="table-search"
                                                >
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table display nowrap" style="width: 100%" id="table-1">
                                        <thead style="width: 100%">
                                        <tr style="width: 100%">
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Condition</th>
                                            <th>Size</th>
                                            <th>Origin</th>
                                            <th>Type</th>
                                            <th>Category</th>
                                            <th>Color</th>
                                            <th>Stock</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->name }}

                                            </td>
                                            <td>
                                                {{ convertToRupiah($item->price) }}
                                            </td>
                                            <td>
                                                {{ $item->condition }}
                                            </td>
                                            <td>
                                                {{ $item->size }}
                                            </td>
                                            <td>
                                                {{ $item->region_of_origin }}
                                            </td>
                                            <td>
                                                {{ $item->sex }}
                                            </td>
                                            <td>
                                                {{ $item->category_name }}
                                            </td>
                                            <td>
                                                {{ $item->color_name }}
                                            </td>
                                            <td>
                                                {{ $item->is_sold ? 'Tidak Ada' : 'Ada' }}
                                            </td>
                                            <td>
                                            <form id="formToSampah" action="{{ route('barang.to_trash', $item->id) }}" method="POST">
                                                <a href="{{ route('barang.edit', $item->id) }}"
                                                class="btn btn-primary">
                                                <i class="ion-edit"
                                                data-pack="default"
                                                data-tags="change, update, write, type, pencil"></i>
                                            </a>
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-danger">
                                                <i class="ion-trash-b"
                                                data-pack="default"
                                                data-tags="delete"></i>
                                            </button>
                                            <a href="/admin/barang/{{ $item->id }}"
                                                class="btn btn-success">
                                                <i class="ion-information-circled"
                                                data-pack="default"
                                                data-tags="detail"></i>
                                            </a>
                                        </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset() }}"></script> --}}
    {{-- <script src="{{ asset() }}"></script> --}}
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    <script src="{{ asset('js/page/modules-ion-icons.js') }}"></script>
@endpush
