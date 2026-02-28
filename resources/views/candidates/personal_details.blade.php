@extends('layouts.app')
@section('title', 'Candidate Personal Details')

<link rel="stylesheet" href="{{ asset('pagestyles/candidates.css') }}">

@section('content')
<div class="content-area">
    <div class="content-section">
        <div class="page-header">
            <h1 class="page-title">Personal Details</h1>
            <p class="page-subtitle">Basic candidate information</p>
        </div>

        <div class="candidate-table-container">
            <!-- Header Section -->
            <div class="candidate-table-header">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                    <h2 class="candidate-table-title">Personal Information</h2>
                    <div class="action-buttons">
                        {{-- <a href="{{ route('candidates.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a> --}}
                    </div>
                </div>
            </div>

            <!-- Candidate Profile -->
            <div style="padding: 40px 30px;">
                @if($candidate->first_name || $candidate->last_name || $candidate->email)
                    <!-- Profile Header -->
                    <div style="display: flex; align-items: center; gap: 25px; margin-bottom: 40px; padding-bottom: 30px; border-bottom: 2px solid var(--border-color);">
                        <div class="name-avatar" style="width: 80px; height: 80px; font-size: 32px;">
                            {{ strtoupper(substr($candidate->first_name ?? 'N', 0, 1)) }}{{ strtoupper(substr($candidate->last_name ?? 'A', 0, 1)) }}
                        </div>
                        <div style="flex: 1;">
                            <h2 style="font-size: 2rem; font-weight: 700; color: var(--primary-color); margin-bottom: 8px;">
                                {{ $candidate->first_name ?? 'N/A' }} {{ $candidate->middle_name }} {{ $candidate->last_name ?? 'N/A' }}
                            </h2>
                            <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 12px;">
                                @if($candidate->gender)
                                <span class="gender-badge gender-{{ strtolower($candidate->gender) }}">
                                    <i class="fas fa-user"></i> {{ $candidate->gender }}
                                </span>
                                @endif
                                {{-- @if($candidate->status)
                                <span class="status-badge status-{{ strtolower($candidate->status) }}">
                                    <i class="fas fa-circle" style="font-size: 8px;"></i> {{ $candidate->status }}
                                </span>
                                @endif --}}
                            </div>
                        </div>
                    </div>

                    <!-- Personal Details Grid -->
                    <div class="details-grid">

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-user"></i> First Name
                        </span>
                        <span class="detail-value">{{ $candidate->first_name }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-user"></i> Middle Name
                        </span>
                        <span class="detail-value">{{ $candidate->middle_name ?? 'N/A' }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-user"></i> Last Name
                        </span>
                        <span class="detail-value">{{ $candidate->last_name }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-venus-mars"></i> Gender
                        </span>
                        <span class="detail-value">
                            <span class="gender-badge gender-{{ strtolower($candidate->gender) }}">
                                {{ $candidate->gender }}
                            </span>
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-calendar"></i> Date of Birth
                        </span>
                        <span class="detail-value">{{ $candidate->date_of_birth ? date('F d, Y', strtotime($candidate->date_of_birth)) : 'N/A' }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-heart"></i> Marital Status
                        </span>
                        <span class="detail-value">{{ $candidate->marital_status ?? 'N/A' }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-flag"></i> Nationality
                        </span>
                        <span class="detail-value">{{ $candidate->nationality ?? 'N/A' }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-envelope"></i> Email Address
                        </span>
                        <span class="detail-value">
                            <a href="mailto:{{ $candidate->email }}" style="color: var(--secondary-color); text-decoration: none; font-weight: 600;">
                                {{ $candidate->email }}
                            </a>
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-phone"></i> Phone Number
                        </span>
                        <span class="detail-value">{{ $candidate->phone_number ?? 'N/A' }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-mobile-alt"></i> Alternative Phone
                        </span>
                        <span class="detail-value">{{ $candidate->alternative_phone ?? 'N/A' }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-map-marker-alt"></i> Address
                        </span>
                        <span class="detail-value">{{ $candidate->address ?? 'N/A' }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-city"></i> City
                        </span>
                        <span class="detail-value">{{ $candidate->city ?? 'N/A' }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-id-card"></i> ID Number
                        </span>
                        <span class="detail-value">{{ $candidate->id_number ?? 'N/A' }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-passport"></i> Passport Number
                        </span>
                        <span class="detail-value">{{ $candidate->passport_number ?? 'N/A' }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-info-circle"></i> Status
                        </span>
                        <span class="detail-value">
                            <span class="status-badge status-{{ strtolower($candidate->status) }}">
                                {{ $candidate->status }}
                            </span>
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-calendar-plus"></i> Registration Date
                        </span>
                        <span class="detail-value">{{ date('F d, Y', strtotime($candidate->created_at)) }}</span>
                    </div>

                </div>

                <!-- Edit Button Section -->
                <div style="margin-top: 40px; text-align: center;">
                    <a href="{{ route('candidate.personal_details.edit', $candidate->id) }}" class="btn btn-primary" style="padding: 14px 40px; font-size: 15px;">
                        <i class="fas fa-edit"></i> Edit All Information
                    </a>
                </div>

                @else
                    <!-- No Personal Details -->
                    <div style="text-align: center; padding: 60px 20px;">
                        <div style="font-size: 80px; color: var(--border-color); margin-bottom: 20px;">
                            <i class="fas fa-user-slash"></i>
                        </div>
                        <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--text-muted); margin-bottom: 15px;">
                            No Personal Details Available
                        </h3>
                        <p style="color: var(--text-muted); margin-bottom: 30px; font-size: 15px;">
                            This candidate hasn't added their personal information yet.
                        </p>
                        <a href="{{ route('candidate.personal_details.edit', $candidate->id) }}" class="btn btn-primary" style="padding: 14px 40px; font-size: 15px;">
                            <i class="fas fa-plus"></i> Add Personal Details
                        </a>
                    </div>
                @endif

                <!-- Additional Notes Section -->
                @if($candidate->notes)
                <div style="margin-top: 40px; padding-top: 30px; border-top: 2px solid var(--border-color);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--primary-color); margin-bottom: 15px; text-align: center;">
                        <i class="fas fa-sticky-note" style="color: var(--secondary-color); margin-right: 8px;"></i>
                        Additional Notes
                    </h3>
                    <div style="background: #f8f9ff; padding: 25px; border-radius: 12px; border-left: 4px solid var(--secondary-color); max-width: 900px; margin: 0 auto;">
                        <p style="color: var(--text-dark); line-height: 1.8; margin: 0; text-align: center;">
                            {{ $candidate->notes }}
                        </p>
                    </div>
                </div>
                @endif

            </div>

            <!-- Footer Actions -->
            {{-- <div class="pagination-container">
                <div class="action-buttons">
                    <form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this candidate?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background: linear-gradient(135deg, var(--danger-color) 0%, #c82333 100%); color: white;">
                            <i class="fas fa-trash"></i> Delete Candidate
                        </button>
                    </form>
                </div>
            </div> --}}
        </div>
    </div>
</div>

<style>
/* Details grid layout */
.details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
    max-width: 1000px;
    margin: 0 auto;
}

/* Detail item styles */
.detail-item {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.detail-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(38, 34, 97, 0.12);
    border-color: var(--primary-color);
}

.detail-label {
    font-size: 12px;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.detail-label i {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--secondary-color), #d89060);
    color: white;
    border-radius: 5px;
    font-size: 11px;
    flex-shrink: 0;
}

.detail-value {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-dark);
    word-break: break-word;
}

@media (max-width: 768px) {
    .details-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .detail-item {
        padding: 15px;
    }
}
</style>
@endsection
