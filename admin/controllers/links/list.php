<?php

require_once "../../core.php";

$accessControl->require_login(SITE_URL_ADMIN . "/controllers/login.php");
$accessControl->check_access([1, 2], SITE_URL . "/404.php");

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