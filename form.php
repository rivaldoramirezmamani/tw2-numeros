<?php
require_once 'database.php';

$errors = $_GET['errors'] ?? [];
if (is_string($errors)) {
    $errors = json_decode(urldecode($errors), true) ?? [];
}
$user = $_GET['user'] ?? [];
if (is_string($user)) {
    $user = json_decode(urldecode($user), true) ?? [];
}
$db = new Database();
$isEdit = isset($_GET['id']) && !empty($_GET['id']);
$editUser = null;

if ($isEdit) {
    $editUser = $db->getById($_GET['id']);
    if (!$editUser) {
        header('Location: index.php?mensaje=Usuario no encontrado&mensajeType=error');
        exit;
    }
    $user = $editUser;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Editar' : 'Crear' ?> Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1><?= $isEdit ? 'Editar' : 'Nuevo' ?> Usuario</h1>
        
        <form method="POST" action="index.php?action=<?= $isEdit ? 'update&id=' . $user['id'] : 'create' ?>">
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($user['nombre'] ?? '') ?>" required>
                <span class="error"><?= $errors['nombre'] ?? '' ?></span>
            </div>
            
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($user['apellido'] ?? '') ?>" required>
                <span class="error"><?= $errors['apellido'] ?? '' ?></span>
            </div>
            
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($user['correo'] ?? '') ?>" required>
                <span class="error"><?= $errors['correo'] ?? '' ?></span>
            </div>
            
            <div class="form-group">
                <label for="carnet">Carnet de Identidad:</label>
                <input type="text" id="carnet" name="carnet" value="<?= htmlspecialchars($user['carnet'] ?? '') ?>" required>
                <span class="error"><?= $errors['carnet'] ?? '' ?></span>
            </div>
            
            <div class="buttons">
                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Actualizar' : 'Crear' ?></button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
