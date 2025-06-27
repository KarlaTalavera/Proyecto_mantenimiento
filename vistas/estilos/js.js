(function() {
    const sidebarState = localStorage.getItem('sidebarExpanded');
    window.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        if (sidebar && sidebarState === 'true') {
            sidebar.classList.add('expand');
            // NO agregues with-transition aquí
        }
    });
})();

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggle-btn');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function() {
            // Solo agrega la transición si el usuario interactúa por PRIMERA VEZ
            if (!sidebar.classList.contains('with-transition')) {
                sidebar.classList.add('with-transition');
                // Guarda en localStorage que la transición ya debe estar activa
                localStorage.setItem('sidebarTransition', 'true');
            }
            sidebar.classList.toggle('expand');
            localStorage.setItem('sidebarExpanded', sidebar.classList.contains('expand'));
        });
    }

    
    if (sidebar && localStorage.getItem('sidebarTransition') === 'true') {
        sidebar.classList.add('with-transition');
    }

    const searchInput = document.getElementById('searchInput');
    const userTable = document.getElementById('userTable');
    if (searchInput && userTable) {
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = userTable.querySelectorAll('tbody tr');
            rows.forEach(function(row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.indexOf(filter) > -1 ? '' : 'none';
            });
        });
    }

    // Buscador de dispositivos
    const searchDeviceInput = document.getElementById('searchDeviceInput');
    const deviceTable = document.getElementById('deviceTable');
    if (searchDeviceInput && deviceTable) {
        searchDeviceInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = deviceTable.querySelectorAll('tbody tr');
            rows.forEach(function(row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.indexOf(filter) > -1 ? '' : 'none';
            });
        });
    }

});