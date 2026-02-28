@extends('layouts.app')
@section('title', 'Candidate Profile')

<link rel="stylesheet" href="{{ asset('pagestyles/candidate-show.css') }}">

@section('content')
    <div class="cv-wrapper">
        <!-- Action Bar -->
        <div class="cv-action-bar">
            <a href="{{ route('candidate.index') }}" class="action-btn back-btn">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <div class="action-buttons">
                <button class="action-btn print-btn" onclick="window.print()">
                    <i class="fas fa-print"></i> Print CV
                </button>
                @if($candidate->resumefile)
                <a href="{{ asset('storage/' . $candidate->resumefile) }}" class="action-btn download-btn" download>
                    <i class="fas fa-download"></i> Download PDF
                </a>
                @endif
                <a href="mailto:{{ $candidate->email }}" class="action-btn email-btn">
                    <i class="fas fa-envelope"></i> Email
                </a>
            </div>
        </div>

        <!-- CV Document Container -->
        <div class="cv-document">
            <!-- CV Header -->
            <div class="cv-header">
                <div class="cv-header-left">
                    {{-- <div class="cv-avatar">
                        {{ substr($candidate->first_name, 0, 1) }}{{ substr($candidate->last_name, 0, 1) }}
                    </div> --}}
                </div>
                <div class="cv-header-center">
                    <h1 class="cv-name">{{ $candidate->full_name }}</h1>
                    <p class="cv-title">{{ $candidate->applied_for ?? 'Professional Candidate' }}</p>
                    <div class="cv-contact-bar">
                        <span class="cv-contact-item">
                            <i class="fas fa-envelope"></i> {{ $candidate->email }}
                        </span>
                        <span class="cv-contact-item">
                            <i class="fas fa-phone"></i> {{ $candidate->mobile }}
                        </span>
                        <span class="cv-contact-item">
                            <i class="fas fa-map-marker-alt"></i> {{ $candidate->city ?? $candidate->address }}
                        </span>
                    </div>
                </div>
                <div class="cv-header-right">
                    <div class="cv-qr-placeholder">
                        <!-- QR Code could go here -->
                        <div class="status-indicator">
                            <span class="status-dot"></span>
                            <span>Available</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CV Body -->
            <div class="cv-body">
                <!-- Left Column: Main Content -->
                <div class="cv-main-column">

                    <!-- Professional Summary -->
                    @if($candidate->expectations)
                    <section class="cv-section">
                        <h2 class="cv-section-title">
                            <span class="section-icon"><i class="fas fa-user-tie"></i></span>
                            Professional Summary
                        </h2>
                        <div class="cv-section-content">
                            <p class="summary-text">{{ $candidate->expectations }}</p>
                        </div>
                    </section>
                    @endif

                    <!-- Work Experience -->
                    <section class="cv-section">
                        <h2 class="cv-section-title">
                            <span class="section-icon"><i class="fas fa-briefcase"></i></span>
                            Work Experience
                        </h2>
                        <div class="cv-section-content">
                            @forelse($candidate->experiences as $experience)
                                <div class="cv-experience-item">
                                    <div class="experience-header">
                                        <div class="experience-title-block">
                                            <h3 class="experience-title">{{ $experience->role }}</h3>
                                            <p class="experience-company">{{ $experience->company_name }}</p>
                                        </div>
                                        <div class="experience-date">
                                            {{ $experience->startdate ? \Carbon\Carbon::parse($experience->startdate)->format('M Y') : 'N/A' }}
                                            -
                                            {{ $experience->enddate ? \Carbon\Carbon::parse($experience->enddate)->format('M Y') : 'Present' }}
                                        </div>
                                    </div>
                                    <p class="experience-duration">
                                        <i class="far fa-clock"></i>
                                        {{ $experience->months }} months
                                        @if($experience->months >= 12)
                                            ({{ floor($experience->months / 12) }} {{ floor($experience->months / 12) == 1 ? 'year' : 'years' }}
                                            @if($experience->months % 12 > 0)
                                                {{ $experience->months % 12 }} {{ ($experience->months % 12) == 1 ? 'month' : 'months' }}
                                            @endif)
                                        @endif
                                    </p>
                                </div>
                            @empty
                                <p class="cv-empty-state">No work experience listed</p>
                            @endforelse
                        </div>
                    </section>

                    <!-- Education -->
                    <section class="cv-section">
                        <h2 class="cv-section-title">
                            <span class="section-icon"><i class="fas fa-graduation-cap"></i></span>
                            Education
                        </h2>
                        <div class="cv-section-content">
                            @forelse($candidate->educations as $education)
                                <div class="cv-education-item">
                                    <div class="education-header">
                                        <div class="education-title-block">
                                            <h3 class="education-degree">{{ $education->educationlevel }}</h3>
                                            <p class="education-institution">{{ $education->institute }}</p>
                                            @if($education->specialization)
                                                <p class="education-field">{{ $education->specialization }}</p>
                                            @endif
                                        </div>
                                        <div class="education-date">
                                            {{ $education->educationstartdate ? \Carbon\Carbon::parse($education->educationstartdate)->format('Y') : '' }}
                                            -
                                            {{ $education->educationenddate ? \Carbon\Carbon::parse($education->educationenddate)->format('Y') : 'Present' }}
                                        </div>
                                    </div>
                                    @if($education->score)
                                        <p class="education-grade">
                                            <i class="fas fa-award"></i> Grade: {{ $education->score }}
                                        </p>
                                    @endif
                                </div>
                            @empty
                                <p class="cv-empty-state">No education records listed</p>
                            @endforelse
                        </div>
                    </section>

                    <!-- References -->
                    @if($candidate->referees->count() > 0)
                    <section class="cv-section">
                        <h2 class="cv-section-title">
                            <span class="section-icon"><i class="fas fa-user-friends"></i></span>
                            Professional References
                        </h2>
                        <div class="cv-section-content">
                            <div class="references-grid">
                                @foreach($candidate->referees as $referee)
                                    <div class="reference-item">
                                        <h4 class="reference-name">{{ $referee->refereename ?? 'N/A' }}</h4>
                                        <p class="reference-position">{{ $referee->title ?? 'Position' }}</p>
                                        <p class="reference-company">{{ $referee->organisation ?? 'Company' }}</p>
                                        <div class="reference-contact">
                                            @if($referee->refereeemail)
                                                <span><i class="fas fa-envelope"></i> {{ $referee->refereeemail }}</span>
                                            @endif
                                            @if($referee->telephone)
                                                <span><i class="fas fa-phone"></i> {{ $referee->telephone }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                    @endif

                </div>

                <!-- Right Column: Sidebar -->
                <div class="cv-sidebar">

                    <!-- Personal Details -->
                    <section class="cv-sidebar-section">
                        <h3 class="sidebar-title">Personal Details</h3>
                        <div class="sidebar-content">
                            <div class="detail-item">
                                <span class="detail-label">Gender</span>
                                <span class="detail-value">{{ ucfirst($candidate->gender) }}</span>
                            </div>
                            @if($candidate->reg_country)
                            <div class="detail-item">
                                <span class="detail-label">Nationality</span>
                                <span class="detail-value">{{ $candidate->reg_country }}</span>
                            </div>
                            @endif
                            @if($candidate->pin)
                            <div class="detail-item">
                                <span class="detail-label">PIN</span>
                                <span class="detail-value">{{ $candidate->pin }}</span>
                            </div>
                            @endif
                        </div>
                    </section>

                    <!-- Contact Information -->
                    <section class="cv-sidebar-section">
                        <h3 class="sidebar-title">Contact</h3>
                        <div class="sidebar-content">
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-envelope"></i> Email</span>
                                <span class="detail-value">{{ $candidate->email }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-phone"></i> Mobile</span>
                                <span class="detail-value">{{ $candidate->mobile }}</span>
                            </div>
                            @if($candidate->secondmobile)
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-phone"></i> Alt Phone</span>
                                <span class="detail-value">{{ $candidate->secondmobile }}</span>
                            </div>
                            @endif
                            @if($candidate->landline)
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-phone-square"></i> Landline</span>
                                <span class="detail-value">{{ $candidate->landline }}</span>
                            </div>
                            @endif
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-map-marker-alt"></i> Address</span>
                                <span class="detail-value">{{ $candidate->address }}</span>
                            </div>
                            @if($candidate->city)
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-city"></i> City</span>
                                <span class="detail-value">{{ $candidate->city }}</span>
                            </div>
                            @endif
                        </div>
                    </section>

                    <!-- Professional Info -->
                    <section class="cv-sidebar-section">
                        <h3 class="sidebar-title">Professional Info</h3>
                        <div class="sidebar-content">
                            <div class="detail-item">
                                <span class="detail-label">Total Experience</span>
                                <span class="detail-value highlight">{{ $candidate->formatted_experience }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Highest Qualification</span>
                                <span class="detail-value">{{ $candidate->highqualification }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Applied For</span>
                                <span class="detail-value">{{ $candidate->applied_for ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </section>

                    <!-- Documents -->
                    @if($candidate->documents->count() > 0 || $candidate->resumefile)
                    <section class="cv-sidebar-section">
                        <h3 class="sidebar-title">Attachments</h3>
                        <div class="sidebar-content">
                            @if($candidate->resumefile)
                                <a href="{{ asset('storage/' . $candidate->resumefile) }}" class="document-link" download>
                                    <i class="fas fa-file-pdf"></i> Resume/CV
                                </a>
                            @endif
                            @foreach($candidate->documents as $document)
                                @if($document->file_path)
                                    <a href="{{ asset('storage/' . $document->file_path) }}" class="document-link" download>
                                        <i class="fas fa-file"></i> {{ ucfirst($document->document_type ?? 'Document') }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </section>
                    @endif

                </div>
            </div>

            <!-- CV Footer -->
            <div class="cv-footer">
                <p class="footer-text">
                    <i class="fas fa-calendar"></i>
                    Application Date: {{ $candidate->created_at->format('F d, Y') }}
                    <span class="separator">|</span>
                    Last Updated: {{ $candidate->updated_at->format('F d, Y') }}
                </p>
            </div>
        </div>
    </div>
@endsection
