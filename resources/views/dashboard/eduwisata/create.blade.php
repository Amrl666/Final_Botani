@extends('layouts.app')

@section('title', 'Tambah Eduwisata')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Tambah Eduwisata Baru</h1>
            <p class="text-muted">Buat paket wisata edukasi</p>
        </div>
        <a href="{{ route('dashboard.eduwisata.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Eduwisata
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.eduwisata.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="form-label">Nama Paket</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   placeholder="Masukkan nama paket"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">Deskripsi Paket</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="5"
                                      placeholder="Jelaskan paket wisata edukasi..."
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-lightbulb me-1"></i>
                                Sertakan aktivitas, durasi, dan apa yang akan dipelajari peserta
                            </small>
                        </div>
                        
                        <div class="mb-4">
                            <label for="harga" class="form-label">Harga (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                       name="harga" 
                                       class="form-control @error('harga') is-invalid @enderror" 
                                       value="{{ old('harga') }}"
                                       placeholder="0"
                                       min="0"
                                       required>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Harga per orang untuk paket edukasi ini
                            </small>
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="form-label">Gambar Paket</label>
                            <div class="image-upload-wrapper">
                                <input type="file" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       id="image" 
                                       name="image" 
                                       accept="image/*"
                                       onchange="previewImage(event)">
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Opsional. Format yang didukung: JPG, PNG, GIF (Ukuran maks: 5MB)
                                </small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light">Reset</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Eduwisata
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Pratinjau Paket</h5>
                </div>
                <div class="card-body">
                    <div class="image-preview-container mb-3">
                        <div id="previewPlaceholder" class="text-center py-5">
                            <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Pratinjau gambar paket</p>
                        </div>
                        <img id="imagePreview" class="w-100 d-none rounded" alt="Preview">
                    </div>
                    <div class="package-info">
                        <div class="d-flex justify-content-between text-muted mb-2">
                            <span>Nama:</span>
                            <span id="namePreview" class="text-dark">--</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted mb-2">
                            <span>Harga:</span>
                            <span id="pricePreview" class="text-success fw-bold">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted">
                            <span>Deskripsi:</span>
                            <span id="descPreview" class="text-dark">--</span>
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

#description {
    resize: vertical;
    min-height: 120px;
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

// Update preview when name changes
document.getElementById('name').addEventListener('input', function() {
    document.getElementById('namePreview').textContent = this.value || '--';
});

// Update preview when price changes
document.getElementById('harga').addEventListener('input', function() {
    const price = this.value || 0;
    document.getElementById('pricePreview').textContent = `Rp ${parseFloat(price).toLocaleString('id-ID')}`;
});

// Update preview when description changes
document.getElementById('description').addEventListener('input', function() {
    const desc = this.value || '--';
    document.getElementById('descPreview').textContent = desc.length > 30 ? desc.substring(0, 30) + '...' : desc;
});
</script>
@endpush

@endsection