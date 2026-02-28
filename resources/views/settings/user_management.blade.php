@extends('layouts.app')
@section('title', 'User Management')

@section('content')
    <div class="content-area">
        <div id="user-management-section" class="content-section">
            <div class="page-header">
                <h1 class="page-title">User Management</h1>
                <p class="page-subtitle">Manage system users and their roles</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-users stat-icon"></i>
                    <div class="stat-value">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-user-shield stat-icon"></i>
                    <div class="stat-value">{{ $stats['admins'] }}</div>
                    <div class="stat-label">Admins</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-user-tie stat-icon"></i>
                    <div class="stat-value">{{ $stats['hr'] }}</div>
                    <div class="stat-label">HR Staff</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-user stat-icon"></i>
                    <div class="stat-value">{{ $stats['candidates'] }}</div>
                    <div class="stat-label">Candidates</div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">All Users</h3>
                    <div class="table-actions">
                        <input type="text" class="search-input" placeholder="Search users...">
                        <button class="btn btn-primary"
                            onclick="document.getElementById('addUserModal').classList.add('show')">
                            <i class="fas fa-user-plus"></i> Add User
                        </button>
                    </div>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                                <td>
                                    @if ($user->is_active)
                                        <span class="status-badge active">Active</span>
                                    @else
                                        <span class="status-badge inactive">Inactive</span>
                                    @endif
                                </td>
                                <td></td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                @if ($users->hasPages())
                    <div class="pagination-container" style="justify-content: space-between; padding: 12px;">

                        <div class="pagination-info">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }}
                            of {{ $users->total() }} entries
                        </div>

                        <div class="pagination">

                            {{-- Previous --}}
                            @if ($users->onFirstPage())
                                <button class="pagination-btn" disabled>
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                            @else
                                <a href="{{ $users->previousPageUrl() }}" class="pagination-btn">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif

                            {{-- Page Numbers --}}
                            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                <a href="{{ $url }}"
                                    class="pagination-btn {{ $page == $users->currentPage() ? 'active' : '' }}">
                                    {{ $page }}
                                </a>
                            @endforeach

                            {{-- Next --}}
                            @if ($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}" class="pagination-btn">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <button class="pagination-btn" disabled>
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            @endif

                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>


    <!-- Add User Modal -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add New User</h3>
                <button class="modal-close" onclick="document.getElementById('addUserModal').classList.remove('show')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" placeholder="Enter full name">
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" placeholder="Enter email address">
                </div>
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <select class="form-control">
                        <option value="">Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="hr">HR Manager</option>
                        <option value="recruiter">Recruiter</option>
                        <option value="candidate">Candidate</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" placeholder="Confirm password">
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" id="sendWelcomeEmail" checked>
                        <label for="sendWelcomeEmail">Send welcome email</label>
                    </div>
                </div>
                <div class="modal-actions">
                    <button class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Create User
                    </button>
                    <button class="btn btn-secondary"
                        onclick="document.getElementById('addUserModal').classList.remove('show')">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
