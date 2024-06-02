
// JavaScript code for dynamic sidebar and active menu item
document.addEventListener("DOMContentLoaded", function() {
    // Function to update sidebar based on user roles
    function updateSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.innerHTML = ''; // Clear existing sidebar content

        // Define sidebar items based on user role
        let sidebarItems = [];
        if (userRole === 'admin') {
            sidebarItems = [
                { title: 'Dashboard', link: 'all_tasks.php', icon: 'nc-layout-11' },
                { title: 'Tasks', link: 'manager_dashboard.php', icon: 'nc-paper' },
                { title: 'Reports', link: 'reports_dashboard.php', icon: 'nc-single-copy-04' },
                { title: 'Logout', link: '../auth/logout-logic.php', icon: 'nc-button-power' }
            ];
        } else if (userRole === 'manager') {
            sidebarItems = [
                { title: 'Dashboard', link: 'all_tasks.php', icon: 'nc-layout-11' },
                { title: 'Tasks', link: 'manager_dashboard.php', icon: 'nc-paper' },
                { title: 'Reports', link: 'reports_dashboard.php', icon: 'nc-single-copy-04' },
                { title: 'Logout', link: '../auth/logout-logic.php', icon: 'nc-button-power' }
            ];
        } else if (userRole === 'employee') {
            sidebarItems = [
                { title: 'Dashboard', link: 'all_tasks.php', icon: 'nc-layout-11' },
                { title: 'Tasks', link: 'manager_dashboard.php', icon: 'nc-paper' },
                { title: 'Logout', link: '../auth/logout-logic.php', icon: 'nc-button-power' }
            ];
        }

        // Create sidebar items dynamically
        sidebarItems.forEach(item => {
            const menuItem = document.createElement('li');
            menuItem.classList.add('nav-item');
            menuItem.innerHTML = `
                <a class="nav-link" href="${item.link}">
                    <i class="nc-icon ${item.icon}"></i>
                    <p>${item.title}</p>
                </a>
            `;
            sidebar.appendChild(menuItem);
        });
    }

    // Function to highlight active menu item
    function highlightActiveMenuItem() {
        const currentLocation = window.location.href;
        const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');

        sidebarLinks.forEach(link => {
            if (link.href === currentLocation) {
                link.parentElement.classList.add('active');
            }
        });
    }

    updateSidebar(userRole);
    highlightActiveMenuItem();

});
