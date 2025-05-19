@extends('layouts.frontend')

@section('title', 'Videos')

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="mb-5">Our Videos</h1>
        
        <div class="row">
            @foreach($videos as $video)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="ratio ratio-16x9">
                        <video class="w-100" controls>
                            <source src="{{ asset('storage/' . $video->video) }}" type="video/mp4">
                            Browser tidak mendukung tag video.
                        </video>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $video->title }}</h5>
                        @if($video->description)
                            <p class="card-text">{{ $video->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{ $videos->links() }}
    </div>
</section>
@endsection
