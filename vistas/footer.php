 </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="/Mantenimiento-Ascardio/vistas/estilos/js.js" defer></script>
    <footer class="text-center py-3" style="background: #f8f9fa; color: #800020;">
     ASCARDIO &copy; 2025. Todos los derechos reservados.
    </footer>
    <script>
    const fechasUltimo = <?= json_encode($fechasUltimo) ?>;

    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('codigo_dispositivo');
        const fechaInput = document.getElementById('fecha_ultimo_mantenimiento');
        if (select && fechaInput) {
            select.addEventListener('change', function() {
                const codigo = this.value;
                if (fechasUltimo[codigo]) {
                    fechaInput.value = fechasUltimo[codigo];
                } else {
                    fechaInput.value = '';
                }
            });
        }
    });
</script>
<script>
$('table').DataTable({
    dom: '<"datatable-header d-flex justify-content-between align-items-center mb-3"<"datatable-search"f><"datatable-length"l>>' +
       'rt' +
       '<"row mt-2"<"col-md-6"i><"col-md-6 text-end"p>>',
  language: {
    lengthMenu: "Mostrar _MENU_ registros por página",
    zeroRecords: "No se encontraron resultados",
    info: "Mostrando página _PAGE_ de _PAGES_",
    infoEmpty: "No hay registros disponibles",
    infoFiltered: "(filtrado de _MAX_ registros totales)",
    search: "Buscar:",
    paginate: {
      next: "Siguiente",
      previous: "Anterior"
    }
  },
  pageLength: 10,
  lengthChange: true,
  searching: true,
  ordering: true,
  info: true,
  autoWidth: false
});
</script>


</body>
</html>