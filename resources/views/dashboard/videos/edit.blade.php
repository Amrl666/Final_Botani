@extends('layouts.app')

@section('title', 'Ubah Video')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Ubah Video</h1>
            <p class="text-muted">Perbarui informasi dan konten video</p>
        </div>
        <a href="{{ route('dashboard.videos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Video
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.videos.update', $video) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="title" class="form-label">Judul Video</label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $video->title) }}" 
                                   placeholder="Masukkan judul video"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="video" class="form-label">Berkas Video</label>
                            <div class="video-upload-wrapper">
                                <input type="file" 
                                       class="form-control @error('video') is-invalid @enderror" 
                                       id="video" 
                                       name="video" 
                                       accept="video/*"
                                       onchange="previewVideo(event)">
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Kosongkan untuk mempertahankan video saat ini. Format yang didukung: MP4, WebM, Ogg
                                </small>
                                @error('video')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Masukkan deskripsi video">{{ old('description', $video->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="mb-4">
                            <label for="name" class="form-label">Nama Video (Opsional)</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $video->name) }}" 
                                   placeholder="Masukkan nama video (opsional)">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('dashboard.videos.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Perbarui Video
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Video Saat Ini</h5>
                </div>
                <div class="card-body">
                    <div class="video-preview-container mb-3">
                        <video class="w-100" controls>
                            <source src="{{ asset('storage/' . $video->video) }}" type="video/mp4">
                            Browser Anda tidak mendukung tag video.
                        </video>
                    </div>
                    <div class="video-info">
                        <div class="d-flex justify-content-between text-muted mb-2">
                            <span>Judul:</span>
                            <span class="text-dark">{{ $video->title }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted mb-2">
                            <span>Diupload:</span>
                            <span>{{ $video->created_at->format('d M Y') }}</span>
                        </div>
                        @if($video->description)
                        <div class="d-flex justify-content-between text-muted">
                            <span>Deskripsi:</span>
                            <span class="text-dark">{{ Str::limit($video->description, 50) }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.video-upload-wrapper {
    position: relative;
}

.video-preview-container {
    background: #f8f9fa;
    border-radius: 0.5rem;
    overflow: hidden;
}

.video-preview-container video {
    border-radius: 0.5rem;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
</style>

@push('scripts')
<script>
function previewVideo(event) {
    const file = event.target.files[0];
    if (file) {
        // Show preview of new video if selected
        const url = URL.createObjectURL(file);
        const previewContainer = document.querySelector('.video-preview-container');
        previewContainer.innerHTML = `
            <video class="w-100" controls>
                <source src="${url}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        `;
    }
}
</script>
@endpush

@endsection