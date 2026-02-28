@extends('layouts.app')
@section('title', 'Job Vacancies')

<link rel="stylesheet" href="{{ asset('pagestyles/vacancies.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
    <div class="content-area">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">My Applications</h1>
                <p class="page-subtitle">List of all your job applications</p>
            </div>
            <div class="header-stats">
                <div class="quick-stat">
                    <i class="fas fa-briefcase"></i>
                    <span> {{ $applications->count() }} Total Applications</span>
                </div>
            </div>
        </div>


        <!-- Vacancies Table Container -->
        <div class="vacancies-table-container">
            <div class="vacancies-table-header">
                <h3 class="vacancies-table-title">All Applications</h3>

                <!-- Filters Section -->
                <div class="filters-section">
                    <!-- Filters Section -->
                    <form action="{{ route('candidate.vacancies.my_applications') }}" method="GET" id="filterForm">
                        <div class="filters-grid">
                            <div class="filter-group">
                                <select class="filter-select" name="status">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>
                                        Shortlisted
                                    </option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                        Rejected
                                    </option>
                                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>
                                        Accepted
                                    </option>
                                </select>
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-search"></i> Filter
                                </button>

                                <a href="{{ route('candidate.vacancies.my_applications') }}" class="btn btn-default btn-sm">
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
                            <th><i class="fas fa-map-marker-alt"></i> Location</th>
                            <th><i class="fas fa-calendar"></i> Applications Date</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                            <th><i class="fas fa-hand-pointer"></i> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $key => $application)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $application->job->job_title }}</td>
                                <td>{{ $application->job->location }}</td>
                                <td>{{ \Carbon\Carbon::parse($application->created_at)->format('M d, Y') }}</td>
                                <td>
                                    <span
                                        class="status-select status-{{ $application->status }}">{{ $application->status }}</span>

                                </td>
                                <td>
                                    <button class="btn btn-apply  btn-sm">
                                        <i class="fas fa-info-circle"></i> View Details
                                    </button>
                                    @if ($application->job->deadline >= \Carbon\Carbon::now())
                                        <button class="btn btn-default  btn-sm">
                                            <i class="fas fa-pencil"></i> edit
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 20px;">
                                    No applications found.
                                </td>
                            </tr>
                        @endforelse

                </table>
            </div>
            <div class="pagination-container">
                <div class="pagination-info">
                    @if ($applications->total() > 0)
                        Showing <strong>{{ $applications->firstItem() }}</strong> to
                        <strong>{{ $applications->lastItem() }}</strong> of
                        <strong>{{ $applications->total() }}</strong> applications
                    @else
                        No applications found
                    @endif
                </div>

                @if ($applications->hasPages())
                    <nav class="pagination-nav">
                        <ul class="pagination">
                            {{-- Previous Page --}}
                            @if ($applications->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $applications->previousPageUrl() }}">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- Page Numbers --}}
                            @foreach ($applications->getUrlRange(1, $applications->lastPage()) as $page => $url)
                                @if ($page == $applications->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page --}}
                            @if ($applications->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $applications->nextPageUrl() }}">
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

                {{-- Per Page Selector --}}
                <div class="per-page-selector">
                    <form action="{{ route('candidate.vacancies.my_applications') }}" method="GET">
                        <span>Show</span>
                        <select name="per_page" onchange="this.form.submit()">
                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
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
