@extends('layouts.app')
@section('title', 'Job Management')

<style>
    :root {
        --primary-color: #262261;
        --secondary-color: #C17340;
        --success-color: #28a745;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
        --light-bg: #f8f9fa;
        --white: #ffffff;
        --border-color: #e1e5e9;
        --text-dark: #2c3e50;
        --text-muted: #6c757d;
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --border-radius: 12px;
        --border-radius-lg: 16px;
        --transition: all 0.15s ease-in-out;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }


    .job-details-container {
        min-height: 100vh;
        padding: 3rem 1rem;
        background: linear-gradient(135deg, var(--light-bg) 0%, var(--white) 50%, #e9ecef 100%);
    }

    .container {
        max-width: 100%;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .job-wrapper {
        max-width: 100%;
        margin: 0 auto;
    }

    .job-card {
        background: var(--white);
        /* border-radius: var(--border-radius-lg); */
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: var(--transition);
        position: relative;
        /* animation: fadeInUp 0.6s ease-out; */
    }

    .job-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(38, 34, 97, 0.15);
    }

    .job-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--secondary-color) 0%, #d4834e 100%);
    }

    .job-header {
        padding: 2.5rem 2.5rem 2rem;
        background: linear-gradient(135deg, var(--primary-color) 0%, #1a1a4d 100%);
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .job-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="80" cy="40" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.1;
    }

    .job-header::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        margin-bottom: 1rem;
        opacity: 0.8;
        position: relative;
        z-index: 1;
    }

    .breadcrumb::before {
        content: '📊';
        margin-right: 8px;
        font-size: 1rem;
    }

    .breadcrumb-separator {
        width: 4px;
        height: 4px;
        background: currentColor;
        border-radius: 50%;
        opacity: 0.6;
    }

    .job-title {
        font-size: 2.25rem;
        font-weight: 800;
        line-height: 1.2;
        margin: 0 0 1.5rem 0;
        letter-spacing: -0.025em;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 1;
    }

    .job-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-top: 1rem;
        position: relative;
        z-index: 1;
    }

    .job-meta-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.9rem;
        padding: 0.75rem 1.25rem;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .job-meta-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }

    .job-meta-item:hover::before {
        left: 100%;
    }

    .job-meta-item:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
    }

    .job-body {
        padding: 2.5rem;
        background: #fafbfc;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid var(--secondary-color);
        position: relative;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
    }

    .section-title::before {
        content: '📄';
        margin-right: 10px;
        font-size: 1.2rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 80px;
        height: 3px;
        background: var(--primary-color);
    }

    .job-info-grid {
        display: grid;
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .info-item {
        background: var(--white);
        border-radius: var(--border-radius);
        padding: 1.75rem;
        border: 2px solid var(--border-color);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        animation: slideInLeft 0.4s ease-out;
        animation-delay: calc(var(--delay) * 0.1s);
    }

    .info-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--secondary-color);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .info-item::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, transparent 0%, rgba(193, 115, 64, 0.02) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .info-item:hover {
        transform: translateX(8px) translateY(-2px);
        box-shadow: var(--shadow-lg);
        border-color: var(--secondary-color);
    }

    .info-item:hover::before {
        transform: scaleY(1);
    }

    .info-item:hover::after {
        opacity: 1;
    }

    .info-label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
        color: var(--primary-color);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
        position: relative;
        z-index: 1;
    }

    .info-value {
        color: var(--text-dark);
        font-size: 1.1rem;
        line-height: 1.7;
        margin: 0;
        font-weight: 400;
        position: relative;
        z-index: 1;
    }

    .job-description {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-dark);
    }

    .stats-container {
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 3px solid var(--secondary-color);
        background: var(--white);
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-sm);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .stat-item {
        text-align: center;
        background: linear-gradient(135deg, var(--white) 0%, var(--light-bg) 100%);
        padding: 2rem 1.5rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--border-color);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.4s ease-out;
        animation-delay: calc(var(--delay) * 0.15s);
    }

    .stat-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--secondary-color) 0%, #d4834e 100%);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: var(--secondary-color);
        background: linear-gradient(135deg, var(--white) 0%, rgba(193, 115, 64, 0.05) 100%);
    }

    .stat-item:hover::before {
        transform: scaleX(1);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--secondary-color) 0%, #d4834e 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: var(--white);
        box-shadow: var(--shadow-sm);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .icon {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
        opacity: 0.8;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid var(--border-color);
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        min-width: 150px;
        justify-content: center;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1a1a4d 100%);
        color: white;
        box-shadow: var(--shadow-md);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-secondary {
        background: linear-gradient(135deg, var(--secondary-color) 0%, #a85d2f 100%);
        color: white;
        box-shadow: var(--shadow-md);
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #a85d2f 0%, var(--secondary-color) 100%);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .job-details-container {
            padding: 1.5rem 0.5rem;
        }

        .job-header,
        .job-body {
            padding: 2rem 1.5rem;
        }

        .job-title {
            font-size: 1.875rem;
        }

        .job-meta {
            flex-direction: column;
            gap: 0.75rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
            align-items: center;
        }

        .btn {
            width: 100%;
            max-width: 300px;
        }
    }

    @media (max-width: 480px) {

        .job-header,
        .job-body {
            padding: 1.5rem 1rem;
        }

        .job-title {
            font-size: 1.5rem;
        }

        .info-item {
            padding: 1.25rem;
        }

        .section-title {
            font-size: 1.125rem;
        }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Hover effects for better interactivity */
    .job-card:hover .job-title {
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .info-item:hover .info-label {
        color: var(--secondary-color);
    }

    /* Enhanced visual feedback */
    .stat-item:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: var(--shadow-md);
    }

    .stat-item:hover .stat-value {
        color: var(--secondary-color);
    }

    /* Additional micro-interactions */
    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .btn:active {
        animation: pulse 0.2s ease-in-out;
    }
</style>

@section('content')
    <div class="content-area">
        <div id="jobs-section" class="content-section">
            <div class="page-header">
                <h1 class="page-title">Job Details</h1>
                <p class="page-subtitle">Details of {{ $job->job_title }}</p>
            </div>
            <div class="">
                <div class="container">
                    <div class="job-wrapper">
                        <div class="job-card">
                            <div class="job-header">
                                <div class="breadcrumb">
                                    <span>Job Details</span>
                                    <div class="breadcrumb-separator"></div>
                                    <span>{{ $job->category }}</span>
                                    <div class="breadcrumb-separator"></div>
                                    <span>Overview</span>
                                </div>

                                <h1 class="job-title">{{ $job->job_title }}</h1>

                                <div class="job-meta">
                                    <div class="job-meta-item">
                                        <svg class="icon" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $job->location }}
                                    </div>
                                    <div class="job-meta-item">
                                        <svg class="icon" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $job->created_at->format('M j, Y') }}
                                    </div>
                                    <div class="job-meta-item">
                                        <svg class="icon" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100 2 1 1 0 000-2z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $job->category }}
                                    </div>
                                </div>
                            </div>

                            <div class="job-body">
                                <h2 class="section-title">Job Information</h2>

                                <div class="job-info-grid">
                                    <div class="info-item" style="--delay: 1">
                                        <div class="info-label">
                                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Job Description
                                        </div>
                                        <p class="info-value job-description">{{ $job->introduction }}</p>
                                    </div>

                                    {{-- <div class="info-item" style="--delay: 2">
                                        <div class="info-label">
                                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Location
                                        </div>
                                        <p class="info-value">{{ $job->location }}</p>
                                    </div>

                                    <div class="info-item" style="--delay: 3">
                                        <div class="info-label">
                                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100 2 1 1 0 000-2z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Job Category
                                        </div>
                                        <p class="info-value">{{ $job->category }}</p>
                                    </div> --}}
                                    <div class="info-item" style="--delay: 3">
                                        <div class="info-label">
                                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100 2 1 1 0 000-2z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Job Responsibility
                                        </div>
                                        <div class="info-value">{!! $job->responsibilities !!}</div>
                                    </div>
                                    <div class="info-item" style="--delay: 3">
                                        <div class="info-label">
                                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100 2 1 1 0 000-2z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Job Qualifications
                                        </div>
                                        <div class="info-value">{!! $job->skillset !!}</div>
                                    </div>
                                </div>

                                <div class="stats-container">
                                    <h2 class="section-title">Job Statistics</h2>
                                    <div class="stats-grid">
                                        <div class="stat-item" style="--delay: 1">
                                            <div class="stat-icon">
                                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    <path fill-rule="evenodd"
                                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="stat-value">{{ number_format($job->countview) }}</div>
                                            <div class="stat-label">Total Views</div>
                                        </div>
                                        <div class="stat-item" style="--delay: 2">
                                            <div class="stat-icon">
                                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="stat-value">{{ $job->created_at->diffForHumans() }}</div>
                                            <div class="stat-label">Posted</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="action-buttons">
                                    <a href="#" class="btn btn-primary">
                                        <svg class="icon" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Apply Now
                                    </a>
                                    <a href="#" class="btn btn-secondary">
                                        <svg class="icon" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Save Job
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
