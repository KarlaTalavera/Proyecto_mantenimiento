<?php include 'header.php'; ?>

<div class="main p-3">
    <h1>Gestión de Usuarios</h1>
    <div class="titulo-linea"></div>
    <!-- este formulario sirve para registrar o editar usuarios -->
    <form method="POST" class="device-form mb-4">
        <?php if (isset($usuarioEditar) && $usuarioEditar): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($usuarioEditar['id']) ?>">
        <?php endif; ?>
        <section class="form-row">
            <label class="form-label flex-grow">
                Nombre
                <input type="text" class="form-control" name="nombre" required value="<?= isset($usuarioEditar) && $usuarioEditar ? htmlspecialchars($usuarioEditar['nombre']) : '' ?>">
            </label>
            <label class="form-label flex-grow">
                Apellido
                <input type="text" class="form-control" name="apellido" required value="<?= isset($usuarioEditar) && $usuarioEditar ? htmlspecialchars($usuarioEditar['apellido']) : '' ?>">
            </label>
        </section>
        <section class="form-row">
            <label class="form-label flex-grow">
                Usuario
                <input type="text" class="form-control" name="usuario" required value="<?= isset($usuarioEditar) && $usuarioEditar ? htmlspecialchars($usuarioEditar['usuario']) : '' ?>">
            </label>
            <label class="form-label flex-grow">
                Contraseña
                <input type="password" class="form-control" name="contrasena" <?= isset($usuarioEditar) && $usuarioEditar ? '' : 'required' ?>>
            </label>
            <label class="form-label flex-grow">
                Rol
                <select class="form-control" name="rol" required>
                    <option value="">Seleccione...</option>
                    <option value="administrador" <?= (isset($usuarioEditar) && $usuarioEditar && $usuarioEditar['rol'] == 'administrador') ? 'selected' : '' ?>>Administrador</option>
                    <option value="usuario" <?= (isset($usuarioEditar) && $usuarioEditar && $usuarioEditar['rol'] == 'usuario') ? 'selected' : '' ?>>Usuario</option>
                </select>
            </label>
        </section>
        <div class="form-buttons">
            <?php if (isset($usuarioEditar) && $usuarioEditar): ?>
                <!-- si estas editando, muestra el boton de actualizar y el de cancelar -->
                <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
                <a href="index.php?vista=usuarios" class="btn btn-secondary">Cancelar</a>
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
    <h1>Tabla de usuarios</h1>
    <div class="titulo-linea"></div>
    <!-- aca se muestra la tabla con todos los usuarios registrados -->
    <table class="device-table" id="usuariosTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['id']) ?></td>
                    <td><?= htmlspecialchars($u['nombre']) ?></td>
                    <td><?= htmlspecialchars($u['apellido']) ?></td>
                    <td><?= htmlspecialchars($u['usuario']) ?></td>
                    <td><?= htmlspecialchars($u['rol']) ?></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:6px;">
                            <!-- los botones para editar o eliminar el usuario -->
                            <a href="index.php?vista=usuarios&editar=<?= urlencode($u['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
                            <span>|</span>
                            <a href="index.php?vista=usuarios&eliminar=<?= urlencode($u['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>