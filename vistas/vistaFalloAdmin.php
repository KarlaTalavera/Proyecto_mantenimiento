<?php include 'header.php'; ?>

<div class="main p-3">
    <h1>Fallos Reportados</h1>
    <div class="titulo-linea"></div>
    <!-- este boton descarga el reporte de fallos en pdf -->
    <button type="button" class="btn btn-secondary mb-3" onclick="genPDF()">
        Descargar Reporte de Fallos
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" style="margin-right:6px;" viewBox="0 0 16 16">
            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.6a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V10.4a.5.5 0 0 1 1 0v2.6A2 2 0 0 1 14 15H2a2 2 0 0 1-2-2V10.4a.5.5 0 0 1 .5-.5z"/>
            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
        </svg>
    </button>
    <?php
        // este array sirve para mostrar los nombres completos de los usuarios en la tabla
        $usuariosMap = [];
        foreach ($usuarios as $u) {
            $usuariosMap[$u['id']] = $u['nombre'] . ' ' . $u['apellido'];
        }
        $admin_id = $_SESSION['usuario']['id'];
    ?>
    <table class="device-table fallos-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Dispositivo</th>
                <th>Ubicación</th>
                <th>Tipo</th>
                <th>Nivel Urgencia</th>
                <th>Descripción</th>
                <th>Reportado por</th>
                <th>Persona Asignada</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fallos as $f): ?>
                <tr>
                    <td><?= htmlspecialchars($f['id']) ?></td>
                    <td><?= htmlspecialchars($f['codigo_dispositivo']) ?></td>
                    <td><?= htmlspecialchars($f['ubicacion']) ?></td>
                    <td><?= htmlspecialchars($f['tipo_dispositivo']) ?></td>
                    <td>
                        <?php
                            // esto pone el color de la urgencia segun el nivel
                            $urgencia = strtolower($f['nivel_urgencia']);
                            $colorClass = '';
                            if ($urgencia == 'alto') $colorClass = 'urgencia-alta';
                            elseif ($urgencia == 'medio' || $urgencia == 'mediano') $colorClass = 'urgencia-media';
                            else $colorClass = 'urgencia-baja';
                        ?>
                        <span class="urgencia-badge <?= $colorClass ?>">
                            <?= htmlspecialchars(ucfirst($f['nivel_urgencia'])) ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($f['descripcion']) ?></td>
                    <td>
                        <?= isset($usuariosMap[$f['id_usuario_reporta']]) ? htmlspecialchars($usuariosMap[$f['id_usuario_reporta']]) : 'Desconocido' ?>
                    </td>
                    <td>
                        <?= $f['id_admin_toma'] && isset($usuariosMap[$f['id_admin_toma']]) ? htmlspecialchars($usuariosMap[$f['id_admin_toma']]) : 'Sin asignar' ?>
                    </td>
                    <td>
                        <?php
                        // muestra el estado del fallo de forma entendible
                        if ($f['estado'] == 'pendiente') {
                            echo "Pendiente";
                        } elseif ($f['estado'] == 'tomado') {
                            if ($f['id_admin_toma'] == $admin_id) {
                                echo "Tomado por mí";
                            } else {
                                $admin = $usuariosMap[$f['id_admin_toma']] ?? 'Administrador';
                                echo "Tomado por $admin";
                            }
                        } elseif ($f['estado'] == 'atendido') {
                            if ($f['id_admin_toma'] == $admin_id) {
                                echo "Atendido por mí";
                            } else {
                                $admin = $usuariosMap[$f['id_admin_toma']] ?? 'Administrador';
                                echo "Atendido por $admin";
                            }
                        } elseif ($f['estado'] == 'por_confirmacion') {
                            echo "Por confirmación";
                        } elseif ($f['estado'] == 'resuelto') {
                            echo "Resuelto";
                        } elseif ($f['estado'] == 'persistente') {
                            echo "Fallo persistente";
                        }
                        ?>
                    </td>                
                    <td class="text-center">
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="fallo_id" value="<?= $f['id'] ?>">
                            <div style="display: flex; align-items: center; gap: 6px; justify-content: center;">
                                <?php if ($f['estado'] == 'pendiente'): ?>
                                    <!-- si el fallo esta pendiente, puedes tomarlo -->
                                    <button type="submit" name="tomar" class="btn btn-sm btn-primary">Tomar</button>
                                <?php elseif (
                                    in_array($f['estado'], ['tomado', 'atendido', 'por_confirmacion', 'resuelto', 'persistente'])
                                    && $f['id_admin_toma'] == $admin_id
                                ): ?>
                                    <?php if ($f['estado'] == 'tomado'): ?>
                                        <!-- si ya lo tomaste, puedes atenderlo -->
                                        <button type="submit" name="atender" class="btn btn-sm btn-success">Atender</button>
                                    <?php elseif ($f['estado'] == 'resuelto'): ?>
                                        <!-- si ya esta resuelto, puedes eliminarlo -->
                                        <button type="submit" name="eliminar_admin" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este reporte definitivamente?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 3v1H4v2h16V4h-5V3H9zm2 2h2v1h-2V5zm-5 4v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V9H6zm2 2h2v8h-2v-8zm4 0h2v8h-2v-8z"/>
                                            </svg>
                                        </button>
                                    <?php elseif ($f['estado'] == 'persistente'): ?>
                                        <span class="text-muted">Por confirmación</span>
                                    <?php else: ?>
                                        <span class="text-muted">En espera de cambio de estado</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <!-- si no eres el admin asignado, no puedes hacer nada -->
                                    <span class="text-muted">Solo <?php
                                     $admin = $usuariosMap[$f['id_admin_toma']] ?? 'Administrador';
                                    echo $admin;?> puede gestionar</span>
                                <?php endif; ?>
                            </div>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>