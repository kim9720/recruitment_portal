@php
    use Vinkla\Hashids\Facades\Hashids;
    $hashId = Hashids::encode($vacancy->job_id);
@endphp

@extends('layouts.app')
@section('title', 'Job Details')

<link rel="stylesheet" href="{{ asset('pagestyles/vacancy_details.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
    <div class="content-area">
        <!-- Breadcrumb & Back Button -->
        <div class="page-navigation">
            <a href="{{ route('candidate.vacancies.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Vacancies
            </a>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <span class="separator">/</span>
                <a href="{{ route('candidate.vacancies.index') }}">Vacancies</a>
                <span class="separator">/</span>
                <span class="current">{{ $vacancy->job_title }}</span>
            </nav>
        </div>

        <!-- Job Header Card -->
        <div class="job-header-card">
            <div class="job-header-content">
                <div class="job-icon-wrapper">
                    <div class="job-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                </div>
                <div class="job-header-info">
                    {{-- <div class="job-ref">Ref: #{{ str_pad($vacancy->job_id, 6, '0', STR_PAD_LEFT) }}</div> --}}
                    <h1 class="job-title">{{ $vacancy->job_title }}</h1>
                    <div class="job-meta">
                        <span class="meta-item">
                            <i class="fas fa-building"></i>
                            {{ $vacancy->category ?? 'General' }}
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $vacancy->location ?? 'Not Specified' }}
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-clock"></i>
                            {{ $vacancy->jobfunction ?? 'Full Time' }}
                        </span>
                    </div>
                </div>
            </div>

            @php
                $deadline = \Carbon\Carbon::parse($vacancy->deadline);
                $daysLeft = (int)now()->diffInDays($deadline, false);
                $isExpired = $daysLeft < 0;
            @endphp

            <div class="job-header-actions">
                <div
                    class="deadline-card {{ $daysLeft < 7 && !$isExpired ? 'urgent' : ($isExpired ? 'expired' : 'safe') }}">
                    <div class="deadline-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="deadline-info">
                        <div class="deadline-label">Application Deadline</div>
                        <div class="deadline-date">{{ $deadline->format('M d, Y') }}</div>
                        @if (!$isExpired)
                            <div class="deadline-countdown">{{ $daysLeft }} {{ $daysLeft == 1 ? 'day' : 'days' }}
                                remaining</div>
                        @else
                            <div class="deadline-countdown">Expired</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Details Grid -->
        <div class="job-details-grid">
            <!-- Main Content -->
            <div class="job-main-content">
                <!-- Job Introduction -->
                @if ($vacancy->introduction)
                    <section class="content-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h2 class="section-title">About the Position</h2>
                        </div>
                        <div class="section-content">
                            <p>{!! $vacancy->introduction !!}</p>
                        </div>
                    </section>
                @endif

                <!-- Key Responsibilities -->
                @if ($vacancy->responsibilities)
                    <section class="content-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <h2 class="section-title">Key Responsibilities</h2>
                        </div>
                        <div class="section-content">
                            <p>{!! $vacancy->responsibilities !!}</p>
                        </div>
                    </section>
                @endif

                <!-- Required Skills -->
                @if ($vacancy->skillset)
                    <section class="content-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <h2 class="section-title">Required Skills & Qualifications</h2>
                        </div>
                        <div class="section-content">
                            <p>{!! $vacancy->skillset !!}</p>
                        </div>
                    </section>
                @endif

                <!-- Bottom Apply Button -->
                @if ($vacancy->status == 1 && !$isExpired)
                    <section class="bottom-apply-section">
                        <div class="bottom-apply-content">
                            <div class="bottom-apply-info">
                                {{-- <h3 class="bottom-apply-title">Ready to Take the Next Step?</h3>
                                <p class="bottom-apply-text">
                                    Submit your application now and join our team. Don't miss this opportunity to advance
                                    your career!
                                </p> --}}
                            </div>
                            <button class="btn-apply-bottom" onclick="openApplicationModal()">
                                <i class="fas fa-paper-plane"></i>
                                Apply for this Position
                            </button>
                        </div>
                    </section>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="job-sidebar">
                <!-- Job Overview Card -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Job Overview</h3>
                    <div class="overview-list">
                        <div class="overview-item">
                            <div class="overview-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="overview-content">
                                <div class="overview-label">Minimum Qualification</div>
                                <div class="overview-value">{{ $vacancy->minimumqualification ?? 'Not Specified' }}</div>
                            </div>
                        </div>

                        <div class="overview-item">
                            <div class="overview-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="overview-content">
                                <div class="overview-label">Experience Required</div>
                                <div class="overview-value">
                                    @if ($vacancy->experiencelenght == 0)
                                        Fresh Graduate
                                    @elseif($vacancy->experiencelenght == 1)
                                        1 Year
                                    @else
                                        {{ $vacancy->experiencelenght }} Years
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="overview-item">
                            <div class="overview-icon">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <div class="overview-content">
                                <div class="overview-label">Posted On</div>
                                <div class="overview-value">{{ $vacancy->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <!-- Apply Card -->
                @if ($vacancy->status == 1 && !$isExpired)
                    <div class="sidebar-card apply-card">
                        <div class="apply-card-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h3 class="apply-card-title">Ready to Apply?</h3>
                        <p class="apply-card-text">
                            Submit your application now and take the next step in your career journey.
                        </p>
                        <button class="btn-apply-sidebar" onclick="openApplicationModal()">
                            <i class="fas fa-paper-plane"></i>
                            Apply Now
                        </button>
                    </div>
                @endif --}}

                <!-- Share Card -->
                {{-- <div class="sidebar-card share-card">
                    <h3 class="sidebar-title">Share this Job</h3>
                    <div class="share-buttons">
                        <button class="share-btn facebook" title="Share on Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </button>
                        <button class="share-btn twitter" title="Share on Twitter">
                            <i class="fab fa-twitter"></i>
                        </button>
                        <button class="share-btn linkedin" title="Share on LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </button>
                        <button class="share-btn whatsapp" title="Share on WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </button>
                        <button class="share-btn link" title="Copy Link" onclick="copyJobLink()">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    <!-- Application Modal -->
    <div id="applicationModal" class="modal">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h2 class="modal-title">
                    <i class="fas fa-file-upload"></i>
                    Submit Your Application
                </h2>
                <button class="modal-close" onclick="closeApplicationModal()">&times;</button>
            </div>
            <form action="{{ route('candidate.vacancies.apply', $hashId) }}" method="POST"
                enctype="multipart/form-data" id="applicationForm">
                @csrf
                <div class="modal-body">
                    <!-- Application Info -->
                    <div class="application-info">
                        <div class="info-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="info-content">
                            <h4>Application for: {{ $vacancy->job_title }}</h4>
                            <p>Please upload your signed application letter in PDF format. Make sure all information is
                                accurate and complete.</p>
                        </div>
                    </div>

                    <!-- File Upload Section -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-file-pdf"></i>
                            Signed Application Letter *
                        </label>
                        <div class="file-upload-wrapper">
                            <input type="file" name="application_letter" id="applicationLetter" class="file-input"
                                accept=".pdf" required onchange="updateFileName()">
                            <label for="applicationLetter" class="file-label">
                                <div class="file-label-content">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span id="fileNameDisplay">Click to upload or drag and drop</span>
                                    <small>PDF file (Max size: 1MB)</small>
                                </div>
                            </label>
                        </div>
                        <div class="file-requirements">
                            <div class="requirement-item">
                                <i class="fas fa-check-circle"></i>
                                <span>File must be in PDF format</span>
                            </div>
                            <div class="requirement-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Maximum file size: 1MB</span>
                            </div>
                            <div class="requirement-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Document must be signed</span>
                            </div>
                        </div>
                    </div>



                    <!-- Expected Salary -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-money-bill-wave"></i>
                            Expected Salary
                        </label>
                        <input type="number" name="expected_salary" class="form-input"
                            placeholder="Enter your expected salary in TZS" min="0" step="1000">
                    </div>

                    <!-- Confirmation -->
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="confirmation" required>
                            <span>I confirm that all information provided is accurate and I meet the requirements for this
                                position.</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeApplicationModal()">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openApplicationModal() {
            document.getElementById('applicationModal').style.display = 'block';
            setTimeout(() => {
                document.querySelector('.modal-content').style.transform = 'scale(1)';
                document.querySelector('.modal-content').style.opacity = '1';
            }, 10);
        }

        function closeApplicationModal() {
            document.querySelector('.modal-content').style.transform = 'scale(0.9)';
            document.querySelector('.modal-content').style.opacity = '0';
            setTimeout(() => {
                document.getElementById('applicationModal').style.display = 'none';
                document.getElementById('applicationForm').reset();
                document.getElementById('fileNameDisplay').innerHTML = 'Click to upload or drag and drop';
            }, 300);
        }

        function updateFileName() {
            const fileInput = document.getElementById('applicationLetter');
            const fileNameDisplay = document.getElementById('fileNameDisplay');

            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const fileName = file.name;
                const fileSize = (file.size / 1024 / 1024).toFixed(2);

                fileNameDisplay.innerHTML = `
            <strong style="color: #28a745;">${fileName}</strong><br>
            <small>Size: ${fileSize} MB</small>
        `;
            } else {
                fileNameDisplay.innerHTML = 'Click to upload or drag and drop';
            }
        }

        function copyJobLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                Swal.fire({
                    title: 'Link Copied!',
                    text: 'Job link has been copied to clipboard',
                    icon: 'success',
                    confirmButtonColor: '#262261',
                    timer: 2000
                });
            });
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('applicationModal');
            if (event.target == modal) {
                closeApplicationModal();
            }
        }

        // Drag and drop functionality
        const fileInput = document.getElementById('applicationLetter');
        const fileLabel = document.querySelector('.file-label');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileLabel.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            fileLabel.addEventListener(eventName, () => {
                fileLabel.classList.add('drag-active');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fileLabel.addEventListener(eventName, () => {
                fileLabel.classList.remove('drag-active');
            }, false);
        });

        fileLabel.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            updateFileName();
        }, false);

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
