@extends('layouts.frontend')

@section('title', 'Videos')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="mb-4 text-center fw-bold">Our Videos</h1>
        
        <div class="row g-4">
            @forelse($videos as $video)
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="ratio ratio-16x9 rounded-top overflow-hidden">
                        <video class="w-100 h-100" controls>
                            <source src="{{ asset('storage/' . $video->video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-semibold">{{ $video->title }}</h5>
                        @if($video->description)
                            <p class="card-text text-muted">{{ Str::limit($video->description, 100) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No videos available at the moment.
                </div>
            </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $videos->links() }}
        </div>
    </div>
</section>
@endsection
