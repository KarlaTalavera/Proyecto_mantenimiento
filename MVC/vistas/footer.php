</div>

    <!-- scripts de bootstrap y js personalizados -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="vistas/estilos/js.js" defer></script>
    <footer class="text-center py-3" style="background: #f8f9fa; color: #800020;">
     ASCARDIO &copy; 2025. Todos los derechos reservados.
    </footer>

<script>
    // llena el input de fecha de ultimo mantenimiento segun el dispositivo seleccionado
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
    // inicializa datatables con opciones en español y estilos personalizados
    $('table').DataTable({
        dom: '<"datatable-header d-flex justify-content-between align-items-center mb-3"<"datatable-search"f><"datatable-length"l>>' +
           'rt' +
           '<"row mt-2"<"col-md-6"i><"col-md-6 text-end"p>>',
      language: {
        lengthMenu: "Mostrar _MENU_ registros por página",
        zeroRecords: "No hay registros por ahora :)",
        info: "Mostrando página _PAGE_ de _PAGES_",
        infoEmpty: "",
        infoFiltered: "(filtrado de _MAX_ registros totales)",
        search: "Buscar:",
        paginate: {
          next: "Siguiente",
          previous: "Anterior"
        }
      },
      pageLength: 5,
      lengthChange: true,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false
    });
</script>
<script>
    // autollenado de ubicacion y tipo segun el dispositivo seleccionado
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('codigo_dispositivo');
        const ubicacionInput = document.getElementById('ubicacion');
        const tipoInput = document.getElementById('tipo_dispositivo');

        select.addEventListener('change', function() {
            const selected = select.options[select.selectedIndex];
            ubicacionInput.value = selected.getAttribute('data-ubicacion') || '';
            tipoInput.value = selected.getAttribute('data-tipo') || '';
        });
    });
</script>

<script>
    // variable con los fallos para exportar a pdf
    const fallos = <?= json_encode($fallos) ?>;
</script>

<script>
    // variable con los usuarios para mostrar nombres en el pdf
    const usuariosMap = <?= json_encode($usuariosMap ?? []) ?>;
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

<script>
    // funcion para generar el pdf de los fallos
    function genPDF() {
        const { jsPDF } = window.jspdf;
        var doc = new jsPDF('p', 'pt', 'letter');

        const margin = 60;
        const pageWidth = doc.internal.pageSize.getWidth();
        
        const title = 'Reporte de Fallos';
        doc.setFontSize(18);
        const textWidth = doc.getTextWidth(title);
        const x = (pageWidth - textWidth) / 2;
        doc.text(title, x, margin);

        const columns = [
            { header: 'ID', dataKey: 'id' },
            { header: 'Dispositivo', dataKey: 'codigo_dispositivo' },
            { header: 'Ubicación', dataKey: 'ubicacion' },
            { header: 'Tipo', dataKey: 'tipo_dispositivo' },
            { header: 'Urgencia', dataKey: 'nivel_urgencia' },
            { header: 'Descripción', dataKey: 'descripcion' },
            { header: 'Reportado por', dataKey: 'id_usuario_reporta' },
            { header: 'Persona que atendió', dataKey: 'id_admin_toma' },
            { header: 'Estado', dataKey: 'estado' }
        ];

        const fallosPDF = fallos.map(f => ({
            ...f,
            estado: f.estado.charAt(0).toUpperCase() + f.estado.slice(1),
            id_usuario_reporta: usuariosMap[f.id_usuario_reporta] || "No asignado",
            id_admin_toma: f.id_admin_toma ? (usuariosMap[f.id_admin_toma] || "No asignado") : "No asignado"
        }));

        doc.autoTable({
            columns: columns,
            body: fallosPDF,
            startY: margin + 20,
            margin: { left: margin, right: margin },
            styles: { fontSize: 10, cellPadding: 4 },
            headStyles: { 
                fillColor: [128,0,32],
                halign: 'center',   
                valign: 'middle'    
            }
        });

        doc.save('reporte_fallos.pdf');
    }
</script>

<script>
    // autollenado de ubicacion y tipo si ya hay un valor seleccionado al cargar la pagina
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('codigo_dispositivo');
        const ubicacion = document.getElementById('ubicacion');
        const tipo = document.getElementById('tipo_dispositivo');
        if (select && ubicacion && tipo) {
            select.addEventListener('change', function() {
                const option = select.options[select.selectedIndex];
                ubicacion.value = option.getAttribute('data-ubicacion') || '';
                tipo.value = option.getAttribute('data-tipo') || '';
            });
            // Si ya hay un valor seleccionado (por edición), dispara el evento para autollenar
            if (select.value) {
                const event = new Event('change');
                select.dispatchEvent(event);
            }
        }
    });
</script>

</body>
</html>