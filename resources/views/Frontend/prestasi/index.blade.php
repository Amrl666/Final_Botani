@extends('layouts.frontend')

@section('title', 'Our Profile')

@section('content')
<section class="py-5">
    <div class="container">
        @if($prestasi)
        <div class="row">
            <div class="col-lg-6">
                <h1 class="mb-4">{{ $prestasi->title }}</h1>
                <div class="content">
                    {!! $prestasi->content !!}
                </div>
            </div>
            <div class="col-lg-6">
                @if($prestasi->image)
                    <img src="{{ asset('storage/' . $prestasi->image) }}" alt="{{ $prestasi->title }}" class="img-fluid rounded">
                @endif
            </div>
        </div>
        @else
        <div class="alert alert-info">
            No profile information available yet.
        </div>
        @endif
    </div>
</section>
@endsection