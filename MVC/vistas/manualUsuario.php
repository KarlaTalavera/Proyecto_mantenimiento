<?php include 'header.php'; ?>

<div class="main p-3">
    <h1 class="mb-4">Manual de Reportes de Fallos</h1>
    <div class="titulo-linea"></div>
    <!-- SECCIÓN 1: REGISTRO -->
    <section class="mb-5">
        <h2 class="border-bottom pb-2">1. Cómo registrar un fallo</h2>
        
        <h5 class="mt-4">Paso 1: Selección del dispositivo</h5>
        <div class="ms-4">
            <p>• Haga clic en el campo <strong>"Dispositivo"</strong> y elija uno de la lista desplegable.<br>
            • Si no aparece su dispositivo agreguelo en "gestión de dispositivos": <a href="#gestion" class="text-primary">(vease Gestión de Dispositivos)</a>.</p>
            <!-- IMAGEN 1 -->
            <div class="text-center bg-light p-2 my-3 border rounded" style="width: fit-content;">
                 <img src="http://localhost/Mantenimiento-Ascardio/MVC/vistas/estilos/imagenes/lista-dispositivos.png" alt="Logo Ascardio" >
            </div>
        </div>

        <h5 class="mt-4">Paso 2: Datos automáticos</h5>
        <div class="ms-4">
            <p>• La <strong>Ubicación</strong> y <strong>Tipo</strong> se completarán automáticamente.</p>
        </div>

        <h5 class="mt-4">Paso 3: Detalles del fallo</h5>
        <div class="ms-4">
            <p>• Seleccione urgencia: 
                <span class="badge bg-danger">Alto</span> (Necesita atención inmediata), 
                <span class="badge bg-warning">Medio</span> (Importante), 
                <span class="badge bg-success">Bajo</span> (Leve).<br>
            • Describa el problema en el campo <strong>"Descripción"</strong></p>
            <!-- IMAGEN 2 -->
            <div class="text-center bg-light p-2 my-3 border rounded">
                <small class="text-muted"><img src="http://localhost/Mantenimiento-Ascardio/MVC/vistas/estilos/imagenes/form-lleno.png" alt="formulario llenado" ></small>
            </div>
        </div>

        <h5 class="mt-4">Paso 4: Envío</h5>
        <div class="ms-4">
            <p>• Haga clic en <button class="btn btn-sm btn-success">Registrar</button> para enviar el reporte.<br>
            • Aparecera automáticamente en la tabla de "Mis reportes de fallos"</p>
        </div>
    </section>

    <!-- SECCIÓN 2: GESTIÓN DE REPORTES -->
    <section>
        <h2 class="border-bottom pb-2">2. Estados y acciones</h2>

        <h5 class="mt-4">Estado: <span class="badge bg-warning">Pendiente</span></h5>
        <div class="ms-4">
            <p>• <strong>Acciones disponibles:</strong> 
                <button class="btn btn-sm btn-warning">Editar</button> 
                <button class="btn btn-sm btn-danger">Eliminar</button><br>
            • El reporte aún no ha sido asignado a un técnico.</p>
            <!-- IMAGEN 3 -->
            <div class="text-center bg-light p-2 my-3 border rounded">
                <small class="text-muted"><img src="http://localhost/Mantenimiento-Ascardio/MVC/vistas/estilos/imagenes/pendientes.png" alt="formulario llenado" ></small>
            </div>
        </div>

        <h5 class="mt-4">Estado: <span class="badge bg-primary">Tomado por [Técnico]</span></h5>
        <div class="ms-4">
            <p>• <strong>Acciones:</strong> <span class="text-muted">En espera de cambio de estado</span><br>
            • El técnico está trabajando en la solución, cuando termine usted podrá realizar acciones. (ya no puedes editar/eliminar).</p>
        </div>

        <h5 class="mt-4">Estado: <span class="badge bg-info">Por confirmación</span></h5>
        <div class="ms-4">
            <p>• <strong>Acciones:</strong> 
                <button class="btn btn-sm btn-success">Resuelto</button> 
                <button class="btn btn-sm btn-secondary">Fallo persistente</button><br>
            • Confirme si el problema fue solucionado o persiste.</p>
            <!-- IMAGEN 4 -->
            <div class="text-center bg-light p-2 my-3 border rounded">
                <small class="text-muted"><img src="http://localhost/Mantenimiento-Ascardio/MVC/vistas/estilos/imagenes/por-confirmacion.png" alt="estado por confirmar" ></small>
            </div>
        </div>

        <h5 class="mt-4">Estado: <span class="badge bg-danger">Fallo persistente</span></h5>
        <div class="ms-4">
            <p>• <strong>Acciones:</strong> Las mismas que en "Por confirmación".<br>
            • El técnico revisará nuevamente el caso.</p>
        </div>

        <div class="alert alert-warning mt-4">
            <strong>Nota:</strong> Al marcar como <button class="btn btn-sm btn-success">Resuelto</button>, el reporte se archivará y desaparecerá de su lista.
        </div>
    </section>

