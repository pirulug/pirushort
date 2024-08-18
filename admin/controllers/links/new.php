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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = cleardata($_POST["title"]);
  $link  = cleardata($_POST["link"]);

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

  // Enlace corto
  $short = getUniqueHash($connect);

  if (!has_error_messages()) {
    $query = "INSERT INTO links (title, link, short) VALUES (:title, :link, :short)";
    $stmt  = $connect->prepare($query);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":link", $link);
    $stmt->bindParam(":short", $short);

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
$theme_title = "Nuevo Link";
$theme_path  = "link-new";
include BASE_DIR_ADMIN . "/views/links/new.view.php";
/* ================================= */