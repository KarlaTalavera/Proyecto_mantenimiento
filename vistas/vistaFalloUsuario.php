<?php include 'header.php'; ?>
<div class="main p-3">
    <h1>Registro de fallos</h1>
    <div class="titulo-linea"></div>
    <!-- este formulario sirve para registrar o editar un fallo, segun si estas editando o no -->
    <form method="POST" class="fallo-form">
        <?php if (isset($falloEditar) && $falloEditar): ?>
            <input type="hidden" name="fallo_id" value="<?= htmlspecialchars($falloEditar['id']) ?>">
        <?php endif; ?>
        <div class="fallo-form-row">
            <div class="fallo-form-group">
                <label for="codigo_dispositivo">Dispositivo</label>
                <select name="codigo_dispositivo" id="codigo_dispositivo" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($dispositivos as $d): ?>
                        <option value="<?= htmlspecialchars($d['codigo_dispositivo']) ?>"
                            data-ubicacion="<?= htmlspecialchars($d['ubicacion']) ?>"
                            data-tipo="<?= htmlspecialchars($d['tipo_dispositivo']) ?>"
                            <?php if (isset($falloEditar) && $falloEditar && $falloEditar['codigo_dispositivo'] == $d['codigo_dispositivo']) echo 'selected'; ?>>
                            <?= htmlspecialchars($d['codigo_dispositivo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="fallo-form-group">
                <label for="ubicacion">Ubicación</label>
                <input type="text" id="ubicacion" name="ubicacion" readonly value="<?= isset($falloEditar) && $falloEditar ? htmlspecialchars($falloEditar['ubicacion'] ?? '') : '' ?>">
            </div>
            <div class="fallo-form-group">
                <label for="tipo_dispositivo">Tipo</label>
                <input type="text" id="tipo_dispositivo" name="tipo_dispositivo" readonly value="<?= isset($falloEditar) && $falloEditar ? htmlspecialchars($falloEditar['tipo_dispositivo'] ?? '') : '' ?>">
            </div>
        </div>
        <div class="fallo-form-row">
            <div class="fallo-form-group">
                <label for="nivel_urgencia">Nivel de urgencia</label>
                <select name="nivel_urgencia" id="nivel_urgencia" required <?= (isset($falloEditar) && $falloEditar) ? 'disabled' : '' ?>>
                    <option value="alto" <?= (isset($falloEditar) && $falloEditar && strtolower($falloEditar['nivel_urgencia']) == 'alto') ? 'selected' : '' ?>>Alto</option>
                    <option value="medio" <?= (isset($falloEditar) && $falloEditar && (strtolower($falloEditar['nivel_urgencia']) == 'medio' || strtolower($falloEditar['nivel_urgencia']) == 'mediano')) ? 'selected' : '' ?>>Medio</option>
                    <option value="bajo" <?= (isset($falloEditar) && $falloEditar && strtolower($falloEditar['nivel_urgencia']) == 'bajo') ? 'selected' : '' ?>>Bajo</option>
                </select>
            </div>
            <div class="fallo-form-group fallo-form-group-full">
                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" required value="<?= isset($falloEditar) && $falloEditar ? htmlspecialchars($falloEditar['descripcion']) : '' ?>">
            </div>
        </div>
        <div class="fallo-form-actions">
            <?php if (isset($falloEditar) && $falloEditar): ?>
                <!-- si estas editando, muestra el boton de actualizar y el de cancelar -->
                <button type="submit" name="guardar_edicion" class="btn btn-primary">Actualizar</button>
                <a href="index.php?vista=fallos" class="btn btn-secondary ms-2">Cancelar</a>
            <?php else: ?>
                <!-- si no, solo muestra el boton de registrar -->
                <button type="submit" name="crear" class="btn btn-primary">Registrar</button>
            <?php endif; ?>
        </div>
    </form>

    <div style="height:40px"></div>
    <h1>Mis reportes de fallos</h1>
    <div class="titulo-linea"></div>
    <?php
        // este array sirve para mostrar los nombres completos de los usuarios en la tabla
        $usuariosMap = [];
        foreach ($usuarios as $u) {
            $usuariosMap[$u['id']] = $u['nombre'] . ' ' . $u['apellido'];
        }
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
                        <?php
                        // muestra el estado del fallo de forma entendible
                        if ($f['estado'] == 'pendiente') {
                            echo "Pendiente";
                        } elseif ($f['estado'] == 'tomado') {
                            $admin = $usuariosMap[$f['id_admin_toma']] ?? 'Administrador';
                            echo "Tomado por $admin";
                        } elseif ($f['estado'] == 'atendido') {
                            $admin = $usuariosMap[$f['id_admin_toma']] ?? 'Administrador';
                            echo "Atendido por $admin";
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
                            <div style="display:flex;align-items:center;gap:6px;justify-content:center;">
                                <?php if ($f['estado'] == 'pendiente'): ?>
                                    <!-- si el fallo esta pendiente, puedes editarlo o eliminarlo -->
                                    <button type="submit" name="editar" class="btn btn-sm btn-warning">Editar</button>
                                    <span>|</span>
                                    <button type="submit" name="eliminar" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este reporte?')">Eliminar</button>
                                <?php elseif ($f['estado'] == 'por_confirmacion' || $f['estado'] == 'persistente'): ?>
                                    <!-- si esta por confirmar o persistente, puedes marcarlo como resuelto o persistente -->
                                    <button type="submit" name="resuelto" class="btn btn-sm btn-success" onclick="return confirm('¿Confirmar que el fallo fue resuelto?')">Resuelto</button>
                                    <span>|</span>
                                    <button type="submit" name="persistente" class="btn btn-sm btn-secondary">Fallo persistente</button>
                                <?php else: ?>
                                    <!-- si no puedes hacer nada, solo muestra el mensaje -->
                                    <span class="text-muted">En espera de cambio de estado</span>
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