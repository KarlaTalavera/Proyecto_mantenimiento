<?php include 'header.php'; ?>

<div class="main p-3">
    <h1>Gestión de Dispositivos</h1>
    <div class="titulo-linea"></div>
        <!-- este formulario sirve para registrar o editar dispositivos, segun si estas en modo edicion o no -->
        <form method="POST" id="formDispositivo" class="device-form">
            <section class="form-row">
                <label class="form-label flex-grow" for="ubicacion">
                    Ubicación
                    <select class="form-control" id="ubicacion" name="ubicacion" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($ubicaciones as $prefijo => $nombre): ?>
                            <option value="<?= $prefijo ?>" <?= (isset($editando) && $editando && $dispositivoEditar['ubicacion'] == $prefijo) ? 'selected' : '' ?>>
                                <?= $nombre ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="form-label flex-grow" for="tipo_dispositivo">
                    Tipo de Dispositivo
                    <select class="form-control" id="tipo_dispositivo" name="tipo_dispositivo" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($tipos as $prefijo => $nombre): ?>
                            <option value="<?= $prefijo ?>" <?= (isset($editando) && $editando && $dispositivoEditar['tipo_dispositivo'] == $prefijo) ? 'selected' : '' ?>>
                                <?= $nombre ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </section>
            <section class="form-row">
                <label class="form-label flex-grow" for="numero_identificador">
                    Número Identificador
                    <input type="number" class="form-control" id="numero_identificador" name="numero_identificador" required
                        value="<?= (isset($editando) && $editando) ? htmlspecialchars($dispositivoEditar['numero_identificador']) : '' ?>">
                </label>
                <label class="form-label flex-grow" for="codigo_dispositivo">
                    Código del Dispositivo
                    <input type="text" class="form-control" id="codigo_dispositivo" name="codigo_dispositivo" readonly
                        value="<?= (isset($editando) && $editando) ? htmlspecialchars($dispositivoEditar['codigo_dispositivo']) : '' ?>">
                </label>
            </section>
            <div class="form-buttons">
            <?php if (isset($editando) && $editando): ?>
                <!-- si estas editando, muestra el boton de actualizar y el de cancelar -->
                <input type="hidden" name="codigo_original" value="<?= htmlspecialchars($dispositivoEditar['codigo_dispositivo']) ?>">
                <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
                <a href="index.php?vista=dispositivos" class="btn btn-secondary" style="margin-left:10px;">Cancelar</a>
            <?php else: ?>
                <!-- si no, solo muestra el boton de registrar -->
                <button type="submit" name="registrar" class="btn btn-primary">Registrar</button>
            <?php endif; ?>
            </div>
            <?php if (!empty($error)): ?>
                <!-- si hay un error, lo muestra arriba del formulario -->
                <div class="alert alert-danger mt-2"><?= $error ?></div>
            <?php endif; ?>
        </form>

    <div style="height:40px"></div>
     <?php
    // detecta si el usuario es admin
    $esAdmin = isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] === 'administrador';
    ?>

    <h1>Tabla de dispositivos</h1>
    <div class="titulo-linea"></div>

    <!-- aca se muestra la tabla con todos los dispositivos registrados -->
    <table class="device-table datatable" id="deviceTable">
        <thead>
            <tr>
                <th>N°</th>
                <th>Código</th>
                <th>Tipo</th>
                <th>Ubicación</th>
                <th>Número Identificador</th>
            <?php if ($esAdmin): ?>
                <th>Acciones</th>
            <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php $contador = 1; ?>
            <?php if (!empty($dispositivos)): ?>
                <?php foreach ($dispositivos as $dispositivo): ?>
                    <tr>
                        <td><?= $contador++ ?></td>
                        <td><?= htmlspecialchars($dispositivo['codigo_dispositivo']) ?></td>
                        <td><?= htmlspecialchars($tipos[$dispositivo['tipo_dispositivo']] ?? $dispositivo['tipo_dispositivo']) ?></td>
                        <td><?= htmlspecialchars($ubicaciones[$dispositivo['ubicacion']] ?? $dispositivo['ubicacion']) ?></td>
                        <td><?= htmlspecialchars($dispositivo['numero_identificador']) ?></td>
                        <?php if ($esAdmin): ?>
                        <td>
                            <div style="display:flex;align-items:center;gap:6px;">
                                <a href="index.php?vista=dispositivos&editar=<?= urlencode($dispositivo['codigo_dispositivo']) ?>" class="btn btn-sm btn-warning">Editar</a>
                                <span>|</span>
                                <a href="index.php?vista=dispositivos&eliminar=<?= urlencode($dispositivo['codigo_dispositivo']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este dispositivo? se eliminaran todos los registros en los que este presente')">Eliminar</a>
                            </div>
                        </td>
                       <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="<?= $esAdmin ? 6 : 5 ?>">
                        No hay dispositivos registrados.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
// este script actualiza el codigo del dispositivo automaticamente segun los campos seleccionados
document.addEventListener('DOMContentLoaded', function() {
    function actualizarCodigo() {
        const ubicacion = document.getElementById('ubicacion').value.trim().toUpperCase();
        const tipo = document.getElementById('tipo_dispositivo').value.trim().toUpperCase();
        const numero = document.getElementById('numero_identificador').value.trim();
        let codigo = '';
        if (ubicacion && tipo && numero) {
            codigo = `${ubicacion}${tipo}-${numero}`;
        }
        document.getElementById('codigo_dispositivo').value = codigo;
    }

    document.getElementById('ubicacion').addEventListener('change', actualizarCodigo);
    document.getElementById('tipo_dispositivo').addEventListener('change', actualizarCodigo);
    document.getElementById('numero_identificador').addEventListener('input', actualizarCodigo);
});
</script>

<?php include 'footer.php'; ?>