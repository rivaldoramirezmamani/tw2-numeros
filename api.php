<?php
require_once 'database.php';

header('Content-Type: application/json');

$db = new Database();
$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'list':
        echo json_encode(['success' => true, 'data' => $db->getAll()]);
        break;

    case 'read':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $user = $db->getById($id);
            if ($user) {
                echo json_encode(['success' => true, 'data' => $user]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'ID requerido']);
        }
        break;

    case 'create':
        $data = $_POST;
        $errors = validate($data);
        
        if (empty($errors)) {
            $user = [
                'nombre' => trim($data['nombre']),
                'apellido' => trim($data['apellido']),
                'correo' => trim($data['correo']),
                'carnet' => trim($data['carnet'])
            ];
            $created = $db->create($user);
            echo json_encode(['success' => true, 'data' => $created]);
        } else {
            echo json_encode(['success' => false, 'errors' => $errors]);
        }
        break;

    case 'update':
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        $data = $_POST;
        $errors = validate($data);
        
        if ($id && empty($errors)) {
            $user = [
                'nombre' => trim($data['nombre']),
                'apellido' => trim($data['apellido']),
                'correo' => trim($data['correo']),
                'carnet' => trim($data['carnet'])
            ];
            $updated = $db->update($id, $user);
            if ($updated) {
                echo json_encode(['success' => true, 'data' => $updated]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
            }
        } else {
            echo json_encode(['success' => false, 'errors' => $errors]);
        }
        break;

    case 'delete':
        $id = $_GET['id'] ?? null;
        if ($id) {
            if ($db->delete($id)) {
                echo json_encode(['success' => true, 'message' => 'Usuario eliminado']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'ID requerido']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}

function validate($data) {
    $errors = [];
    
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
    
    return $errors;
}
