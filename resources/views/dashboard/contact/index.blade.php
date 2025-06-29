@extends('layouts.app')

@section('title', 'Pesan Kontak')

@section('content')
<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    @keyframes scaleIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    @keyframes bounceIn {
        0% { transform: scale(0.3); opacity: 0; }
        50% { transform: scale(1.05); }
        70% { transform: scale(0.9); }
        100% { transform: scale(1); opacity: 1; }
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out forwards;
        animation-delay: var(--delay, 0s);
    }

    .animate-slide-up {
        animation: slideUp 0.6s ease-out forwards;
        animation-delay: var(--delay, 0s);
    }

    .animate-scale-in {
        animation: scaleIn 0.6s ease-out forwards;
        animation-delay: var(--delay, 0s);
    }

    .animate-bounce-in {
        animation: bounceIn 0.8s ease-out forwards;
        animation-delay: var(--delay, 0s);
    }

    .stats-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .stats-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 24px;
        transition: transform 0.3s ease;
    }

    .stats-card:hover .stats-icon {
        transform: scale(1.1);
    }

    .message-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .message-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .table thead th {
        background: var(--bs-primary);
        color: white;
        font-weight: 600;
        border: none;
        padding: 1rem;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f8f9fa;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }

    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 16px;
        transition: transform 0.3s ease;
    }

    .table tbody tr:hover .avatar-circle {
        transform: scale(1.1);
    }

    .btn {
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-group .btn {
        padding: 0.5rem;
        margin: 0 0.25rem;
        border-radius: 0.5rem;
    }

    .btn-group .btn i {
        font-size: 0.875rem;
    }

    .badge {
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 0.5rem;
    }

    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: #000;
    }

    .badge.bg-success {
        background-color: #198754 !important;
        color: #fff;
    }

    .form-check-input {
        cursor: pointer;
        width: 1.2rem;
        height: 1.2rem;
        border-radius: 0.25rem;
        transition: all 0.3s ease;
    }

    .form-check-input:checked {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
        transform: scale(1.1);
    }

    .dropdown-menu {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .dropdown-item {
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    .empty-state {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 1rem;
        padding: 3rem;
        text-align: center;
    }

    .empty-state i {
        font-size: 4rem;
        color: #adb5bd;
        margin-bottom: 1.5rem;
    }

    .message-preview {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .message-time {
        font-size: 0.875rem;
        color: #6c757d;
    }
</style>

<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in" style="--delay: 0.1s">
        <div>
            <h1 class="h3 mb-0">Pesan Kontak</h1>
            <p class="text-muted">Kelola dan tanggapi pertanyaan pelanggan</p>
        </div>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i>Semua Pesan</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-envelope-open me-2"></i>Belum Dibaca</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-check me-2"></i>Sudah Dibaca</a></li>
                </ul>
            </div>
            <button class="btn btn-primary">
                <i class="fas fa-download me-2"></i>Export
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stats-card animate-fade-in" style="--delay: 0.2s">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Total Pesan</h6>
                        <h2 class="mb-0">{{ $contacts->total() }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card animate-fade-in" style="--delay: 0.3s">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-envelope-open"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Belum Dibaca</h6>
                        <h2 class="mb-0">{{ $contacts->where('read_at', null)->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card animate-fade-in" style="--delay: 0.4s">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-reply"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Sudah Dibalas</h6>
                        <h2 class="mb-0">{{ $contacts->where('replied_at', '!=', null)->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages Table -->
    <div class="message-card animate-scale-in" style="--delay: 0.5s">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th><i class="fas fa-user me-2"></i>Nama</th>
                            <th><i class="fab fa-whatsapp me-2"></i>WhatsApp</th>
                            <th><i class="fas fa-tag me-2"></i>Subjek</th>
                            <th><i class="fas fa-info-circle me-2"></i>Status</th>
                            <th><i class="fas fa-calendar me-2"></i>Tanggal</th>
                            <th><i class="fas fa-cogs me-2"></i>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                       @forelse($contacts as $contact)
                            @php
                                // Normalisasi nomor WhatsApp, ganti awalan 0 menjadi 62
                                $wa_number = preg_replace('/^0/', '62', $contact->whatsapp);
                            @endphp
                            <tr class="animate-bounce-in" style="--delay: {{ $loop->iteration * 0.1 }}s">
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input message-checkbox" type="checkbox" value="{{ $contact->id }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary bg-opacity-10 text-primary me-3">
                                            {{ strtoupper(substr($contact->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $contact->name }}</h6>
                                            <small class="text-muted">{{ $contact->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="https://wa.me/{{ $wa_number }}" class="text-decoration-none" target="_blank">
                                        <i class="fab fa-whatsapp text-success me-2"></i>{{ $contact->whatsapp }}
                                    </a>
                                </td>
                                <td>
                                    <div class="message-preview" title="{{ $contact->subject }}">
                                        {{ $contact->subject }}
                                    </div>
                                </td>
                                <td>
                                    @if($contact->read_at)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Dibaca
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock me-1"></i>Belum Dibaca
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">{{ $contact->created_at->format('d M Y') }}</span>
                                        <small class="message-time">{{ $contact->created_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('dashboard.contact.show', $contact) }}" 
                                        class="btn btn-outline-primary" 
                                        data-bs-toggle="tooltip" 
                                        title="Lihat Pesan">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="https://wa.me/{{ $wa_number }}?text=Halo%20{{ urlencode($contact->name) }}" 
                                        class="btn btn-outline-success" 
                                        data-bs-toggle="tooltip" 
                                        title="Balas via WhatsApp" 
                                        target="_blank">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                        <form action="{{ route('dashboard.contact.destroy', $contact) }}" 
                                            method="POST" 
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')"
                                                    data-bs-toggle="tooltip" 
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h4 class="text-muted mb-3">Belum Ada Pesan</h4>
                                        <p class="text-muted mb-0">Belum ada pesan yang masuk</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($contacts->hasPages())
                <div class="d-flex justify-content-between align-items-center p-4 border-top">
                    <div class="text-muted">
                        Menampilkan {{ $contacts->firstItem() ?? 0 }} sampai {{ $contacts->lastItem() ?? 0 }} dari {{ $contacts->total() }} pesan
                    </div>
                    {{ $contacts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Select all functionality
    document.getElementById('selectAll').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('.message-checkbox');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = this.checked;
        });
    });

    // Individual checkbox functionality
    document.querySelectorAll('.message-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var allCheckboxes = document.querySelectorAll('.message-checkbox');
            var checkedCheckboxes = document.querySelectorAll('.message-checkbox:checked');
            var selectAllCheckbox = document.getElementById('selectAll');
            
            if (checkedCheckboxes.length === allCheckboxes.length) {
                selectAllCheckbox.checked = true;
                selectAllCheckbox.indeterminate = false;
            } else if (checkedCheckboxes.length > 0) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = true;
            } else {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
            }
        });
    });

    // Add hover effects for table rows
    document.querySelectorAll('tbody tr').forEach(function(row) {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
</script>
@endpush
@endsection