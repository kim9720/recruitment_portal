<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3><i class="fas fa-briefcase"></i> Recruitment Hub</h3>
    </div>

    <div class="sidebar-menu">

        {{-- ================= DASHBOARD ================= --}}
        <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span class="menu-text">Dashboard</span>
        </a>

        @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr'))
            {{-- ================= JOB MANAGEMENT ================= --}}
            <a href="#" class="menu-item has-submenu {{ request()->routeIs('jobs.*') ? 'active' : '' }}"
                id="jobsMenu">
                <i class="fas fa-briefcase"></i>
                <span class="menu-text">Job Management</span>
            </a>
            <div class="submenu {{ request()->routeIs('jobs.*') ? 'active' : '' }}" id="jobsSubmenu">
                <a href="{{ route('jobs.list') }}"
                    class="submenu-item {{ request()->routeIs('jobs.list') ? 'active' : '' }}">
                    <i class="fas fa-list"></i> All Jobs
                </a>
            </div>

            {{-- ================= APPLICATIONS ================= --}}
            <a href="#" class="menu-item has-submenu {{ request()->routeIs('applications.*') ? 'active' : '' }}"
                id="applicationsMenu">
                <i class="fas fa-file-alt"></i>
                <span class="menu-text">Applications</span>
            </a>
            <div class="submenu {{ request()->routeIs('applications.*') ? 'active' : '' }}" id="applicationsSubmenu">
                <a href="{{ route('applications.index') }}"
                    class="submenu-item {{ request()->routeIs('applications.index') ? 'active' : '' }}">
                    <i class="fas fa-inbox"></i> All Applications
                </a>
            </div>

            {{-- ================= CANDIDATES ================= --}}
            <a href="#" class="menu-item has-submenu {{ request()->routeIs('candidate.*') ? 'active' : '' }}"
                id="candidatesMenu">
                <i class="fas fa-users"></i>
                <span class="menu-text">Candidates</span>
            </a>
            <div class="submenu {{ request()->routeIs('candidate.*') ? 'active' : '' }}" id="candidatesSubmenu">
                <a href="{{ route('candidate.index') }}"
                    class="submenu-item {{ request()->routeIs('candidate.index') ? 'active' : '' }}">
                    <i class="fas fa-user-friends"></i> All Candidates
                </a>
            </div>

            {{-- ================= INTERVIEWS ================= --}}
            <a href="#" class="menu-item has-submenu {{ request()->routeIs('interviews.*') ? 'active' : '' }}"
                id="interviewsMenu">
                <i class="fas fa-calendar-check"></i>
                <span class="menu-text">Interviews</span>
            </a>
            <div class="submenu {{ request()->routeIs('interviews.*') ? 'active' : '' }}" id="interviewsSubmenu">
                <a href="#" class="submenu-item {{ request()->routeIs('interviews.schedule') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i> Schedule
                </a>
            </div>

            {{-- ================= REPORTS ================= --}}
            <a href="#" class="menu-item has-submenu {{ request()->routeIs('reports.*') ? 'active' : '' }}"
                id="reportsMenu">
                <i class="fas fa-chart-bar"></i>
                <span class="menu-text">Reports & Analytics</span>
            </a>
            <div class="submenu {{ request()->routeIs('reports.*') ? 'active' : '' }}" id="reportsSubmenu">
                <a href="#" class="submenu-item {{ request()->routeIs('reports.index') ? 'active' : '' }}">
                    <i class="fas fa-file-chart-column"></i> Generate Reports
                </a>
            </div>

            {{-- ================= COMMUNICATION ================= --}}
            <a href="#" class="menu-item has-submenu {{ request()->routeIs('communication.*') ? 'active' : '' }}"
                id="communicationMenu">
                <i class="fas fa-envelope"></i>
                <span class="menu-text">Communication</span>
            </a>
            <div class="submenu {{ request()->routeIs('communication.*') ? 'active' : '' }}" id="communicationSubmenu">
                <a href="#" class="submenu-item {{ request()->routeIs('communication.email') ? 'active' : '' }}">
                    <i class="fas fa-envelope-open-text"></i> Email Templates
                </a>
            </div>

            {{-- ================= SETTINGS ================= --}}
            <a href="#" class="menu-item has-submenu {{ request()->routeIs('settings.*') ? 'active' : '' }}"
                id="settingsMenu">
                <i class="fas fa-cog"></i>
                <span class="menu-text">Settings</span>
            </a>
            <div class="submenu {{ request()->routeIs('settings.*') ? 'active' : '' }}" id="settingsSubmenu">
                <a href="{{ route('settings.general') }}"
                    class="submenu-item {{ request()->routeIs('settings.general') ? 'active' : '' }}">
                    <i class="fas fa-sliders-h"></i> General Settings
                </a>
                <a href="{{ route('settings.users') }}"
                    class="submenu-item {{ request()->routeIs('settings.users') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i> User Management
                </a>
                <a href="{{ route('settings.permissions') }}"
                    class="submenu-item {{ request()->routeIs('settings.permissions') ? 'active' : '' }}">
                    <i class="fas fa-key"></i> Permissions
                </a>
                <a href="{{ route('settings.logs') }}"
                    class="submenu-item {{ request()->routeIs('settings.logs') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> System Logs
                </a>
            </div>
        @elseif(auth()->user()->hasRole('candidate'))
            {{-- ================= CANDIDATE MENU ================= --}}
            <a href="{{ route('candidate.personal_details.index') }}"
                class="menu-item {{ request()->routeIs('candidate.personal_details.*') ? 'active' : '' }}">
                <i class="fas fa-user"></i>
                <span class="menu-text">Personal Details</span>
            </a>

            <a href="{{ route('candidate.academic_details.index') }}"
                class="menu-item {{ request()->routeIs('candidate.academic_details.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i>
                <span class="menu-text">Academic Details</span>
            </a>

            <a href="{{ route('candidate.referees.index') }}"
                class="menu-item {{ request()->routeIs('candidate.referees.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span class="menu-text">References</span>
            </a>

            <a href="{{ route('candidate.attachments.index') }}"
                class="menu-item {{ request()->routeIs('candidate.attachments.*') ? 'active' : '' }}">
                <i class="fas fa-briefcase"></i>
                <span class="menu-text">Attachments</span>
            </a>
            {{-- work Experience --}}
            <a href="{{ route('candidate.work_experience.index') }}"
                class="menu-item {{ request()->routeIs('candidate.work_experience.*') ? 'active' : '' }}">
                <i class="fas fa-briefcase"></i>
                <span class="menu-text">Work Experience</span>
            </a>
        @endif

    </div>
</nav>
{{-- <a href="#" class="menu-item">
    <i class="fas fa-briefcase"></i>
    <span class="menu-text">Vacancies</span>
</a>

<a href="#" class="menu-item">
    <i class="fas fa-file-alt"></i>
    <span class="menu-text">My Applications</span>
</a>

<a href="#" class="menu-item">
    <i class="fas fa-calendar-check"></i>
    <span class="menu-text">My Interviews</span>
</a>

<a href="#" class="menu-item">
    <i class="fas fa-user-circle"></i>
    <span class="menu-text">My Profile</span>
</a> --}}
