@extends('layouts.app')

@section('title', 'Tambah Item Galeri')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Tambah Item Galeri Baru</h1>
            <p class="text-muted">Upload dan atur gambar galeri</p>
        </div>
        <a href="{{ route('dashboard.gallery.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Galeri
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.gallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="title" class="form-label">Judul Gambar</label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   placeholder="Masukkan judul gambar"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="form-label">File Gambar</label>
                            <div class="image-upload-wrapper">
                                <input type="file" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       id="image" 
                                       name="image" 
                                       accept="image/*"
                                       onchange="previewImage(event)"
                                       required>
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Format yang didukung: JPG, PNG, GIF 
                                </small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">Tanggal Galeri</label>
                            <input type="date" 
                                   class="form-control @error('description') is-invalid @enderror" 
                                   id="description" 
                                   name="description" 
                                   value="{{ old('description', isset($gallery) ? $gallery->description : '') }}" 
                                   required>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light">Reset</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-cloud-upload-alt me-2"></i>Tambah ke Galeri
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Pratinjau Gambar</h5>
                </div>
                <div class="card-body">
                    <div class="image-preview-container mb-3">
                        <div id="previewPlaceholder" class="text-center py-5">
                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Pratinjau gambar akan muncul di sini</p>
                        </div>
                        <img id="imagePreview" class="w-100 d-none rounded" alt="Preview">
                    </div>
                    <div class="image-info d-none" id="imageInfo">
                        <div class="d-flex justify-content-between text-muted mb-2">
                            <span>Ukuran file:</span>
                            <span id="imageSize">-- KB</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted">
                            <span>Dimensi:</span>
                            <span id="imageDimensions">-- x --</span>
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
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#imagePreview {
    max-height: 300px;
    object-fit: contain;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
</style>

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('previewPlaceholder');
    const imageInfo = document.getElementById('imageInfo');
    const size = document.getElementById('imageSize');
    const dimensions = document.getElementById('imageDimensions');

    if (file) {
        const url = URL.createObjectURL(file);
        preview.src = url;
        preview.classList.remove('d-none');
        placeholder.classList.add('d-none');
        imageInfo.classList.remove('d-none');

        // Display file size
        const fileSizeKB = (file.size / 1024).toFixed(2);
        size.textContent = `${fileSizeKB} KB`;

        // Get image dimensions
        const img = new Image();
        img.onload = function() {
            dimensions.textContent = `${this.width} x ${this.height}`;
        };
        img.src = url;
    } else {
        preview.src = '';
        preview.classList.add('d-none');
        placeholder.classList.remove('d-none');
        imageInfo.classList.add('d-none');
    }
}
</script>
@endpush

@endsection