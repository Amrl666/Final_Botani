@extends('layouts.frontend')

@section('title', 'Videos')

@section('content')
<section class="videos-section py-5 bg-light">
    <div class="container custom-container">
        <h1 class="videos-title mb-4 text-center">
        Explore Our Inspiring <span class="highlight fw-bold">Video Collection</span>
        </h1>

        <div class="row g-4 justify-content-center">
            @forelse($videos as $video)
                <div class="col-sm-12 col-md-6 col-lg-4 d-flex justify-content-center">
                    <div class="video-card card bg-white shadow-sm">
                        <div class="ratio ratio-16x9 video-wrapper">
                            <video controls preload="metadata" class="video-player" tabindex="0" aria-label="Video titled {{ $video->title }}">
                                <source src="{{ asset('storage/' . $video->video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title video-title fw-semibold mb-2">
                                {{ $video->title }}
                            </h5>
                            @if($video->description)
                                <p class="card-text video-description text-muted" title="{{ $video->description }}">
                                    {{ \Illuminate\Support\Str::limit($video->description, 160, '...') }}
                                </p>
                            @else
                                <p class="card-text video-description text-muted fst-italic">
                                    No description available for this video.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center no-video-message">
                        Sorry, no videos available at the moment. Please check back soon!
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $videos->links() }}
        </div>
    </div>
</section>

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<style>
    .videos-section {
        font-family: 'Inter', sans-serif;
        color: #2f855a;
    }

    .videos-title {
        color: #2f855a;
        font-size: 2.5rem;
        letter-spacing: 0.05em;
        font-weight: 900; /* super bold */
    }

    .highlight {
        color: #38a169;
    }

    .video-card {
        border: 1px solid #c6f6d5;
        padding: 1rem;
        max-width: 350px;
        width: 100%;
        background-color: #fff;
        border-radius: 0.5rem;
        transition: box-shadow 0.3s ease;
    }

    .video-card:hover {
        box-shadow: 0 8px 20px rgba(56, 161, 105, 0.3);
    }

    .video-wrapper {
        max-height: 200px;
        overflow: hidden;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    .video-player {
        object-fit: cover;
        width: 100%;
        height: 200px;
        border-radius: 0.5rem;
        background-color: #000;
    }

    .card-body {
        padding: 1rem 1rem 1.25rem;
    }

    .video-title {
        font-size: 1.3rem;
        line-height: 1.2;
        color: #276749;
        margin-bottom: 0.5rem;
    }

    .video-description {
        font-size: 1rem;
        line-height: 1.5;
        color: #4a5568;
        margin-top: 0.25rem;
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        max-height: 6em;
    }

    .video-description.fst-italic {
        color: #718096;
    }

    .no-video-message {
        font-family: 'Inter', sans-serif;
        color: #2f855a;
        background-color: #c6f6d5;
        padding: 1rem;
        border-radius: 0.25rem;
        font-weight: 600;
        font-size: 1.1rem;
    }

    /* Responsive container padding for large screens */
    .custom-container {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    @media (min-width: 768px) {
        .custom-container {
            padding-left: 2rem;
            padding-right: 2rem;
        }
    }

    @media (min-width: 992px) {
        .custom-container {
            padding-left: 3rem;
            padding-right: 3rem;
        }
    }

    @media (min-width: 1200px) {
        .custom-container {
            padding-left: 4rem;
            padding-right: 4rem;
        }
    }

    @media (min-width: 1400px) {
        .custom-container {
            padding-left: 5rem;
            padding-right: 5rem;
        }
    }
</style>
@endpush

@endsection
