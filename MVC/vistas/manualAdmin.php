<?php include 'header.php'; ?>

<div class="main p-3">
    <h1 class="mb-4">Manual de Gestión de Reportes de Fallos (Técnicos/Administradores)</h1>
    <div class="titulo-linea"></div>
    
    <!-- SECCIÓN 1: VISUALIZACIÓN DE REPORTES -->
    <section class="mb-5">
        <h2 class="border-bottom pb-2">1. Visualización de reportes</h2>
        
        <div class="alert alert-info">
            <strong>Nota:</strong> Como técnico/administrador, verás todos los reportes del sistema pero con capacidades de gestión.
        </div>
        
        <h5 class="mt-4">Estructura de la tabla</h5>
        <div class="ms-4">
            <p>• La tabla muestra todos los reportes existentes con información detallada.<br>
            • Columnas: <strong>ID, Dispositivo, Ubicación, Tipo, Nivel urgencia, Descripción, Reportado por, Persona Asignada, Estado, Acciones</strong></p>
            <!-- IMAGEN 1 -->
            <div class="text-center bg-light p-2 my-3 border rounded">
                <img width= "900" height="550"src="http://localhost/Mantenimiento-Ascardio/MVC/vistas/estilos/imagenes/reportes-admin.png" alt="Tabla de reportes técnico">
            </div>
        </div>
        
        <h5 class="mt-4">Filtros y búsqueda</h5>
        <div class="ms-4">
            <p>• Use el campo <strong>"Buscar"</strong> para filtrar por cualquier campo.<br>
            • Descargue reportes en PDF con el botón <button class="btn btn-sm btn-danger">Descargar Reporte de Fallos ↓</button></p>
        </div>
    </section>
    
    <!-- SECCIÓN 2: GESTIÓN DE REPORTES -->
    <section class="mb-5">
        <h2 class="border-bottom pb-2">2. Estados y acciones disponibles</h2>
        
        <h5 class="mt-4">Estado: <span class="badge bg-warning">Pendiente</span></h5>
        <div class="ms-4">
            <p>• <strong>Persona Asignada:</strong> "Sin asignar"<br>
            • <strong>Acciones disponibles:</strong> 
                <button class="btn btn-sm btn-primary">Tomar reporte</button><br>
            • Cualquier técnico puede tomar el reporte para atenderlo.</p>
        </div>
        
        <h5 class="mt-4">Estado: <span class="badge bg-primary">Tomado por mí</span></h5>
        <div class="ms-4">
            <p>• <strong>Persona Asignada:</strong> [Tu nombre]<br>
            • <strong>Acciones disponibles:</strong> 
                <button class="btn btn-sm btn-success">Atender</button><br>
            • Solo tú puedes gestionar este reporte. Presiona "Atender" cuando hayas solucionado el problema.</p>
        </div>
        
        <h5 class="mt-4">Estado: <span class="badge bg-primary">Tomado</span> (por otro técnico)</h5>
        <div class="ms-4">
            <p>• <strong>Persona Asignada:</strong> [Nombre del técnico]<br>
            • <strong>Acciones:</strong> "Solo [Técnico asignado] puede gestionar"<br>
            • No puedes realizar acciones sobre este reporte.</p>
        </div>
        
        <h5 class="mt-4">Estado: <span class="badge bg-info">Por confirmación</span></h5>
        <div class="ms-4">
            <p>• <strong>Acciones:</strong> "En espera de cambio de estado"<br>
            • Debes esperar a que el usuario que reportó confirme si el problema fue solucionado.</p>
        </div>
        
        <h5 class="mt-4">Estado: <span class="badge bg-danger">Fallo persistente</span></h5>
        <div class="ms-4">
            <p>• <strong>Acciones:</strong> <button class="btn btn-sm btn-success">Atender</button><br>
            • El usuario indicó que el problema persiste. Debes volver a atender el reporte.</p>
        </div>
        
        <h5 class="mt-4">Estado: <span class="badge bg-success">Resuelto</span></h5>
        <div class="ms-4">
            <p>• <strong>Acciones disponibles:</strong> 
               <button type="submit" name="eliminar_admin" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este reporte definitivamente?')">
                     <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M9 3v1H4v2h16V4h-5V3H9zm2 2h2v1h-2V5zm-5 4v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V9H6zm2 2h2v8h-2v-8zm4 0h2v8h-2v-8z"/>
                     </svg>
               </button><br>
            • Puedes eliminar el reporte de la tabla si ya está completamente finalizado.</p>
        </div>
    </section>
    
    <!-- SECCIÓN 3: GESTIÓN DE DISPOSITIVOS (ADMIN) -->
    <section id="gestion">
        <h2 class="border-bottom pb-2">3. Gestión de Dispositivos (Solo Administradores)</h2>
        
        <div class="alert alert-warning">
            <strong>Nota:</strong> Esta sección solo está disponible para usuarios con privilegios de administrador.
        </div>
        
        <h5 class="mt-4">Acciones adicionales</h5>
        <div class="ms-4">
            <p>• <strong>Acciones disponibles:</strong> 
                <button class="btn btn-sm btn-warning">Editar</button> 
                <button class="btn btn-sm btn-danger">Eliminar</button><br>
            • Estas opciones aparecen en la tabla de dispositivos.</p>
            <!-- IMAGEN 6 -->
            <div class="text-center bg-light p-2 my-3 border rounded">
                <img src="http://localhost/Mantenimiento-Ascardio/MVC/vistas/estilos/imagenes/dispositivos-admin.png" alt="Acciones admin dispositivos">
            </div>
        </div>
    </section>

