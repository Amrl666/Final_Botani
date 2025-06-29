@extends('layouts.app')

@section('title', 'Buat Prestasi Baru')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Buat Prestasi Baru</h1>
            <p class="text-muted">Tambah prestasi dan pencapaian baru</p>
        </div>
        <a href="{{ route('dashboard.prestasi.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Prestasi
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.prestasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="title" class="form-label">Judul Prestasi</label>
                            <input 
                                type="text" 
                                class="form-control @error('title') is-invalid @enderror" 
                                id="title" 
                                name="title" 
                                value="{{ old('title') }}"
                                placeholder="Masukkan judul prestasi"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="form-label">Gambar Prestasi</label>
                            <div class="image-upload-wrapper">
                                <input 
                                    type="file" 
                                    class="form-control @error('image') is-invalid @enderror" 
                                    id="image" 
                                    name="image"
                                    accept="image/*"
                                    onchange="previewImage(event)"
                                >
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Opsional. Format yang didukung: JPG, PNG, GIF (Ukuran maks: 5MB)
                                </small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="content" class="form-label">Detail Prestasi</label>
                            <textarea 
                                class="form-control @error('content') is-invalid @enderror" 
                                id="content" 
                                name="content" 
                                rows="8"
                                placeholder="Jelaskan detail prestasi..."
                                required
                            >{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-lightbulb me-1"></i>
                                Sertakan detail tentang prestasi, tanggal, dan signifikansinya
                            </small>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light">Reset</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-trophy me-2"></i>Buat Prestasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Pratinjau Prestasi</h5>
                </div>
                <div class="card-body">
                    <div class="image-preview-container mb-3">
                        <div id="previewPlaceholder" class="text-center py-5">
                            <i class="fas fa-trophy fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Pratinjau gambar prestasi</p>
                        </div>
                        <img id="imagePreview" class="w-100 d-none rounded" alt="Preview">
                    </div>
                    <div class="achievement-info">
                        <div class="d-flex justify-content-between text-muted mb-2">
                            <span>Judul:</span>
                            <span id="titlePreview" class="text-dark">--</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted mb-2">
                            <span>Panjang konten:</span>
                            <span id="contentLength">0 karakter</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted">
                            <span>Jumlah kata:</span>
                            <span id="wordCount">0 kata</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.image-upload-wrapper {
    position: relative;
}

.image-preview-container {
    background: #f8f9fa;
    border-radius: 0.5rem;
    overflow: hidden;
    min-height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#imagePreview {
    max-height: 200px;
    object-fit: cover;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

#content {
    resize: vertical;
    min-height: 200px;
}
</style>

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('previewPlaceholder');

    if (file) {
        const url = URL.createObjectURL(file);
        preview.src = url;
        preview.classList.remove('d-none');
        placeholder.classList.add('d-none');
    } else {
        preview.src = '';
        preview.classList.add('d-none');
        placeholder.classList.remove('d-none');
    }
}

// Update preview when title changes
document.getElementById('title').addEventListener('input', function() {
    document.getElementById('titlePreview').textContent = this.value || '--';
});

// Update preview when content changes
document.getElementById('content').addEventListener('input', function() {
    const content = this.value;
    document.getElementById('contentLength').textContent = content.length + ' karakter';
    document.getElementById('wordCount').textContent = content.trim().split(/\s+/).filter(word => word.length > 0).length + ' kata';
});
</script>
@endpush

@endsection