<div id= "gestion" class="main p-3">
    <h1 class="mb-4">Manual de Gestión de Dispositivos</h1>
    <div class="titulo-linea"></div>
    <!-- SECCIÓN 1: REGISTRO DE DISPOSITIVOS -->
    <section class="mb-5">
        <h2 class="border-bottom pb-2">1. Registrar nuevo dispositivo</h2>
        
        <div class="alert alert-info">
            <strong>Nota:</strong> El código del dispositivo se genera automáticamente.
        </div>

        <h5 class="mt-5">Paso 1: Seleccionar ubicación</h5>
        <div class="ms-4">
            <p>• Elija la ubicación del dispositivo en el menú desplegable.<br>
            • Ejemplo: <span class="badge bg-primary">Maternidad</span></p>
            <!-- IMAGEN 1 -->
            <div class="text-center bg-light p-2 my-3 border rounded">
                <small class="text-muted"><img src="http://localhost/Mantenimiento-Ascardio/MVC/vistas/estilos/imagenes/ubicacion.png" alt="formulario llenado" ></small>
            </div>
        </div>

        <h5 class="mt-4">Paso 2: Seleccionar tipo</h5>
        <div class="ms-4">
            <p>• Elija el tipo de dispositivo.<br>
            • Ejemplo: <span class="badge bg-primary">Impresora</span></p>
            <!-- IMAGEN 2 -->
            <div class="text-center bg-light p-2 my-3 border rounded">
                <small class="text-muted"><img src="http://localhost/Mantenimiento-Ascardio/MVC/vistas/estilos/imagenes/tipo-dispositivo.png" alt="formulario llenado" ></small>
            </div>
        </div>

        <h5 class="mt-4">Paso 3: Ingresar número</h5>
        <div class="ms-4">
            <p>• Digite un número único para el dispositivo.<br>
            • Ejemplo: <span class="badge bg-primary">3</span> → Generará <strong>MATIMP-3</strong></p>
            <!-- IMAGEN 3 -->
            <div class="text-center bg-light p-2 my-3 border rounded">
                <small class="text-muted"><img src="http://localhost/Mantenimiento-Ascardio/MVC/vistas/estilos/imagenes/identificador.png" alt="formulario llenado" ></small>
            </div>
        </div>

        <h5 class="mt-4">Paso 4: Código autogenerado</h5>
        <div class="ms-4">
            <p>• El sistema mostrará el código en formato: <strong>[UBICACIÓN][TIPO]-[NÚMERO]</strong><br>
            • Ejemplo completo: <span class="badge bg-success">MATIMP-3</span></p>
            <!-- IMAGEN 4 -->
            <div class="text-center bg-light p-2 my-3 border rounded">
                <small class="text-muted"><img src="http://localhost/Mantenimiento-Ascardio/MVC/vistas/estilos/imagenes/codigo.png" alt="formulario llenado" ></small>
            </div>
            <div class="alert alert-warning mt-2">
                <strong>Importante:</strong> Este código es único y no puede modificarse manualmente.
            </div>
        </div>
    </section>

    <!-- SECCIÓN 2: TABLA DE DISPOSITIVOS -->
    <section>
        <h2 class="border-bottom pb-2">2. Visualización y búsqueda</h2>
        
        <h5 class="mt-4">Estructura de la tabla</h5>
        <div class="ms-4">
            <p>• La tabla muestra todos los dispositivos registrados.<br>
            • Columnas: <strong>Código, Tipo, Ubicación, Número</strong></p>
            <!-- IMAGEN 5 -->
            <div class="text-center bg-light p-2 my-3 border rounded">
                <small class="text-muted"><img src="http://localhost/Mantenimiento-Ascardio/MVC/vistas/estilos/imagenes/tabla-dispositivos.png" alt="formulario llenado" ></small>
            </div>
        </div>

        <h5 class="mt-4">Funcionalidades</h5>
        <div class="ms-4">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Búsqueda:</strong><br>
                    • Use el campo "Buscar" para filtrar por código/ubicación.<br>
                    • Ejemplo: <span class="badge bg-info">LAB</span> mostrará solo dispositivos del Laboratorio.</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Paginación:</strong><br>
                    • Navegue entre páginas con los botones.<br>
                    • Ajuste registros visibles con "Mostrar X por página".</p>
                </div>
            </div>
            <!-- IMAGEN 6 -->
            <div class="text-center bg-light p-2 my-3 border rounded">
                <small class="text-muted"><img src="http://localhost/Mantenimiento-Ascardio/MVC/vistas/estilos/imagenes/busqueda.png" alt="formulario llenado" ></small>
            </div>
        </div>

        <div class="alert alert-danger mt-3">
            <strong>Restricción:</strong> Solo el área de Sistemas puede editar/eliminar dispositivos existentes.
        </div>
    </section>
</div>

</div>

<?php include 'footer.php'; ?>