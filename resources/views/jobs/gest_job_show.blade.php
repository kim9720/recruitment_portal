@extends('layouts.guest')

@section('title', $job->job_title . ' - Habari Recruitment Portal')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/job_show.css') }}">
    <!-- Job Header Section -->
    <div class="job-header-section">
        <div class="header-overlay"></div>
        <div class="container">
            <div class="breadcrumb-nav">
                <a href="{{ route('home') }}">
                    <i class="fas fa-home"></i> Home
                </a>
                <span class="separator">/</span>
                <a href="{{ route('jobs.index') }}">Jobs</a>
                <span class="separator">/</span>
                <span class="current">{{ $job->job_title }}</span>
            </div>

            <div class="job-header-content">
                <div class="job-badge">
                    <span class="type-badge badge-{{ Str::slug($job->category) }}">
                        {{ $job->category }}
                    </span>
                    <span class="featured-badge">
                        <i class="fas fa-star"></i> Featured
                    </span>
                </div>

                <h1 class="job-title">{{ $job->job_title }}</h1>

                <div class="job-meta">
                    <div class="meta-item">
                        <i class="fas fa-building"></i>
                        <span>Habari Node PLC</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $job->location }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Posted {{ $job->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-clock"></i>
                        <span>Deadline: {{ date('M d, Y', strtotime($job->deadline)) }}</span>
                    </div>
                </div>

                <div class="job-actions">
                    <a href="{{ route('candidate.vacancies.show', $job->hash_id) }}" class="btn-apply" >
                        <i class="fas fa-paper-plane"></i>
                        Apply Now
                    </a>
                    <button class="btn-save" onclick="saveJob({{ $job->job_id }})">
                        <i class="far fa-bookmark"></i>
                        Save Job
                    </button>
                    <button class="btn-share-header" onclick="shareJob({{ $job->job_id }}, '{{ $job->job_title }}')">
                        <i class="fas fa-share-alt"></i>
                        Share
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Details Section -->
    <section class="job-details-section">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="job-content-card">
                        <!-- Job Overview -->
                        <div class="content-block">
                            <div class="block-header">
                                <i class="fas fa-info-circle"></i>
                                <h2>Job Overview</h2>
                            </div>
                            <div class="block-content">
                                <p class="job-introduction">{{ $job->introduction }}</p>
                            </div>
                        </div>

                        <!-- Job Description -->
                        @if ($job->responsibilities)
                            <div class="content-block">
                                <div class="block-header">
                                    <i class="fas fa-tasks"></i>
                                    <h2>Key Responsibilities</h2>
                                </div>

                                <div class="block-content">
                                    <div class="responsibilities-list">
                                        {!! $job->responsibilities !!}
                                    </div>
                                </div>
                            </div>
                        @endif


                        <!-- Required Skills -->
                        @if ($job->skillset)
                            <div class="content-block">
                                <div class="block-header">
                                    <i class="fas fa-star"></i>
                                    <h2>Required Skills</h2>
                                </div>
                                <div class="block-content">
                                    <div class="skills-grid">
                                        {!! $job->skillset !!}
                                    </div>
                                </div>
                            </div>
                        @endif


                        <!-- Job Function -->
                        @if ($job->jobfunction)
                            <div class="content-block">
                                <div class="block-header">
                                    <i class="fas fa-briefcase"></i>
                                    <h2>Job Function</h2>
                                </div>
                                <div class="block-content">
                                    <p>{{ $job->jobfunction }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Application Section -->
                        {{-- <div class="content-block application-block" id="application-section">
                            <div class="block-header">
                                <i class="fas fa-file-alt"></i>
                                <h2>Apply for this Position</h2>
                            </div>
                            <div class="block-content">
                                <div class="application-info">
                                    <p>Interested in this position? Submit your application below:</p>
                                </div>
                                <form class="application-form" method="POST" action="" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="job_id" value="{{ $job->job_id }}">

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="full_name">
                                                <i class="fas fa-user"></i>
                                                Full Name *
                                            </label>
                                            <input type="text" id="full_name" name="full_name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">
                                                <i class="fas fa-envelope"></i>
                                                Email Address *
                                            </label>
                                            <input type="email" id="email" name="email" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="phone">
                                                <i class="fas fa-phone"></i>
                                                Phone Number *
                                            </label>
                                            <input type="tel" id="phone" name="phone" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="experience">
                                                <i class="fas fa-briefcase"></i>
                                                Years of Experience *
                                            </label>
                                            <select id="experience" name="experience" required>
                                                <option value="">Select experience</option>
                                                <option value="0-1">0-1 years</option>
                                                <option value="1-3">1-3 years</option>
                                                <option value="3-5">3-5 years</option>
                                                <option value="5-10">5-10 years</option>
                                                <option value="10+">10+ years</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="cover_letter">
                                            <i class="fas fa-file-alt"></i>
                                            Cover Letter
                                        </label>
                                        <textarea id="cover_letter" name="cover_letter" rows="5" placeholder="Tell us why you're a great fit for this position..."></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="resume">
                                            <i class="fas fa-upload"></i>
                                            Upload Resume/CV *
                                        </label>
                                        <div class="file-upload-wrapper">
                                            <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" required>
                                            <label for="resume" class="file-upload-label">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <span class="file-name">Choose file or drag here</span>
                                                <span class="file-info">PDF, DOC, DOCX (Max 5MB)</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn-submit-application">
                                            <i class="fas fa-paper-plane"></i>
                                            Submit Application
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Job Summary Card -->
                    <div class="sidebar-card job-summary-card">
                        <h3>Job Summary</h3>
                        <div class="summary-items">
                            <div class="summary-item">
                                <div class="summary-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="summary-content">
                                    <span class="label">Posted Date</span>
                                    <span class="value">{{ $job->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>

                            <div class="summary-item">
                                <div class="summary-icon">
                                    <i class="fas fa-hourglass-end"></i>
                                </div>
                                <div class="summary-content">
                                    <span class="label">Application Deadline</span>
                                    <span class="value">{{ date('M d, Y', strtotime($job->deadline)) }}</span>
                                </div>
                            </div>

                            <div class="summary-item">
                                <div class="summary-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="summary-content">
                                    <span class="label">Location</span>
                                    <span class="value">{{ $job->location }}</span>
                                </div>
                            </div>

                            <div class="summary-item">
                                <div class="summary-icon">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div class="summary-content">
                                    <span class="label">Job Type</span>
                                    <span class="value">{{ $job->category }}</span>
                                </div>
                            </div>

                            <div class="summary-item">
                                <div class="summary-icon">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <div class="summary-content">
                                    <span class="label">Function</span>
                                    <span class="value">{{ $job->jobfunction }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Share Card -->
                    <div class="sidebar-card share-card">
                        <h3>Share This Job</h3>
                        <div class="share-buttons">
                            <button class="share-btn facebook" onclick="shareOnFacebook('{{ $job->job_title }}')">
                                <i class="fab fa-facebook-f"></i>
                                Facebook
                            </button>
                            <button class="share-btn twitter" onclick="shareOnTwitter('{{ $job->job_title }}')">
                                <i class="fab fa-twitter"></i>
                                Twitter
                            </button>
                            <button class="share-btn linkedin" onclick="shareOnLinkedIn('{{ $job->job_title }}')">
                                <i class="fab fa-linkedin-in"></i>
                                LinkedIn
                            </button>
                            <button class="share-btn email" onclick="shareViaEmail('{{ $job->job_title }}')">
                                <i class="fas fa-envelope"></i>
                                Email
                            </button>
                        </div>
                    </div>

                    <!-- Related Jobs Card -->
                    @if (isset($relatedJobs) && $relatedJobs->count() > 0)
                        <div class="sidebar-card related-jobs-card">
                            <h3>Related Jobs</h3>
                            <div class="related-jobs-list">
                                @foreach ($relatedJobs as $relatedJob)
                                    <a href="{{ route('jobs.show', $relatedJob->job_id) }}" class="related-job-item">
                                        <div class="related-job-info">
                                            <h4>{{ $relatedJob->job_title }}</h4>
                                            <p>
                                                <i class="fas fa-map-marker-alt"></i>
                                                {{ $relatedJob->location }}
                                            </p>
                                        </div>
                                        <span class="related-job-type">{{ $relatedJob->category }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script>
        // Scroll to application form
        function scrollToApplication() {
            const element = document.getElementById('application-section');
            if (element) {
                element.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        // Save job functionality
        function saveJob(jobId) {
            // You can implement localStorage or backend save
            let savedJobs = JSON.parse(localStorage.getItem('savedJobs') || '[]');

            if (!savedJobs.includes(jobId)) {
                savedJobs.push(jobId);
                localStorage.setItem('savedJobs', JSON.stringify(savedJobs));
                showNotification('Job saved successfully!', 'success');

                // Update button state
                const btn = event.target.closest('.btn-save');
                btn.innerHTML = '<i class="fas fa-bookmark"></i> Saved';
                btn.classList.add('saved');
            } else {
                showNotification('Job already saved!', 'info');
            }
        }

        // Share job functionality
        function shareJob(jobId, jobTitle) {
            const url = window.location.href;

            if (navigator.share) {
                navigator.share({
                    title: jobTitle + ' - Habari Recruitment',
                    text: 'Check out this job opportunity',
                    url: url
                }).catch(err => console.log('Share cancelled'));
            } else {
                navigator.clipboard.writeText(url).then(() => {
                    showNotification('Job link copied to clipboard!', 'success');
                });
            }
        }

        // Social sharing functions
        function shareOnFacebook(jobTitle) {
            const url = encodeURIComponent(window.location.href);
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
        }

        function shareOnTwitter(jobTitle) {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent(`Check out this job: ${jobTitle}`);
            window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
        }

        function shareOnLinkedIn(jobTitle) {
            const url = encodeURIComponent(window.location.href);
            window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank', 'width=600,height=400');
        }

        function shareViaEmail(jobTitle) {
            const subject = encodeURIComponent(`Job Opportunity: ${jobTitle}`);
            const body = encodeURIComponent(`I found this job that might interest you:\n\n${window.location.href}`);
            window.location.href = `mailto:?subject=${subject}&body=${body}`;
        }

        // File upload handling
        document.getElementById('resume')?.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Choose file or drag here';
            document.querySelector('.file-name').textContent = fileName;
        });

        // Check if job is already saved
        window.addEventListener('DOMContentLoaded', function() {
            const jobId = {{ $job->job_id }};
            const savedJobs = JSON.parse(localStorage.getItem('savedJobs') || '[]');

            if (savedJobs.includes(jobId)) {
                const btn = document.querySelector('.btn-save');
                if (btn) {
                    btn.innerHTML = '<i class="fas fa-bookmark"></i> Saved';
                    btn.classList.add('saved');
                }
            }
        });

        // Notification function
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => notification.classList.add('show'), 100);
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => document.body.removeChild(notification), 300);
            }, 3000);
        }
    </script>
@endsection
