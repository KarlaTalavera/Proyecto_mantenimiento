    (function() {
    const sidebarState = localStorage.getItem('sidebarExpanded');
    window.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            if (sidebarState === 'true') {
                sidebar.classList.add('expand');
            } else {
                sidebar.classList.remove('expand');
            }
        }
    });
})();

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggle-btn');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function() {
            if (!sidebar.classList.contains('with-transition')) {
                sidebar.classList.add('with-transition');
            }
            sidebar.classList.toggle('expand');
            localStorage.setItem('sidebarExpanded', sidebar.classList.contains('expand'));
        });
    }
});