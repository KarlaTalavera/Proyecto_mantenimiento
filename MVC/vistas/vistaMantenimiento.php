<?php include 'header.php'; ?>

<div class="main p-3">
    <h1>Gestión de Mantenimientos</h1>
    <div class="titulo-linea"></div>

    <!-- este formulario sirve para registrar o editar mantenimientos -->
    <form method="POST" class="device-form mb-4">
        <?php if ($editando && $mantenimientoEditar): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($mantenimientoEditar['id']) ?>">
        <?php endif; ?>
        <section class="form-row">
            <label class="form-label flex-grow">
                Dispositivo
                <select class="form-control" name="codigo_dispositivo" id="codigo_dispositivo" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($dispositivos as $d): ?>
                        <option value="<?= htmlspecialchars($d['codigo_dispositivo']) ?>"
                            <?php
                                if ($editando && $mantenimientoEditar && $mantenimientoEditar['codigo_dispositivo'] == $d['codigo_dispositivo']) {
                                    echo 'selected';
                                } elseif (isset($_POST['codigo_dispositivo']) && $_POST['codigo_dispositivo'] == $d['codigo_dispositivo']) {
                                    echo 'selected';
                                }
                            ?>>
                            <?= htmlspecialchars($d['codigo_dispositivo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </section>
        <section class="form-row">
            <label class="form-label flex-grow">
                Fecha del último mantenimiento
                <input type="date" class="form-control" name="fecha_ultimo_mantenimiento" id="fecha_ultimo_mantenimiento" required
                    value="<?php
                        if ($editando) {
                            echo htmlspecialchars($mantenimientoEditar['fecha_ultimo_mantenimiento']);
                        } elseif (!empty($ultima_fecha_realizado)) {
                            echo htmlspecialchars($ultima_fecha_realizado);
                        } elseif (isset($_POST['fecha_ultimo_mantenimiento'])) {
                            echo htmlspecialchars($_POST['fecha_ultimo_mantenimiento']);
                        }
                    ?>">
            </label>
            <label class="form-label flex-grow">
                Fecha del próximo mantenimiento
                <input type="date" class="form-control" name="fecha_proximo_mantenimiento" required
                    value="<?= $editando ? htmlspecialchars($mantenimientoEditar['fecha_proximo_mantenimiento']) : '' ?>">
            </label>
        </section>
        <section class="form-row">
            <label class="form-label flex-grow">
                Descripción del próximo mantenimiento
                <input type="text" class="form-control" name="descripcion_proximo_mantenimiento" required
                    value="<?= $editando ? htmlspecialchars($mantenimientoEditar['descripcion_proximo_mantenimiento']) : '' ?>">
            </label>
        </section>
        <div class="form-buttons">
            <?php if ($editando): ?>
                <!-- si estas editando, muestra el boton de actualizar y el de cancelar -->
                <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
                <a href="index.php?vista=mantenimiento" class="btn btn-secondary">Cancelar</a>
            <?php else: ?>
                <!-- si no, solo muestra el boton de registrar -->
                <button type="submit" name="registrar" class="btn btn-primary">Registrar</button>
            <?php endif; ?>
        </div>
    </form>

    <div style="height:40px"></div>
    <!-- Tabla de Próximos Mantenimientos -->
    <h1>Próximos Mantenimientos</h1>
    <div class="titulo-linea"></div>
    <!-- aca se muestra la tabla con los mantenimientos que aun no vencen -->
    <table class="device-table" id= "pendientes">
        <thead>
            <tr>
                <th>ID</th>
                <th>Dispositivo</th>
                <th>Último</th>
                <th>Próximo</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proximos as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['id']) ?></td>
                    <td><?= htmlspecialchars($m['codigo_dispositivo']) ?></td>
                    <td><?= htmlspecialchars($m['fecha_ultimo_mantenimiento']) ?></td>
                    <td><?= htmlspecialchars($m['fecha_proximo_mantenimiento']) ?></td>
                    <td><?= htmlspecialchars($m['descripcion_proximo_mantenimiento']) ?></td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="index.php?vista=mantenimiento&editar=<?= urlencode($m['id']) ?>" class="btn btn-sm btn-warning">Editar</a> |
                            <a href="index.php?vista=mantenimiento&eliminar=<?= urlencode($m['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este dispositivo?')">Eliminar</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="height:40px"></div>

    <h1>Mantenimientos Pendientes</h1>
    <div class="titulo-linea"></div>
    <!-- aca se muestra la tabla con los mantenimientos que ya vencieron o estan pendientes -->
    <table class="device-table" id="pendientes" >
        <thead>
            <tr>
                <th>ID</th>
                <th>Dispositivo</th>
                <th>Último</th>
                <th>Próximo</th>
                <th>Descripción</th>
                <th>Persona Asignada</th>
                <th class="text-center">Acción</th>
                <th class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendientes as $m): ?>
                <?php if (!empty($m['fecha_realizado'])) continue; ?>
                <tr>
                    <td><?= htmlspecialchars($m['id']) ?></td>
                    <td><?= htmlspecialchars($m['codigo_dispositivo']) ?></td>
                    <td><?= htmlspecialchars($m['fecha_ultimo_mantenimiento']) ?></td>
                    <td><?= htmlspecialchars($m['fecha_proximo_mantenimiento']) ?></td>
                    <td><?= htmlspecialchars($m['descripcion_proximo_mantenimiento']) ?></td>
                    <td>
                        <?php
                        // busca el nombre de la persona asignada, si no hay muestra "Sin asignar"
                        $persona = '';
                        foreach ($usuarios as $u) {
                            if ($u['id'] == $m['persona_asignada']) {
                                $persona = $u['nombre'] . ' ' . $u['apellido'];
                                break;
                            }
                        }
                        echo $persona ?: 'Sin asignar';
                        ?>
                    </td>

                    <!-- COLUMNA ACCIÓN CENTRADA -->
                   <td class="text-center align-middle">
                        <?php if (!$m['persona_asignada']): ?>
                            <!-- si nadie lo ha tomado, muestra el boton para tomarlo -->
                            <form method="POST" action="index.php?vista=mantenimiento#pendientes" class="d-inline-block">
                                <input type="hidden" name="tomar_mantenimiento" value="<?= $m['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Realizar este mantenimiento</button>
                            </form>
                        <?php elseif ($m['persona_asignada'] == $_SESSION['usuario']['id']): ?>
                            <span class="badge bg-info text-dark">Tomado por mí</span>
                        <?php else: ?>
                            <span class="badge bg-success">Tomado</span>
                        <?php endif; ?>
                    </td>

                    <!-- COLUMNA ESTADO CENTRADA -->
                    <td class="text-center align-middle">
                        <?php if (
                            $m['persona_asignada'] 
                            && $m['persona_asignada'] == $_SESSION['usuario']['id'] 
                            && empty($m['fecha_realizado'])
                        ): ?>
                            <!-- si eres la persona asignada y no lo has realizado, muestra el boton para marcarlo como realizado -->
                            <form method="POST" action="index.php?vista=mantenimiento#pendientes" class="d-inline-block">
                                <input type="hidden" name="realizar_mantenimiento" value="<?= $m['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-success">Mantenimiento realizado</button>
                            </form>
                        <?php elseif (!empty($m['fecha_realizado'])): ?>
                            <span class="badge bg-success">Realizado</span>
                        <?php elseif ($m['persona_asignada']): ?>
                            <span class="badge bg-warning text-dark">Por confirmación</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Pendiente</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="height:48px"></div>
</div>
<?php include 'footer.php'; ?>