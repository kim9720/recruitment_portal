@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
   <div class="content-area">
    <div id="system-logs-section" class="content-section">
        <div class="page-header">
            <h1 class="page-title">System Logs</h1>
            <p class="page-subtitle">Monitor system activities and events</p>
        </div>

        <!-- Log Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-info-circle stat-icon"></i>
                <div class="stat-value">1,234</div>
                <div class="stat-label">Info Logs</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-exclamation-triangle stat-icon" style="color: var(--warning);"></i>
                <div class="stat-value">45</div>
                <div class="stat-label">Warnings</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-times-circle stat-icon" style="color: var(--danger);"></i>
                <div class="stat-value">12</div>
                <div class="stat-label">Errors</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-clock stat-icon"></i>
                <div class="stat-value">24h</div>
                <div class="stat-label">Time Range</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="log-filters">
            <div class="filter-group">
                <label class="filter-label">Log Level</label>
                <select class="form-control">
                    <option value="">All Levels</option>
                    <option value="info">Info</option>
                    <option value="warning">Warning</option>
                    <option value="error">Error</option>
                    <option value="critical">Critical</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Date Range</label>
                <select class="form-control">
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="week">Last 7 Days</option>
                    <option value="month">Last 30 Days</option>
                    <option value="custom">Custom Range</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Category</label>
                <select class="form-control">
                    <option value="">All Categories</option>
                    <option value="auth">Authentication</option>
                    <option value="jobs">Job Management</option>
                    <option value="applications">Applications</option>
                    <option value="users">User Management</option>
                    <option value="system">System</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Search</label>
                <input type="text" class="form-control" placeholder="Search logs...">
            </div>
            <div class="filter-actions">
                <button class="btn btn-primary">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
                <button class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </button>
                <button class="btn btn-success">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>

        <!-- Logs Table -->
        <div class="table-container">
            <div class="table-header">
                <h3 class="table-title">Recent Logs</h3>
                <button class="btn btn-primary" onclick="location.reload()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
            <table class="data-table logs-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">Level</th>
                        <th style="width: 150px;">Timestamp</th>
                        <th style="width: 120px;">Category</th>
                        <th style="width: 150px;">User</th>
                        <th>Message</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="log-level log-info"><i class="fas fa-info-circle"></i></span></td>
                        <td>2025-09-29 14:32:15</td>
                        <td><span class="log-category">Authentication</span></td>
                        <td>john.doe@example.com</td>
                        <td>User logged in successfully</td>
                        <td>
                            <button class="btn btn-sm btn-success"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="log-level log-success"><i class="fas fa-check-circle"></i></span></td>
                        <td>2025-09-29 14:28:42</td>
                        <td><span class="log-category">Jobs</span></td>
                        <td>jane.smith@example.com</td>
                        <td>New job posting created: Senior Developer</td>
                        <td>
                            <button class="btn btn-sm btn-success"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="log-level log-warning"><i class="fas fa-exclamation-triangle"></i></span></td>
                        <td>2025-09-29 14:15:33</td>
                        <td><span class="log-category">Applications</span></td>
                        <td>system</td>
                        <td>Application processing delayed due to high volume</td>
                        <td>
                            <button class="btn btn-sm btn-success"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="log-level log-error"><i class="fas fa-times-circle"></i></span></td>
                        <td>2025-09-29 14:10:18</td>
                        <td><span class="log-category">System</span></td>
                        <td>system</td>
                        <td>Failed to send email notification to candidate</td>
                        <td>
                            <button class="btn btn-sm btn-success"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="log-level log-info"><i class="fas fa-info-circle"></i></span></td>
                        <td>2025-09-29 14:05:27</td>
                        <td><span class="log-category">Users</span></td>
                        <td>admin@example.com</td>
                        <td>New user account created: mike.johnson@example.com</td>
                        <td>
                            <button class="btn btn-sm btn-success"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="log-level log-success"><i class="fas fa-check-circle"></i></span></td>
                        <td>2025-09-29 13:58:44</td>
                        <td><span class="log-category">Applications</span></td>
                        <td>candidate@example.com</td>
                        <td>Application submitted for Web Developer position</td>
                        <td>
                            <button class="btn btn-sm btn-success"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="log-level log-info"><i class="fas fa-info-circle"></i></span></td>
                        <td>2025-09-29 13:45:12</td>
                        <td><span class="log-category">Authentication</span></td>
                        <td>sarah.williams@example.com</td>
                        <td>Password changed successfully</td>
                        <td>
                            <button class="btn btn-sm btn-success"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="log-level log-warning"><i class="fas fa-exclamation-triangle"></i></span></td>
                        <td>2025-09-29 13:30:55</td>
                        <td><span class="log-category">System</span></td>
                        <td>system</td>
                        <td>Database connection pool nearing capacity</td>
                        <td>
                            <button class="btn btn-sm btn-success"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            <div class="pagination-info">
                Showing 1 to 8 of 1,291 entries
            </div>
            <div class="pagination">
                <button class="pagination-btn" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="pagination-btn active">1</button>
                <button class="pagination-btn">2</button>
                <button class="pagination-btn">3</button>
                <button class="pagination-btn">4</button>
                <button class="pagination-btn">5</button>
                <button class="pagination-btn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