<div class="main p-3">
    <h1 class="mb-4">Manual de Gestión de Usuarios y Mantenimientos</h1>
    <div class="titulo-linea"></div>
    
    <!-- SECCIÓN 1: GESTIÓN DE USUARIOS -->
    <section class="mb-5">
        <h2 class="border-bottom pb-2">1. Gestión de Usuarios</h2>
        
        <div class="alert alert-warning">
            <strong>Importante:</strong> Solo usuarios con privilegios de administrador pueden acceder a esta sección.
        </div>
        
        <h5 class="mt-4">Registro de nuevos usuarios</h5>
        <div class="ms-4">
            <p>• Complete los campos: <strong>Nombre, Apellido, Usuario, Contraseña</strong><br>
            • Seleccione el <strong>Rol</strong> (Administrador, Técnico o Usuario normal)<br>
            • Haga clic en <button class="btn btn-sm btn-primary">Registrar</button></p>
            <!-- IMAGEN 1 -->
            <div class="text-center bg-light p-2 my-3 border rounded">
                <img src="http://localhost/Mantenimiento-Ascardio/MVC/vistas/estilos/imagenes/usuarios-admin.png" alt="Formulario de registro de usuarios">
            </div>
        </div>
        
        <h5 class="mt-4">Edición y eliminación de usuarios</h5>
        <div class="ms-4">
            <div class="alert alert-danger">
                <strong>Advertencia:</strong> Al eliminar un usuario se borrarán todos sus datos asociados:
                <ul>
                    <li>Si es usuario normal: desaparecerán los reportes que hizo</li>
                    <li>Si es técnico: desaparecerán los reportes que atendió</li>
                    <li>Se eliminará completamente su perfil</li>
                </ul>
            </div>
            <p>• Para editar: <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Editar</button><br>
            • Para eliminar: <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Eliminar</button></p>
        </div>
    </section>
    
    <!-- SECCIÓN 2: GESTIÓN DE MANTENIMIENTOS -->
    <section class="mb-5">
        <h2 class="border-bottom pb-2">2. Gestión de Mantenimientos</h2>
        
        <h5 class="mt-4">Registro de nuevos mantenimientos</h5>
        <div class="ms-4">
            <p>• Seleccione el <strong>Dispositivo</strong> de la lista desplegable<br>
            • Ingrese la <strong>Fecha del último mantenimiento</strong> (formato dd/mm/aaaa)<br>
            • Describa el <strong>Próximo mantenimiento</strong> requerido<br>
            • Establezca la <strong>Fecha del próximo mantenimiento</strong><br>
            • Haga clic en <button class="btn btn-sm btn-primary">Registrar</button></p>
            <!-- IMAGEN 2 -->
            <div class="text-center bg-light p-2 my-3 border rounded">
                <img src="http://localhost/Mantenimiento-Ascardio/MVC/vistas/estilos/imagenes/mantenimiento.png" alt="Formulario de registro de mantenimientos">
            </div>
        </div>
        
        <h5 class="mt-4">Tabla: Próximos Mantenimientos</h5>
        <div class="ms-4">
            <p>• Muestra los mantenimientos cuya fecha aún no ha llegado<br>
            • <strong>Acciones disponibles:</strong><br>
              - <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Editar</button><br>
              - <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Eliminar</button><br>
            • Puede buscar/filtrar y navegar entre páginas</p>
            <!-- IMAGEN 3 -->
            <div class="text-center bg-light p-2 my-3 border rounded">
                <img src="http://localhost/Mantenimiento-Ascardio/MVC/vistas/estilos/imagenes/proximos-mantenimientos.png" alt="Tabla de próximos mantenimientos">
            </div>
        </div>
        
        <h5 class="mt-4">Tabla: Mantenimientos Pendientes</h5>
        <div class="ms-4">
            <p>• Muestra los mantenimientos cuya fecha ya llegó y necesitan atención<br>
            • <strong>Flujo de trabajo:</strong></p>
            <ol>
                <li>Estado inicial: <span class="badge bg-warning">Pendiente</span></li>
                <li>Acción disponible: <button class="btn btn-sm btn-primary">Realizar este mantenimiento</button></li>
                <li>Al tomar el mantenimiento:
                    <ul>
                        <li>Estado cambia a: <span class="badge bg-info">Tomado por mí</span></li>
                        <li>Aparece el botón: <button class="btn btn-sm btn-success">Mantenimiento realizado</button></li>
                    </ul>
                </li>
                <li>Al completar el mantenimiento:
                    <ul>
                        <li>El registro se elimina automáticamente de la tabla</li>
                    </ul>
                </li>
            </ol>
            <!-- IMAGEN 4 -->
            <div class="text-center bg-light p-2 my-3 border rounded">
                <img src="http://localhost/Mantenimiento-Ascardio/MVC/vistas/estilos/imagenes/mantenimientos-pendientes.png" alt="Tabla de mantenimientos pendientes">
            </div>
            <div class="alert alert-info mt-3">
                <strong>Nota:</strong> Una vez que un mantenimiento pasa a "Pendientes", ya no se puede editar ni eliminar, solo completar.
            </div>
        </div>
    </section>
    
    <!-- SECCIÓN 3: CONSIDERACIONES IMPORTANTES -->
    <section>
        <h2 class="border-bottom pb-2">3. Consideraciones importantes</h2>
        
        <h5 class="mt-4">Impacto de las eliminaciones</h5>
        <div class="ms-4">
            <div class="alert alert-danger">
                <strong>Advertencia:</strong> Las eliminaciones son irreversibles y afectan múltiples áreas del sistema:
                <ul>
                    <li>Eliminar un usuario borra toda su información asociada</li>
                    <li>Eliminar un mantenimiento próximo lo remueve completamente del sistema</li>
                    <li>Los mantenimientos pendientes no pueden eliminarse, solo completarse</li>
                </ul>
            </div>
        </div>
        
        <h5 class="mt-4">Responsabilidades del técnico</h5>
        <div class="ms-4">
            <p>• Solo puede tomar un mantenimiento pendiente a la vez (aparecerá como "Tomado por mí")<br>
            • Debe marcar como realizado solo cuando el mantenimiento esté completamente terminado<br>
            • No puede editar/eliminar mantenimientos pendientes</p>
        </div>
    </section>
</div>

</div>

<?php include 'footer.php'; ?>