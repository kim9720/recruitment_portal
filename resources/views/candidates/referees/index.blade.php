@extends('layouts.app')
@section('title', 'Referees')

<link rel="stylesheet" href="{{ asset('pagestyles/referees.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
    <div class="content-area">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Referees</h1>
                <p class="page-subtitle">Manage and track all referee information</p>
            </div>
            <button class="btn btn-primary" onclick="openAddModal()">
                <i class="fas fa-plus"></i> Add New Referee
            </button>
        </div>

        <!-- Statistics Cards -->
        {{-- <div class="stats-grid">
            <div class="stat-card stat-total">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">24</div>
                    <div class="stat-label">Total Referees</div>
                </div>
            </div>

            <div class="stat-card stat-active">
                <div class="stat-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">18</div>
                    <div class="stat-label">Active Referees</div>
                </div>
            </div>

            <div class="stat-card stat-verified">
                <div class="stat-icon">
                    <i class="fas fa-shield-check"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">20</div>
                    <div class="stat-label">Verified Referees</div>
                </div>
            </div>

            <div class="stat-card stat-pending">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">4</div>
                    <div class="stat-label">Pending Verification</div>
                </div>
            </div>
        </div> --}}

        <!-- Referees Table Container -->
        <div class="referees-table-container">
            <div class="referees-table-header">
                <h3 class="referees-table-title">All Referees</h3>

                <!-- Filters Section -->
                {{-- <div class="filters-section">
                    <div class="filters-grid">
                        <div class="filter-group">
                            <input type="text" class="filter-input" placeholder="Search by name..." id="searchInput">
                        </div>
                        <div class="filter-group">
                            <input type="email" class="filter-input" placeholder="Search by email..." id="emailSearch">
                        </div>
                        <div class="filter-group">
                            <select class="filter-select" id="statusFilter">
                                <option value="">All Statuses</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="verified">Verified</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                        <div class="filter-actions">
                            <button class="btn btn-success btn-sm">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <button class="btn btn-default btn-sm">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                        </div>
                    </div>
                </div> --}}
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="referees-data-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> ID</th>
                            <th><i class="fas fa-user"></i> Referee Name</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-phone"></i> Phone</th>
                            <th><i class="fas fa-building"></i> Organization</th>
                            <th><i class="fas fa-briefcase"></i> Title</th>
                            <th><i class="fas fa-map-marker-alt"></i> Address</th>
                            <th><i class="fas fa-cogs"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($referees as $key => $referee)
                            <tr>
                                <td>
                                    {{ ++$key }}
                                </td>
                                <td>
                                    <div class="referee-info">
                                        {{-- <div class="referee-avatar">
                                            {{ strtoupper(substr($referee->refereename, 0, 2)) }}
                                        </div> --}}
                                        <div class="referee-details">
                                            <div class="referee-name">{{ $referee->refereename }}</div>
                                            <div class="referee-subtitle">{{ $referee->title ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="email-badge">
                                        <i class="fas fa-envelope"></i>
                                        {{ $referee->refereeemail }}
                                    </div>
                                </td>
                                <td>
                                    <div class="phone-badge">
                                        <i class="fas fa-phone"></i>
                                        {{ $referee->telephone }}
                                    </div>
                                </td>
                                <td>
                                    <div class="organization-info">
                                        <div class="org-name">{{ $referee->organisation }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="position-badge">{{ $referee->title ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <div class="address-info">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $referee->refereeaddress ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        {{-- <button class="btn btn-info btn-sm"
                                            onclick="viewReferee({{ $referee->id }}, '{{ addslashes($referee->refereename) }}', '{{ addslashes($referee->refereeemail) }}', '{{ addslashes($referee->telephone) }}', '{{ addslashes($referee->organisation) }}', '{{ addslashes($referee->title) }}', '{{ addslashes($referee->refereeaddress) }}')">
                                            <i class="fas fa-eye"></i>
                                        </button> --}}
                                        <button class="btn btn-info btn-sm"
                                            onclick="openEditModal({{ $referee->id }}, '{{ addslashes($referee->refereename) }}', '{{ addslashes($referee->refereeemail) }}', '{{ addslashes($referee->telephone) }}', '{{ addslashes($referee->organisation) }}', '{{ addslashes($referee->title ?? '') }}', '{{ addslashes($referee->refereeaddress ?? '') }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm"
                                            onclick="deleteReferee({{ $referee->id }}, '{{ addslashes($referee->refereename) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="no-data">
                                    <div class="no-data-message">
                                        <i class="fas fa-inbox fa-4x"></i>
                                        <p>No referees found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{-- <div class="pagination-container">
                <div class="pagination-info">
                    Showing 1 to 3 of 24 referees
                </div>
                <ul class="pagination">
                    <li class="disabled"><span><i class="fas fa-chevron-left"></i></span></li>
                    <li class="active"><span>1</span></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i></a></li>
                </ul>
                <div class="per-page-selector">
                    Show
                    <select>
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                    per page
                </div>
            </div> --}}
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="refereeModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Add New Referee</h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <form action="{{ route('candidate.referees.store') }}" method="POST" id="refereeForm">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="referee_id" id="refereeId">

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Referee Name *</label>
                            <input type="text" name="refereename" id="refereename" class="form-control"
                                placeholder="Enter full name" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email Address *</label>
                            <input type="email" name="refereeemail" id="refereeemail" class="form-control"
                                placeholder="Enter email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> Telephone *</label>
                            <input type="tel" name="telephone" id="telephone" class="form-control"
                                placeholder="Enter phone number" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-building"></i> Organization *</label>
                            <input type="text" name="organisation" id="organisation" class="form-control"
                                placeholder="Enter organization" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-briefcase"></i> Title *</label>
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter title/position" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Address</label>
                        <textarea name="refereeaddress" id="refereeaddress" class="form-control" rows="3"
                            placeholder="Enter referee address..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Referee
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add New Referee';
            document.getElementById('refereeForm').reset();
            document.getElementById('refereeForm').action = "{{ route('candidate.referees.store') }}";
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('refereeId').value = '';
            document.getElementById('refereeModal').style.display = 'block';
            setTimeout(() => {
                document.querySelector('.modal-content').style.transform = 'scale(1)';
            }, 10);
        }

        function openEditModal(id, name, email, phone, organisation, title, address) {
            document.getElementById('modalTitle').textContent = 'Edit Referee';
            document.getElementById('refereeForm').action = `{{ url('candidate/referees/update') }}/${id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('refereeId').value = id;

            // Populate form fields
            document.getElementById('refereename').value = name || '';
            document.getElementById('refereeemail').value = email || '';
            document.getElementById('telephone').value = phone || '';
            document.getElementById('organisation').value = organisation || '';
            document.getElementById('title').value = title || '';
            document.getElementById('refereeaddress').value = address || '';

            document.getElementById('refereeModal').style.display = 'block';
            setTimeout(() => {
                document.querySelector('.modal-content').style.transform = 'scale(1)';
            }, 10);
        }

        function closeModal() {
            document.querySelector('.modal-content').style.transform = 'scale(0.7)';
            setTimeout(() => {
                document.getElementById('refereeModal').style.display = 'none';
            }, 300);
        }

        function viewReferee(id, name, email, phone, organisation, title, address) {
            Swal.fire({
                title: 'Referee Details',
                html: `
            <div style="text-align: left; padding: 20px;">
                <p><strong>Name:</strong> ${name || 'N/A'}</p>
                <p><strong>Email:</strong> ${email || 'N/A'}</p>
                <p><strong>Phone:</strong> ${phone || 'N/A'}</p>
                <p><strong>Organization:</strong> ${organisation || 'N/A'}</p>
                <p><strong>Title:</strong> ${title || 'N/A'}</p>
                <p><strong>Address:</strong> ${address || 'N/A'}</p>
            </div>
        `,
                icon: 'info',
                confirmButtonColor: '#262261',
                width: 600
            });
        }

        function deleteReferee(id, name) {
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete ${name}. This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a form and submit it
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('candidate/referees/destroy') }}/${id}`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    form.appendChild(csrfToken);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('refereeModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        // Show success/error messages if they exist
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#262261'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonColor: '#262261'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                title: 'Validation Error!',
                html: `
            <ul style="text-align: left;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        `,
                icon: 'error',
                confirmButtonColor: '#262261'
            });
        @endif
    </script>
@endsection
