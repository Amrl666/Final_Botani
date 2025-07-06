@extends('layouts.app')

@section('title', 'Ubah Produk')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Ubah Produk</h1>
            <p class="text-muted">Perbarui detail dan informasi produk</p>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" form="productForm" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Perbarui Produk
            </button>
            <a href="{{ route('dashboard.product.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Produk
            </a>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card animate-fade-in">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2 text-primary"></i>
                        Ubah Produk: {{ $product->name }}
                    </h5>
                </div>
                <div class="card-body">
                    <form id="productForm" action="{{ route('dashboard.product.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <!-- Name Field -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        id="name" 
                                        name="name" 
                                        placeholder="Masukkan nama produk"
                                        value="{{ old('name', $product->name) }}" 
                                        required
                                    >
                                    <label for="name">
                                        <i class="fas fa-box me-2"></i>Nama Produk
                                    </label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Image Upload -->
                            <div class="col-12">
                                <div class="image-upload-area" id="imageUploadArea">
                                    <div class="current-image mb-3">
                                        @if($product->image)
                                            <div class="image-preview">
                                                <img src="{{ asset('storage/' . $product->image) }}" 
                                                     alt="{{ $product->name }}" 
                                                     class="preview-img">
                                                <div class="image-overlay">
                                                    <span class="badge bg-primary">Gambar Saat Ini</span>
                                                    <button type="button" class="btn btn-light btn-sm" onclick="openImageModal('{{ asset('storage/' . $product->image) }}', '{{ $product->name }}')">
                                                        <i class="fas fa-expand-alt me-1"></i>Lihat
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="upload-section">
                                        <div class="form-floating">
                                            <input 
                                                type="file" 
                                                class="form-control @error('image') is-invalid @enderror" 
                                                id="image" 
                                                name="image"
                                                accept="image/*"
                                            >
                                            <label for="image">
                                                <i class="fas fa-image me-2"></i>Perbarui Gambar (Opsional)
                                            </label>
                                        </div>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Ukuran yang disarankan: 800x600 piksel, Ukuran maks: 5MB
                                        </div>
                                        @error('image')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Description Field -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea 
                                        class="form-control @error('description') is-invalid @enderror" 
                                        id="description" 
                                        name="description" 
                                        placeholder="Masukkan deskripsi produk"
                                        rows="4"
                                        style="height: 120px;"
                                        required
                                    >{{ old('description', $product->description) }}</textarea>
                                    <label for="description">
                                        <i class="fas fa-align-left me-2"></i>Deskripsi Produk
                                    </label>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Berikan deskripsi detail tentang produk
                                </div>
                            </div>

                            <!-- Price Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="number" 
                                        class="form-control @error('price') is-invalid @enderror" 
                                        id="price" 
                                        name="price" 
                                        placeholder="Masukkan harga"
                                        value="{{ old('price', $product->price) }}" 
                                        min="0"
                                        step="1000"
                                        required
                                    >
                                    <label for="price">
                                        <i class="fas fa-tag me-2"></i>Harga (Rp)
                                    </label>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Stock Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="number" 
                                        class="form-control @error('stock') is-invalid @enderror" 
                                        id="stock" 
                                        name="stock" 
                                        placeholder="Masukkan jumlah stok"
                                        value="{{ old('stock', $product->stock ?? 0) }}" 
                                        min="0"
                                        required
                                    >
                                    <label for="stock">
                                        <i class="fas fa-boxes me-2"></i>Jumlah Stok
                                    </label>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Unit Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit" required>
                                        <option value="">Pilih Satuan</option>
                                        <option value="kg" {{ old('unit', $product->unit ?? '') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                        <option value="gram" {{ old('unit', $product->unit ?? '') == 'gram' ? 'selected' : '' }}>Gram</option>
                                        <option value="buah" {{ old('unit', $product->unit ?? '') == 'buah' ? 'selected' : '' }}>Buah</option>
                                        <option value="ikat" {{ old('unit', $product->unit ?? '') == 'ikat' ? 'selected' : '' }}>Ikat</option>
                                        <option value="pack" {{ old('unit', $product->unit ?? '') == 'pack' ? 'selected' : '' }}>Pack</option>
                                        <option value="box" {{ old('unit', $product->unit ?? '') == 'box' ? 'selected' : '' }}>Box</option>
                                        <option value="pcs" {{ old('unit', $product->unit ?? '') == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                                    </select>
                                    <label for="unit">
                                        <i class="fas fa-ruler me-2"></i>Satuan
                                    </label>
                                    @error('unit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Min Increment Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="number" 
                                        class="form-control @error('min_increment') is-invalid @enderror" 
                                        id="min_increment" 
                                        name="min_increment" 
                                        placeholder="Masukkan kelipatan minimum"
                                        value="{{ old('min_increment', $product->min_increment ?? 0.5) }}" 
                                        min="0.01"
                                        step="0.01"
                                        required
                                    >
                                    <label for="min_increment">
                                        <i class="fas fa-plus-minus me-2"></i>Kelipatan Minimum
                                    </label>
                                    @error('min_increment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Jumlah minimum yang dapat dipesan (misal: 0.5 untuk kg, 1 untuk pieces)
                                </div>
                            </div>
                        </div>

                        <!-- Bundle Fields -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="number" 
                                        class="form-control @error('bundle_quantity') is-invalid @enderror" 
                                        id="bundle_quantity" 
                                        name="bundle_quantity" 
                                        placeholder="Masukkan jumlah bundle"
                                        value="{{ old('bundle_quantity', $product->bundle_quantity ?? '') }}" 
                                        min="0"
                                    >
                                    <label for="bundle_quantity">
                                        <i class="fas fa-boxes me-2"></i>Jumlah Bundle
                                    </label>
                                    @error('bundle_quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Jumlah item dalam bundle (misal: 3 untuk "5000 dapat 3")
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="number" 
                                        class="form-control @error('bundle_price') is-invalid @enderror" 
                                        id="bundle_price" 
                                        name="bundle_price" 
                                        placeholder="Masukkan harga bundle"
                                        value="{{ old('bundle_price', $product->bundle_price ?? '') }}" 
                                        min="0"
                                        step="0.01"
                                    >
                                    <label for="bundle_price">
                                        <i class="fas fa-tag me-2"></i>Harga Bundle (Rp)
                                    </label>
                                    @error('bundle_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Harga total untuk bundle (misal: 5000 untuk "5000 dapat 3")
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Featured Field -->
                            <div class="col-md-6">
                                <div class="form-check form-switch mt-4">
                                    <input type="hidden" name="featured" value="0">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="featured" 
                                        name="featured" 
                                        value="1"
                                        {{ old('featured', $product->featured ?? false) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="featured">
                                        <i class="fas fa-star me-2"></i>Produk Unggulan
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top">
                            <a href="{{ route('dashboard.product.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Perbarui Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalTitle">Pratinjau Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<style>
/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideIn {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes scaleIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
}

.animate-slide-in {
    animation: slideIn 0.6s ease-out forwards;
}

.animate-scale-in {
    animation: scaleIn 0.6s ease-out forwards;
}

/* Card Styles */
.card {
    border: none;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    border-radius: 1rem;
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
}

.card-body {
    padding: 2rem;
}

/* Form Styles */
.form-floating {
    position: relative;
}

.form-control, .form-select {
    border: 2px solid #e9ecef;
    border-radius: 0.75rem;
    padding: 1rem 0.75rem;
    font-size: 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: #fff;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.25);
    outline: none;
}

.form-floating > label {
    padding: 1rem 0.75rem;
    color: #6c757d;
    font-weight: 500;
}

.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label,
.form-floating > .form-select ~ label {
    color: var(--primary-color);
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
}

/* Image Upload Area */
.image-upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 1rem;
    padding: 2rem;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.image-upload-area:hover {
    border-color: var(--primary-color);
    background: rgba(5, 150, 105, 0.05);
}

.current-image {
    text-align: center;
}

.image-preview {
    position: relative;
    display: inline-block;
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.preview-img {
    max-width: 400px;
    max-height: 300px;
    object-fit: cover;
    border-radius: 0.75rem;
    transition: transform 0.3s ease;
}

.image-preview:hover .preview-img {
    transform: scale(1.05);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.image-preview:hover .image-overlay {
    opacity: 1;
}

.upload-section {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #dee2e6;
}

/* Form Switch */
.form-check-input {
    width: 3rem;
    height: 1.5rem;
    margin-top: 0.25rem;
    background-color: #e9ecef;
    border: 2px solid #e9ecef;
    border-radius: 1rem;
    transition: all 0.3s ease;
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.form-check-input:focus {
    box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.25);
}

.form-check-label {
    font-weight: 500;
    color: #495057;
}

/* Button Styles */
.btn {
    border-radius: 0.75rem;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(5, 150, 105, 0.3);
}

.btn-outline-secondary {
    border: 2px solid #6c757d;
    color: #6c757d;
    background: transparent;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    color: white;
    transform: translateY(-2px);
}

.btn-light {
    background: rgba(255, 255, 255, 0.9);
    color: #333;
    border: none;
}

.btn-light:hover {
    background: #fff;
    transform: scale(1.05);
}

/* Badge Styles */
.badge {
    font-weight: 500;
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.bg-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
}

/* Form Text */
.form-text {
    color: #6c757d;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

/* Modal Styles */
.modal-content {
    border: none;
    border-radius: 1rem;
    overflow: hidden;
}

.modal-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

/* Loading States */
.loading {
    position: relative;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 1rem;
    height: 1rem;
    margin: -0.5rem 0 0 -0.5rem;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem;
    }
    
    .image-upload-area {
        padding: 1.5rem;
    }
    
    .preview-img {
        max-width: 100%;
    }
    
    .image-overlay {
        flex-direction: column;
        gap: 0.25rem;
    }
}

/* Focus styles for accessibility */
.form-control:focus,
.form-select:focus,
.btn:focus,
.form-check-input:focus {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
}

/* Error States */
.is-invalid {
    border-color: #dc3545 !important;
}

.is-invalid:focus {
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('productForm');
    const imageInput = document.getElementById('image');
    const descriptionTextarea = document.getElementById('description');
    const priceInput = document.getElementById('price');
    const stockInput = document.getElementById('stock');

    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memperbarui...';
        }
    });

    // Auto-resize textarea
    descriptionTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 200) + 'px';
    });

    // Image preview
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file harus kurang dari 5MB');
                this.value = '';
                return;
            }

            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Silakan pilih file gambar yang valid');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const currentImage = document.querySelector('.current-image');
                currentImage.innerHTML = `
                    <div class="image-preview animate-scale-in">
                        <img src="${e.target.result}" alt="Preview" class="preview-img">
                        <div class="image-overlay">
                            <span class="badge bg-success">New Image</span>
                            <button type="button" class="btn btn-light btn-sm" onclick="openImageModal('${e.target.result}', 'Preview')">
                                <i class="fas fa-expand-alt me-1"></i>View
                            </button>
                        </div>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        }
    });

    // Price formatting
    priceInput.addEventListener('input', function() {
        const value = this.value.replace(/\D/g, '');
        if (value) {
            const formatted = new Intl.NumberFormat('id-ID').format(value);
            this.setAttribute('data-formatted', formatted);
        }
    });

    // Real-time validation
    const nameInput = document.getElementById('name');

    nameInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            this.classList.remove('is-invalid');
        }
    });

    descriptionTextarea.addEventListener('input', function() {
        if (this.value.length > 0) {
            this.classList.remove('is-invalid');
        }
    });

    priceInput.addEventListener('input', function() {
        if (this.value.length > 0 && this.value >= 0) {
            this.classList.remove('is-invalid');
        }
    });

    stockInput.addEventListener('input', function() {
        if (this.value.length > 0 && this.value >= 0) {
            this.classList.remove('is-invalid');
        }
    });

    // Character counter for description
    descriptionTextarea.addEventListener('input', function() {
        const maxLength = 500; // Set your desired max length
        const currentLength = this.value.length;
        const counter = document.getElementById('charCounter') || createCharCounter();
        
        counter.textContent = `${currentLength}/${maxLength} characters`;
        
        if (currentLength > maxLength * 0.9) {
            counter.classList.add('text-warning');
        } else {
            counter.classList.remove('text-warning');
        }
        
        if (currentLength > maxLength) {
            counter.classList.add('text-danger');
        } else {
            counter.classList.remove('text-danger');
        }
    });

    function createCharCounter() {
        const counter = document.createElement('div');
        counter.id = 'charCounter';
        counter.className = 'form-text text-end';
        descriptionTextarea.parentNode.appendChild(counter);
        return counter;
    }

    // Add floating label animation
    const formControls = document.querySelectorAll('.form-control, .form-select');
    formControls.forEach(control => {
        if (control.value) {
            control.classList.add('has-value');
        }
        
        control.addEventListener('input', function() {
            if (this.value) {
                this.classList.add('has-value');
            } else {
                this.classList.remove('has-value');
            }
        });
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});

// Image modal functions
function openImageModal(imageSrc, imageTitle) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalImage').alt = imageTitle;
    document.getElementById('imageModalTitle').textContent = imageTitle;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>
@endpush
@endsection