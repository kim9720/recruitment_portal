{{-- resources/views/dashboards/candidate.blade.php --}}

<link rel="stylesheet" href="{{ asset('pagestyles/candidate-dashboard.css') }}">




<div class="content-area">
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Welcome back, {{ Auth::user()->username }}</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <i class="fas fa-paper-plane stat-icon"></i>
            <div class="stat-value" id="applicationsCount">{{ $candidateData['applicationsCount'] }}</div>
            <div class="stat-label">Applications Sent</div>
        </div>

        <div class="stat-card">
            <i class="fas fa-calendar-check stat-icon"></i>
            <div class="stat-value" id="interviewsCount">{{ $candidateData['interviewsCount'] }}</div>
            <div class="stat-label">Interviews Scheduled</div>
        </div>

        <div class="stat-card stat-card-profile">
            <div class="profile-completion">
                <div class="profile-info">
                    <div class="profile-header">
                        <div class="stat-label">Profile Completion</div>
                        <div class="progress-percentage" id="progressText">{{ $candidateData['profileCompletion'] }}%</div>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar-track">
                            <div class="progress-bar-fill" id="progressBar" data-progress="{{ $candidateData['profileCompletion'] }}">
                                <div class="progress-bar-shine"></div>
                                <div class="progress-bar-wave"></div>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="complete-link">
                        <i class="fas fa-user-edit"></i> Complete Your Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Vacancies -->
    <div class="table-container">
        <div class="table-header">
            <h3 class="table-title">Latest Job Vacancies</h3>
            <a href="{{ route('candidate.vacancies.index') }}" class="btn btn-primary">
                <i class="fas fa-search"></i> Browse All Jobs
            </a>
        </div>

        <!-- Desktop Table View -->
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Position</th>
                        {{-- <th>Company</th> --}}
                        <th>Location</th>
                        <th>Type</th>
                        <th>Posted</th>
                        <th>Dead Line</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- {{ dd($latestVacancies) }} --}}
                    @foreach ($latestVacancies as $vacancy)
                        <tr>
                            <td><strong>{{ $vacancy->job_title }}</strong></td>
                            {{-- <td>{{ $vacancy->company }}</td> --}}
                            <td>{{ $vacancy->location }}</td>
                            <td><span class="type-badge type-fulltime">{{ $vacancy->category }}</span></td>
                            <td>{{ $vacancy->created_at->diffForHumans() }}</td>
                            <td>{{ \Carbon\Carbon::parse($vacancy->deadline)->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('candidate.vacancies.show', $vacancy->hash_id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="table-card-view">
            @foreach ($latestVacancies as $vacancy)
                <div class="vacancy-card">
                    <div class="vacancy-header">
                        <h4>{{ $vacancy->job_title }}</h4>
                        <span class="type-badge type-{{ str_replace(' ', '', strtolower($vacancy->category)) }}">{{ $vacancy->category }}</span>
                    </div>
                    <div class="vacancy-company">{{ $vacancy->company }}</div>
                    <div class="vacancy-meta">
                        <span><i class="fas fa-map-marker-alt"></i> {{ $vacancy->location }}</span>
                        <span><i class="fas fa-clock"></i> {{ $vacancy->created_at->diffForHumans() }}</span>
                        <span><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($vacancy->deadline)->format('M d, Y') }}</span>
                    </div>
                    <a href="{{ route('candidate.vacancies.show', $vacancy->hash_id) }}" class="btn btn-sm btn-primary btn-block">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Progress Bar Animation
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');

        if (!progressBar || !progressText) return;

        const targetPercent = parseInt(progressBar.getAttribute('data-progress')) || 70;

        // Reset to 0
        progressBar.style.width = '0%';
        progressText.textContent = '0%';

        // Start animation after small delay
        setTimeout(() => {
            // Animate the bar
            progressBar.style.width = targetPercent + '%';

            // Animate the number
            const duration = 2500; // Match CSS transition duration
            const startTime = Date.now();

            function animateNumber() {
                const elapsed = Date.now() - startTime;
                const progress = Math.min(elapsed / duration, 1);

                // Use same easing as CSS: cubic-bezier(0.65, 0, 0.35, 1)
                const eased = progress < 0.5
                    ? 2 * progress * progress
                    : 1 - Math.pow(-2 * progress + 2, 2) / 2;

                const current = Math.round(eased * targetPercent);
                progressText.textContent = current + '%';

                if (progress < 1) {
                    requestAnimationFrame(animateNumber);
                } else {
                    progressText.textContent = targetPercent + '%';
                }
            }

            requestAnimationFrame(animateNumber);
        }, 300);
    });
</script>
