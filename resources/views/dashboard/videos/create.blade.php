@extends('layouts.app')

@section('title', 'Tambah Video')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Tambah Video Baru</h1>
            <p class="text-muted">Upload dan kelola konten video Anda</p>
        </div>
        <a href="{{ route('dashboard.videos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Video
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card animate-fade-in">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-video me-2 text-primary"></i>
                        Informasi Video
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.videos.store') }}" method="POST" enctype="multipart/form-data" id="videoForm">
                        @csrf
                        
                        <div class="row g-4">
                            <!-- Title Field -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        class="form-control @error('title') is-invalid @enderror" 
                                        id="title" 
                                        name="title" 
                                        placeholder="Masukkan judul video"
                                        value="{{ old('title') }}"
                                        required
                                    >
                                    <label for="title">
                                        <i class="fas fa-heading me-2"></i>Judul Video
                                    </label>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Video File Upload -->
                            <div class="col-12">
                                <div class="upload-area" id="uploadArea">
                                    <div class="upload-content">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                        <h5>Unggah Berkas Video</h5>
                                        <p class="text-muted">Seret dan lepas berkas video Anda di sini atau klik untuk memilih</p>
                                        <input 
                                            type="file" 
                                            class="form-control @error('video') is-invalid @enderror" 
                                            id="video" 
                                            name="video" 
                                            accept="video/*"
                                            required
                                            style="display: none;"
                                        >
                                        <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('video').click()">
                                            <i class="fas fa-folder-open me-2"></i>Pilih Berkas
                                        </button>
                                    </div>
                                    <div class="upload-preview" id="uploadPreview" style="display: none;">
                                        <div class="preview-content">
                                            <i class="fas fa-video fa-2x text-success"></i>
                                            <h6 id="fileName">Berkas video dipilih</h6>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearFile()">
                                                <i class="fas fa-times me-1"></i>Hapus
                                            </button>
                                        </div>
                                    </div>
                                    @error('video')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description Field -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea 
                                        class="form-control @error('description') is-invalid @enderror" 
                                        id="description" 
                                        name="description" 
                                        placeholder="Masukkan deskripsi video"
                                        rows="4"
                                        style="height: 120px;"
                                    >{{ old('description') }}</textarea>
                                    <label for="description">
                                        <i class="fas fa-align-left me-2"></i>Deskripsi
                                    </label>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                            <!-- Name Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        id="name" 
                                        name="name" 
                                        placeholder="Masukkan nama video (opsional)"
                                        value="{{ old('name') }}"
                                    >
                                    <label for="name">
                                        <i class="fas fa-tag me-2"></i>Nama Video (Opsional)
                                    </label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top">
                            <a href="{{ route('dashboard.videos.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Video
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

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
}

.animate-slide-in {
    animation: slideIn 0.6s ease-out forwards;
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

/* Upload Area */
.upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 1rem;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    background: #f8f9fa;
    position: relative;
    overflow: hidden;
}

.upload-area:hover {
    border-color: var(--primary-color);
    background: rgba(5, 150, 105, 0.05);
}

.upload-area.dragover {
    border-color: var(--primary-color);
    background: rgba(5, 150, 105, 0.1);
    transform: scale(1.02);
}

.upload-content {
    transition: all 0.3s ease;
}

.upload-preview {
    background: #fff;
    border-radius: 0.75rem;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.preview-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.preview-content i {
    color: var(--success-color);
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

.btn-outline-primary {
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    background: transparent;
}

.btn-outline-primary:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
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

.btn-outline-danger {
    border: 2px solid #dc3545;
    color: #dc3545;
    background: transparent;
}

.btn-outline-danger:hover {
    background: #dc3545;
    color: white;
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

/* Progress Bar */
.progress {
    height: 0.5rem;
    border-radius: 0.25rem;
    background: #e9ecef;
    overflow: hidden;
    margin-top: 1rem;
}

.progress-bar {
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    transition: width 0.3s ease;
}

/* Responsive Design */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem;
    }
    
    .upload-area {
        padding: 1.5rem;
    }
    
    .preview-content {
        flex-direction: column;
        text-align: center;
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
    const uploadArea = document.getElementById('uploadArea');
    const videoInput = document.getElementById('video');
    const uploadContent = document.querySelector('.upload-content');
    const uploadPreview = document.getElementById('uploadPreview');
    const fileName = document.getElementById('fileName');
    const form = document.getElementById('videoForm');

    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            videoInput.files = files;
            handleFileSelect(files[0]);
        }
    });

    // File input change
    videoInput.addEventListener('change', function(e) {
        if (this.files.length > 0) {
            handleFileSelect(this.files[0]);
        }
    });

    // Handle file selection
    function handleFileSelect(file) {
        if (file.type.startsWith('video/')) {
            fileName.textContent = file.name;
            uploadContent.style.display = 'none';
            uploadPreview.style.display = 'block';
            
            // Add animation
            uploadPreview.style.animation = 'slideIn 0.3s ease-out';
        } else {
            alert('Silakan pilih file video yang valid.');
            clearFile();
        }
    }

    // Clear file function
    window.clearFile = function() {
        videoInput.value = '';
        uploadContent.style.display = 'block';
        uploadPreview.style.display = 'none';
    };

    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        }
    });

    // Real-time validation
    const titleInput = document.getElementById('title');
    const descriptionInput = document.getElementById('description');

    titleInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            this.classList.remove('is-invalid');
        }
    });

    descriptionInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            this.classList.remove('is-invalid');
        }
    });

    // Auto-resize textarea
    descriptionInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 200) + 'px';
    });

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
});
</script>
@endpush
@endsection