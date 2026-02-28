@extends('layouts.app')
@section('title', 'Review Application')

<link rel="stylesheet" href="{{ asset('pagestyles/application_review.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
    <div class="content-area">
        <!-- Page Header -->
        <div class="page-navigation">
            <a href="{{ route('applications.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Applications
            </a>
            <div class="application-status-badge status-pending">
                <i class="fas fa-clock"></i> Pending Review
            </div>
        </div>

        <!-- Candidate Profile Card -->
        <div class="candidate-profile-card">
            <div class="profile-header">
                <div class="profile-avatar-large">
                    <img src="{{ $application->candidateProfile->profile_photo }}" alt="Candidate Photo"
                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                </div>
                <div class="profile-info">
                    <h1 class="candidate-name">{{ $application->candidateProfile->full_name }}</h1>
                    <div class="candidate-meta">
                        <span class="meta-item">
                            <i class="fas fa-envelope"></i>
                            {{ $application->user->email }}
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-phone"></i>
                            {{ $application->candidateProfile->mobile }}
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $application->candidateProfile->address }}
                        </span>
                    </div>
                </div>
                <div class="profile-actions">
                    <div class="application-date">
                        <i class="fas fa-calendar"></i>
                        Applied: {{ $application->created_at->format('F d, Y') }}
                    </div>
                </div>
            </div>

            <div class="position-applied">
                <div class="position-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="position-details">
                    <div class="position-label">Position Applied For</div>
                    <div class="position-title">{{ $application->job->job_title }}</div>
                    {{-- <div class="position-ref">Ref: #000123</div> --}}
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="review-content-grid">
            <!-- Documents Section -->
            <div class="documents-section">
                <!-- Document Tabs -->
                <div class="document-tabs-card">
                    <div class="tabs-header">
                        <h3 class="tabs-title">
                            <i class="fas fa-folder-open"></i>
                            Candidate Documents
                        </h3>
                    </div>

                    <div class="document-tabs">
                        <button class="tab-btn active" onclick="showDocument('application-letter')">
                            <i class="fas fa-file-alt"></i>
                            <span>Application Letter</span>
                        </button>
                        <button class="tab-btn" onclick="showDocument('cv')">
                            <i class="fas fa-file-pdf"></i>
                            <span>CV</span>
                        </button>
                        <button class="tab-btn" onclick="showDocument('education')">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Education</span>
                        </button>
                        <button class="tab-btn" onclick="showDocument('nida')">
                            <i class="fas fa-id-card"></i>
                            <span>NIDA</span>
                        </button>
                        <button class="tab-btn" onclick="showDocument('birth-certificate')">
                            <i class="fas fa-certificate"></i>
                            <span>Birth Certificate</span>
                        </button>
                    </div>
                </div>

                <!-- Document Viewer -->
                <div class="document-viewer-card">
                    <div class="viewer-header">
                        <div class="viewer-title" id="viewerTitle">
                            <i class="fas fa-file-alt"></i>
                            Application Letter
                        </div>
                        <div class="viewer-actions">
                            <button class="btn-viewer-action" title="Download"
                                onclick="downloadDocument('application-letter')">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn-viewer-action" title="Print" onclick="printDocument('application-letter')">
                                <i class="fas fa-print"></i>
                            </button>
                            <button class="btn-viewer-action" title="Fullscreen"
                                onclick="toggleFullscreen('documentViewer')">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>

                    <div class="document-viewer" id="documentViewer">
                        <!-- Application Letter Content -->
                        <div class="document-content active" id="application-letter">
                            <iframe id="iframe-application-letter" class="pdf-iframe" src=""
                                style="display: none;"></iframe>
                            <div class="document-placeholder" id="placeholder-application-letter">
                                <i class="fas fa-file-alt"></i>
                                <h3>Application Letter</h3>
                                <p>The candidate's application letter will be displayed here.</p>
                                <button class="btn-load-document" onclick="loadDocument('application-letter')">
                                    <i class="fas fa-eye"></i>
                                    Load Document
                                </button>
                            </div>
                        </div>

                        <!-- CV Content -->
                        <div class="document-content" id="cv">
                            <iframe id="iframe-cv" class="pdf-iframe" src="" style="display: none;"></iframe>
                            <div class="document-placeholder" id="placeholder-cv">
                                <i class="fas fa-file-pdf"></i>
                                <h3>Curriculum Vitae</h3>
                                <p>The candidate's CV will be displayed here.</p>
                                <button class="btn-load-document" onclick="loadDocument('cv')">
                                    <i class="fas fa-eye"></i>
                                    Load Document
                                </button>
                            </div>
                        </div>

                        <!-- Education Content -->
                        <div class="document-content" id="education">
                            <div class="education-links">
                                @forelse ($application->candidateProfile->educationCertificateLinks() as $edu)
                                    <button class="edu-link-btn"
                                        onclick="loadEducationDocument('{{ $edu['url'] }}', '{{ $edu['label'] }}')">
                                        <i class="fas fa-file-pdf"></i>
                                        {{ $edu['label'] }}
                                    </button>

                                @empty
                                    <p>No education certificates available.</p>
                                @endforelse
                            </div>

                            <div class="document-viewer-inner">
                                <iframe id="iframe-education" class="pdf-iframe" src=""
                                    style="display: none;"></iframe>
                                <div class="document-placeholder" id="placeholder-education" style="display: block;">
                                    <i class="fas fa-graduation-cap"></i>
                                    <h3>Education Certificates</h3>
                                    <p>Select a certificate from above to view it here.</p>
                                </div>
                            </div>
                        </div>

                        <!-- NIDA Content -->
                        <div class="document-content" id="nida">
                            <iframe id="iframe-nida" class="pdf-iframe" src="" style="display: none;"></iframe>
                            <div class="document-placeholder" id="placeholder-nida">
                                <i class="fas fa-id-card"></i>
                                <h3>National ID (NIDA)</h3>
                                <p>The candidate's National ID will be displayed here.</p>
                                <button class="btn-load-document" onclick="loadDocument('nida')">
                                    <i class="fas fa-eye"></i>
                                    Load Document
                                </button>
                            </div>
                        </div>

                        <!-- Birth Certificate Content -->
                        <div class="document-content" id="birth-certificate">
                            <iframe id="iframe-birth-certificate" class="pdf-iframe" src=""
                                style="display: none;"></iframe>
                            <div class="document-placeholder" id="placeholder-birth-certificate">
                                <i class="fas fa-certificate"></i>
                                <h3>Birth Certificate</h3>
                                <p>The candidate's birth certificate will be displayed here.</p>
                                <button class="btn-load-document" onclick="loadDocument('birth-certificate')">
                                    <i class="fas fa-eye"></i>
                                    Load Document
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="review-sidebar">
                <!-- Experience Summary -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="fas fa-briefcase"></i>
                        Experience Summary
                    </h3>
                    <div class="experience-list">
                        @foreach ($application->candidateProfile->experiences as $experience)
                            <div class="experience-item">
                                <div class="exp-company">{{ $experience->company_name }}</div>
                                <div class="exp-role">{{ $experience->role }}</div>
                                <div class="exp-duration">
                                    <i class="fas fa-clock"></i>
                                    ({{ floor($experience->months / 12) }}
                                    {{ floor($experience->months / 12) == 1 ? 'year' : 'years' }}
                                    @if ($experience->months % 12 > 0)
                                        {{ $experience->months % 12 }}
                                        {{ $experience->months % 12 == 1 ? 'month' : 'months' }}
                                    @endif)
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Education Summary -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="fas fa-graduation-cap"></i>
                        Education
                    </h3>
                    <div class="education-list">
                        <div class="education-item">
                            <div class="edu-degree">{{ $application->candidateProfile->latestEducation->educationlevel }}
                            </div>
                            <div class="edu-field">{{ $application->candidateProfile->latestEducation->specialization }}
                            </div>
                            <div class="edu-institution">{{ $application->candidateProfile->latestEducation->institute }}
                            </div>
                            <div class="edu-year">
                                {{ \Carbon\Carbon::parse($application->candidateProfile->latestEducation->educationenddate)->year }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <!-- Skills -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="fas fa-star"></i>
                        Key Skills
                    </h3>
                    <div class="skills-list">
                        <span class="skill-tag">Python</span>
                        <span class="skill-tag">Laravel</span>
                        <span class="skill-tag">React</span>
                        <span class="skill-tag">MySQL</span>
                        <span class="skill-tag">Docker</span>
                        <span class="skill-tag">AWS</span>
                    </div>
                </div> --}}
            </div>
        </div>

        <!-- Decision Actions -->
        <div class="decision-actions-card">
            <div class="decision-content">
                <div class="decision-info">
                    <h3 class="decision-title">Review Application</h3>
                    <p class="decision-text">Make your decision on this candidate's application</p>
                </div>
                <div class="decision-buttons">
                    <button class="btn-decision btn-reject" onclick="rejectApplication({{ $application->id }})">
                        <i class="fas fa-times-circle"></i>
                        Reject Application
                    </button>
                    <button class="btn-decision btn-shortlist" onclick="shortlistApplication({{ $application->id }})">
                        <i class="fas fa-check-circle"></i>
                        Add to Shortlist
                    </button>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        <div class="notes-section-card">
            <div class="notes-header">
                <h3 class="notes-title">
                    <i class="fas fa-sticky-note"></i>
                    Reviewer Notes
                </h3>
            </div>
            <div class="notes-content">
                <textarea class="notes-textarea" placeholder="Add your notes about this candidate here..."></textarea>
                <button class="btn-save-notes">
                    <i class="fas fa-save"></i>
                    Save Notes
                </button>
            </div>
        </div>
    </div>

    <script>
        // Document URLs - Updated for application letter using model accessor
        // For other documents, adjust based on your CandidateProfile model (e.g., $application->candidateProfile->cv_path)
        // Example: Add similar accessors like cvUrl() in CandidateProfile if needed
        const documentUrls = {
            'application-letter': '{{ $application->cover_letter ? $application->applicationLetterUrl() : '' }}',
            'cv': '{{ isset($application->candidateProfile->cv_url) ? $application->candidateProfile->cv_url : '' }}', // Adjust field name as per model
            'nida': '{{ isset($application->candidateProfile->nida_url) ? $application->candidateProfile->nida_url : '' }}', // Placeholder; adjust
            'birth-certificate': '{{ isset($application->candidateProfile->birth_certificate_url) ? $application->candidateProfile->birth_certificate_url : '' }}' // Placeholder; adjust
            // Note: 'education' is handled separately with multiple URLs, so not included here
        };

        function showDocument(docId) {
            // Remove active class from all tabs
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Remove active class from all documents
            document.querySelectorAll('.document-content').forEach(doc => {
                doc.classList.remove('active');
            });

            // Add active class to clicked tab
            event.target.closest('.tab-btn').classList.add('active');

            // Show selected document
            document.getElementById(docId).classList.add('active');

            // Update viewer title
            const titles = {
                'application-letter': 'Application Letter',
                'cv': 'Curriculum Vitae',
                'education': 'Education Certificates',
                'nida': 'National ID (NIDA)',
                'birth-certificate': 'Birth Certificate'
            };

            const icons = {
                'application-letter': 'fa-file-alt',
                'cv': 'fa-file-pdf',
                'education': 'fa-graduation-cap',
                'nida': 'fa-id-card',
                'birth-certificate': 'fa-certificate'
            };

            document.getElementById('viewerTitle').innerHTML = `
                <i class="fas ${icons[docId]}"></i>
                ${titles[docId]}
            `;

            // For education tab, ensure placeholder is visible and iframe hidden on tab switch
            if (docId === 'education') {
                document.getElementById('iframe-education').style.display = 'none';
                document.getElementById('placeholder-education').style.display = 'block';
            }

            // Auto-load document if URL exists (optional: remove if you want manual load only)
            // Skip for education since it has multiple docs
            if (documentUrls[docId] && documentUrls[docId] !== '' && docId !== 'education') {
                loadDocument(docId);
            }
        }

        function loadDocument(docId) {
            const url = documentUrls[docId];
            if (!url || url === '') {
                Swal.fire({
                    title: 'Document Not Available',
                    text: 'This document has not been uploaded by the candidate.',
                    icon: 'warning',
                    confirmButtonColor: '#262261'
                });
                return;
            }

            const iframe = document.getElementById('iframe-' + docId);
            const placeholder = document.getElementById('placeholder-' + docId);

            iframe.src = url + '#view=FitH'; // Optional: Fit to width for better PDF display
            iframe.style.display = 'block';
            placeholder.style.display = 'none';

            // Optional: Show loading indicator
            iframe.onload = function() {
                // PDF loaded successfully
            };
            iframe.onerror = function() {
                Swal.fire({
                    title: 'Error Loading Document',
                    text: 'Unable to load the document. Please try downloading it instead.',
                    icon: 'error',
                    confirmButtonColor: '#262261'
                });
                iframe.style.display = 'none';
                placeholder.style.display = 'block';
            };
        }

        function loadEducationDocument(url, label) {
            if (!url || url === '') {
                Swal.fire({
                    title: 'Document Not Available',
                    text: 'This document could not be loaded.',
                    icon: 'warning',
                    confirmButtonColor: '#262261'
                });
                return;
            }

            const iframe = document.getElementById('iframe-education');
            const placeholder = document.getElementById('placeholder-education');

            // Update viewer title dynamically for the selected document
            document.getElementById('viewerTitle').innerHTML = `
                <i class="fas fa-graduation-cap"></i>
                ${label || 'Education Certificate'}
            `;

            iframe.src = url + '#view=FitH';
            iframe.style.display = 'block';
            placeholder.style.display = 'none';

            iframe.onload = function() {
                // PDF loaded successfully
            };
            iframe.onerror = function() {
                Swal.fire({
                    title: 'Error Loading Document',
                    text: 'Unable to load the document. Please try downloading it instead.',
                    icon: 'error',
                    confirmButtonColor: '#262261'
                });
                iframe.style.display = 'none';
                placeholder.style.display = 'block';
            };
        }

        function downloadDocument(docId) {
            let url;
            if (docId === 'education') {
                // For education, we need to handle the current loaded URL or prompt selection
                const iframe = document.getElementById('iframe-education');
                if (iframe.src && iframe.src !== '') {
                    url = iframe.src.replace('#view=FitH', '');
                } else {
                    Swal.fire({
                        title: 'No Document Loaded',
                        text: 'Please load a document first to download.',
                        icon: 'warning',
                        confirmButtonColor: '#262261'
                    });
                    return;
                }
            } else {
                url = documentUrls[docId];
                if (!url || url === '') {
                    Swal.fire({
                        title: 'Document Not Available',
                        text: 'This document has not been uploaded.',
                        icon: 'warning',
                        confirmButtonColor: '#262261'
                    });
                    return;
                }
            }
            window.open(url, '_blank');
        }

        function printDocument(docId) {
            let iframe;
            if (docId === 'education') {
                iframe = document.getElementById('iframe-education');
            } else {
                iframe = document.getElementById('iframe-' + docId);
            }
            if (iframe && iframe.src) {
                iframe.contentWindow.print();
            } else {
                Swal.fire({
                    title: 'Load Document First',
                    text: 'Please load the document before printing.',
                    icon: 'info',
                    confirmButtonColor: '#262261'
                });
            }
        }

        function toggleFullscreen(elementId) {
            const element = document.getElementById(elementId);
            if (!document.fullscreenElement) {
                element.requestFullscreen().catch(err => {
                    console.error('Error attempting to enable fullscreen:', err);
                });
            } else {
                document.exitFullscreen();
            }
        }

        // function shortlistApplication() {
        //     Swal.fire({
        //         title: 'Add to Shortlist?',
        //         text: 'This candidate will be moved to the shortlisted candidates list.',
        //         icon: 'question',
        //         showCancelButton: true,
        //         confirmButtonColor: '#28a745',
        //         cancelButtonColor: '#6c757d',
        //         confirmButtonText: '<i class="fas fa-check-circle"></i> Yes, Shortlist',
        //         cancelButtonText: 'Cancel'

        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             // TODO: Add AJAX call to shortlist the application
        //             Swal.fire({
        //                 title: 'Shortlisted!',
        //                 text: 'Candidate has been added to the shortlist successfully.',
        //                 icon: 'success',
        //                 confirmButtonColor: '#262261'
        //             });
        //         }
        //     });
        // }
        function shortlistApplication(applicationId) {
            Swal.fire({
                title: 'Add to Shortlist?',
                text: 'This candidate will be moved to the shortlisted candidates list.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-check-circle"></i> Yes, Shortlist',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {

                    fetch("{{ route('applications.update_status', ':id') }}".replace(':id', applicationId), {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                status: 'shortlisted'
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Shortlisted!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonColor: '#262261'
                                }).then(() => {
                                    location.reload(); // optional
                                });
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Something went wrong', 'error');
                        });
                }
            });
        }

        function rejectApplication(applicationId) {
            Swal.fire({
                title: 'Reject Application?',
                text: 'Are you sure you want to reject this application? This action cannot be undone.',
                icon: 'warning',
                input: 'textarea',
                inputLabel: 'Rejection Reason (Optional)',
                inputPlaceholder: 'Enter reason for rejection...',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-times-circle"></i> Yes, Reject',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {

                    fetch("{{ route('applications.update_status', ':id') }}".replace(':id', applicationId), {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                status: 'rejected',
                                reject_reason: result.value // 👈 from textarea
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Rejected!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonColor: '#262261'
                                }).then(() => {
                                    location.reload(); // optional
                                });
                            } else {
                                Swal.fire('Failed', data.message ?? 'Unable to reject application', 'warning');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Something went wrong', 'error');
                        });
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

    <style>
        .pdf-iframe {
            width: 100%;
            height: 100vh;
            /* Adjust height as needed, e.g., 80vh */
            border: none;
            min-height: 600px;
        }

        .document-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            padding: 40px;
        }

        .document-placeholder h3 {
            margin: 10px 0;
            color: #333;
        }

        .document-placeholder p {
            margin-bottom: 20px;
            color: #666;
        }

        .btn-load-document {
            background: #262261;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-load-document:hover {
            background: #1e1a4a;
        }

        .education-links {
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
            background: #f9f9f9;
        }

        .edu-link-btn {
            background: #262261;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 10px;
            display: inline-block;
            text-align: left;
            width: auto;
            min-width: 200px;
        }

        .edu-link-btn:hover {
            background: #1e1a4a;
        }

        .edu-link-btn i {
            margin-right: 8px;
        }

        .document-viewer-inner {
            position: relative;
            height: 100%;
            min-height: 600px;
        }
    </style>
@endsection
