<div class="content-area">
    <div id="admin-dashboard-section" class="content-section">
        <div class="page-header">
            <h1 class="page-title">Admin Dashboard</h1>
            <p class="page-subtitle">System overview and management</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-users-cog stat-icon"></i>
                <div class="stat-value">45</div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-building stat-icon"></i>
                <div class="stat-value">8</div>
                <div class="stat-label">Departments</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-briefcase stat-icon"></i>
                <div class="stat-value">32</div>
                <div class="stat-label">Active Jobs</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-chart-line stat-icon"></i>
                <div class="stat-value">87%</div>
                <div class="stat-label">System Performance</div>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="admin-grid">
            <!-- Recent Users Table -->
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">Recent Users</h3>
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Add User
                    </a>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sarah Williams</td>
                            <td>HR Manager</td>
                            <td><span class="status-badge status-active">Active</span></td>
                            <td>
                                <button class="btn btn-sm btn-success"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>David Brown</td>
                            <td>Recruiter</td>
                            <td><span class="status-badge status-active">Active</span></td>
                            <td>
                                <button class="btn btn-sm btn-success"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Emma Davis</td>
                            <td>Candidate</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td>
                                <button class="btn btn-sm btn-success"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- System Activity -->
            <div class="activity-container">
                <div class="activity-header">
                    <h3 class="activity-title">System Activity</h3>
                </div>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-success">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-text">New user registered</div>
                            <div class="activity-time">2 minutes ago</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-warning">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-text">Job posting created</div>
                            <div class="activity-time">15 minutes ago</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-info">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-text">Application submitted</div>
                            <div class="activity-time">1 hour ago</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-text">System backup completed</div>
                            <div class="activity-time">3 hours ago</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Department Overview -->
        <div class="table-container">
            <div class="table-header">
                <h3 class="table-title">Department Overview</h3>
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Department
                </a>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Manager</th>
                        <th>Employees</th>
                        <th>Open Positions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Engineering</td>
                        <td>John Smith</td>
                        <td>25</td>
                        <td>5</td>
                        <td>
                            <button class="btn btn-sm btn-success"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Marketing</td>
                        <td>Lisa Anderson</td>
                        <td>12</td>
                        <td>2</td>
                        <td>
                            <button class="btn btn-sm btn-success"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Finance</td>
                        <td>Robert Taylor</td>
                        <td>8</td>
                        <td>1</td>
                        <td>
                            <button class="btn btn-sm btn-success"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
