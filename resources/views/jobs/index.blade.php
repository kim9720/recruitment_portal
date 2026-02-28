@extends('layouts.guest')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/jobs.css') }}">
    <!-- Search Section -->
    <div id="homesection" class="jobs-search-section">
        <div class="search-overlay"></div>
        <div class="container">
            <div class="search-header">
                <h1>Find Your Dream Job</h1>
                <p>Explore {{ $totalJobs ?? 0 }} opportunities from Habari</p>
            </div>

            <div class="search-card">
                <form method="GET" action="{{ route('jobs.index') }}" class="job-search-form">
                    <div class="search-grid">
                        <div class="search-field">
                            <label>
                                <i class="fas fa-briefcase"></i>
                                Job Function
                            </label>
                            <select name="jobfunction" class="form-select">
                                <option value="">All Job Functions</option>
                                <option value="Accounting, Auditing and Finance" {{ request('jobfunction') == 'Accounting, Auditing and Finance' ? 'selected' : '' }}>Accounting, Auditing & Finance</option>
                                <option value="Administrative & Office" {{ request('jobfunction') == 'Administrative & Office' ? 'selected' : '' }}>Administrative & Office</option>
                                <option value="Agriculture & Farming" {{ request('jobfunction') == 'Agriculture & Farming' ? 'selected' : '' }}>Agriculture & Farming</option>
                                <option value="Building & Architecture" {{ request('jobfunction') == 'Building & Architecture' ? 'selected' : '' }}>Building & Architecture</option>
                                <option value="Community & Social Services" {{ request('jobfunction') == 'Community & Social Services' ? 'selected' : '' }}>Community & Social Services</option>
                                <option value="Consulting & Strategy" {{ request('jobfunction') == 'Consulting & Strategy' ? 'selected' : '' }}>Consulting & Strategy</option>
                                <option value="Creative & Design" {{ request('jobfunction') == 'Creative & Design' ? 'selected' : '' }}>Creative & Design</option>
                                <option value="Customer Service & Support" {{ request('jobfunction') == 'Customer Service & Support' ? 'selected' : '' }}>Customer Service & Support</option>
                                <option value="Engineering" {{ request('jobfunction') == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                                <option value="Food Services & Catering" {{ request('jobfunction') == 'Food Services & Catering' ? 'selected' : '' }}>Food Services & Catering</option>
                                <option value="Health & Safety" {{ request('jobfunction') == 'Health & Safety' ? 'selected' : '' }}>Health & Safety</option>
                                <option value="Hospitality/Leisure/Travel" {{ request('jobfunction') == 'Hospitality/Leisure/Travel' ? 'selected' : '' }}>Hospitality/Leisure/Travel</option>
                                <option value="Human Resources" {{ request('jobfunction') == 'Human Resources' ? 'selected' : '' }}>Human Resources</option>
                                <option value="IT & Software" {{ request('jobfunction') == 'IT & Software' ? 'selected' : '' }}>IT & Software</option>
                                <option value="Legal Services" {{ request('jobfunction') == 'Legal Services' ? 'selected' : '' }}>Legal Services</option>
                                <option value="Management & Business Development" {{ request('jobfunction') == 'Management & Business Development' ? 'selected' : '' }}>Management & Business Development</option>
                                <option value="Marketing & Communications" {{ request('jobfunction') == 'Marketing & Communications' ? 'selected' : '' }}>Marketing & Communications</option>
                                <option value="Medical & Pharmaceutical" {{ request('jobfunction') == 'Medical & Pharmaceutical' ? 'selected' : '' }}>Medical & Pharmaceutical</option>
                                <option value="Natural Sciences" {{ request('jobfunction') == 'Natural Sciences' ? 'selected' : '' }}>Natural Sciences</option>
                                <option value="Project & Product Management" {{ request('jobfunction') == 'Project & Product Management' ? 'selected' : '' }}>Project & Product Management</option>
                                <option value="Sales" {{ request('jobfunction') == 'Sales' ? 'selected' : '' }}>Sales</option>
                                <option value="Security" {{ request('jobfunction') == 'Security' ? 'selected' : '' }}>Security</option>
                                <option value="Supply Chain & Procurement" {{ request('jobfunction') == 'Supply Chain & Procurement' ? 'selected' : '' }}>Supply Chain & Procurement</option>
                                <option value="Transport & Logistics" {{ request('jobfunction') == 'Transport & Logistics' ? 'selected' : '' }}>Transport & Logistics</option>
                            </select>
                        </div>

                        <div class="search-field">
                            <label>
                                <i class="fas fa-clock"></i>
                                Category
                            </label>
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                <option value="Full Time" {{ request('category') == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                                <option value="Part Time" {{ request('category') == 'Part Time' ? 'selected' : '' }}>Part Time</option>
                                <option value="Freelance" {{ request('category') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                <option value="Internship" {{ request('category') == 'Internship' ? 'selected' : '' }}>Internship</option>
                                <option value="Temporary" {{ request('category') == 'Temporary' ? 'selected' : '' }}>Temporary</option>
                            </select>
                        </div>

                        <div class="search-field">
                            <label>
                                <i class="fas fa-map-marker-alt"></i>
                                Location
                            </label>
                            <select name="location" class="form-select">
                                <option value="">All Locations</option>
                                <option value="Arusha" {{ request('location') == 'Arusha' ? 'selected' : '' }}>Arusha</option>
                                <option value="Dar es Salaam" {{ request('location') == 'Dar es Salaam' ? 'selected' : '' }}>Dar es Salaam</option>
                                <option value="Dodoma" {{ request('location') == 'Dodoma' ? 'selected' : '' }}>Dodoma</option>
                                <option value="Geita" {{ request('location') == 'Geita' ? 'selected' : '' }}>Geita</option>
                                <option value="Iringa" {{ request('location') == 'Iringa' ? 'selected' : '' }}>Iringa</option>
                                <option value="Kagera" {{ request('location') == 'Kagera' ? 'selected' : '' }}>Kagera</option>
                                <option value="Katavi" {{ request('location') == 'Katavi' ? 'selected' : '' }}>Katavi</option>
                                <option value="Kigoma" {{ request('location') == 'Kigoma' ? 'selected' : '' }}>Kigoma</option>
                                <option value="Kilimanjaro" {{ request('location') == 'Kilimanjaro' ? 'selected' : '' }}>Kilimanjaro</option>
                                <option value="Lindi" {{ request('location') == 'Lindi' ? 'selected' : '' }}>Lindi</option>
                                <option value="Manyara" {{ request('location') == 'Manyara' ? 'selected' : '' }}>Manyara</option>
                                <option value="Mara" {{ request('location') == 'Mara' ? 'selected' : '' }}>Mara</option>
                                <option value="Mbeya" {{ request('location') == 'Mbeya' ? 'selected' : '' }}>Mbeya</option>
                                <option value="Morogoro" {{ request('location') == 'Morogoro' ? 'selected' : '' }}>Morogoro</option>
                                <option value="Mtwara" {{ request('location') == 'Mtwara' ? 'selected' : '' }}>Mtwara</option>
                                <option value="Mwanza" {{ request('location') == 'Mwanza' ? 'selected' : '' }}>Mwanza</option>
                                <option value="Njombe" {{ request('location') == 'Njombe' ? 'selected' : '' }}>Njombe</option>
                                <option value="Pemba North" {{ request('location') == 'Pemba North' ? 'selected' : '' }}>Pemba North</option>
                                <option value="Pemba South" {{ request('location') == 'Pemba South' ? 'selected' : '' }}>Pemba South</option>
                                <option value="Pwani" {{ request('location') == 'Pwani' ? 'selected' : '' }}>Pwani</option>
                                <option value="Rukwa" {{ request('location') == 'Rukwa' ? 'selected' : '' }}>Rukwa</option>
                                <option value="Ruvuma" {{ request('location') == 'Ruvuma' ? 'selected' : '' }}>Ruvuma</option>
                                <option value="Shinyanga" {{ request('location') == 'Shinyanga' ? 'selected' : '' }}>Shinyanga</option>
                                <option value="Simiyu" {{ request('location') == 'Simiyu' ? 'selected' : '' }}>Simiyu</option>
                                <option value="Singida" {{ request('location') == 'Singida' ? 'selected' : '' }}>Singida</option>
                                <option value="Tabora" {{ request('location') == 'Tabora' ? 'selected' : '' }}>Tabora</option>
                                <option value="Tanga" {{ request('location') == 'Tanga' ? 'selected' : '' }}>Tanga</option>
                                <option value="Zanzibar North" {{ request('location') == 'Zanzibar North' ? 'selected' : '' }}>Zanzibar North</option>
                                <option value="Zanzibar South and Central" {{ request('location') == 'Zanzibar South and Central' ? 'selected' : '' }}>Zanzibar South and Central</option>
                                <option value="Zanzibar West" {{ request('location') == 'Zanzibar West' ? 'selected' : '' }}>Zanzibar West</option>
                            </select>
                        </div>

                        <div class="search-field search-button-field">
                            <button type="submit" class="btn-search">
                                <i class="fas fa-search"></i>
                                Search Jobs
                            </button>
                        </div>
                    </div>

                    <!-- Clear Filters Button -->
                    @if(request()->hasAny(['jobfunction', 'category', 'location', 'keyword']))
                        <div class="clear-filters">
                            <a href="{{ route('jobs.index') }}" class="btn-clear">
                                <i class="fas fa-times"></i>
                                Clear Filters
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Jobs Listing Section -->
    <section class="jobs-listing-section">
        <div class="container">
            <!-- Section Header with Results Count -->
            <div class="section-header">
                <h2>Available <span>Positions</span></h2>
                <p>
                    Showing {{ $joblist->firstItem() ?? 0 }} - {{ $joblist->lastItem() ?? 0 }}
                    of {{ $joblist->total() }} jobs
                    @if(request()->hasAny(['jobfunction', 'category', 'location']))
                        <span class="filtered-text">(filtered)</span>
                    @endif
                </p>
            </div>

            <!-- Jobs Table -->
            <div class="jobs-table-container">
                @if($joblist->count() > 0)
                    <div class="table-responsive">
                        <table class="jobs-table">
                            <thead>
                                <tr>
                                    <th>
                                        <i class="fas fa-briefcase"></i>
                                        Job Title
                                    </th>
                                    <th>
                                        <i class="fas fa-map-marker-alt"></i>
                                        Location
                                    </th>
                                    <th>
                                        <i class="fas fa-clock"></i>
                                        Type
                                    </th>
                                    <th>
                                        <i class="fas fa-calendar-alt"></i>
                                        Deadline
                                    </th>
                                    <th>
                                        <i class="fas fa-ellipsis-v"></i>
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($joblist as $job)
                                    <tr class="job-row" data-job-id="{{ $job->job_id }}">
                                        <td class="job-title-cell">
                                            <div class="job-title-wrapper">
                                                <h4>{{ $job->job_title }}</h4>
                                                <p class="job-intro">{{ Str::limit($job->introduction, 100) }}</p>
                                                @if ($job->skills)
                                                    <div class="job-skills">
                                                        @foreach (array_slice(explode(',', $job->skills), 0, 3) as $skill)
                                                            <span class="skill-tag">{{ trim($skill) }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="job-location-cell">
                                            <div class="location-badge">
                                                <i class="fas fa-map-marker-alt"></i>
                                                {{ $job->location }}
                                            </div>
                                        </td>
                                        <td class="job-type-cell">
                                            <span class="type-badge badge-{{ Str::slug($job->category) }}">
                                                {{ $job->category }}
                                            </span>
                                        </td>
                                        <td class="job-deadline-cell">
                                            <div class="deadline-wrapper">
                                                <span class="deadline-date">{{ date('M d, Y', strtotime($job->deadline)) }}</span>
                                                <span class="deadline-label">Apply Before</span>
                                            </div>
                                        </td>
                                        <td class="job-actions-cell">
                                            <div class="action-buttons">
                                                <a href="{{ route('jobs.guest_job_show', $job->job_id) }}" class="btn-view" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                    View
                                                </a>
                                                <button class="btn-share" title="Share Job" onclick="shareJob({{ $job->job_id }}, '{{ $job->job_title }}')">
                                                    <i class="fas fa-share-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="empty-state">
                        <i class="fas fa-search"></i>
                        <h3>No Jobs Found</h3>
                        <p>Try adjusting your search filters to find more opportunities</p>
                        <a href="{{ route('jobs.index') }}" class="btn-reset">
                            <i class="fas fa-redo"></i>
                            Reset Filters
                        </a>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            @if($joblist->hasPages())
                <div class="pagination-wrapper">
                    <nav aria-label="Job listings pagination">
                        {{ $joblist->links('pagination.custom') }}
                    </nav>

                    <div class="pagination-info">
                        <p>
                            Page {{ $joblist->currentPage() }} of {{ $joblist->lastPage() }}
                            <span class="separator">•</span>
                            Total: {{ $joblist->total() }} jobs
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Share Job Script -->
    <script>
        function shareJob(jobId, jobTitle) {
            const url = `${window.location.origin}/jobs/${jobId}`;

            if (navigator.share) {
                navigator.share({
                    title: jobTitle + ' - Habari Recruitment',
                    text: 'Check out this job opportunity',
                    url: url
                }).catch(err => console.log('Share cancelled'));
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(url).then(() => {
                    showNotification('Job link copied to clipboard!');
                }).catch(() => {
                    // Fallback for older browsers
                    const tempInput = document.createElement('input');
                    tempInput.value = url;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);
                    showNotification('Job link copied to clipboard!');
                });
            }
        }

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('show');
            }, 100);

            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Add row click functionality (optional - makes entire row clickable)
        document.querySelectorAll('.job-row').forEach(row => {
            row.addEventListener('click', function(e) {
                // Don't trigger if clicking on action buttons
                if (!e.target.closest('.btn-view') && !e.target.closest('.btn-share')) {
                    const viewBtn = this.querySelector('.btn-view');
                    if (viewBtn) {
                        window.location.href = viewBtn.href;
                    }
                }
            });
        });
    </script>

    <style>
        /* Additional styles for this page */
        .clear-filters {
            margin-top: 20px;
            text-align: center;
        }

        .btn-clear {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #fff;
            color: var(--habari-primary);
            border: 2px solid var(--habari-primary);
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-clear:hover {
            background: var(--habari-primary);
            color: #fff;
        }

        .filtered-text {
            color: var(--habari-primary);
            font-weight: 600;
        }

        .btn-reset {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--habari-primary);
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .btn-reset:hover {
            background: var(--habari-primary-dark);
            color: #fff;
            transform: translateY(-2px);
        }

        .pagination-info {
            text-align: center;
            margin-top: 20px;
        }

        .pagination-info p {
            font-size: 14px;
            color: var(--habari-gray);
        }

        .pagination-info .separator {
            margin: 0 10px;
            color: var(--habari-border);
        }

        /* Notification styles */
        .notification {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--habari-dark);
            color: #fff;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            z-index: 9999;
        }

        .notification.show {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 767px) {
            .notification {
                bottom: 20px;
                right: 20px;
                left: 20px;
            }
        }
    </style>
@endsection
