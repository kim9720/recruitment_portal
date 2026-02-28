<!-- Top Bar -->
<div class="topbar">
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="fas fa-ellipsis-v"></i>
    </button>

    <!-- Navigation Links -->
    <nav class="topbar-nav" id="topbarNav">
        <a href="{{ route('candidate.vacancies.index') }}" class="topbar-link">
            <i class="fas fa-briefcase"></i>
            <span>Vacancies</span>
        </a>

        <a href="{{ route('candidate.vacancies.my_applications') }}" class="topbar-link">
            <i class="fas fa-file-alt"></i>
            <span>My Applications</span>
        </a>

        <a href="#" class="topbar-link">
            <i class="fas fa-calendar-check"></i>
            <span>My Interviews</span>
        </a>
    </nav>

    <!-- User Info -->
    <div class="user-info">
        <span class="welcome-text">Welcome, {{ Auth::user()->username }}</span>
        <div class="user-avatar" id="userAvatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="user-dropdown" id="userDropdown">
            <div class="dropdown-header">
                <div class="dropdown-user-name">{{ Auth::user()->email }}</div>
                <div class="dropdown-user-role">{{ Auth::user()->role_name }}</div>
            </div>
            <div class="dropdown-menu">
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user-circle"></i>
                    <span>My Profile</span>
                </a>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-cog"></i>
                    <span>Account Settings</span>
                </a>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-bell"></i>
                    <span>Notifications</span>
                </a>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-question-circle"></i>
                    <span>Help & Support</span>
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item"
                        style="border:none; background:none; width:100%; text-align:left; cursor:pointer;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Enhanced Top Bar Styles */
.topbar {
    background: var(--white);
    padding: 15px 25px;
    border-bottom: 1px solid var(--border-color);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    position: relative;
}

/* Mobile Menu Toggle (Hidden by default) */
.mobile-menu-toggle {
    display: none;
    background: var(--primary-navy);
    color: var(--white);
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.3s ease;
}

.mobile-menu-toggle:hover {
    background: var(--primary-orange);
}

/* Navigation Container */
.topbar-nav {
    display: flex;
    align-items: center;
    gap: 5px;
    flex: 1;
    margin-left: 20px;
}

/* Top Bar Links */
.topbar-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    color: var(--primary-navy);
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.topbar-link:hover {
    background: rgba(210, 129, 73, 0.1);
    color: var(--primary-orange);
}

.topbar-link.active {
    background: var(--primary-orange);
    color: var(--white);
}

.topbar-link i {
    font-size: 16px;
}

/* Welcome Text */
.welcome-text {
    color: var(--primary-navy);
    font-weight: 500;
    font-size: 14px;
    margin-right: 10px;
}

/* Responsive Adjustments */
@media (max-width: 1200px) {
    .topbar-link span {
        display: none;
    }

    .topbar-link {
        padding: 10px 12px;
    }

    .topbar-link i {
        font-size: 18px;
    }
}

@media (max-width: 768px) {
    .topbar {
        padding: 10px 15px;
        gap: 10px;
    }

    .topbar-nav {
        margin-left: 10px;
        gap: 3px;
    }

    .welcome-text {
        display: none;
    }

    .topbar-link {
        padding: 8px 10px;
    }
}

/* Mobile View (Below 600px) */
@media (max-width: 600px) {
    .mobile-menu-toggle {
        display: block;
    }

    .topbar-nav {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--white);
        flex-direction: column;
        gap: 0;
        margin: 0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        z-index: 999;
    }

    .topbar-nav.show {
        max-height: 400px;
        border-bottom: 2px solid var(--border-color);
    }

    .topbar-link {
        width: 100%;
        padding: 15px 20px;
        border-radius: 0;
        border-bottom: 1px solid var(--border-color);
        justify-content: flex-start;
    }

    .topbar-link span {
        display: inline;
    }

    .topbar-link:last-child {
        border-bottom: none;
    }

    .topbar-link i {
        font-size: 16px;
        width: 20px;
        text-align: center;
    }
}
</style>

<script>
// Mobile menu toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const topbarNav = document.getElementById('topbarNav');
    const userAvatar = document.getElementById('userAvatar');
    const userDropdown = document.getElementById('userDropdown');

    // Mobile menu toggle
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            topbarNav.classList.toggle('show');

            // Close user dropdown if open
            if (userDropdown.classList.contains('show')) {
                userDropdown.classList.remove('show');
            }
        });
    }

    // User dropdown toggle
    if (userAvatar) {
        userAvatar.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');

            // Close mobile menu if open
            if (topbarNav.classList.contains('show')) {
                topbarNav.classList.remove('show');
            }
        });
    }

    // Close menus when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.topbar-nav') && !e.target.closest('.mobile-menu-toggle')) {
            topbarNav.classList.remove('show');
        }
        if (!e.target.closest('.user-info')) {
            userDropdown.classList.remove('show');
        }
    });

    // Close mobile menu when a link is clicked
    const topbarLinks = document.querySelectorAll('.topbar-link');
    topbarLinks.forEach(link => {
        link.addEventListener('click', function() {
            topbarNav.classList.remove('show');
        });
    });
});
</script>
