@extends('layouts.app')
@section('title', 'Permissions Management')

@section('content')
  <div class="content-area">
    <div id="permissions-section" class="content-section">
        <div class="page-header">
            <h1 class="page-title">Permissions Management</h1>
            <p class="page-subtitle">Configure role-based access control</p>
        </div>

        <!-- Role Cards -->
        <div class="role-cards-grid">
            <div class="role-card role-card-admin">
                <div class="role-card-header">
                    <i class="fas fa-user-shield"></i>
                    <h3>Admin</h3>
                </div>
                <div class="role-card-body">
                    <p>Full system access with all permissions</p>
                    <div class="role-stats">
                        <span><i class="fas fa-users"></i> 5 Users</span>
                    </div>
                </div>
                <div class="role-card-footer">
                    <button class="btn btn-sm btn-primary">Edit Permissions</button>
                </div>
            </div>

            <div class="role-card role-card-hr">
                <div class="role-card-header">
                    <i class="fas fa-user-tie"></i>
                    <h3>HR Manager</h3>
                </div>
                <div class="role-card-body">
                    <p>Manage jobs, applications, and candidates</p>
                    <div class="role-stats">
                        <span><i class="fas fa-users"></i> 12 Users</span>
                    </div>
                </div>
                <div class="role-card-footer">
                    <button class="btn btn-sm btn-primary">Edit Permissions</button>
                </div>
            </div>

            <div class="role-card role-card-recruiter">
                <div class="role-card-header">
                    <i class="fas fa-user-cog"></i>
                    <h3>Recruiter</h3>
                </div>
                <div class="role-card-body">
                    <p>Review applications and schedule interviews</p>
                    <div class="role-stats">
                        <span><i class="fas fa-users"></i> 8 Users</span>
                    </div>
                </div>
                <div class="role-card-footer">
                    <button class="btn btn-sm btn-primary">Edit Permissions</button>
                </div>
            </div>

            <div class="role-card role-card-candidate">
                <div class="role-card-header">
                    <i class="fas fa-user"></i>
                    <h3>Candidate</h3>
                </div>
                <div class="role-card-body">
                    <p>Apply for jobs and track applications</p>
                    <div class="role-stats">
                        <span><i class="fas fa-users"></i> 28 Users</span>
                    </div>
                </div>
                <div class="role-card-footer">
                    <button class="btn btn-sm btn-primary">Edit Permissions</button>
                </div>
            </div>
        </div>

        <!-- Permissions Matrix -->
        <div class="permissions-container">
            <div class="permissions-header">
                <h3>Permissions Matrix</h3>
                <button class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Custom Role
                </button>
            </div>
            <div class="permissions-table-wrapper">
                <table class="permissions-table">
                    <thead>
                        <tr>
                            <th class="permission-name-col">Permission</th>
                            <th class="permission-role-col">Admin</th>
                            <th class="permission-role-col">HR Manager</th>
                            <th class="permission-role-col">Recruiter</th>
                            <th class="permission-role-col">Candidate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dashboard Permissions -->
                        <tr class="permission-category">
                            <td colspan="5"><strong>Dashboard</strong></td>
                        </tr>
                        <tr>
                            <td>View Dashboard</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox" checked></td>
                        </tr>

                        <!-- Job Management Permissions -->
                        <tr class="permission-category">
                            <td colspan="5"><strong>Job Management</strong></td>
                        </tr>
                        <tr>
                            <td>Create Jobs</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox"></td>
                        </tr>
                        <tr>
                            <td>Edit Jobs</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox"></td>
                        </tr>
                        <tr>
                            <td>Delete Jobs</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox"></td>
                        </tr>
                        <tr>
                            <td>View All Jobs</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox" checked></td>
                        </tr>

                        <!-- Application Permissions -->
                        <tr class="permission-category">
                            <td colspan="5"><strong>Applications</strong></td>
                        </tr>
                        <tr>
                            <td>View All Applications</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox"></td>
                        </tr>
                        <tr>
                            <td>Review Applications</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox"></td>
                        </tr>
                        <tr>
                            <td>Approve/Reject Applications</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox"></td>
                        </tr>
                        <tr>
                            <td>Submit Application</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox" checked></td>
                        </tr>

                        <!-- Candidate Management -->
                        <tr class="permission-category">
                            <td colspan="5"><strong>Candidate Management</strong></td>
                        </tr>
                        <tr>
                            <td>View All Candidates</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox"></td>
                        </tr>
                        <tr>
                            <td>Edit Candidate Profiles</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox"></td>
                        </tr>
                        <tr>
                            <td>Delete Candidates</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox"></td>
                        </tr>

                        <!-- Interview Management -->
                        <tr class="permission-category">
                            <td colspan="5"><strong>Interview Management</strong></td>
                        </tr>
                        <tr>
                            <td>Schedule Interviews</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox"></td>
                        </tr>
                        <tr>
                            <td>View Interview Schedule</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox" checked></td>
                        </tr>
                        <tr>
                            <td>Provide Interview Feedback</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox"></td>
                        </tr>

                        <!-- System Settings -->
                        <tr class="permission-category">
                            <td colspan="5"><strong>System Settings</strong></td>
                        </tr>
                        <tr>
                            <td>Manage Users</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox"></td>
                        </tr>
                        <tr>
                            <td>Manage Permissions</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox"></td>
                        </tr>
                        <tr>
                            <td>Access System Logs</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox"></td>
                        </tr>
                        <tr>
                            <td>Configure Settings</td>
                            <td><input type="checkbox" checked disabled></td>
                            <td><input type="checkbox" checked></td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="permissions-footer">
                <button class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Permissions
                </button>
                <button class="btn btn-secondary">
                    <i class="fas fa-undo"></i> Reset to Default
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
