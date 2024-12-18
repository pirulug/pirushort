<?php

require_once "../../core.php";

$accessControl->require_login(SITE_URL_ADMIN . "/controllers/login.php");
$accessControl->check_access([1, 2], SITE_URL . "/404.php");

// Si no tine id
if (!isset($_GET["id"]) || $_GET["id"] == "") {
  add_message("Tienes que tener un id.", "danger");
  header("Location: list.php");
  exit();
}

$id = $encryption->decrypt($_GET["id"]);

// Comprobar si existe el link en la DB
$query = "SELECT * FROM links WHERE id = $id";
$stmt  = $connect->prepare($query);
$stmt->execute();
$link = $stmt->fetch(PDO::FETCH_OBJ);

if (empty($link)) {
  $messageHandler->addMessage("Link no encontrado.", "danger");
  header("Location: list.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $link  = $_POST['link'];
  $id  = $_POST['id'];

  // Validación del título
  if (empty($title)) {
    $messageHandler->addMessage("El título no debe estar vacío.", "danger");
  }

  // Validación del link
  if (empty($link)) {
    $messageHandler->addMessage("El enlace no debe estar vacío.", "danger");
  } elseif (!filter_var($link, FILTER_VALIDATE_URL)) {
    $messageHandler->addMessage("El enlace no es válido. Por favor, ingresa una URL correcta.", "danger");
  }

  if (!$messageHandler->hasMessagesOfType('danger')) {
    $query = "UPDATE links SET title=:title, link=:link WHERE id=:id";
    $stmt  = $connect->prepare($query);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":link", $link);
    $stmt->bindParam(":id", $id);

    if ($stmt->execute()) {
      $messageHandler->addMessage("El nuevo link se insertó correctamente.", "success");
      header("Location: list.php");
      exit();
    } else {
      $messageHandler->addMessage("Hubo un error al intentar insertar el nuevo link.", "danger");
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