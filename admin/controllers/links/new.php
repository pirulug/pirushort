<?php

require_once "../../core.php";

$accessControl->require_login(SITE_URL_ADMIN . "/controllers/login.php");
$accessControl->check_access([1, 2], SITE_URL . "/404.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = cleardata($_POST["title"]);
  $link  = cleardata($_POST["link"]);

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

  // Enlace corto
  $short = getUniqueHash($connect);

  if (!$messageHandler->hasMessagesOfType('danger')) {
    $query = "INSERT INTO links (title, link, short) VALUES (:title, :link, :short)";
    $stmt  = $connect->prepare($query);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":link", $link);
    $stmt->bindParam(":short", $short);

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
$theme_title = "Nuevo Link";
$theme_path  = "link-new";
include BASE_DIR_ADMIN . "/views/links/new.view.php";
/* ================================= */