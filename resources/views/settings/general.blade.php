@extends('layouts.app')
@section('title', 'General Settings')

@section('content')
<div class="content-area">
    <div id="general-settings-section" class="content-section">
        <div class="page-header">
            <h1 class="page-title">General Settings</h1>
            <p class="page-subtitle">Configure system-wide settings</p>
        </div>

        <!-- Settings Grid -->
        <div class="settings-grid">
            <!-- Company Information -->
            <div class="settings-card">
                <div class="settings-card-header">
                    <i class="fas fa-building"></i>
                    <h3>Company Information</h3>
                </div>
                <div class="settings-card-body">
                    <div class="form-group">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control" value="Recruitment Hub Inc." placeholder="Enter company name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="info@recruitmenthub.com" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" value="+1 234 567 8900" placeholder="Enter phone">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" rows="3" placeholder="Enter address">123 Business Street, New York, NY 10001</textarea>
                    </div>
                    <button class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </div>

            <!-- Application Settings -->
            <div class="settings-card">
                <div class="settings-card-header">
                    <i class="fas fa-cog"></i>
                    <h3>Application Settings</h3>
                </div>
                <div class="settings-card-body">
                    <div class="form-group">
                        <label class="form-label">Auto-close jobs after (days)</label>
                        <input type="number" class="form-control" value="30" placeholder="Enter days">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Max applications per job</label>
                        <input type="number" class="form-control" value="100" placeholder="Enter maximum">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Default job status</label>
                        <select class="form-control">
                            <option>Active</option>
                            <option>Draft</option>
                            <option>Pending</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" id="allowMultipleApplications" checked>
                            <label for="allowMultipleApplications">Allow multiple applications from same candidate</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" id="requireResume" checked>
                            <label for="requireResume">Require resume upload</label>
                        </div>
                    </div>
                    <button class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </div>

            <!-- Email Configuration -->
            <div class="settings-card">
                <div class="settings-card-header">
                    <i class="fas fa-envelope"></i>
                    <h3>Email Configuration</h3>
                </div>
                <div class="settings-card-body">
                    <div class="form-group">
                        <label class="form-label">SMTP Host</label>
                        <input type="text" class="form-control" value="smtp.gmail.com" placeholder="Enter SMTP host">
                    </div>
                    <div class="form-group">
                        <label class="form-label">SMTP Port</label>
                        <input type="text" class="form-control" value="587" placeholder="Enter port">
                    </div>
                    <div class="form-group">
                        <label class="form-label">From Email</label>
                        <input type="email" class="form-control" value="noreply@recruitmenthub.com" placeholder="Enter from email">
                    </div>
                    <div class="form-group">
                        <label class="form-label">From Name</label>
                        <input type="text" class="form-control" value="Recruitment Hub" placeholder="Enter from name">
                    </div>
                    <button class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="settings-card">
                <div class="settings-card-header">
                    <i class="fas fa-bell"></i>
                    <h3>Notification Settings</h3>
                </div>
                <div class="settings-card-body">
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" id="emailNotifications" checked>
                            <label for="emailNotifications">Email notifications</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" id="smsNotifications">
                            <label for="smsNotifications">SMS notifications</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" id="pushNotifications" checked>
                            <label for="pushNotifications">Push notifications</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" id="notifyNewApplication" checked>
                            <label for="notifyNewApplication">Notify on new applications</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" id="notifyInterview" checked>
                            <label for="notifyInterview">Notify on interview schedules</label>
                        </div>
                    </div>
                    <button class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
