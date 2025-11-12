@extends('layouts.app')

@section('title', 'Manajemen User & Role')

@section('content')
<div class="container">
  <div class="page-header mb-4">
    <h3 class="page-title"><i class="fas fa-users-cog me-2"></i>Manajemen User & Role</h3>
    <p class="text-muted">Kelola pengguna dan peran mereka dalam sistem</p>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

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
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar User</h5>
      <span class="badge bg-primary">{{ isset($users) ? $users->count() : 0 }} User</span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0" id="userTable">
          <thead>
            <tr>
              <th width="50">#</th>
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
  </div>
</div>

<style>
/* Basic Styling */
.page-header {
    margin-bottom: 24px;
}

.page-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 8px;
}

/* Cards */
.card {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 12px 16px;
}

/* Table */
.table thead th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #6A5A41;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.role-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
}

.role-badge.admin {
    background-color: #f8d7da;
    color: #721c24;
}

.role-badge.petugas {
    background-color: #d1ecf1;
    color: #0c5460;
}

.role-badge.peminjam {
    background-color: #d4edda;
    color: #155724;
}

.role-badge.unknown {
    background-color: #e2e3e5;
    color: #383d41;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 20px;
}

/* Form Controls */
.input-group-text {
    background-color: #f8f9fa;
}

/* Responsive */
@media (max-width: 768px) {
    .table thead th, .table tbody td {
        padding: 8px;
        font-size: 14px;
    }
    
    .avatar-circle {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simple search functionality
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');
    const resetFilter = document.getElementById('resetFilter');
    const userTable = document.getElementById('userTable');
    const rows = userTable ? userTable.querySelectorAll('tbody tr') : [];

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
});
</script>
@endsection