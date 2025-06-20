@extends('layouts.app')

@section('title', 'Edit Eduwisata')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Edit Eduwisata Program</h1>
            <p class="text-muted">Update educational tourism program details</p>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" form="eduwisataForm" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Update Program
            </button>
            <a href="{{ route('dashboard.eduwisata.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Programs
            </a>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card animate-fade-in">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2 text-primary"></i>
                        Edit Program: {{ $eduwisata->name }}
                    </h5>
                </div>
                <div class="card-body">
                    <form id="eduwisataForm" action="{{ route('dashboard.eduwisata.update', $eduwisata->id) }}" method="POST" enctype="multipart/form-data">
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
                                        placeholder="Enter program name"
                                        value="{{ old('name', $eduwisata->name) }}" 
                                        required
                                    >
                                    <label for="name">
                                        <i class="fas fa-map-marker-alt me-2"></i>Program Name
                                    </label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
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
                                        placeholder="Enter program description"
                                        rows="4"
                                        style="height: 120px;"
                                        required
                                    >{{ old('description', $eduwisata->description) }}</textarea>
                                    <label for="description">
                                        <i class="fas fa-align-left me-2"></i>Description
                                    </label>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Provide a detailed description of the educational tourism program
                                </div>
                            </div>

                            <!-- Price Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="number" 
                                        class="form-control @error('harga') is-invalid @enderror" 
                                        id="harga" 
                                        name="harga" 
                                        placeholder="Enter price"
                                        value="{{ old('harga', $eduwisata->harga ?? '') }}" 
                                        min="0"
                                        step="1000"
                                        required
                                    >
                                    <label for="harga">
                                        <i class="fas fa-tag me-2"></i>Price (Rp)
                                    </label>
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Location Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        class="form-control @error('location') is-invalid @enderror" 
                                        id="location" 
                                        name="location" 
                                        placeholder="Enter location"
                                        value="{{ old('location', $eduwisata->location ?? '') }}" 
                                        required
                                    >
                                    <label for="location">
                                        <i class="fas fa-map-pin me-2"></i>Location
                                    </label>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="col-12">
                                <div class="image-upload-area" id="imageUploadArea">
                                    <div class="current-image mb-3">
                                        @if($eduwisata->image)
                                            <div class="image-preview">
                                                <img src="{{ asset('storage/' . $eduwisata->image) }}" 
                                                     alt="{{ $eduwisata->name }}" 
                                                     class="preview-img">
                                                <div class="image-overlay">
                                                    <span class="badge bg-primary">Current Image</span>
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
                                        @error('image')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Program Type -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                                        <option value="">Select program type</option>
                                        <option value="field_trip" {{ old('type', $eduwisata->type) == 'field_trip' ? 'selected' : '' }}>Field Trip</option>
                                        <option value="workshop" {{ old('type', $eduwisata->type) == 'workshop' ? 'selected' : '' }}>Workshop</option>
                                        <option value="tour" {{ old('type', $eduwisata->type) == 'tour' ? 'selected' : '' }}>Educational Tour</option>
                                        <option value="seminar" {{ old('type', $eduwisata->type) == 'seminar' ? 'selected' : '' }}>Seminar</option>
                                        <option value="other" {{ old('type', $eduwisata->type) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <label for="type">
                                        <i class="fas fa-graduation-cap me-2"></i>Program Type
                                    </label>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        class="form-control @error('duration') is-invalid @enderror" 
                                        id="duration" 
                                        name="duration" 
                                        placeholder="e.g., 2 hours, 1 day"
                                        value="{{ old('duration', $eduwisata->duration ?? '') }}" 
                                    >
                                    <label for="duration">
                                        <i class="fas fa-clock me-2"></i>Duration
                                    </label>
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Max Participants -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="number" 
                                        class="form-control @error('max_participants') is-invalid @enderror" 
                                        id="max_participants" 
                                        name="max_participants" 
                                        placeholder="Enter max participants"
                                        value="{{ old('max_participants', $eduwisata->max_participants ?? '') }}" 
                                        min="1"
                                    >
                                    <label for="max_participants">
                                        <i class="fas fa-users me-2"></i>Max Participants
                                    </label>
                                    @error('max_participants')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="active" {{ old('status', $eduwisata->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $eduwisata->status ?? 'inactive') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="draft" {{ old('status', $eduwisata->status ?? 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    </select>
                                    <label for="status">
                                        <i class="fas fa-toggle-on me-2"></i>Status
                                    </label>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top">
                            <a href="{{ route('dashboard.eduwisata.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Program
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
    const form = document.getElementById('eduwisataForm');
    const descriptionTextarea = document.getElementById('description');
    const imageInput = document.getElementById('image');
    const priceInput = document.getElementById('harga');

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
    descriptionTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 200) + 'px';
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
    const locationInput = document.getElementById('location');
    const typeSelect = document.getElementById('type');
    const statusSelect = document.getElementById('status');

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
        if (this.value.length > 0) {
            this.classList.remove('is-invalid');
        }
    });

    locationInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            this.classList.remove('is-invalid');
        }
    });

    // Character counter for description
    descriptionTextarea.addEventListener('input', function() {
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
</script>
@endpush
@endsection