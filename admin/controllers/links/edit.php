<?php

require_once "../../core.php";

if (empty($_SESSION['user_id'])) {
  header("Location: " . APP_URL . "/admin/controllers/login.php");
  exit();
}

if (!$accessControl->hasAccess([0, 1], $_SESSION['user_role'])) {
  header("Location: " . APP_URL);
  exit();
}

// Si no tine id
if (!isset($_GET["id"]) || $_GET["id"] == "") {
  add_message("Tienes que tener un id.", "danger");
  header("Location: list.php");
  exit();
}

$id = decrypt($_GET["id"]);

// Comprobar si existe el link en la DB
$query = "SELECT * FROM links WHERE id = $id";
$stmt  = $connect->prepare($query);
$stmt->execute();
$link = $stmt->fetch(PDO::FETCH_OBJ);

if (empty($link)) {
  add_message("Link no encontrado.", "danger");
  header("Location: list.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $link  = $_POST['link'];
  $id  = $_POST['id'];

  // Validación del título
  if (empty($title)) {
    add_message("El título no debe estar vacío.", "danger");
  }

  // Validación del link
  if (empty($link)) {
    add_message("El enlace no debe estar vacío.", "danger");
  } elseif (!filter_var($link, FILTER_VALIDATE_URL)) {
    add_message("El enlace no es válido. Por favor, ingresa una URL correcta.", "danger");
  }

  if (!has_error_messages()) {
    $query = "UPDATE links SET title=:title, link=:link WHERE id=:id";
    $stmt  = $connect->prepare($query);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":link", $link);
    $stmt->bindParam(":id", $id);

    if ($stmt->execute()) {
      add_message("El nuevo link se insertó correctamente.", "success");
      header("Location: list.php");
      exit();
    } else {
      add_message("Hubo un error al intentar insertar el nuevo link.", "danger");
    }
  }
}
/* ========== Theme config ========= */
$theme_title = "Editar Links";
$theme_path  = "link-new";
// $theme_scripts = ["pages/dashboard.js"];
// $theme_styles = ["pages/dashboard.css"];
include BASE_DIR_ADMIN . "/views/links/edit.view.php";
/* ================================= */