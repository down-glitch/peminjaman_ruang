@extends('layouts.app')

@section('title', 'Manajemen User & Role')

@section('content')
<div class="container-fluid">
  <div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="page-title"><i class="fas fa-users-cog me-2"></i>Manajemen User & Role</h3>
      <p class="page-subtitle">Kelola pengguna dan peran mereka dalam sistem</p>
    </div>

  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Stats Cards -->
  <div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="stat-card admin">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="stat-icon me-3">
              <i class="fas fa-user-shield"></i>
            </div>
            <div>
              <h4 class="mb-0">{{ isset($users) ? $users->where('role', 'admin')->count() : 0 }}</h4>
              <small>Admin</small>
            </div>
          </div>
        </div>
        <div class="stat-decoration"></div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="stat-card petugas">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="stat-icon me-3">
              <i class="fas fa-user-tie"></i>
            </div>
            <div>
              <h4 class="mb-0">{{ isset($users) ? $users->where('role', 'petugas')->count() : 0 }}</h4>
              <small>Petugas</small>
            </div>
          </div>
        </div>
        <div class="stat-decoration"></div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="stat-card peminjam">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="stat-icon me-3">
              <i class="fas fa-users"></i>
            </div>
            <div>
              <h4 class="mb-0">{{ isset($users) ? $users->where('role', 'peminjam')->count() : 0 }}</h4>
              <small>Peminjam</small>
            </div>
          </div>
        </div>
        <div class="stat-decoration"></div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="stat-card total">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="stat-icon me-3">
              <i class="fas fa-users"></i>
            </div>
            <div>
              <h4 class="mb-0">{{ isset($users) ? $users->count() : 0 }}</h4>
              <small>Total User</small>
            </div>
          </div>
        </div>
        <div class="stat-decoration"></div>
      </div>
    </div>
  </div>

  <!-- Search and Filter -->
  <div class="card mb-4">
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-search"></i>
            </span>
            <input type="text" class="form-control" id="searchInput" placeholder="Cari berdasarkan username atau email...">
          </div>
        </div>
        <div class="col-md-4">
          <select class="form-select" id="roleFilter">
            <option value="">Semua Role</option>
            <option value="admin">Admin</option>
            <option value="petugas">Petugas</option>
            <option value="peminjam">Peminjam</option>
          </select>
        </div>
        <div class="col-md-2">
          <button class="btn btn-outline-secondary w-100" id="resetFilter">
            <i class="fas fa-undo me-2"></i>Reset
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Table -->
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar User</h5>
        <div class="table-info">
          <span class="badge bg-primary">{{ isset($users) ? $users->count() : 0 }} User</span>
        </div>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0" id="userTable">
          <thead>
            <tr>
              <th width="50">#</th>
              <th>Username</th>
              <th>Email</th>
              <th>Role</th>
              <th width="180">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @if(isset($users) && $users->count() > 0)
              @foreach($users as $key => $user)
              <tr data-role="{{ $user->role ?? '' }}">
                <td>{{ $key + 1 }}</td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar-circle me-3">
                      {{ isset($user->username) ? strtoupper(substr($user->username, 0, 1)) : 'U' }}
                    </div>
                    <div>
                      <div class="fw-medium">{{ $user->username ?? '-' }}</div>
                      <small class="text-muted">ID: #{{ $user->id ?? '-' }}</small>
                    </div>
                  </div>
                </td>
                <td>{{ $user->email ?? '-' }}</td>
                <td>
                  <span class="badge role-badge {{ $user->role ?? 'unknown' }}">
                    @if(isset($user->role))
                      @if($user->role == 'admin')
                        <i class="fas fa-user-shield me-1"></i>Admin
                      @elseif($user->role == 'petugas')
                        <i class="fas fa-user-tie me-1"></i>Petugas
                      @else
                        <i class="fas fa-user me-1"></i>Peminjam
                      @endif
                    @else
                      <i class="fas fa-question me-1"></i>Tidak Diketahui
                    @endif
                  </span>
                </td>
                <td>
                  <div class="d-flex gap-2">
                    <form action="{{ route('manajemen.user.updateRole', $user->id ?? '') }}" method="POST" class="d-inline">
                      @csrf
                      @method('PUT')
                      <div class="input-group input-group-sm">
                        <select name="role" class="form-select form-select-sm">
                          <option value="admin" {{ (isset($user->role) && $user->role == 'admin') ? 'selected' : '' }}>Admin</option>
                          <option value="petugas" {{ (isset($user->role) && $user->role == 'petugas') ? 'selected' : '' }}>Petugas</option>
                          <option value="peminjam" {{ (isset($user->role) && $user->role == 'peminjam') ? 'selected' : '' }}>Peminjam</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary">
                          <i class="fas fa-save"></i>
                        </button>
                      </div>
                    </form>

                  </div>
                </td>
              </tr>
              @endforeach
            @else
            <tr>
              <td colspan="5" class="text-center py-5">
                <div class="empty-state">
                  <i class="fas fa-users-slash fa-3x mb-3"></i>
                  <h5>Belum ada user yang terdaftar</h5>
                  <p>Tidak ada user yang terdaftar dalam sistem</p>
                  <a href="{{ route('manajemen.user.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-user-plus me-2"></i>Tambah User Pertama
                  </a>
                </div>
              </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer">
      <div class="d-flex justify-content-between align-items-center">
        <div class="text-muted">
          <i class="fas fa-info-circle me-1"></i> Menampilkan {{ isset($users) ? $users->count() : 0 }} user
        </div>
        <div class="table-pagination">
          <button class="btn btn-sm btn-outline-secondary me-1" id="prevPage">
            <i class="fas fa-chevron-left"></i>
          </button>
          <span class="pagination-info">Halaman 1 dari 1</span>
          <button class="btn btn-sm btn-outline-secondary ms-1" id="nextPage">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->


