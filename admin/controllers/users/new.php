<?php

require_once "../../core.php";

if (!isUserLoggedIn()) {
  header('Location: ' . APP_URL . '/admin/controllers/login.php');
  exit();
}

if (!$accessControl->hasAccess([0, 1], $_SESSION['user_role'])) {
  header("Location: " . APP_URL . "/admin/controllers/dashboard.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Obtener los datos del formulario y limpiarlos
  $user_name   = cleardata($_POST['user_name']);
  $user_email  = cleardata($_POST['user_email']);
  $user_role   = cleardata($_POST['user_role']);
  $user_status = cleardata($_POST['user_status']);
  $password    = cleardata($_POST['user_password']);

  // Validar el nombre de usuario (mínimo 4 caracteres)
  if (strlen($user_name) < 4) {
    add_message("El nombre de usuario debe tener al menos 4 caracteres.", "danger");
  } else {
    // Verificar si el nombre de usuario ya existe en la base de datos
    $query     = "SELECT COUNT(*) AS count FROM users WHERE user_name = :user_name";
    $statement = $connect->prepare($query);
    $statement->bindParam(':user_name', $user_name);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
      add_message("El nombre de usuario ya está en uso.", "danger");
    }
  }

  // Validar el formato y la unicidad del email
  if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
    add_message("El email ingresado no es válido.", "danger");
  } else {
    // Verificar si el email ya está registrado en la base de datos
    $query     = "SELECT COUNT(*) AS count FROM users WHERE user_email = :user_email";
    $statement = $connect->prepare($query);
    $statement->bindParam(':user_email', $user_email);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
      add_message("El email ya está registrado.", "danger");
    }
  }

  // Validar selected
  if (!in_array($user_role, [1, 2])) {
    add_message("Seleccionar rol.", "danger");
  }

  // Validar selected
  if (!in_array($user_status, [1, 2])) {
    add_message("Seleccionar estatus.", "danger");
  }

  // Si no hay mensajes de error, proceder con la inserción
  if (!has_error_messages()) {
    $hashed_password = $encryption->encrypt($password);

    // Preparar la consulta SQL para la inserción
    $query     = "INSERT INTO users (user_name, user_email, user_role, user_status, user_password, user_updated) VALUES (:user_name, :user_email, :user_role, :user_status, :user_password, CURRENT_TIME)";
    $statement = $connect->prepare($query);

    // Enlazar los parámetros
    $statement->bindParam(':user_name', $user_name);
    $statement->bindParam(':user_email', $user_email);
    $statement->bindParam(':user_role', $user_role);
    $statement->bindParam(':user_status', $user_status);
    $statement->bindParam(':user_password', $hashed_password);

    // Ejecutar la consulta de inserción
    if ($statement->execute()) {
      add_message("El nuevo usuario se insertó correctamente.", "success");
      header("Location: list.php");
      exit();
    } else {
      add_message("Hubo un error al intentar insertar el nuevo usuario.", "danger");
    }
  }
}

/* ========== Theme config ========= */
$theme_title = "Usuario nuevo";
$theme_path  = "user-new";
// $theme_scripts = ["js/clear.js"];
// $theme_styles = ["pages/dashboard.css"];
include BASE_DIR_ADMIN . "/views/users/new.view.php";
/* ================================= */


