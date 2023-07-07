@extends('layouts.customer_app')

@section('title', 'Catalog')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush
@section('main')
    <div class="container my-4 text-center d-flex justify-content-center">
    <div class="content-container">
        <div class="text">
            <img src="{{ $user->sex == 'Laki-laki' ? asset('img/avatar/avatar-2.png') : asset('img/avatar/avatar-3.png')  }}" alt="">
            <h3>{{ $user->name }}</h3>
            <p><span class="badge rounded-pill {{ $user->points > 300 ? 'gold' : ($user->points <= 300 && $user->points > 0 ? 'silver' : 'bronze' ) }}">{{ $user->points > 300 ? 'Gold' : ($user->points <= 300 && $user->points > 0 ? 'Silver' : 'Bronze' ) }}</span></p>
            <div class="progress" style="width: 100%">
                <div class="progress-bar" style="width: {{ $progress_value }}%" role="progressbar" aria-valuenow="{{ $progress_value }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            @if($progress_value == 100)
              <p>Selamat, Anda telah mencapai tingkatan user tertinggi!</p>
            @elseif ($progress_value > 0 && $progress_value <= 300)
              <p>{{ 300 - $user->points }} menuju Gold user</p>
            @endif
            <h4>Alamat :</h4>
            <ul class="list-group">
                @foreach ($alamats as $alamat)
                <li class="list-group-item">{{ $alamat->alamat_rumah }}</li> 
                @endforeach
              </ul>
        </div>
    </div>
</div>
@endsection