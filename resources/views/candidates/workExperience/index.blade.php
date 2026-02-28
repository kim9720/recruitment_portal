@extends('layouts.app')
@section('title', 'Work Experience')

<link rel="stylesheet" href="{{ asset('pagestyles/work_experience.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
<div class="content-area">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Work Experience</h1>
            <p class="page-subtitle">Manage your professional work history</p>
        </div>
        <button class="btn btn-primary" onclick="openAddModal()">
            <i class="fas fa-plus"></i> Add Experience
        </button>
    </div>

    {{-- <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-total">
            <div class="stat-icon">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $experiences->count() }}</div>
                <div class="stat-label">Total Experiences</div>
            </div>
        </div>

        <div class="stat-card stat-years">
            <div class="stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ floor($experiences->sum('months') / 12) }}</div>
                <div class="stat-label">Years of Experience</div>
            </div>
        </div>

        <div class="stat-card stat-months">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $experiences->sum('months') }}</div>
                <div class="stat-label">Total Months</div>
            </div>
        </div>

        <div class="stat-card stat-companies">
            <div class="stat-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $experiences->unique('company_name')->count() }}</div>
                <div class="stat-label">Companies Worked</div>
            </div>
        </div>
    </div> --}}

    <!-- Experience Table Container -->
    <div class="experience-table-container">
        <div class="experience-table-header">
            <h3 class="experience-table-title">All Work Experience</h3>

            <!-- Filters Section -->
            {{-- <div class="filters-section">
                <div class="filters-grid">
                    <div class="filter-group">
                        <input type="text" class="filter-input" placeholder="Search by company..." id="searchInput">
                    </div>
                    <div class="filter-group">
                        <input type="text" class="filter-input" placeholder="Search by role..." id="roleSearch">
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
            <table class="experience-data-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag"></i> ID</th>
                        <th><i class="fas fa-building"></i> Company</th>
                        <th><i class="fas fa-user-tie"></i> Role</th>
                        <th><i class="fas fa-calendar-check"></i> Start Date</th>
                        <th><i class="fas fa-calendar-times"></i> End Date</th>
                        <th><i class="fas fa-hourglass-half"></i> Duration</th>
                        <th><i class="fas fa-cogs"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($experiences as $key => $experience)
                    <tr>
                        <td>
                            {{ ++$key }}
                        </td>
                        <td>
                            <div class="company-info">
                                {{-- <div class="company-avatar">
                                    {{ strtoupper(substr($experience->company_name, 0, 2)) }}
                                </div> --}}
                                <div class="company-details">
                                    <div class="company-name">{{ $experience->company_name }}</div>
                                    <div class="company-subtitle">Organization</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="role-badge">{{ $experience->role }}</span>
                        </td>
                        <td>
                            <div class="date-badge">
                                <i class="fas fa-calendar-check"></i>
                                {{ \Carbon\Carbon::parse($experience->startdate)->format('M d, Y') }}
                            </div>
                        </td>
                        <td>
                            <div class="date-badge">
                                <i class="fas fa-calendar-times"></i>
                                @if($experience->enddate)
                                    {{ \Carbon\Carbon::parse($experience->enddate)->format('M d, Y') }}
                                @else
                                    <span class="present-badge">Present</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="duration-info">
                                <span class="duration-badge">
                                    <i class="fas fa-clock"></i>
                                    {{ $experience->months }}
                                    {{ $experience->months == 1 ? 'month' : 'months' }}
                                </span>
                                @if($experience->months >= 12)
                                <div class="years-display">
                                    ({{ floor($experience->months / 12) }}
                                    {{ floor($experience->months / 12) == 1 ? 'year' : 'years' }}
                                    @if($experience->months % 12 > 0)
                                        {{ $experience->months % 12 }}
                                        {{ ($experience->months % 12) == 1 ? 'month' : 'months' }}
                                    @endif)
                                </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-info btn-sm" onclick="viewExperience({{ $experience->exp_id }}, '{{ addslashes($experience->company_name) }}', '{{ addslashes($experience->role) }}', '{{ $experience->startdate }}', '{{ $experience->enddate }}', {{ $experience->months }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-primary btn-sm" onclick="openEditModal({{ $experience->exp_id }}, '{{ addslashes($experience->company_name) }}', '{{ addslashes($experience->role) }}', '{{ $experience->startdate }}', '{{ $experience->enddate }}', {{ $experience->months }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteExperience({{ $experience->exp_id }}, '{{ addslashes($experience->company_name) }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="no-data">
                            <div class="no-data-message">
                                <i class="fas fa-briefcase fa-4x"></i>
                                <p>No work experience added yet</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            <div class="pagination-info">
                Showing {{ $experiences->count() }} work experience records
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="experienceModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Add New Experience</h2>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <form action="{{ route('candidate.work_experience.store') }}" method="POST" id="experienceForm">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="experience_id" id="experienceId">

            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-building"></i> Company Name *</label>
                        <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Enter company name" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-user-tie"></i> Role/Position *</label>
                        <input type="text" name="role" id="role" class="form-control" placeholder="Enter your role" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-calendar-check"></i> Start Date *</label>
                        <input type="date" name="startdate" id="startdate" class="form-control" required onchange="calculateMonths()">
                    </div>
                    <div class="form-group">
                        <label>
                            <i class="fas fa-calendar-times"></i> End Date
                            <span style="font-size: 12px; font-weight: normal; color: #6c757d;">(Leave empty if current)</span>
                        </label>
                        <input type="date" name="enddate" id="enddate" class="form-control" onchange="calculateMonths()">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-hourglass-half"></i> Duration (Months) *</label>
                        <input type="number" name="months" id="months" class="form-control" placeholder="Duration in months" min="1" required readonly>
                    </div>
                    <div class="form-group">
                        <div class="duration-display" id="durationDisplay">
                            <i class="fas fa-info-circle"></i>
                            <span>Duration will be calculated automatically</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Experience
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Add New Experience';
    document.getElementById('experienceForm').reset();
    document.getElementById('experienceForm').action = "{{ route('candidate.work_experience.store') }}";
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('experienceId').value = '';
    document.getElementById('durationDisplay').innerHTML = '<i class="fas fa-info-circle"></i><span>Duration will be calculated automatically</span>';
    document.getElementById('experienceModal').style.display = 'block';
    setTimeout(() => {
        document.querySelector('.modal-content').style.transform = 'scale(1)';
    }, 10);
}

function openEditModal(id, company, role, startdate, enddate, months) {
    document.getElementById('modalTitle').textContent = 'Edit Experience';
    document.getElementById('experienceForm').action = `{{ url('candidate/work_experience/update') }}/${id}`;
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('experienceId').value = id;

    // Populate form fields
    document.getElementById('company_name').value = company;
    document.getElementById('role').value = role;
    document.getElementById('startdate').value = startdate;
    document.getElementById('enddate').value = enddate || '';
    document.getElementById('months').value = months;

    calculateMonths();

    document.getElementById('experienceModal').style.display = 'block';
    setTimeout(() => {
        document.querySelector('.modal-content').style.transform = 'scale(1)';
    }, 10);
}

function closeModal() {
    document.querySelector('.modal-content').style.transform = 'scale(0.7)';
    setTimeout(() => {
        document.getElementById('experienceModal').style.display = 'none';
    }, 300);
}

function calculateMonths() {
    const startDate = document.getElementById('startdate').value;
    const endDate = document.getElementById('enddate').value;

    if (!startDate) return;

    const start = new Date(startDate);
    const end = endDate ? new Date(endDate) : new Date();

    const months = (end.getFullYear() - start.getFullYear()) * 12 + (end.getMonth() - start.getMonth()) + 1;

    if (months > 0) {
        document.getElementById('months').value = months;

        const years = Math.floor(months / 12);
        const remainingMonths = months % 12;

        let displayText = '';
        if (years > 0) {
            displayText = `${years} ${years === 1 ? 'year' : 'years'}`;
            if (remainingMonths > 0) {
                displayText += ` and ${remainingMonths} ${remainingMonths === 1 ? 'month' : 'months'}`;
            }
        } else {
            displayText = `${months} ${months === 1 ? 'month' : 'months'}`;
        }

        document.getElementById('durationDisplay').innerHTML = `
            <i class="fas fa-check-circle" style="color: #28a745;"></i>
            <span><strong>Duration:</strong> ${displayText}</span>
        `;
    }
}

function viewExperience(id, company, role, startdate, enddate, months) {
    const start = new Date(startdate);
    const end = enddate ? new Date(enddate) : null;

    const years = Math.floor(months / 12);
    const remainingMonths = months % 12;

    let durationText = '';
    if (years > 0) {
        durationText = `${years} ${years === 1 ? 'year' : 'years'}`;
        if (remainingMonths > 0) {
            durationText += ` and ${remainingMonths} ${remainingMonths === 1 ? 'month' : 'months'}`;
        }
    } else {
        durationText = `${months} ${months === 1 ? 'month' : 'months'}`;
    }

    Swal.fire({
        title: 'Experience Details',
        html: `
            <div style="text-align: left; padding: 20px;">
                <p><strong>Company:</strong> ${company}</p>
                <p><strong>Role:</strong> ${role}</p>
                <p><strong>Start Date:</strong> ${start.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                <p><strong>End Date:</strong> ${end ? end.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) : 'Present'}</p>
                <p><strong>Duration:</strong> ${durationText} (${months} months)</p>
            </div>
        `,
        icon: 'info',
        confirmButtonColor: '#262261',
        width: 600
    });
}

function deleteExperience(id, company) {
    Swal.fire({
        title: 'Are you sure?',
        text: `You are about to delete experience at ${company}. This action cannot be undone!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('candidate/work_experience/destroy') }}/${id}`;

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
    const modal = document.getElementById('experienceModal');
    if (event.target == modal) {
        closeModal();
    }
}

// Show success/error messages
@if(session('success'))
    Swal.fire({
        title: 'Success!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonColor: '#262261'
    });
@endif

@if(session('error'))
    Swal.fire({
        title: 'Error!',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonColor: '#262261'
    });
@endif

@if($errors->any())
    Swal.fire({
        title: 'Validation Error!',
        html: `
            <ul style="text-align: left;">
                @foreach($errors->all() as $error)
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
