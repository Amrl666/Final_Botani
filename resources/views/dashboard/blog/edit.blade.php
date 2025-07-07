@extends('layouts.app')

@section('title', 'Ubah Artikel Blog')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Ubah Artikel Blog</h1>
            <p class="text-muted">Perbarui konten dan pengaturan artikel blog Anda</p>
        </div>
        <div class="d-flex gap-2">
            <button form="editPostForm" type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Simpan Perubahan
            </button>
            <a href="{{ route('dashboard.blog.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Artikel
            </a>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card animate-fade-in">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2 text-primary"></i>
                        Ubah Artikel: {{ $blog->title }}
                    </h5>
                </div>
                <div class="card-body">
                    <form id="editPostForm" action="{{ route('dashboard.blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <!-- Title Field -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        class="form-control @error('title') is-invalid @enderror" 
                                        id="title" 
                                        name="title" 
                                        placeholder="Masukkan judul blog"
                                        value="{{ old('title', $blog->title) }}" 
                                        required
                                    >
                                    <label for="title">
                                        <i class="fas fa-heading me-2"></i>Judul Blog
                                    </label>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Image Upload -->
                            <div class="col-12">
                                <div class="image-upload-area" id="imageUploadArea">
                                    <div class="current-image mb-3">
                                        @if($blog->image)
                                            <div class="image-preview">
                                                <img src="{{ asset('storage/' . $blog->image) }}" 
                                                     alt="{{ $blog->title }}" 
                                                     class="preview-img">
                                                <div class="image-overlay">
                                                    <span class="badge bg-primary">Gambar Saat Ini</span>
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
                                        @error('image')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Content Field -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea 
                                        class="form-control @error('content') is-invalid @enderror" 
                                        id="content" 
                                        name="content" 
                                        placeholder="Masukkan konten blog"
                                        rows="8"
                                        style="height: 300px;"
                                        required
                                    >{{ old('content', $blog->content) }}</textarea>
                                    <label for="content">
                                        <i class="fas fa-align-left me-2"></i>Konten Blog
                                    </label>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Gunakan pemformatan markdown untuk struktur konten yang lebih baik
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top">
                            <a href="{{ route('dashboard.blog.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Perbarui Artikel
                            </button>
                        </div>
                    </form>
                </div>
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
    max-width: 300px;
    max-height: 200px;
    object-fit: cover;
    border-radius: 0.75rem;
    transition: transform 0.3s ease;
}

.image-preview:hover .preview-img {
    transform: scale(1.05);
}

.image-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
}

.upload-section {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #dee2e6;
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
}

/* Focus styles for accessibility */
.form-control:focus,
.form-select:focus,
.btn:focus {
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
    const form = document.getElementById('editPostForm');
    const contentTextarea = document.getElementById('content');
    const imageInput = document.getElementById('image');

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
    contentTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 400) + 'px';
    });

    // Image preview
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const currentImage = document.querySelector('.current-image');
                currentImage.innerHTML = `
                    <div class="image-preview animate-scale-in">
                        <img src="${e.target.result}" alt="Preview" class="preview-img">
                        <div class="image-overlay">
                            <span class="badge bg-success">New Image</span>
                        </div>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        }
    });

    // Real-time validation
    const titleInput = document.getElementById('title');
    const categorySelect = document.getElementById('category');
    const statusSelect = document.getElementById('status');

    titleInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            this.classList.remove('is-invalid');
        }
    });

    contentTextarea.addEventListener('input', function() {
        if (this.value.length > 0) {
            this.classList.remove('is-invalid');
        }
    });

    // Character counter for content
    contentTextarea.addEventListener('input', function() {
        const maxLength = 5000; // Set your desired max length
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
        contentTextarea.parentNode.appendChild(counter);
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
</script>
@endpush
@endsection