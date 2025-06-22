<?php include 'header.php'; ?>
<div class="main p-3">
    <h1>Gestión de Usuarios</h1>
    <div class="titulo-linea"></div>
    <!-- Formulario de registro o edición -->
        <?php if (isset($usuarioEditar) && $usuarioEditar): ?>
            <form method="POST" class="user-form mb-4">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuarioEditar['id']); ?>">
                <div class="form-row">
                    <input type="text" name="nombre" placeholder="Nombre" required value="<?php echo htmlspecialchars($usuarioEditar['nombre']); ?>">
                    <input type="text" name="apellido" placeholder="Apellido" required value="<?php echo htmlspecialchars($usuarioEditar['apellido']); ?>">
                </div>
                <div class="form-row">
                    <input type="text" name="usuario" placeholder="Usuario" required value="<?php echo htmlspecialchars($usuarioEditar['usuario']); ?>">
                    <input type="password" name="contrasena" placeholder="Contraseña">
                </div>
                <select name="rol" required>
                    <option value="administrador" <?php if($usuarioEditar['rol']=='administrador') echo 'selected'; ?>>Administrador</option>
                    <option value="usuario" <?php if($usuarioEditar['rol']=='usuario') echo 'selected'; ?>>Usuario</option>
                </select>
                <div class="edit-actions">
                    <button type="submit" name="actualizar">Actualizar</button>
                    <a href="index.php" class="btn-secondary">Cancelar</a>
                </div>
            </form>
        <?php else: ?>
            <form method="POST" class="user-form mb-4">
                <div class="form-row">
                    <input type="text" name="nombre" placeholder="Nombre" required>
                    <input type="text" name="apellido" placeholder="Apellido" required>
                </div>
                <div class="form-row">
                    <input type="text" name="usuario" placeholder="Nombre de Usuario" required>
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                </div>
                <select name="rol" required>
                    <option value="">Seleccione Rol</option>
                    <option value="administrador">Administrador</option>
                    <option value="usuario">Usuario</option>
                </select>
                <button type="submit" name="registrar">Registrar</button>
            </form>
        <?php endif; ?>

    <!-- Buscador -->

    <h1>Tabla de registros</h1>
    <div class="titulo-linea"></div>
    <input type="text" id="searchInput" class="user-table-search" placeholder="Buscar usuario...">

    <!-- Tabla de usuarios -->
    <table class="user-table" id="userTable">
        <thead>
            <tr>
                <th>N°</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
           <?php $contador = 1;?>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo $contador++; ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['usuario']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                        <td>
                            <a href="index.php?editar=<?php echo $usuario['id']; ?>">Editar</a> |
                            <a href="index.php?eliminar=<?php echo $usuario['id']; ?>" onclick="return confirm('¿Seguro?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No hay usuarios registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>