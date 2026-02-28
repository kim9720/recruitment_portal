@extends('layouts.app')
@section('title', 'Job Vacancies')

<link rel="stylesheet" href="{{ asset('pagestyles/vacancies.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
    <div class="content-area">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Available Job Vacancies</h1>
                <p class="page-subtitle">Browse and apply for exciting career opportunities</p>
            </div>
            <div class="header-stats">
                <div class="quick-stat">
                    <i class="fas fa-briefcase"></i>
                    <span>{{ $totalJobs }} Open Positions</span>
                </div>
            </div>
        </div>

        {{-- <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-total">
            <div class="stat-icon">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $vacancies->count() }}</div>
                <div class="stat-label">Total Vacancies</div>
            </div>
        </div>

        <div class="stat-card stat-new">
            <div class="stat-icon">
                <i class="fas fa-fire"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $vacancies->where('created_at', '>=', now()->subWeek())->count() }}</div>
                <div class="stat-label">New This Week</div>
            </div>
        </div>

        <div class="stat-card stat-closing">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $vacancies->where('deadline', '<=', now()->addDays(7))->count() }}</div>
                <div class="stat-label">Closing Soon</div>
            </div>
        </div>

        <div class="stat-card stat-applied">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $vacancies->sum('applications_count') }}</div>
                <div class="stat-label">Total Applications</div>
            </div>
        </div>
    </div> --}}

        <!-- Vacancies Table Container -->
        <div class="vacancies-table-container">
            <div class="vacancies-table-header">
                <h3 class="vacancies-table-title">All Job Openings</h3>

                <!-- Filters Section -->
                <div class="filters-section">
                    <form action="{{ route('candidate.vacancies.index') }}" method="GET" id="filterForm">
                        <div class="filters-grid">
                            <div class="filter-group">
                                <input type="text" name="search" class="filter-input"
                                    placeholder="Search by position..." id="searchInput" value="{{ request('search') }}">
                            </div>
                            <div class="filter-group">
                                <select class="filter-select" name="category" id="categoryFilter">
                                    <option value="">All Categories</option>
                                    @foreach ($vacancies->pluck('category')->unique()->filter() as $category)
                                        <option value="{{ $category }}"
                                            {{ request('category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="filter-group">
                                <select class="filter-select" name="location" id="locationFilter">
                                    <option value="">All Locations</option>
                                    @foreach ($vacancies->pluck('location')->unique()->filter() as $location)
                                        <option value="{{ $location }}"
                                            {{ request('location') == $location ? 'selected' : '' }}>
                                            {{ $location }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="filter-actions">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('candidate.vacancies.index') }}" class="btn btn-default btn-sm">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="vacancies-data-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i></th>
                            <th><i class="fas fa-briefcase"></i> Position</th>
                            <th><i class="fas fa-building"></i> Department</th>
                            <th><i class="fas fa-map-marker-alt"></i> Location</th>
                            {{-- <th><i class="fas fa-user-friends"></i> Vacancies</th> --}}
                            <th><i class="fas fa-calendar"></i> Deadline</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                            <th><i class="fas fa-hand-pointer"></i> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vacancies as $key => $vacancy)
                            @php
                                $deadline = \Carbon\Carbon::parse($vacancy->deadline);
                                $daysLeft = (int) now()->diffInDays($deadline, false);
                                $daysLeftClass = $daysLeft < 7 ? 'critical' : ($daysLeft < 14 ? 'urgent' : 'safe');
                            @endphp
                            <tr>
                                <td>
                                    {{ ++$key }}
                                </td>
                                <td>
                                    <div class="position-info">
                                        {{-- <div class="position-icon">
                                            <i class="fas fa-briefcase"></i>
                                        </div> --}}
                                        <div class="position-details">
                                            <div class="position-title">{{ $vacancy->job_title }}</div>
                                            <div class="position-level">{{ $vacancy->jobfunction ?? 'General' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="department-badge {{ strtolower(str_replace(' ', '-', $vacancy->category ?? 'general')) }}">
                                        <i class="fas fa-tag"></i>
                                        {{ $vacancy->category ?? 'General' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="location-badge">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $vacancy->location ?? 'Not Specified' }}
                                    </div>
                                </td>
                                {{-- <td>
                            <span class="vacancies-count">
                                <i class="fas fa-users"></i>
                                {{ $vacancy->applications_count ?? 0 }}
                                {{ ($vacancy->applications_count ?? 0) == 1 ? 'application' : 'applications' }}
                            </span>
                        </td> --}}
                                <td>
                                    <div class="deadline-info">
                                        <div class="deadline-date">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ $deadline->format('M d, Y') }}
                                        </div>
                                        @if ($daysLeft > 0)
                                            <div class="days-left {{ $daysLeftClass }}">
                                                {{ $daysLeft }} {{ $daysLeft == 1 ? 'day' : 'days' }} left
                                            </div>
                                        @else
                                            <div class="days-left critical">Expired</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if ($vacancy->status == 1 && $daysLeft >= 0)
                                        <span class="status-badge status-open">
                                            <i class="fas fa-circle"></i> Open
                                        </span>
                                    @else
                                        <span class="status-badge status-closed">
                                            <i class="fas fa-times-circle"></i> Closed
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($vacancy->status == 1 && $daysLeft >= 0)
                                        <a href="{{ route('candidate.vacancies.show', $vacancy->hash_id) }}"
                                            class="btn btn-apply">
                                            <i class="fas fa-paper-plane"></i> Apply Now
                                        </a>
                                    @else
                                        <button class="btn btn-apply" disabled style="opacity: 0.5; cursor: not-allowed;">
                                            <i class="fas fa-ban"></i> Closed
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="no-data">
                                    <div class="no-data-message">
                                        <i class="fas fa-briefcase fa-4x"></i>
                                        <p>No vacancies available at the moment</p>
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
                    @if ($vacancies->total() > 0)
                        Showing <strong>{{ $vacancies->firstItem() }}</strong> to
                        <strong>{{ $vacancies->lastItem() }}</strong> of <strong>{{ $vacancies->total() }}</strong>
                        vacancies
                    @else
                        No vacancies found
                    @endif
                </div>

                @if ($vacancies->hasPages())
                    <nav class="pagination-nav">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($vacancies->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $vacancies->previousPageUrl() }}" rel="prev">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($vacancies->getUrlRange(1, $vacancies->lastPage()) as $page => $url)
                                @if ($page == $vacancies->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($vacancies->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $vacancies->nextPageUrl() }}" rel="next">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif

                <div class="per-page-selector">
                    <form action="{{ route('candidate.vacancies.index') }}" method="GET" id="perPageForm">
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if (request('location'))
                            <input type="hidden" name="location" value="{{ request('location') }}">
                        @endif

                        <span>Show</span>
                        <select name="per_page" onchange="this.form.submit()">
                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <span>per page</span>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function applyForJob(jobId, position) {
            Swal.fire({
                title: 'Apply for this position?',
                html: `
            <div style="text-align: left; padding: 20px;">
                <p><strong>Position:</strong> ${position}</p>
                <p><strong>Job ID:</strong> ${jobId}</p>
                <p style="margin-top: 20px; color: #6c757d;">
                    You are about to submit your application for this position.
                    Make sure your profile is complete before applying.
                </p>
            </div>
        `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#262261',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-paper-plane"></i> Yes, Apply Now',
                cancelButtonText: 'Cancel',
                width: 600
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('candidate/vacancies/apply') }}/${jobId}`;

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

        // Show success/error messages
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
    </script>
@endsection
