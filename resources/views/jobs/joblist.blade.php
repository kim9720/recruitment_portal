@extends('layouts.app')
@section('title', 'Job Management')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.7.2/tinymce.min.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.1/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.1/sweetalert2.min.css">

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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .content-area {
            padding: 30px;
            min-height: 100vh;
        }

        .table-container {
            background: white;
            /* border-radius: 20px; */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 30px;
        }

        .table-header {
            padding: 25px 30px;
            background: linear-gradient(135deg, var(--light-bg) 0%, #e9ecef 100%);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid var(--secondary-color);
        }

        .table-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
        }

        .table-title::before {
            content: '📊';
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
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
            box-shadow: 0 5px 15px rgba(38, 34, 97, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(38, 34, 97, 0.4);
        }

        .btn-sm {
            padding: 8px 12px;
            font-size: 12px;
            border-radius: 6px;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #20923a 100%);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, #e0a800 100%);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #c82333 100%);
            color: white;
        }

        .btn-default {
            background: #6c757d;
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #a85d2f 100%);
            color: white;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .data-table th,
        .data-table td {
            padding: 18px 20px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        .data-table th {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1a1a4d 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 12px;
        }

        .data-table tbody tr:hover {
            background: linear-gradient(135deg, #f8f9ff 0%, #fff5f0 100%);
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-pending {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-expired {
            background: linear-gradient(135deg, #ffdbcd 0%, #ffcaa7 100%);
            color: #852904;
            border: 1px solid #ffc3a7;
        }

        /* Pagination Styles */
        .pagination-container {
            padding: 25px 30px;
            background: var(--light-bg);
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .pagination-info {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
        }

        .pagination {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 5px;
        }

        .pagination li {
            margin: 0;
        }

        .pagination a,
        .pagination span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            background: white;
            color: var(--text-dark);
        }

        .pagination a:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(38, 34, 97, 0.3);
        }

        .pagination .active span {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 3px 10px rgba(38, 34, 97, 0.3);
        }

        .pagination .disabled span {
            background: #f8f9fa;
            color: var(--text-muted);
            cursor: not-allowed;
            border-color: #e9ecef;
        }

        /* Per Page Selector */
        .per-page-selector {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-muted);
            font-size: 14px;
        }

        .per-page-selector select {
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background: white;
            color: var(--text-dark);
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .per-page-selector select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(38, 34, 97, 0.1);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.show {
            display: block;
            opacity: 1;
        }

        .modal-content {
            background: white;
            margin: 2% auto;
            border-radius: 20px;
            width: 90%;
            max-width: 900px;
            max-height: 95vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px rgba(38, 34, 97, 0.3);
            transform: translateY(-50px) scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal.show .modal-content {
            transform: translateY(0) scale(1);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1a1a4d 100%);
            color: white;
            padding: 25px 30px;
            border-radius: 20px 20px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="80" cy="40" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.1;
        }

        .modal-title {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            z-index: 1;
            position: relative;
        }

        .modal-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 18px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 1;
            position: relative;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 40px 30px;
            background: #fafbfc;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 15px 18px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(38, 34, 97, 0.1);
            transform: translateY(-2px);
        }

        .form-control:hover {
            border-color: var(--secondary-color);
        }

        select.form-control {
            cursor: pointer;
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="%23262261" viewBox="0 0 16 16"><path d="M8 11L3 6h10l-5 5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
            appearance: none;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
            line-height: 1.6;
        }

        .required::after {
            content: '*';
            color: var(--danger-color);
            margin-left: 4px;
        }

        .modal-footer {
            padding: 25px 30px;
            background: var(--light-bg);
            border-radius: 0 0 20px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .button-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .form-section {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            color: var(--primary-color);
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--secondary-color);
            display: inline-block;
        }

        /* Custom SweetAlert Styles */
        .swal2-popup {
            border-radius: 20px !important;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3) !important;
        }

        .swal2-title {
            color: var(--primary-color) !important;
            font-weight: 700 !important;
        }

        .swal2-confirm {
            background: var(--primary-color) !important;
            border-radius: 10px !important;
            font-weight: 600 !important;
            padding: 12px 24px !important;
        }

        .swal2-cancel {
            background: var(--text-muted) !important;
            border-radius: 10px !important;
            font-weight: 600 !important;
            padding: 12px 24px !important;
        }

        .swal2-success .swal2-success-ring {
            border-color: var(--success-color) !important;
        }

        .swal2-success .swal2-success-fix {
            background-color: var(--success-color) !important;
        }

        .swal2-success [class^="swal2-success-line"] {
            background-color: var(--success-color) !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .content-area {
                padding: 15px;
            }

            .table-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .modal-content {
                width: 95%;
                margin: 1% auto;
            }

            .modal-body {
                padding: 25px 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .modal-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .button-group {
                width: 100%;
                justify-content: center;
            }

            .btn {
                flex: 1;
                min-width: 120px;
            }

            .data-table {
                font-size: 12px;
            }

            .data-table th,
            .data-table td {
                padding: 12px 8px;
            }

            .pagination-container {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }

            .pagination {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

        .editor-container {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: white;
        }

        .editor-container:hover {
            border-color: var(--secondary-color);
        }

        .editor-container:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(38, 34, 97, 0.1);
            transform: translateY(-2px);
        }

        .tox .tox-editor-header {
            border-bottom: 1px solid #e1e5e9 !important;
        }

        .tox .tox-toolbar__group {
            border-color: #e1e5e9 !important;
        }

        .tox .tox-tbtn {
            color: var(--primary-color) !important;
        }

        .tox .tox-tbtn:hover {
            background-color: var(--secondary-color) !important;
            color: white !important;
        }

        .tox .tox-tbtn--enabled {
            background-color: var(--primary-color) !important;
            color: white !important;
        }

        .modal-content::-webkit-scrollbar {
            width: 8px;
        }

        .modal-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .modal-content::-webkit-scrollbar-thumb {
            background: var(--secondary-color);
            border-radius: 4px;
        }

        .modal-content::-webkit-scrollbar-thumb:hover {
            background: #a85d2f;
        }
    </style>

    <div class="content-area">
        <div id="jobs-section" class="content-section">
            <div class="page-header">
                <h1 class="page-title">Job Management</h1>
                <p class="page-subtitle">Manage job openings and requirements with ease</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">All Job Postings</h3>
                    <button class="btn btn-primary" onclick="openModal('jobModal')">
                        <i class="fas fa-plus"></i> Add New Job
                    </button>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-briefcase"></i> Job Title</th>
                            <th><i class="fas fa-map-marker-alt"></i> Location</th>
                            <th><i class="fas fa-tag"></i> Category</th>
                            <th><i class="fas fa-calendar"></i> Deadline</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                            <th><i class="fas fa-users"></i> Applications</th>
                            <th><i class="fas fa-cogs"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jobs as $job)
                            <tr>
                                <td><strong>{{ $job->job_title }}</strong></td>
                                <td>{{ $job->location }}</td>
                                <td>{{ $job->category }}</td>
                                <td>{{ $job->deadline }}</td>
                                <td>
                                    @if($job->status === 1)
                                        <span class="status-badge status-active">Active</span>
                                    @elseif($job->status === 2)
                                        <span class="status-badge status-pending">Draft</span>
                                    @elseif($job->status === 3)
                                        <span class="status-badge status-expired">Expired</span>
                                    @endif
                                </td>
                                <td><strong>45</strong></td>
                                <td>
                                    <button class="btn btn-sm btn-success" title="View Details" onclick="viewJob({{ $job->job_id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" title="Edit Job" onclick="editJob({{ $job->job_id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Delete Job" onclick="deleteJob({{ $job->job_id }}, '{{ $job->job_title }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination-container">
                    <div class="pagination-info">
                        Showing {{ $jobs->firstItem() ?? 0 }} to {{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} results
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

                    <!-- Laravel Pagination Links -->
                    {{ $jobs->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Job Modal -->
    <div id="jobModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-briefcase" style="margin-right: 12px;"></i>
                    Add New Job Position
                </h3>
                <button class="modal-close" onclick="closeModal('jobModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <form id="jobForm" action="{{ route('jobs.store') }}" method="POST">
                    @csrf

                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-info-circle" style="margin-right: 8px;"></i>
                            Basic Information
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label required">Job Title</label>
                                <input type="text" class="form-control" name="title"
                                    placeholder="e.g. Senior Software Engineer" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label required">Category</label>
                                <select class="form-control" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="Full Time">Full Time</option>
                                    <option value="Part Time">Part Time</option>
                                    <option value="Freelance">Freelance</option>
                                    <option value="Internship">Internship</option>
                                    <option value="Temporary">Temporary</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label required">Location</label>
                                <select class="form-control" name="location" required>
                                    <option value="">Select Location</option>
                                    <option value="Arusha">Arusha</option>
                                    <option value="Dar es Salaam">Dar es Salaam</option>
                                    <option value="Dodoma">Dodoma</option>
                                    <option value="Geita">Geita</option>
                                    <option value="Iringa">Iringa</option>
                                    <option value="Kagera">Kagera</option>
                                    <option value="Katavi">Katavi</option>
                                    <option value="Kigoma">Kigoma</option>
                                    <option value="Kilimanjaro">Kilimanjaro</option>
                                    <option value="Lindi">Lindi</option>
                                    <option value="Manyara">Manyara</option>
                                    <option value="Mara">Mara</option>
                                    <option value="Mbeya">Mbeya</option>
                                    <option value="Morogoro">Morogoro</option>
                                    <option value="Mtwara">Mtwara</option>
                                    <option value="Mwanza">Mwanza</option>
                                    <option value="Njombe">Njombe</option>
                                    <option value="Pemba North">Pemba North</option>
                                    <option value="Pemba South">Pemba South</option>
                                    <option value="Pwani">Pwani</option>
                                    <option value="Rukwa">Rukwa</option>
                                    <option value="Ruvuma">Ruvuma</option>
                                    <option value="Shinyanga">Shinyanga</option>
                                    <option value="Simiyu">Simiyu</option>
                                    <option value="Singida">Singida</option>
                                    <option value="Tabora">Tabora</option>
                                    <option value="Tanga">Tanga</option>
                                    <option value="Zanzibar North">Zanzibar North</option>
                                    <option value="Zanzibar South and Central">Zanzibar South and Central</option>
                                    <option value="Zanzibar West">Zanzibar West</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label required">Job Function</label>
                                <select class="form-control" name="jobfunction" required>
                                    <option value="">Select Job Function</option>
                                    <option value="Accounting, Auditing and Finance">Accounting, Auditing & Finance</option>
                                    <option value="Administrative & Office">Administrative & Office</option>
                                    <option value="Agriculture & Farming">Agriculture & Farming</option>
                                    <option value="Building & Architecture">Building & Architecture</option>
                                    <option value="Community & Social Services">Community & Social Services</option>
                                    <option value="Consulting & Strategy">Consulting & Strategy</option>
                                    <option value="Creative & Design">Creative & Design</option>
                                    <option value="Customer Service & Support">Customer Service & Support</option>
                                    <option value="Employability & Soft Skills">Employability & Soft Skills</option>
                                    <option value="Engineering">Engineering</option>
                                    <option value="Food Services & Catering">Food Services & Catering</option>
                                    <option value="Health & Safety">Health & Safety</option>
                                    <option value="Hospitality/Leisure/Travel">Hospitality/Leisure/Travel</option>
                                    <option value="Human Resources">Human Resources</option>
                                    <option value="IT & Software">IT & Software</option>
                                    <option value="Legal Services">Legal Services</option>
                                    <option value="Management & Business Development">Management & Business Development</option>
                                    <option value="Marketing & Communications">Marketing & Communications</option>
                                    <option value="Medical & Pharmaceutical">Medical & Pharmaceutical</option>
                                    <option value="Natural Sciences">Natural Sciences</option>
                                    <option value="Other">Other</option>
                                    <option value="Project & Product Management">Project & Product Management</option>
                                    <option value="Quality Control & Assurance">Quality Control & Assurance</option>
                                    <option value="Real Estate & Property Management">Real Estate & Property Management</option>
                                    <option value="Research, Teaching & Training">Research, Teaching & Training</option>
                                    <option value="Sales">Sales</option>
                                    <option value="Security">Security</option>
                                    <option value="Supply Chain & Procurement">Supply Chain & Procurement</option>
                                    <option value="Trades & Services">Trades & Services</option>
                                    <option value="Transport & Logistics">Transport & Logistics</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label required">Application Deadline</label>
                                <input type="date" class="form-control" name="deadline" required>
                            </div>
                        </div>
                    </div>

                    <!-- Requirements Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-graduation-cap" style="margin-right: 8px;"></i>
                            Requirements & Qualifications
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label required">Minimum Qualification</label>
                                <select class="form-control" name="minimumqualification" required>
                                    <option value="">Select Minimum Qualification</option>
                                    <option value="Advanced Diploma">Advanced Diploma</option>
                                    <option value="Advanced Level (ACSE)">Advanced Level (ACSE)</option>
                                    <option value="Certificate">Certificate</option>
                                    <option value="Degree">Degree</option>
                                    <option value="Diploma / FTC">Diploma / FTC</option>
                                    <option value="Master Degree">Master Degree</option>
                                    <option value="Ordinary Level (CSE)">Ordinary Level (CSE)</option>
                                    <option value="PHD">PHD</option>
                                    <option value="Post Graduate Diploma">Post Graduate Diploma</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label required">Experience Length</label>
                                <select class="form-control" name="experiencelenght" required>
                                    <option value="">Select Experience Length</option>
                                    <option value="0">Fresh Graduate</option>
                                    <option value="1">1 Year</option>
                                    <option value="2">2 Years</option>
                                    <option value="3">3 Years</option>
                                    <option value="4">4 Years</option>
                                    <option value="5">5 Years</option>
                                    <option value="6">6 Years</option>
                                    <option value="7">7 Years</option>
                                    <option value="8">8 Years</option>
                                    <option value="9">9 Years</option>
                                    <option value="10">10+ Years</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Job Details Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-file-alt" style="margin-right: 8px;"></i>
                            Job Details
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Job Introduction</label>
                            <textarea class="form-control" name="jobintro" rows="3"
                                placeholder="Brief introduction about the role and company..."></textarea>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label required">Job Responsibilities</label>
                            <div class="editor-container">
                                <textarea class="form-control rich-editor" name="responsibilities" id="responsibilities"
                                    placeholder="• List the main responsibilities and duties&#10;• Include key tasks and expectations&#10;• Be specific and clear about requirements"
                                    required></textarea>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label required">Required Skills & Competencies</label>
                            <div class="editor-container">
                                <textarea class="form-control rich-editor" name="skillset" id="skillset"
                                    placeholder="• Technical skills required&#10;• Soft skills needed&#10;• Tools and technologies&#10;• Languages or certifications"
                                    required></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <div>
                    <small style="color: #6c757d;">
                        <i class="fas fa-info-circle"></i>
                        Fields marked with * are required
                    </small>
                </div>

                <div class="button-group">
                    <button type="button" class="btn btn-default" onclick="closeModal('jobModal')">
                        <i class="fas fa-times" style="margin-right: 8px;"></i>
                        Cancel
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="submitForm('expired')">
                        <i class="fas fa-archive" style="margin-right: 8px;"></i>
                        Mark Expired
                    </button>
                    <button type="button" class="btn btn-primary" onclick="submitForm('savedraft')">
                        <i class="fas fa-save" style="margin-right: 8px;"></i>
                        Save Draft
                    </button>
                    <button type="button" class="btn btn-success" onclick="submitForm('savepublish')">
                        <i class="fas fa-rocket" style="margin-right: 8px;"></i>
                        Save & Publish
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Check for success message from session
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session("success") }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end',
                    customClass: {
                        popup: 'swal2-toast-custom'
                    }
                });
            });
        @endif

        // Initialize TinyMCE for rich text editors
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: '.rich-editor',
                height: 200,
                menubar: false,
                branding: false,
                statusbar: false,
                plugins: [
                    'lists', 'link', 'table', 'code', 'help'
                ],
                toolbar: 'undo redo | formatselect | bold italic underline strikethrough | ' +
                    'bullist numlist outdent indent | alignleft aligncenter alignright alignjustify | ' +
                    'link table | code help',
                content_style: `
                    body {
                        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                        font-size: 14px;
                        line-height: 1.6;
                        color: #2c3e50;
                        padding: 15px;
                    }
                    ul, ol {
                        padding-left: 20px;
                    }
                    li {
                        margin-bottom: 5px;
                    }
                `,
                setup: function(editor) {
                    editor.on('change keyup', function() {
                        editor.save(); // Save content back to textarea
                    });
                }
            });

            // Set minimum date to today for deadline field
            const deadlineField = document.querySelector('input[name="deadline"]');
            if (deadlineField) {
                const today = new Date().toISOString().split('T')[0];
                deadlineField.min = today;
            }
        });

        // Job Action Functions
        function viewJob(jobId) {
            // Implement view job functionality
            window.location.href = `{{ url('/job_show') }}/${jobId}`;
        }

        function editJob(jobId) {
            // Implement edit job functionality
            window.location.href = `{{ url('/jobs') }}/${jobId}/edit`;
        }

        function deleteJob(jobId, jobTitle) {
            Swal.fire({
                title: 'Delete Job Position?',
                html: `Are you sure you want to delete <strong>"${jobTitle}"</strong>?<br><br>
                       <small class="text-muted">This action cannot be undone and will permanently remove the job posting and all associated applications.</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash"></i> Delete Job',
                cancelButtonText: '<i class="fas fa-times"></i> Cancel',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait while we delete the job posting.',
                        icon: 'info',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('/job_destroy') }}/${jobId}`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'POST';

                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Pagination Functions
        function changePerPage(value) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', value);
            url.searchParams.delete('page'); // Reset to first page when changing per page
            window.location.href = url.toString();
        }

        // Modal functionality
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('show');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('show');
            document.body.style.overflow = 'auto'; // Restore scrolling

            // Reset form
            const form = document.getElementById('jobForm');
            form.reset();

            // Clear TinyMCE editors
            if (typeof tinymce !== 'undefined') {
                tinymce.get('responsibilities')?.setContent('');
                tinymce.get('skillset')?.setContent('');
            }

            // Clear validation styles
            const fields = form.querySelectorAll('.form-control');
            fields.forEach(field => {
                field.style.borderColor = '';
                field.style.boxShadow = '';
            });

            // Clear editor container validation styles
            const editorContainers = form.querySelectorAll('.editor-container');
            editorContainers.forEach(container => {
                container.style.borderColor = '';
                container.style.boxShadow = '';
            });
        }

        function submitForm(action) {
            const form = document.getElementById('jobForm');

            // Save TinyMCE content to textareas
            if (typeof tinymce !== 'undefined') {
                tinymce.get('responsibilities')?.save();
                tinymce.get('skillset')?.save();
            }

            // Remove any existing action inputs
            const existingActionInputs = form.querySelectorAll(
                'input[name="expired"], input[name="savedraft"], input[name="savepublish"]');
            existingActionInputs.forEach(input => input.remove());

            // Create hidden input for the action
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = action;
            actionInput.value = action;
            form.appendChild(actionInput);

            // Validate required fields (except for draft saves)
            if (action !== 'savedraft') {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                let firstInvalidField = null;

                requiredFields.forEach(field => {
                    let isEmpty = false;

                    // Check if field is a TinyMCE editor
                    if (field.classList.contains('rich-editor')) {
                        const editorId = field.id;
                        const editorContent = tinymce.get(editorId)?.getContent({
                            format: 'text'
                        }).trim();
                        isEmpty = !editorContent;

                        // Style the editor container instead of the textarea
                        const editorContainer = field.closest('.editor-container');
                        if (isEmpty) {
                            editorContainer.style.borderColor = '#dc3545';
                            editorContainer.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.1)';
                            if (!firstInvalidField) {
                                firstInvalidField = editorContainer;
                            }
                        } else {
                            editorContainer.style.borderColor = '';
                            editorContainer.style.boxShadow = '';
                        }
                    } else {
                        isEmpty = !field.value.trim();

                        if (isEmpty) {
                            field.style.borderColor = '#dc3545';
                            field.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.1)';
                            if (!firstInvalidField) {
                                firstInvalidField = field;
                            }
                        } else {
                            field.style.borderColor = '';
                            field.style.boxShadow = '';
                        }
                    }

                    if (isEmpty) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    // Show error message with SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please fill in all required fields before submitting.',
                        confirmButtonColor: '#262261',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        }
                    });

                    // Focus on first invalid field
                    if (firstInvalidField) {
                        if (firstInvalidField.classList && firstInvalidField.classList.contains('editor-container')) {
                            const editorId = firstInvalidField.querySelector('.rich-editor').id;
                            tinymce.get(editorId)?.focus();
                        } else {
                            firstInvalidField.focus();
                        }
                        firstInvalidField.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                    return;
                }
            }

            // Show loading state
            const submitButtons = document.querySelectorAll('.modal-footer .btn');
            submitButtons.forEach(btn => {
                btn.disabled = true;
                if (btn.onclick && btn.onclick.toString().includes(action)) {
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right: 8px;"></i>Processing...';
                }
            });

            // Submit the form
            form.submit();
        }

        // Close modal when clicking outside
        document.getElementById('jobModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal('jobModal');
            }
        });

        // Add escape key functionality
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('jobModal');
                if (modal.classList.contains('show')) {
                    closeModal('jobModal');
                }
            }
        });

        // Form field validation on blur
        document.querySelectorAll('.form-control[required]').forEach(field => {
            if (!field.classList.contains('rich-editor')) {
                field.addEventListener('blur', function() {
                    if (this.value.trim()) {
                        this.style.borderColor = '';
                        this.style.boxShadow = '';
                    }
                });
            }
        });

        // Custom toast styles for success messages
        const style = document.createElement('style');
        style.textContent = `
            .swal2-toast-custom {
                background: linear-gradient(135deg, #28a745 0%, #20923a 100%) !important;
                color: white !important;
                border-radius: 15px !important;
                box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3) !important;
            }
            .swal2-toast-custom .swal2-title {
                color: white !important;
                font-weight: 600 !important;
            }
            .swal2-toast-custom .swal2-timer-progress-bar {
                background: rgba(255, 255, 255, 0.3) !important;
            }
        `;
        document.head.appendChild(style);
    </script>

@endsection
