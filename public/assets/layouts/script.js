// Sidebar and Navigation Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const menuItems = document.querySelectorAll('.menu-item');
    const submenuItems = document.querySelectorAll('.submenu-item');
    const contentSections = document.querySelectorAll('.content-section');

    // Toggle sidebar
    if (sidebarToggle && sidebar && mainContent) {
        sidebarToggle.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                // Mobile: slide in/out
                sidebar.classList.toggle('show');
            } else {
                // Desktop: collapse/expand
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');
            }
        });
    }

    // Submenu toggle functionality
    const submenuToggleItems = document.querySelectorAll('.has-submenu');
    submenuToggleItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();

            const submenuId = this.id.replace('Menu', 'Submenu');
            const submenu = document.getElementById(submenuId);

            // Toggle current submenu
            this.classList.toggle('expanded');
            if (submenu) {
                submenu.classList.toggle('expanded');
            }

            // Close other submenus
            submenuToggleItems.forEach(otherItem => {
                if (otherItem !== this) {
                    otherItem.classList.remove('expanded');
                    const otherSubmenuId = otherItem.id.replace('Menu', 'Submenu');
                    const otherSubmenu = document.getElementById(otherSubmenuId);
                    if (otherSubmenu) {
                        otherSubmenu.classList.remove('expanded');
                    }
                }
            });
        });
    });

    // Regular menu navigation (non-submenu items)
    menuItems.forEach(item => {
        if (!item.classList.contains('has-submenu')) {
            item.addEventListener('click', function(e) {
                // Uncomment e.preventDefault() if you want to prevent default link behavior
                // e.preventDefault();

                // Remove active class from all menu items and submenu items
                menuItems.forEach(i => i.classList.remove('active'));
                submenuItems.forEach(i => i.classList.remove('active'));

                // Add active class to clicked item
                this.classList.add('active');

                // Hide all content sections
                contentSections.forEach(section => {
                    section.style.display = 'none';
                });

                // Show selected section
                const sectionId = this.getAttribute('data-section') + '-section';
                const targetSection = document.getElementById(sectionId);
                if (targetSection) {
                    targetSection.style.display = 'block';
                }

                // Close sidebar on mobile
                if (window.innerWidth <= 768 && sidebar) {
                    sidebar.classList.remove('show');
                }
            });
        }
    });

    // Submenu navigation
    submenuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Uncomment e.preventDefault() if you want to prevent default link behavior
            // e.preventDefault();

            // Remove active class from all menu items and submenu items
            menuItems.forEach(i => i.classList.remove('active'));
            submenuItems.forEach(i => i.classList.remove('active'));

            // Add active class to clicked submenu item
            this.classList.add('active');

            // Hide all content sections
            contentSections.forEach(section => {
                section.style.display = 'none';
            });

            // Show selected section
            const sectionId = this.getAttribute('data-section') + '-section';
            const targetSection = document.getElementById(sectionId);
            if (targetSection) {
                targetSection.style.display = 'block';
            } else {
                // If section doesn't exist, fallback to dashboard
                const dashboardSection = document.getElementById('dashboard-section');
                if (dashboardSection) {
                    dashboardSection.style.display = 'block';
                }
            }

            // Close sidebar on mobile
            if (window.innerWidth <= 768 && sidebar) {
                sidebar.classList.remove('show');
            }
        });
    });

    // Responsive handling: Close mobile sidebar on resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && sidebar) {
            sidebar.classList.remove('show');
        }
    });
});