<style>
/* CSS Variables */
:root {
    --gradient-primary: linear-gradient(135deg, #6A5A41, #8B7355);
    --gradient-secondary: linear-gradient(135deg, #6c757d, #495057);
    --gradient-success: linear-gradient(135deg, #28a745, #20c997);
    --gradient-info: linear-gradient(135deg, #17a2b8, #138496);
    --gradient-danger: linear-gradient(135deg, #dc3545, #c82333);
    --gradient-warning: linear-gradient(135deg, #ffc107, #e0a800);
    --gradient-sidebar: linear-gradient(135deg, #f8f0d7, #e9dfc7);
    --card-bg: #ffffff;
    --sidebar-bg: #f8f0d7;
    --sidebar-hover: #e9dfc7;
    --border-color: rgba(156, 124, 94, 0.2);
    --text: #4a3c29;
    --text-secondary: #7a6b56;
    --text-muted: #9c8e7a;
    --accent: #9c7c5e;
    --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
    --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.12);
    --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.15);
}

/* Page Header */
.page-header {
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border-color);
}

.page-title {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 8px;
    letter-spacing: -0.5px;
}

.page-subtitle {
    font-size: 15px;
    color: var(--text-secondary);
    margin: 0;
}

.page-actions .btn {
    background: var(--gradient-primary);
    border: none;
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.page-actions .btn:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

/* Alert */
.alert {
    border-radius: 12px;
    border: none;
    margin-bottom: 24px;
}

.alert-success {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
    border: 1px solid rgba(40, 167, 69, 0.3);
}

/* Stats Cards */
.stat-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    box-shadow: var(--shadow-md);
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
}

.stat-card.admin::before {
    background: var(--gradient-danger);
}

.stat-card.petugas::before {
    background: var(--gradient-info);
}

.stat-card.peminjam::before {
    background: var(--gradient-success);
}

.stat-card.total::before {
    background: var(--gradient-primary);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
    box-shadow: var(--shadow-sm);
    flex-shrink: 0;
}

.stat-card.admin .stat-icon {
    background: var(--gradient-danger);
}

.stat-card.petugas .stat-icon {
    background: var(--gradient-info);
}

.stat-card.peminjam .stat-icon {
    background: var(--gradient-success);
}

.stat-card.total .stat-icon {
    background: var(--gradient-primary);
}

.stat-decoration {
    position: absolute;
    top: -20px;
    right: -20px;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    opacity: 0.1;
}

.stat-card.admin .stat-decoration {
    background: #dc3545;
}

.stat-card.petugas .stat-decoration {
    background: #17a2b8;
}

.stat-card.peminjam .stat-decoration {
    background: #28a745;
}

.stat-card.total .stat-decoration {
    background: #6A5A41;
}

/* Cards */
.card {
    background: var(--card-bg);
    border: none;
    border-radius: 16px;
    box-shadow: var(--shadow-md);
    overflow: hidden;
    margin-bottom: 24px;
}

.card-header {
    background: var(--gradient-sidebar);
    border-bottom: 1px solid var(--border-color);
    padding: 16px 20px;
}

.card-header h5 {
    font-weight: 600;
    color: var(--text);
    margin: 0;
}

.card-footer {
    background: var(--sidebar-bg);
    border-top: 1px solid var(--border-color);
    padding: 12px 20px;
}

/* Table */
.table {
    margin-bottom: 0;
}

.table thead th {
    background: var(--sidebar-bg);
    color: var(--text);
    font-weight: 600;
    border-bottom: 2px solid var(--border-color);
    padding: 16px;
    font-size: 14px;
}

.table tbody td {
    padding: 16px;
    vertical-align: middle;
    border-bottom: 1px solid var(--border-color);
    font-size: 14px;
}

.table tbody tr:hover {
    background: var(--sidebar-hover);
}

.avatar-circle {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: var(--gradient-primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 16px;
    box-shadow: var(--shadow-sm);
    flex-shrink: 0;
}

.role-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
}

.role-badge.admin {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    border: 1px solid rgba(220, 53, 69, 0.3);
}

.role-badge.petugas {
    background: rgba(23, 162, 184, 0.1);
    color: #17a2b8;
    border: 1px solid rgba(23, 162, 184, 0.3);
}

.role-badge.peminjam {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
    border: 1px solid rgba(40, 167, 69, 0.3);
}

.role-badge.unknown {
    background: rgba(108, 117, 125, 0.1);
    color: #6c757d;
    border: 1px solid rgba(108, 117, 125, 0.3);
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.btn-primary {
    background: var(--gradient-primary);
    border-color: var(--accent);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

.btn-outline-primary {
    background: transparent;
    border-color: var(--accent);
    color: var(--accent);
}

.btn-outline-primary:hover {
    background: var(--accent);
    color: white;
}

.btn-outline-danger {
    background: transparent;
    border-color: #dc3545;
    color: #dc3545;
}

.btn-outline-danger:hover {
    background: #dc3545;
    color: white;
}

.btn-outline-secondary {
    background: transparent;
    border-color: var(--border-color);
    color: var(--text);
}

.btn-outline-secondary:hover {
    background: var(--sidebar-hover);
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

/* Form Controls */
.form-control, .form-select {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    color: var(--text);
    border-radius: 8px;
}

.form-control:focus, .form-select:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 0.25rem rgba(226, 206, 177, 0.25);
}

.input-group-text {
    background: var(--sidebar-bg);
    border: 1px solid var(--border-color);
    color: var(--accent);
}

.input-group-sm .form-select {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.input-group-sm .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: var(--text);
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 16px;
    color: var(--text-muted);
}

.empty-state h5 {
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--text);
}

.empty-state p {
    color: var(--text-secondary);
    margin-bottom: 16px;
}

/* Table Info Badge */
.table-info {
    display: flex;
    align-items: center;
}

.badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.75rem;
}

.bg-primary {
    background: var(--gradient-primary);
    color: white;
}

/* Table Pagination */
.table-pagination {
    display: flex;
    align-items: center;
}

.pagination-info {
    margin: 0 1rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

/* Animation for stats */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card {
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start !important;
    }

    .page-actions {
        margin-top: 16px;
        width: 100%;
    }

    .page-actions .btn {
        width: 100%;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }

    .avatar-circle {
        width: 40px;
        height: 40px;
        font-size: 14px;
    }

    .table thead th, .table tbody td {
        padding: 12px 8px;
        font-size: 12px;
    }
}

@media (max-width: 576px) {
    .page-title {
        font-size: 24px;
    }

    .d-flex.gap-2 {
        flex-direction: column;
    }

    .input-group {
        flex-direction: column;
    }

    .input-group .form-control, .input-group .form-select {
        border-radius: 8px;
        margin-top: 8px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');
    const resetFilter = document.getElementById('resetFilter');
    const userTable = document.getElementById('userTable');
    const rows = userTable ? userTable.querySelectorAll('tbody tr') : [];

    // Search and filter function
    function filterTable() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const roleTerm = roleFilter ? roleFilter.value : '';

        rows.forEach(row => {
            const username = row.querySelector('td:nth-child(2) .fw-medium')?.textContent.toLowerCase() || '';
            const email = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
            const role = row.getAttribute('data-role') || '';

            const matchesSearch = username.includes(searchTerm) || email.includes(searchTerm);
            const matchesRole = roleTerm === '' || role === roleTerm;

            if (matchesSearch && matchesRole) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Event listeners
    if (searchInput) {
        searchInput.addEventListener('keyup', filterTable);
    }

    if (roleFilter) {
        roleFilter.addEventListener('change', filterTable);
    }

    if (resetFilter) {
        resetFilter.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            if (roleFilter) roleFilter.value = '';
            filterTable();
        });
    }

    // Delete confirmation modal
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteForm = document.getElementById('deleteForm');
    const deleteUsername = document.getElementById('deleteUsername');
    
    document.querySelectorAll('.btn-outline-danger').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            const username = this.getAttribute('data-username');
            
            if (deleteUsername) deleteUsername.textContent = username;
            if (deleteForm) deleteForm.action = `/manajemen/user/${userId}`;
            
            deleteModal.show();
        });
    });

    // Form submission loading state
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalHTML = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                submitBtn.disabled = true;
                
                // Revert after 3 seconds (for demo)
                setTimeout(() => {
                    submitBtn.innerHTML = originalHTML;
                    submitBtn.disabled = false;
                }, 3000);
            }
        });
    });
});
</script>
@endsection