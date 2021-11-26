@extends('layouts.home')
@section('content')
<link rel="stylesheet" href="{{ asset('/css/track.css') }}">
<h1 style="text-align:center">Tracking Disposisi</h1>
@include('../layouts/headcontent')
<div class="track">
    <div class="timeline">
        <div class="timeline-body">
            @foreach ($track as $item)
            <div class="timeline-item">
                <p class="time">{{ $item->created_at->format('d, M Y') }} <br>
                    {{ $item->created_at->format('H:i') }}
                </p>
                <div class="content">
                    <h4 class="judul">{{ $item->status }}</h4>
                    <p>{{ $item->keterangan }}</p>

                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
