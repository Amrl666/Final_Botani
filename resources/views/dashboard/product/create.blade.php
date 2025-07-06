@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Tambah Produk Baru</h1>
            <p class="text-muted">Buat dan kelola daftar produk</p>
        </div>
        <a href="{{ route('dashboard.product.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Produk
        </a>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Mohon perbaiki kesalahan berikut:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="form-label">Nama Produk</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   placeholder="Masukkan nama produk"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">Deskripsi Produk</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Jelaskan produk Anda..."
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="price" class="form-label">Harga (Rp)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" 
                                               step="0.01" 
                                               class="form-control @error('price') is-invalid @enderror" 
                                               id="price" 
                                               name="price" 
                                               value="{{ old('price') }}"
                                               placeholder="0.00"
                                               required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="stock" class="form-label">Jumlah Stok</label>
                                    <input type="number" 
                                           class="form-control @error('stock') is-invalid @enderror" 
                                           id="stock" 
                                           name="stock" 
                                           value="{{ old('stock') }}"
                                           placeholder="0"
                                           min="0"
                                           required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="unit" class="form-label">Satuan</label>
                                    <select class="form-select @error('unit') is-invalid @enderror" 
                                            id="unit" 
                                            name="unit" 
                                            required>
                                        <option value="">Pilih Satuan</option>
                                        <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                        <option value="gram" {{ old('unit') == 'gram' ? 'selected' : '' }}>Gram</option>
                                        <option value="buah" {{ old('unit') == 'buah' ? 'selected' : '' }}>Buah</option>
                                        <option value="ikat" {{ old('unit') == 'ikat' ? 'selected' : '' }}>Ikat</option>
                                        <option value="pack" {{ old('unit') == 'pack' ? 'selected' : '' }}>Pack</option>
                                        <option value="box" {{ old('unit') == 'box' ? 'selected' : '' }}>Box</option>
                                        <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                                    </select>
                                    @error('unit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="min_increment" class="form-label">Kelipatan Minimum</label>
                                    <input type="number" 
                                           step="0.01" 
                                           class="form-control @error('min_increment') is-invalid @enderror" 
                                           id="min_increment" 
                                           name="min_increment" 
                                           value="{{ old('min_increment', 0.5) }}"
                                           placeholder="0.5"
                                           min="0.01"
                                           required>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Jumlah minimum yang dapat dipesan (misal: 0.5 untuk kg, 1 untuk pieces)
                                    </small>
                                    @error('min_increment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Bundle Fields -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="bundle_quantity" class="form-label">Jumlah Bundle</label>
                                    <input type="number" 
                                           class="form-control @error('bundle_quantity') is-invalid @enderror" 
                                           id="bundle_quantity" 
                                           name="bundle_quantity" 
                                           value="{{ old('bundle_quantity') }}"
                                           placeholder="0"
                                           min="0">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Jumlah item dalam bundle (misal: 3 untuk "5000 dapat 3")
                                    </small>
                                    @error('bundle_quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="bundle_price" class="form-label">Harga Bundle (Rp)</label>
                                    <input type="number" 
                                           step="0.01" 
                                           class="form-control @error('bundle_price') is-invalid @enderror" 
                                           id="bundle_price" 
                                           name="bundle_price" 
                                           value="{{ old('bundle_price') }}"
                                           placeholder="0.00"
                                           min="0">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Harga total untuk bundle (misal: 5000 untuk "5000 dapat 3")
                                    </small>
                                    @error('bundle_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="form-label">Gambar Produk</label>
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
                                    Format yang didukung: JPG, PNG, GIF (Ukuran maks: 5MB)
                                </small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="hidden" name="featured" value="0">
                                <input type="checkbox" 
                                       class="form-check-input @error('featured') is-invalid @enderror" 
                                       id="featured" 
                                       name="featured" 
                                       value="1"
                                       {{ old('featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured">
                                    <i class="fas fa-star me-1"></i>Produk Unggulan
                                </label>
                                @error('featured')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light">Reset</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Pratinjau Produk</h5>
                </div>
                <div class="card-body">
                    <div class="image-preview-container mb-3">
                        <div id="previewPlaceholder" class="text-center py-5">
                            <i class="fas fa-box fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Pratinjau gambar produk</p>
                        </div>
                        <img id="imagePreview" class="w-100 d-none rounded" alt="Preview">
                    </div>
                    <div class="product-info">
                        <div class="d-flex justify-content-between text-muted mb-2">
                            <span>Nama:</span>
                            <span id="namePreview" class="text-dark">--</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted mb-2">
                            <span>Harga:</span>
                            <span id="pricePreview" class="text-success fw-bold">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted mb-2">
                            <span>Stok:</span>
                            <span id="stockPreview" class="text-dark">0</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted mb-2">
                            <span>Satuan:</span>
                            <span id="unitPreview" class="text-dark">--</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted mb-2">
                            <span>Kelipatan Min:</span>
                            <span id="minIncrementPreview" class="text-dark">--</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted">
                            <span>Unggulan:</span>
                            <span id="featuredPreview" class="text-warning">Tidak</span>
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

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
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
document.getElementById('price').addEventListener('input', function() {
    const price = this.value || 0;
    document.getElementById('pricePreview').textContent = `Rp ${parseFloat(price).toLocaleString('id-ID')}`;
});

// Update preview when stock changes
document.getElementById('stock').addEventListener('input', function() {
    document.getElementById('stockPreview').textContent = this.value || 0;
});

// Update preview when unit changes
document.getElementById('unit').addEventListener('change', function() {
    document.getElementById('unitPreview').textContent = this.value || '--';
});

// Update preview when min_increment changes
document.getElementById('min_increment').addEventListener('input', function() {
    document.getElementById('minIncrementPreview').textContent = this.value || '--';
});

// Update preview when featured checkbox changes
document.getElementById('featured').addEventListener('change', function() {
    document.getElementById('featuredPreview').textContent = this.checked ? 'Ya' : 'Tidak';
    document.getElementById('featuredPreview').className = this.checked ? 'text-warning fw-bold' : 'text-muted';
});
</script>
@endpush

@endsection