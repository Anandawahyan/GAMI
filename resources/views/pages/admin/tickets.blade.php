@extends('layouts.app')

@section('title', 'Tickets')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/chocolat/dist/css/chocolat.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tickets</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Tickets</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Help Your Customer</h2>
                <p class="section-lead">
                    Some customers need your help.
                </p>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tickets</h4>
                            </div>
                            <div class="card-body">
                                <a href="#"
                                    class="btn btn-primary btn-icon icon-left btn-lg btn-block d-md-none mb-4"
                                    data-toggle-slide="#ticket-items">
                                    <i class="fas fa-list"></i> All Tickets
                                </a>
                                <div class="tickets">
                                    <div class="ticket-items"
                                        id="ticket-items">
                                        @foreach ($messages as $message)
                                        <div class="ticket-item {{ $messageSpesific[0]->message_id == $message->message_id ? 'active' : '' }} mb-2">
                                            <a class="d-block" href="/admin/ticket/{{ $message->message_id }}">
                                            <div class="ticket-title">
                                                <h4>{{$message->title}}</h4>
                                            </div>
                                            <div class="ticket-desc">
                                                <div>{{$message->name}}</div>
                                                <div class="bullet"></div>
                                                <div>2 min ago</div>
                                            </div>
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="ticket-content">
                                        <div class="ticket-header">
                                            <div class="ticket-sender-picture img-shadow">
                                                <img src="{{ asset('img/avatar/avatar-3.png') }}"
                                                    alt="image">
                                            </div>
                                            <div class="ticket-detail">
                                                <div class="ticket-title">
                                                    <h4>{{ $messageSpesific[0]->title }}</h4>
                                                </div>
                                                <div class="ticket-info">
                                                    <div class="font-weight-600">{{$messageSpesific[0]->name}}</div>
                                                    <div class="bullet"></div>
                                                    <div class="text-primary font-weight-600">2 min ago</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ticket-description" style="font-size: 20px">
                                            {!! $messageSpesific[0]->text !!}
                                        </div>
                                        <div class="ticket-divider mt-2 mb-2"></div>
                                        <div class="ticket-replies">
                                            @foreach ($replies as $reply)
                                            <div class="ticket-header mb-2">
                                                <div class="ticket-sender-picture img-shadow">
                                                    <img src="{{ $reply->role == 'admin' ? asset('img/avatar/avatar-5.png') : asset('img/avatar/avatar-3.png')}}"
                                                        alt="image">
                                                </div>
                                                <div class="ticket-detail">
                                                    <div class="ticket-info mb-0">
                                                        <div class="font-weight-600">{{$reply->role == 'admin' ? 'Admin' : $reply->name}}</div>
                                                        <div class="bullet"></div>
                                                        <div class="text-primary font-weight-600">2 min ago</div>
                                                    </div>
                                                    <div class="ticket-description mt-1">
                                                        {!! $reply->text !!}
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="ticket-form mt-5">
                                            <form method="POST" action={{ route('ticket.create', $messageSpesific[0]->message_id) }}>
                                                @csrf
                                                <div class="form-group">
                                                @error('reply')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                                    <textarea name="reply" class="summernote form-control"
                                                        placeholder="Type a reply ..."></textarea>
                                                </div>
                                                <div class="form-group text-right">
                                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                                        Reply
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="mt-1">
                                            <form id="finishThreadForm" method="POST" action="{{ route('ticket.solved', $messageSpesific[0]->message_id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group text-right">
                                                    <button id="finishThread" type="button" class="btn btn-success btn-lg w-100">
                                                        Selesaikan thread
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
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
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $('#finishThread').on('click', function() {
            swal({
                title: 'Apakah kamu yakin untuk menyelesaikan thread?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willFinish) => {
                if (willFinish) {
                $('#finishThreadForm').trigger('submit');
                }
            });
        });
    </script>
@endpush
