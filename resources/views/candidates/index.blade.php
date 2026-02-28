@extends('layouts.app')
@section('title', 'Candidates')

    <link rel="stylesheet" href="{{ asset('pagestyles/candidates.css') }}">


@section('content')
    <div class="content-area">
        <div class="content-section">
            <div class="page-header">
                <h1 class="page-title">Applicants List</h1>
                <p class="page-subtitle">List of all registered Applicants</p>
            </div>
        </div>

        <div class="candidate-table-container">
            <div class="candidate-table-header">
                <h3 class="candidate-table-title">All Applicants</h3>

                <!-- Filter and Search Section -->
                <div class="filters-section">
                    <form method="GET" action="{{ route('candidate.index') }}" id="filterForm">
                        <div class="filters-grid">
                            <!-- Search Input -->
                            <div class="filter-group">
                                <input type="text"
                                       name="search"
                                       class="filter-input"
                                       placeholder="🔍 Search applicants..."
                                       value="{{ request('search') }}">
                            </div>

                            <!-- Gender Filter -->
                            <div class="filter-group">
                                <select name="gender" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All Genders</option>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender }}" {{ request('gender') == $gender ? 'selected' : '' }}>
                                            {{ ucfirst($gender) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Education Filter -->
                            <div class="filter-group">
                                <select name="education" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All Education Levels</option>
                                    @foreach($educations as $education)
                                        <option value="{{ $education }}" {{ request('education') == $education ? 'selected' : '' }}>
                                            {{ $education }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="filter-actions">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('candidate.index') }}" class="btn btn-default btn-sm">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                        <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                    </form>
                </div>
            </div>

            <!-- Active Filters Display -->
            @if(request('gender') || request('education') || request('search'))
                <div class="active-filters">
                    <span class="filter-label">Active Filters:</span>
                    @if(request('search'))
                        <span class="filter-tag">
                            Search: "{{ request('search') }}"
                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="filter-remove">×</a>
                        </span>
                    @endif
                    @if(request('gender'))
                        <span class="filter-tag">
                            Gender: {{ ucfirst(request('gender')) }}
                            <a href="{{ request()->fullUrlWithQuery(['gender' => null]) }}" class="filter-remove">×</a>
                        </span>
                    @endif
                    @if(request('education'))
                        <span class="filter-tag">
                            Education: {{ request('education') }}
                            <a href="{{ request()->fullUrlWithQuery(['education' => null]) }}" class="filter-remove">×</a>
                        </span>
                    @endif
                </div>
            @endif

            <div class="table-responsive">
                <table class="candidate-data-table">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th><i class="fas fa-user"></i> Applicant Name</th>
                            <th><i class="fas fa-map-marker-alt"></i> Location</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-book"></i> Education</th>
                            <th><i class="fas fa-venus-mars"></i> Gender</th>
                            <th><i class="fas fa-phone"></i> Phone</th>
                            <th><i class="fas fa-briefcase"></i> Job Applied</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                            <th><i class="fas fa-cogs"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($candidates as $index => $candidate)
                        <tr>
                            <td>{{ $candidates->firstItem() + $index }}</td>
                            <td>
                                <div class="candidate-name">
                                    {{-- <span class="name-avatar">{{ substr($candidate->first_name, 0, 1) }}{{ substr($candidate->last_name, 0, 1) }}</span> --}}
                                    <span>{{ $candidate->full_name }}</span>
                                </div>
                            </td>
                            <td>{{ $candidate->address ?? 'N/A' }}</td>
                            <td>{{ $candidate->email }}</td>
                            <td>
                                <span class="education-badge">{{ $candidate->latestEducation->educationlevel ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="gender-badge gender-{{ strtolower($candidate->gender) }}">
                                    {{ ucfirst($candidate->gender) }}
                                </span>
                            </td>
                            <td>{{ $candidate->mobile }}</td>
                            <td>
                                <span class="job-badge">{{ $candidate->job_title ?? 'Not Applied' }}</span>
                            </td>
                            <td>
                                <span class="status-badge status-active">Active</span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('candidate.show', $candidate->id) }}" class="btn btn-success btn-sm" title="View Details">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="no-data">
                                <div class="no-data-message">
                                    <i class="fas fa-inbox fa-3x"></i>
                                    <p>No applicants found matching your criteria</p>
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
                    Showing {{ $candidates->firstItem() ?? 0 }} to {{ $candidates->lastItem() ?? 0 }} of {{ $candidates->total() }} results
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

                {{ $candidates->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function changePerPage(value) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', value);
            window.location.href = url.toString();
        }
    </script>
    @endpush
@endsection
