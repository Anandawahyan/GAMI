@extends('layouts.app')

@section('title', 'Activities')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Activities</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Activities</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="activities">
                            @foreach ($activities as $activity)    
                            <div class="activity">
                                <div class="activity-icon bg-primary shadow-primary text-white">
                                    @if ($activity->type == 'barang')
                                        <i class="fa-solid fa-box"></i>
                                    @elseif ($activity->type == 'message')
                                        <i class="fas fa-comment-alt"></i>
                                    @else
                                        <i class="fas fa-receipt"></i>
                                    @endif
                                </div>
                                <div class="activity-detail">
                                    <div class="mb-2">
                                        <span class="text-job text-primary">{{ convertDateToIndo($activity->created_at->toDateTimeString()) }}</span>
                                        <span class="bullet"></span>
                                        <span class="text-job text-primary">{{ getTime($activity->created_at->toDateTimeString()) }}</span>
                                        <div class="dropdown float-right">
                                            <a href="#"
                                                data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                                            <div class="dropdown-menu">
                                                <div class="dropdown-title">Options</div>
                                                <a href="#"
                                                    class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                                                <a href="#"
                                                    class="dropdown-item has-icon"><i class="fas fa-list"></i> Detail</a>
                                                <div class="dropdown-divider"></div>
                                                <a href="#"
                                                    class="dropdown-item has-icon text-danger"
                                                    data-confirm="Wait, wait, wait...|This action can't be undone. Want to take risks?"
                                                    data-confirm-text-yes="Yes, IDC"><i class="fas fa-trash-alt"></i>
                                                    Archive</a>
                                            </div>
                                        </div>
                                    </div>
                                    @if (Auth::user()->id == $activity->id_user)
                                    <p>Anda {{$activity->activity}}</p>
                                    @else
                                    <p>{{ $activity->nama_user . ' ' . $activity->activity }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
