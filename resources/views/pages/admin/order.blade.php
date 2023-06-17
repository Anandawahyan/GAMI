@extends('layouts.app')

@section('title', 'Semua Barang')

@push('style')
    <!-- CSS Libraries -->
    
    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
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
                                    <table class="table-striped table display nowrap" style="width: 100%" id="table-2">
                                        <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Status</th>
                                            <th>Order Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                        <tr>
                                            <td><a href="#">{{ $order->order_id }}</a></td>
                                            <td class="font-weight-600">{{ $order->name }}</td>
                                            <td>
                                                   @if ($order->status == 1)
                                                   <div class="badge badge-warning">Dikemas</div>
                                                   @elseif ($order->status == 2)
                                                   <div class="badge badge-danger">Ditolak</div>
                                                   @elseif ($order->status == 3)
                                                   <div class="badge badge-info">Diantar</div>
                                                   @elseif ($order->status == 4)
                                                   <div class="badge badge-success">Diterima</div>
                                                   @endif
                                            </td>
                                            <td>{{ convertDateToIndo($order->date) }}</td>
                                            <td>
                                                <a href="/admin/order/{{ $order->order_id }}"
                                                    class="btn btn-primary">Detail</a>
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
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset() }}"></script> --}}
    {{-- <script src="{{ asset() }}"></script> --}}
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    <script>
        $(document).ready( function () {
            var table = $('#table-2').DataTable( {
                "dom": 'lrtip',
                "scrollX": false
            } );

            table.columns.adjust().draw();
            
            $('#table-search').on( 'keyup click', function () {
                table.search($('#table-search').val()).draw();
            } );
            });

            $('#buttonHapus').on('click', function() {
            swal({
                title: 'Apakah kamu yakin menghapus semua?',
                text: 'Setelah dihapus, Kamu tidak akan bisa merestore itemnya loh!',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                $('#formToDelete').trigger('submit');
                }
            });
            })
    </script>
@endpush
