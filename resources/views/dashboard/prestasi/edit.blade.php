@extends('layouts.app')

@section('title', 'Edit Achievement')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Edit Achievement</h1>
            <p class="text-muted">Update achievement details and information</p>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" form="prestasiForm" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Update Achievement
            </button>
            <a href="{{ route('dashboard.prestasi.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Achievements
            </a>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card animate-fade-in">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2 text-primary"></i>
                        Edit Achievement: {{ $prestasi->title }}
                    </h5>
                </div>
                <div class="card-body">
                    <form id="prestasiForm" action="{{ route('dashboard.prestasi.update', $prestasi) }}" method="POST" enctype="multipart/form-data">
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
                                        placeholder="Enter achievement title"
                                        value="{{ old('title', $prestasi->title) }}" 
                                        required
                                    >
                                    <label for="title">
                                        <i class="fas fa-trophy me-2"></i>Achievement Title
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
                                        @if($prestasi->image)
                                            <div class="image-preview">
                                                <img src="{{ asset('storage/' . $prestasi->image) }}" 
                                                     alt="{{ $prestasi->title }}" 
                                                     class="preview-img">
                                                <div class="image-overlay">
                                                    <span class="badge bg-primary">Current Image</span>
                                                    <button type="button" class="btn btn-light btn-sm" onclick="openImageModal('{{ asset('storage/' . $prestasi->image) }}', '{{ $prestasi->title }}')">
                                                        <i class="fas fa-expand-alt me-1"></i>View
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
                                                <i class="fas fa-image me-2"></i>Update Image (Optional)
                                            </label>
                                        </div>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Recommended size: 800x600 pixels, Max size: 5MB
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
                                        placeholder="Enter achievement description"
                                        rows="5"
                                        style="height: 150px;"
                                        required
                                    >{{ old('content', $prestasi->content) }}</textarea>
                                    <label for="content">
                                        <i class="fas fa-align-left me-2"></i>Achievement Description
                                    </label>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Provide a detailed description of the achievement
                                </div>
                            </div>

                            <!-- Category Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                                        <option value="">Select category</option>
                                        <option value="academic" {{ old('category', $prestasi->category) == 'academic' ? 'selected' : '' }}>Academic</option>
                                        <option value="sports" {{ old('category', $prestasi->category) == 'sports' ? 'selected' : '' }}>Sports</option>
                                        <option value="arts" {{ old('category', $prestasi->category) == 'arts' ? 'selected' : '' }}>Arts & Culture</option>
                                        <option value="technology" {{ old('category', $prestasi->category) == 'technology' ? 'selected' : '' }}>Technology</option>
                                        <option value="community" {{ old('category', $prestasi->category) == 'community' ? 'selected' : '' }}>Community Service</option>
                                        <option value="other" {{ old('category', $prestasi->category) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <label for="category">
                                        <i class="fas fa-tags me-2"></i>Category
                                    </label>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Year Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="number" 
                                        class="form-control @error('year') is-invalid @enderror" 
                                        id="year" 
                                        name="year" 
                                        placeholder="Enter year"
                                        value="{{ old('year', $prestasi->year ?? date('Y')) }}" 
                                        min="1900"
                                        max="{{ date('Y') + 1 }}"
                                        required
                                    >
                                    <label for="year">
                                        <i class="fas fa-calendar me-2"></i>Year
                                    </label>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Level Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('level') is-invalid @enderror" id="level" name="level">
                                        <option value="">Select level</option>
                                        <option value="local" {{ old('level', $prestasi->level) == 'local' ? 'selected' : '' }}>Local</option>
                                        <option value="regional" {{ old('level', $prestasi->level) == 'regional' ? 'selected' : '' }}>Regional</option>
                                        <option value="national" {{ old('level', $prestasi->level) == 'national' ? 'selected' : '' }}>National</option>
                                        <option value="international" {{ old('level', $prestasi->level) == 'international' ? 'selected' : '' }}>International</option>
                                    </select>
                                    <label for="level">
                                        <i class="fas fa-globe me-2"></i>Level
                                    </label>
                                    @error('level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Position/Rank Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        class="form-control @error('position') is-invalid @enderror" 
                                        id="position" 
                                        name="position" 
                                        placeholder="e.g., 1st Place, Gold Medal"
                                        value="{{ old('position', $prestasi->position ?? '') }}" 
                                    >
                                    <label for="position">
                                        <i class="fas fa-medal me-2"></i>Position/Rank
                                    </label>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Organization Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        class="form-control @error('organization') is-invalid @enderror" 
                                        id="organization" 
                                        name="organization" 
                                        placeholder="Enter organizing body"
                                        value="{{ old('organization', $prestasi->organization ?? '') }}" 
                                    >
                                    <label for="organization">
                                        <i class="fas fa-building me-2"></i>Organizing Body
                                    </label>
                                    @error('organization')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="active" {{ old('status', $prestasi->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $prestasi->status ?? 'inactive') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="draft" {{ old('status', $prestasi->status ?? 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    </select>
                                    <label for="status">
                                        <i class="fas fa-toggle-on me-2"></i>Status
                                    </label>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Featured Field -->
                            <div class="col-md-6">
                                <div class="form-check form-switch mt-4">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="is_featured" 
                                        name="is_featured" 
                                        value="1"
                                        {{ old('is_featured', $prestasi->is_featured ?? false) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="is_featured">
                                        <i class="fas fa-star me-2"></i>Featured Achievement
                                    </label>
                                </div>
                            </div>

                            <!-- Certificate URL Field -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input 
                                        type="url" 
                                        class="form-control @error('certificate_url') is-invalid @enderror" 
                                        id="certificate_url" 
                                        name="certificate_url" 
                                        placeholder="Enter certificate URL"
                                        value="{{ old('certificate_url', $prestasi->certificate_url ?? '') }}" 
                                    >
                                    <label for="certificate_url">
                                        <i class="fas fa-link me-2"></i>Certificate URL (Optional)
                                    </label>
                                    @error('certificate_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Link to digital certificate or verification document
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top">
                            <a href="{{ route('dashboard.prestasi.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Achievement
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
                <h5 class="modal-title" id="imageModalTitle">Image Preview</h5>
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
    const form = document.getElementById('prestasiForm');
    const imageInput = document.getElementById('image');
    const contentTextarea = document.getElementById('content');

    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
        }
    });

    // Auto-resize textarea
    contentTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 200) + 'px';
    });

    // Image preview
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB');
                this.value = '';
                return;
            }

            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image file');
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

    // Real-time validation
    const titleInput = document.getElementById('title');
    const yearInput = document.getElementById('year');
    const categorySelect = document.getElementById('category');
    const levelSelect = document.getElementById('level');
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

    yearInput.addEventListener('input', function() {
        const year = parseInt(this.value);
        if (year >= 1900 && year <= new Date().getFullYear() + 1) {
            this.classList.remove('is-invalid');
        }
    });

    // Character counter for content
    contentTextarea.addEventListener('input', function() {
        const maxLength = 1000; // Set your desired max length
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