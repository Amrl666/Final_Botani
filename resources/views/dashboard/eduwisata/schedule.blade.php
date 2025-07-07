@extends('layouts.app')

@section('title', 'Jadwal Eduwisata')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Jadwal Eduwisata</h1>
            <p class="text-muted">Kelola dan lihat jadwal eduwisata</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
                <i class="fas fa-plus me-2"></i>Tambah Jadwal
            </button>
            <a href="{{ route('dashboard.eduwisata.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Program
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 animate-fade-in" style="--delay: 0.1s">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Jadwal
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $schedules->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 animate-fade-in" style="--delay: 0.2s">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Acara Mendatang
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $schedules->where('date', '>=', now()->toDateString())->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 animate-fade-in" style="--delay: 0.3s">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $schedules->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 animate-fade-in" style="--delay: 0.4s">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Selesai
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $schedules->where('date', '<', now()->toDateString())->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4 animate-slide-in">
        <div class="card-header bg-transparent">
            <h5 class="card-title mb-0">
                <i class="fas fa-filter me-2 text-primary"></i>
                Filter & Pencarian
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="programFilter">
                            <option value="">Semua Program</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->name }}</option>
                            @endforeach
                        </select>
                        <label for="programFilter">
                            <i class="fas fa-graduation-cap me-2"></i>Filter berdasarkan Program
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari jadwal...">
                        <label for="searchInput">
                            <i class="fas fa-search me-2"></i>Cari
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule List -->
    <div class="card animate-fade-in">
        <div class="card-header bg-transparent">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2 text-primary"></i>
                Daftar Jadwal
            </h5>
        </div>
        <div class="card-body">
            @if($schedules->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    <i class="fas fa-calendar me-2"></i>Tanggal & Waktu
                                </th>
                                <th>
                                    <i class="fas fa-graduation-cap me-2"></i>Program
                                </th>
                                <th>
                                    <i class="fas fa-users me-2"></i>Peserta
                                </th>

                                <th>
                                    <i class="fas fa-toggle-on me-2"></i>Status
                                </th>
                                <th>
                                    <i class="fas fa-cogs me-2"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                                <tr class="schedule-row" data-program="{{ $schedule->eduwisata_id }}" data-status="{{ $schedule->status }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="date-badge me-3">
                                                <div class="date-day">{{ \Carbon\Carbon::parse($schedule->date)->format('d') }}</div>
                                                <div class="date-month">{{ \Carbon\Carbon::parse($schedule->date)->format('M') }}</div>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ \Carbon\Carbon::parse($schedule->date)->format('l, F j, Y') }}</div>
                                                <div class="text-muted">
                                                    <i class="far fa-clock me-1"></i>
                                                    {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="program-icon me-3">
                                                <i class="fas fa-graduation-cap"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $schedule->eduwisata->name }}</div>
                                                <div class="text-muted small">{{ $schedule->eduwisata->type ?? 'Educational Tour' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="participants-info">
                                            <div class="d-flex align-items-center">
                                                <div class="participants-count me-2">
                                                    <span class="badge bg-primary">{{ $schedule->current_participants ?? 0 }}</span>
                                                </div>
                                                <div class="participants-max">
                                                    <small class="text-muted">/ {{ $schedule->max_participants ?? 'Unlimited' }}</small>
                                                </div>
                                            </div>
                                            @if($schedule->current_participants && $schedule->max_participants)
                                                <div class="progress mt-1" style="height: 4px;">
                                                    @php
                                                        $percentage = ($schedule->current_participants / $schedule->max_participants) * 100;
                                                    @endphp
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%"></div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        @php
                                            $status = 'upcoming';
                                            $statusClass = 'bg-warning';
                                            $statusIcon = 'fas fa-clock';
                                            
                                            if($schedule->date < now()->toDateString()) {
                                                $status = 'completed';
                                                $statusClass = 'bg-success';
                                                $statusIcon = 'fas fa-check-circle';
                                            } elseif($schedule->date == now()->toDateString()) {
                                                $status = 'ongoing';
                                                $statusClass = 'bg-info';
                                                $statusIcon = 'fas fa-play-circle';
                                            }
                                        @endphp
                                        <span class="badge {{ $statusClass }} status-badge" data-status="{{ $status }}">
                                            <i class="{{ $statusIcon }} me-1"></i>
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewSchedule({{ $schedule->id }})" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="editSchedule({{ $schedule->id }})" title="Ubah Jadwal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteSchedule({{ $schedule->id }})" title="Hapus Jadwal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak Ada Jadwal Ditemukan</h5>
                        <p class="text-muted">Mulai dengan menambahkan jadwal wisata edukasi pertama Anda.</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
                            <i class="fas fa-plus me-2"></i>Tambah Jadwal Pertama
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Schedule Modal -->
<div class="modal fade" id="addScheduleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2 text-primary"></i>
                    Tambah Jadwal Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addScheduleForm">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="program_id" name="program_id" required>
                                    <option value="">Pilih Program</option>
                                    @foreach($programs as $program)
                                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                                    @endforeach
                                </select>
                                <label for="program_id">
                                    <i class="fas fa-graduation-cap me-2"></i>Program
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="date" name="date" required>
                                <label for="date">
                                    <i class="fas fa-calendar me-2"></i>Tanggal
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="time" class="form-control" id="start_time" name="start_time" required>
                                <label for="start_time">
                                    <i class="fas fa-clock me-2"></i>Waktu Mulai
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="time" class="form-control" id="end_time" name="end_time" required>
                                <label for="end_time">
                                    <i class="fas fa-clock me-2"></i>Waktu Selesai
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="max_participants" name="max_participants" placeholder="Masukkan maksimal peserta" min="1">
                                <label for="max_participants">
                                    <i class="fas fa-users me-2"></i>Maksimal Peserta
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="notes" name="notes" placeholder="Masukkan catatan tambahan" rows="3"></textarea>
                                <label for="notes">
                                    <i class="fas fa-sticky-note me-2"></i>Catatan
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Jadwal
                    </button>
                </div>
            </form>
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

@keyframes bounceIn {
    0% { opacity: 0; transform: scale(0.3); }
    50% { opacity: 1; transform: scale(1.05); }
    70% { transform: scale(0.9); }
    100% { opacity: 1; transform: scale(1); }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
    animation-delay: var(--delay, 0s);
}

.animate-slide-in {
    animation: slideIn 0.6s ease-out forwards;
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

/* Stats Cards */
.border-left-primary {
    border-left: 4px solid var(--primary-color) !important;
}

.border-left-success {
    border-left: 4px solid #28a745 !important;
}

.border-left-info {
    border-left: 4px solid #17a2b8 !important;
}

.border-left-warning {
    border-left: 4px solid #ffc107 !important;
}

/* Date Badge */
.date-badge {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 0.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
}

.date-day {
    font-size: 1.2rem;
    line-height: 1;
}

.date-month {
    font-size: 0.7rem;
    text-transform: uppercase;
}

/* Program Icon */
.program-icon {
    width: 40px;
    height: 40px;
    background: rgba(5, 150, 105, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
}

/* Status Badges */
.status-badge {
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

.bg-success {
    background: linear-gradient(135deg, #28a745, #20c997) !important;
}

.bg-info {
    background: linear-gradient(135deg, #17a2b8, #6f42c1) !important;
}

/* Progress Bar */
.progress {
    background-color: #e9ecef;
    border-radius: 0.25rem;
}

.progress-bar {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 0.25rem;
}

/* Table Styles */
.table {
    margin-bottom: 0;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    background: #f8f9fa;
    padding: 1rem;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.table-hover tbody tr:hover {
    background-color: rgba(5, 150, 105, 0.05);
    transform: translateY(-1px);
    transition: all 0.3s ease;
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

.btn-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.btn-group .btn {
    border-radius: 0.5rem;
    margin-right: 0.25rem;
}

.btn-group .btn:last-child {
    margin-right: 0;
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

/* Empty State */
.empty-state {
    padding: 3rem 1rem;
}

.empty-state i {
    opacity: 0.5;
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

.modal-footer {
    background: #f8f9fa;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

/* Responsive Design */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .date-badge {
        width: 40px;
        height: 40px;
    }
    
    .date-day {
        font-size: 1rem;
    }
    
    .date-month {
        font-size: 0.6rem;
    }
    
    .btn-group {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .btn-group .btn {
        margin-right: 0;
        margin-bottom: 0.25rem;
    }
}

/* Focus styles for accessibility */
.btn:focus,
.form-control:focus,
.form-select:focus {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
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
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const programFilter = document.getElementById('programFilter');
    const searchInput = document.getElementById('searchInput');
    const scheduleRows = document.querySelectorAll('.schedule-row');

    function filterSchedules() {
        const programValue = programFilter.value;
        const searchValue = searchInput.value.toLowerCase();

        scheduleRows.forEach(row => {
            const program = row.dataset.program;
            const text = row.textContent.toLowerCase();

            const programMatch = !programValue || program === programValue;
            const searchMatch = !searchValue || text.includes(searchValue);

            if (programMatch && searchMatch) {
                row.style.display = '';
                row.classList.add('animate-bounce-in');
            } else {
                row.style.display = 'none';
            }
        });
    }

    programFilter.addEventListener('change', filterSchedules);
    searchInput.addEventListener('input', filterSchedules);

    // Add schedule form
    const addScheduleForm = document.getElementById('addScheduleForm');
    if (addScheduleForm) {
        addScheduleForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';

            // Add your form submission logic here
            // For now, just show a success message
            setTimeout(() => {
                showAlert('Schedule added successfully!', 'success');
                bootstrap.Modal.getInstance(document.getElementById('addScheduleModal')).hide();
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Save Schedule';
                this.reset();
            }, 2000);
        });
    }

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});

// Schedule action functions
function viewSchedule(id) {
    // Add your view logic here
    showAlert(`Viewing schedule ${id}`, 'info');
}

function editSchedule(id) {
    // Add your edit logic here
    showAlert(`Editing schedule ${id}`, 'warning');
}

function deleteSchedule(id) {
    if (confirm('Apakah Anda yakin ingin menghapus jadwal ini?')) {
        // Create a form to submit the DELETE request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/dashboard/eduwisata/schedule/destroy/${id}`;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add method override for DELETE
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        // Submit the form
        document.body.appendChild(form);
        form.submit();
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
</script>
@endpush
@endsection