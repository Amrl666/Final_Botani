@extends('layouts.app')

@section('title', 'Detail Pesan')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Detail Pesan</h1>
            <p class="text-muted">Lihat dan kelola informasi pesan</p>
        </div>
        <div class="d-flex gap-2">
            @php
                $wa_number = preg_replace('/^0/', '62', $contact->whatsapp);
            @endphp
            <a href="https://wa.me/{{ $wa_number }}?text=Halo%20{{ urlencode($contact->name) }}" 
               class="btn btn-success" target="_blank">
                <i class="fab fa-whatsapp me-2"></i>Balas via WhatsApp
            </a>
            <a href="{{ route('dashboard.contact.messages') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Pesan
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Message Details -->
        <div class="col-lg-8">
            <div class="card animate-fade-in">
                <div class="card-header bg-transparent">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-circle bg-primary bg-opacity-10 text-primary me-3">
                            {{ strtoupper(substr($contact->name, 0, 1)) }}
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $contact->name }}</h5>
                            <p class="text-muted mb-0">
                                <i class="fab fa-whatsapp text-success me-1"></i>{{ $contact->whatsapp }}
                            </p>
                        </div>
                    </div>
                    <div class="message-header">
                        <h4 class="mb-2">{{ $contact->subject }}</h4>
                        <div class="d-flex align-items-center text-muted">
                            <i class="far fa-clock me-2"></i>
                            {{ $contact->created_at->format('F j, Y \a\t g:i a') }}
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="message-content">
                        <div class="message-bubble">
                            <div class="message-text">
                                {{ $contact->message }}
                            </div>
                            <div class="message-time">
                                <small class="text-muted">
                                    <i class="far fa-clock me-1"></i>
                                    {{ $contact->created_at->format('g:i a') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Actions & Info -->
        <div class="col-lg-4">
            <!-- Message Actions -->
            <div class="card mb-4 animate-slide-in" style="--delay: 0.2s">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2 text-primary"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" onclick="markAsRead()">
                            <i class="fas fa-check me-2"></i>Tandai Sudah Dibaca
                        </button>
                        <button class="btn btn-outline-success" onclick="markAsImportant()">
                            <i class="fas fa-star me-2"></i>Tandai Penting
                        </button>
                        <button class="btn btn-outline-info" onclick="archiveMessage()">
                            <i class="fas fa-archive me-2"></i>Arsipkan Pesan
                        </button>
                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn btn-outline-warning">
                            <i class="fas fa-reply me-2"></i>Balas via Email
                        </a>
                        <form action="{{ route('dashboard.contact.destroy', $contact) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                <i class="fas fa-trash me-2"></i>Hapus Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Message Information -->
            <div class="card animate-slide-in" style="--delay: 0.4s">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Informasi Pesan
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <i class="fas fa-hashtag me-2"></i>ID Pesan
                            </span>
                            <span class="text-dark fw-bold">#{{ $contact->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <i class="fas fa-user me-2"></i>Nama Pengirim
                            </span>
                            <span class="text-dark">{{ $contact->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <i class="fab fa-whatsapp me-2"></i>Nomor WhatsApp
                            </span>
                            <span class="text-dark">{{ $contact->whatsapp }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <i class="fas fa-tag me-2"></i>Status
                            </span>
                            @if($contact->read_at)
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>Sudah Dibaca
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    <i class="fas fa-clock me-1"></i>Belum Dibaca
                                </span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <i class="fas fa-calendar me-2"></i>Diterima
                            </span>
                            <span class="text-dark">{{ $contact->created_at->format('M j, Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <i class="fas fa-clock me-2"></i>Waktu
                            </span>
                            <span class="text-dark">{{ $contact->created_at->format('g:i a') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <i class="fas fa-bell me-2"></i>Notifikasi
                            </span>
                            <span class="text-success">
                                <i class="fas fa-check-circle me-1"></i>WhatsApp terkirim
                            </span>
                        </li>
                    </ul>
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
    from { opacity: 0; transform: translateX(20px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes bounceIn {
    0% { opacity: 0; transform: scale(0.3); }
    50% { opacity: 1; transform: scale(1.05); }
    70% { transform: scale(0.9); }
    100% { opacity: 1; transform: scale(1); }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
}

.animate-slide-in {
    animation: slideIn 0.6s ease-out forwards;
    animation-delay: var(--delay, 0s);
}

.animate-bounce-in {
    animation: bounceIn 0.6s ease-out forwards;
}

/* Card Styles */
.card {
    border: none;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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

/* Avatar Circle */
.avatar-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 24px;
    transition: all 0.3s ease;
}

.avatar-circle:hover {
    transform: scale(1.1);
}

/* Message Content */
.message-content {
    font-size: 1rem;
    line-height: 1.6;
}

.message-bubble {
    background: #f8f9fa;
    border-radius: 1rem;
    padding: 1.5rem;
    border-left: 4px solid var(--primary-color);
    position: relative;
}

.message-bubble::before {
    content: '';
    position: absolute;
    top: 20px;
    left: -8px;
    width: 0;
    height: 0;
    border-top: 8px solid transparent;
    border-bottom: 8px solid transparent;
    border-right: 8px solid var(--primary-color);
}

.message-text {
    margin-bottom: 1rem;
    white-space: pre-wrap;
    word-wrap: break-word;
}

.message-time {
    text-align: right;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    padding-top: 0.5rem;
}

/* List Group */
.list-group-item {
    border: none;
    padding: 1rem 0;
    background: transparent;
    transition: background-color 0.3s ease;
}

.list-group-item:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

.list-group-item:not(:last-child) {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
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

.bg-warning {
    background: linear-gradient(135deg, #ffc107, #fd7e14) !important;
    color: #000;
}

.bg-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
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

.btn-outline-success {
    border: 2px solid #28a745;
    color: #28a745;
    background: transparent;
}

.btn-outline-success:hover {
    background: #28a745;
    color: white;
    transform: translateY(-2px);
}

.btn-outline-info {
    border: 2px solid #17a2b8;
    color: #17a2b8;
    background: transparent;
}

.btn-outline-info:hover {
    background: #17a2b8;
    color: white;
    transform: translateY(-2px);
}

.btn-outline-warning {
    border: 2px solid #ffc107;
    color: #ffc107;
    background: transparent;
}

.btn-outline-warning:hover {
    background: #ffc107;
    color: #000;
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
    transform: translateY(-2px);
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
    
    .avatar-circle {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
    
    .message-bubble {
        padding: 1rem;
    }
}

/* Focus styles for accessibility */
.btn:focus {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
}

/* Success/Error Messages */
.alert {
    border: none;
    border-radius: 0.75rem;
    padding: 1rem 1.5rem;
    margin-bottom: 1rem;
}

.alert-success {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    color: #155724;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da, #f5c6cb);
    color: #721c24;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Add loading states to forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            }
        });
    });

    // Add hover effects to avatar
    const avatar = document.querySelector('.avatar-circle');
    if (avatar) {
        avatar.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1) rotate(5deg)';
        });
        
        avatar.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) rotate(0deg)';
        });
    }
});

// Action functions
function markAsRead() {
    // Add your mark as read logic here
    showAlert('Pesan ditandai sudah dibaca!', 'success');
    updateStatus('Dibaca');
}

function markAsImportant() {
    // Add your mark as important logic here
    showAlert('Pesan ditandai penting!', 'success');
    updateStatus('Penting');
}

function archiveMessage() {
    // Add your archive logic here
    showAlert('Pesan diarsipkan!', 'success');
    updateStatus('Arsip');
}

function updateStatus(status) {
    const statusBadge = document.querySelector('.badge.bg-warning');
    if (statusBadge) {
        statusBadge.textContent = status;
        statusBadge.className = 'badge bg-success';
    }
}

function showAlert(message, type) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show animate-bounce-in`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insert at the top of the container
    const container = document.querySelector('.container-fluid');
    container.insertBefore(alertDiv, container.firstChild);
    
    // Auto dismiss after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}

// Copy email to clipboard
function copyEmail() {
    navigator.clipboard.writeText('{{ $contact->email }}').then(() => {
        showAlert('Email disalin ke clipboard!', 'success');
    });
}

// Copy message content
function copyMessage() {
    navigator.clipboard.writeText('{{ $contact->message }}').then(() => {
        showAlert('Konten pesan disalin ke clipboard!', 'success');
    });
}
</script>
@endpush
@endsection