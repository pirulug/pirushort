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

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page   = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit  = 10;
$offset = ($page - 1) * $limit;

// Condiciones adicionales dinámicas
$searchColumns = ['title'];

$additionalConditions = [];

$total_results = getTotalResults('links', $searchColumns, $search, $additionalConditions, $connect);
$total_pages   = ceil($total_results / $limit);

$links = getPaginatedResults('links', $searchColumns, $search, $additionalConditions, $limit, $offset, $connect);

/* ========== Theme config ========= */
$theme_title = "Lista de Links";
$theme_path  = "link-list";
include BASE_DIR_ADMIN . "/views/links/list.view.php";
/* ================================= */