<?php
require_once 'database.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? '';
    
    $errors = [];
    $data = $_POST;
    
    if (empty(trim($data['nombre'] ?? ''))) {
        $errors['nombre'] = 'El nombre es requerido';
    }
    if (empty(trim($data['apellido'] ?? ''))) {
        $errors['apellido'] = 'El apellido es requerido';
    }
    if (empty(trim($data['correo'] ?? ''))) {
        $errors['correo'] = 'El correo es requerido';
    } elseif (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
        $errors['correo'] = 'El correo no es válido';
    }
    if (empty(trim($data['carnet'] ?? ''))) {
        $errors['carnet'] = 'El carnet de identidad es requerido';
    }
    
    if (empty($errors)) {
        $user = [
            'nombre' => trim($data['nombre']),
            'apellido' => trim($data['apellido']),
            'correo' => trim($data['correo']),
            'carnet' => trim($data['carnet'])
        ];
        
        if ($action === 'update' && !empty($data['id'])) {
            $db->update($data['id'], $user);
            header('Location: index.php?mensaje=Usuario actualizado exitosamente&mensajeType=success');
            exit;
        } else {
            $db->create($user);
            header('Location: index.php?mensaje=Usuario creado exitosamente&mensajeType=success');
            exit;
        }
    } else {
        $user = $data;
        $errorsParam = urlencode(json_encode($errors));
        $userParam = urlencode(json_encode($user));
        
        if ($action === 'update' && !empty($data['id'])) {
            header('Location: form.php?id=' . $data['id'] . '&errors=' . $errorsParam . '&user=' . $userParam);
            exit;
        } else {
            header('Location: form.php?errors=' . $errorsParam . '&user=' . $userParam);
            exit;
        }
    }
}

$usuarios = $db->getAll();
$mensaje = $_GET['mensaje'] ?? '';
$mensajeType = $_GET['mensajeType'] ?? 'success';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Usuarios</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Usuarios</h1>
        
        <?php if ($mensaje): ?>
            <div class="alert alert-<?= $mensajeType ?>">
                <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php endif; ?>
        
        <a href="form.php" class="btn btn-primary">+ Nuevo Usuario</a>
        
        <?php if (empty($usuarios)): ?>
            <div class="empty-state">
                <p>No hay usuarios registrados.</p>
            </div>
        <?php else: ?>
            <table class="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Carnet</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['nombre']) ?></td>
                            <td><?= htmlspecialchars($user['apellido']) ?></td>
                            <td><?= htmlspecialchars($user['correo']) ?></td>
                            <td><?= htmlspecialchars($user['carnet']) ?></td>
                            <td class="actions">
                                <a href="form.php?id=<?= $user['id'] ?>" class="btn btn-edit">Editar</a>
                                <a href="api.php?action=delete&id=<?= $user['id'] ?>" class="btn btn-delete" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <div class="info">
            <p><strong>Total de usuarios:</strong> <?= count($usuarios) ?></p>
            <p><strong>Persistencia:</strong> Los datos se guardan en <code>database.json</code></p>
        </div>
    </div>
</body>
</html>
