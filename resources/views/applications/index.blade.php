@extends('layouts.app')
@section('title', 'Applications')


<link rel="stylesheet" href="{{ asset('pagestyles/applications.css') }}">


@section('content')
    <div class="content-area">
        <div class="content-section">
            <div class="page-header">
                <h1 class="page-title">Job Applications</h1>
                <p class="page-subtitle">Manage and review all job applications</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card stat-total">
                <div class="stat-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-number">{{ $applications->total() }}</h3>
                    <p class="stat-label">Total Applications</p>
                </div>
            </div>
            <div class="stat-card stat-pending">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    {{-- <h3 class="stat-number">{{ \App\Models\CandidateApplyFor::where('status', 'pending')->count() }}</h3> --}}
                    <p class="stat-label">Pending Review</p>
                </div>
            </div>
            <div class="stat-card stat-shortlisted">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-info">
                    {{-- <h3 class="stat-number">{{ \App\Models\CandidateApplyFor::where('status', 'shortlisted')->count() }}</h3> --}}
                    <p class="stat-label">Shortlisted</p>
                </div>
            </div>
            <div class="stat-card stat-interview">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    {{-- <h3 class="stat-number">{{ \App\Models\CandidateApplyFor::where('status', 'interview')->count() }}</h3> --}}
                    <p class="stat-label">Interview Stage</p>
                </div>
            </div>
        </div>

        <div class="applications-table-container">
            <div class="applications-table-header">
                <h3 class="applications-table-title">All Applications</h3>

                <!-- Filter and Search Section -->
                <div class="filters-section">
                    <form method="GET" action="{{ route('applications.index') }}" id="filterForm">
                        <div class="filters-grid">
                            <!-- Search Input -->
                            <div class="filter-group">
                                <input type="text" name="search" class="filter-input"
                                    placeholder="🔍 Search applicant name..." value="{{ request('search') }}">
                            </div>

                            <!-- Job Filter -->
                            <div class="filter-group">
                                <select name="job_id" class="filter-select"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All Positions</option>
                                    @foreach ($jobs as $job)
                                        <option value="{{ $job->id }}"
                                            {{ request('job_id') == $job->id ? 'selected' : '' }}>
                                            {{ $job->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div class="filter-group">
                                <select name="status" class="filter-select"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All Status</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}"
                                            {{ request('status') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date Range -->
                            <div class="filter-group">
                                <input type="date" name="date_from" class="filter-input" placeholder="From Date"
                                    value="{{ request('date_from') }}">
                            </div>

                            <div class="filter-group">
                                <input type="date" name="date_to" class="filter-input" placeholder="To Date"
                                    value="{{ request('date_to') }}">
                            </div>

                            <!-- Filter Buttons -->
                            <div class="filter-actions">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('applications.index') }}" class="btn btn-default btn-sm">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                        <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                    </form>
                </div>
            </div>

            <!-- Active Filters Display -->
            @if (request('search') || request('job_id') || request('status') || request('date_from') || request('date_to'))
                <div class="active-filters">
                    <span class="filter-label">Active Filters:</span>
                    @if (request('search'))
                        <span class="filter-tag">
                            Search: "{{ request('search') }}"
                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="filter-remove">×</a>
                        </span>
                    @endif
                    @if (request('job_id'))
                        <span class="filter-tag">
                            Position: {{ $jobs->find(request('job_id'))->title ?? 'Unknown' }}
                            <a href="{{ request()->fullUrlWithQuery(['job_id' => null]) }}" class="filter-remove">×</a>
                        </span>
                    @endif
                    @if (request('status'))
                        <span class="filter-tag">
                            Status: {{ ucfirst(request('status')) }}
                            <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="filter-remove">×</a>
                        </span>
                    @endif
                    @if (request('date_from'))
                        <span class="filter-tag">
                            From: {{ \Carbon\Carbon::parse(request('date_from'))->format('M d, Y') }}
                            <a href="{{ request()->fullUrlWithQuery(['date_from' => null]) }}" class="filter-remove">×</a>
                        </span>
                    @endif
                    @if (request('date_to'))
                        <span class="filter-tag">
                            To: {{ \Carbon\Carbon::parse(request('date_to'))->format('M d, Y') }}
                            <a href="{{ request()->fullUrlWithQuery(['date_to' => null]) }}" class="filter-remove">×</a>
                        </span>
                    @endif
                </div>
            @endif

            <div class="table-responsive">
                <table class="applications-data-table">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th><i class="fas fa-user"></i> Applicant Name</th>
                            <th><i class="fas fa-briefcase"></i> Position Applied</th>
                            <th><i class="fas fa-calendar"></i> Date Applied</th>
                            <th><i class="fas fa-money-bill-wave"></i> Expected Salary</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                            <th><i class="fas fa-cogs"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $index => $application)
                            <tr>
                                <td>{{ $applications->firstItem() + $index }}</td>
                                <td>
                                    <div class="applicant-info">
                                        <div class="applicant-avatar">
                                            <img src="{{ $application->candidateProfile->profile_photo }}"
                                                alt="Candidate Photo"
                                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                        </div>
                                        <div class="applicant-details">
                                            <span
                                                class="applicant-name">{{ $application->candidateProfile->full_name ?? 'N/A' }}</span>
                                            <span
                                                class="applicant-email">{{ $application->candidateProfile->email ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="position-info">
                                        <span class="position-title">{{ $application->job->job_title ?? 'N/A' }}</span>
                                        <span class="position-ref">Ref: {{ $application->job->ref ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="date-badge">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ $application->applied_date ? \Carbon\Carbon::parse($application->applied_date)->format('M d, Y') : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="salary-badge">
                                        {{ $application->expected_salary ? 'TZS ' . number_format($application->expected_salary) : 'Not Specified' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-select status-{{ $application->status }}">{{ $application->status }}</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('applications.show', $application->hash_id) }}"
                                            class="btn btn-primary btn-sm" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if ($application->cover_letter)
                                            <a class="btn btn-info btn-sm"
                                                href="{{ $application->applicationLetterUrl() }}" target="_blank"
                                                title="View Cover Letter">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                        @endif
                                        <a href="mailto:{{ $application->candidateProfile->email ?? '' }}"
                                            class="btn btn-success btn-sm" title="Send Email">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                        {{-- <button class="btn btn-danger btn-sm" onclick="deleteApplication({{ $application->id }})" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button> --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="no-data">
                                    <div class="no-data-message">
                                        <i class="fas fa-inbox fa-3x"></i>
                                        <p>No applications found matching your criteria</p>
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
                    Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }} of
                    {{ $applications->total() }} results
                </div>

                <div class="per-page-selector">
                    <label for="perPage">Show:</label>
                    <select id="perPage" onchange="changePerPage(this.value)">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span>per page</span>
                </div>

                {{ $applications->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>


    <script>
        function changePerPage(value) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', value);
            window.location.href = url.toString();
        }

        function updateStatus(applicationId, status) {
            if (confirm('Are you sure you want to update this application status?')) {
                fetch(`/applications/${applicationId}/status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        function viewCoverLetter(url) {
            // Implement cover letter modal view
            // const url = $application->applicationLetterUrl();
            // if (!url || url === '') {
            //     Swal.fire({
            //         title: 'Document Not Available',
            //         text: 'This document has not been uploaded.',
            //         icon: 'warning',
            //         confirmButtonColor: '#262261'
            //     });
            //     return;
            // }
            window.open(url, '_blank');
        }

        function deleteApplication(applicationId) {
            if (confirm('Are you sure you want to delete this application? This action cannot be undone.')) {
                // Implement delete functionality
                alert('Delete application #' + applicationId);
            }
        }
    </script>

@endsection
