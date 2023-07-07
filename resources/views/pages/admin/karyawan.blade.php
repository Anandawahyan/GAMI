@extends('layouts.app')

@section('title', 'Karyawan')

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
                <h1>Order</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/admin/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Karyawan</a></div>
                    <div class="breadcrumb-item">Semua Karyawan</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Karyawan</h2>
                <button type="button" data-bs-toggle="modal" data-bs-target="#alamatModal" class="btn btn-primary">Tambah Karyawan Baru</button>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Semua Karyawan</h4>
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
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Sex</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td><a href="#">{{ $user->id }}</a></td>
                                            <td class="font-weight-600">{{ $user->name }}</td>
                                            <td>
                                                {{$user->sex}}
                                            </td>
                                            <td>
                                                {{$user->role}}
                                            </td>
                                            <td>
                                                <form id="deleteKaryawan" action="{{ route('karyawan.delete', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn buttonHapus btn-danger">
                                                    Hapus
                                                </button>
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
    <div class="modal fade" id="alamatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Data Karyawan</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="karyawanBaruForm" action="{{ route('karyawan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                  <label for="email" class="col-form-label">Email :</label>
                  <input name="email" type="email" class="form-control" id="email">
                </div>
                <div class="mb-3">
                  <label for="password" class="col-form-label">Password :</label>
                  <div class="input-group d-flex" id="show_hide_password">
                    <input id="passwordInput" class="form-control" type="password" name="password">
                    <div class="input-group-addon">
                      <a class="d-flex justify-content-center bg-light h-100 align-items-center" style="width: 30px; text-decoration: none; border-radius: 0 10px 10px 0" href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                    </div>
                  </div>
                  <button type="button" id="randomPasswordButton" class="mt-2 btn btn-primary">Generate Password</button>
                </div>
                <div class="mb-3">
                  <label for="namaKaryawan" class="col-form-label">Nama Karyawan :</label>
                  <input name="namaKaryawan" type="text" class="form-control" id="namaKaryawan">
                </div>
                <div class="mb-3">
                  <label for="roleKaryawan" class="col-form-label">Role : </label>
                  <select name="roleKaryawan" class="d-block w-100 form-select" aria-label="roleKaryawan" id="roleKaryawan">
                    <option value="admin">admin</option>
                    <option value="executive">Executive</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="sexKaryawan" class="col-form-label">Jenis Kelamin : </label>
                  <select name="sexKaryawan" class="d-block w-100 form-select" aria-label="sexKaryawan" id="sexKaryawan">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
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
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset() }}"></script> --}}
    {{-- <script src="{{ asset() }}"></script> --}}
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js" type="text/javascript"></script>
    <script>
        $(document).ready( function () {
            moment.locale('id')
            $.fn.dataTable.moment("ddd, D-MMM-YY");
            var table = $('#table-2').DataTable( {
                "dom": 'lrtip',
                "scrollX": false,
                columnDefs: [{
                    target: 3, //index of column
                }],
                order: [[3, 'desc']],
            } );

            table.columns.adjust().draw();
            
            $('#table-search').on( 'keyup click', function () {
                table.search($('#table-search').val()).draw();
            } );
            $("#show_hide_password a").on('click', function(event) {
                    event.preventDefault();
                    if($('#show_hide_password input').attr("type") == "text"){
                        $('#show_hide_password input').attr('type', 'password');
                        $('#show_hide_password i').addClass( "fa-eye-slash" );
                        $('#show_hide_password i').removeClass( "fa-eye" );
                    }else if($('#show_hide_password input').attr("type") == "password"){
                        $('#show_hide_password input').attr('type', 'text');
                        $('#show_hide_password i').removeClass( "fa-eye-slash" );
                        $('#show_hide_password i').addClass( "fa-eye" );
                    }
                });
            });

            $('.buttonHapus').on('click', function() {
                console.log('siu');
                swal({
                    title: 'Apakah kamu yakin menghapus karyawan?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                    $('#deleteKaryawan').trigger('submit');
                    }
                });
            });
    </script>
    <script>
        $('#randomPasswordButton').on('click', function() {
            $.ajax({
                url: '/password/random',
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    $('#passwordInput').val(response.data);
                }
            })
        });
    </script>
@endpush
