<?php include 'header.php'; ?>

<div class="main p-3">
    <h1>Gestión de Mantenimientos</h1>
    <div class="titulo-linea"></div>

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
                            <?= (isset($_POST['codigo_dispositivo']) && $_POST['codigo_dispositivo'] == $d['codigo_dispositivo']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($d['codigo_dispositivo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <?php if ($editando): ?>
            <label class="form-label flex-grow">
                Persona Asignada
                <select class="form-control" name="persona_asignada">
                    <option value="">Sin asignar</option>
                    <?php foreach ($usuarios as $u): ?>
                        <option value="<?= htmlspecialchars($u['id']) ?>"
                            <?= ($mantenimientoEditar['persona_asignada'] == $u['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($u['nombre'] . ' ' . $u['apellido']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <?php endif; ?>
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
                <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
                <a href="index.php?vista=mantenimiento" class="btn btn-secondary">Cancelar</a>
            <?php else: ?>
                <button type="submit" name="registrar" class="btn btn-primary">Registrar</button>
            <?php endif; ?>
        </div>
    </form>

    <!-- Tabla de Próximos Mantenimientos -->
    <h1>Próximos Mantenimientos</h1>
    <div class="titulo-linea"></div>
    <table class="device-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Dispositivo</th>
                <th>Último</th>
                <th>Próximo</th>
                <th>Descripción</th>
                <th>Persona Asignada</th>

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
                        <?php
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
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Tabla de Mantenimientos Pendientes -->
    <h1>Mantenimientos Pendientes</h1>
    <div class="titulo-linea"></div>
    <table class="device-table" id="pendientes">
        <thead>
            <tr>
                <th>ID</th>
                <th>Dispositivo</th>
                <th>Último</th>
                <th>Próximo</th>
                <th>Descripción</th>
                <th>Persona Asignada</th>
                <th>Acción</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendientes as $m): ?>
                 <?php if (!empty($m['fecha_realizado'])) continue; // Oculta los realizados ?>
                <tr>
                    <td><?= htmlspecialchars($m['id']) ?></td>
                    <td><?= htmlspecialchars($m['codigo_dispositivo']) ?></td>
                    <td><?= htmlspecialchars($m['fecha_ultimo_mantenimiento']) ?></td>
                    <td><?= htmlspecialchars($m['fecha_proximo_mantenimiento']) ?></td>
                    <td><?= htmlspecialchars($m['descripcion_proximo_mantenimiento']) ?></td>
                    <td>
                        <?php
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
                    <td>
                        <?php if (!$m['persona_asignada']): ?>
                            <form method="POST" action="index.php?vista=mantenimiento#pendientes">
                                <input type="hidden" name="tomar_mantenimiento" value="<?= $m['id'] ?>">
                                <button type="submit" class="btn btn-primary btn-sm">Tomar mantenimiento</button>
                            </form>
                        <?php else: ?>
                            <span class="badge bg-success">En proceso</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (
                            $m['persona_asignada'] 
                            && $m['persona_asignada'] == $_SESSION['usuario']['id'] 
                            && empty($m['fecha_realizado'])
                        ): ?>
                            <form method="POST" action="index.php?vista=mantenimiento#pendientes">
                                <input type="hidden" name="realizar_mantenimiento" value="<?= $m['id'] ?>">
                                <button type="submit" class="btn btn-success btn-sm">Mantenimiento realizado</button>
                            </form>
                        <?php elseif (!empty($m['fecha_realizado'])): ?>
                            <span class="badge bg-success">Realizado</span>
                        <?php elseif ($m['persona_asignada']): ?>
                            <span class="badge bg-warning">En proceso</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Pendiente</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>