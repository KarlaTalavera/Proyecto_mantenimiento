
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggle-btn');

    // Recupera el estado guardado
    if (localStorage.getItem('sidebarExpanded') === 'true') {
        sidebar.classList.add('expand');
    } else {
        sidebar.classList.remove('expand');
    }

    // Al hacer clic, guarda el estado
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('expand');
            localStorage.setItem('sidebarExpanded', sidebar.classList.contains('expand'));
        });
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
});