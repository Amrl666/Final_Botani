@extends('layouts.frontend')

@section('title', 'Gallery')

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="mb-5">Our Gallery</h1>
        
        <div class="row">
            @foreach($galleries as $gallery)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $gallery->image) }}" class="card-img-top" alt="{{ $gallery->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $gallery->title }}</h5>
                        @if($gallery->description)
                            <p class="card-text">{{ Str::limit($gallery->description, 50) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{ $galleries->links() }}
    </div>
</section>
@endsection