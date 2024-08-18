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

$shot = $_GET["shot"];

// Consultas de datos
$data_day   = [];
$data_month = [];
$data_year  = [];

// Fecha actual
$today        = new DateTime();
$currentYear  = $today->format('Y');
$currentMonth = $today->format('m');
$lastTenYears = range($currentYear - 10, $currentYear);

// Consulta de datos por día (solo para el mes actual)
$sql_day  = "SELECT DAY(access_time) as day, COUNT(*) as count 
                FROM telemetry 
                WHERE YEAR(access_time) = :year AND MONTH(access_time) = :month AND short_link = :short_link
                GROUP BY DAY(access_time)
                ORDER BY DAY(access_time) ASC";
$stmt_day = $connect->prepare($sql_day);
$stmt_day->execute(['year' => $currentYear, 'month' => $currentMonth, 'short_link' => $shot]);
$data_day = $stmt_day->fetchAll(PDO::FETCH_ASSOC);

// Consulta de datos por mes (solo para el año actual)
$sql_month  = "SELECT MONTH(access_time) as month, COUNT(*) as count 
              FROM telemetry 
              WHERE YEAR(access_time) = :year AND short_link = :short_link
              GROUP BY MONTH(access_time)";
$stmt_month = $connect->prepare($sql_month);
$stmt_month->execute(['year' => $currentYear, 'short_link' => $shot]);
$data_month = $stmt_month->fetchAll(PDO::FETCH_ASSOC);

// Consulta de datos por año (solo para los últimos 10 años)
$sql_year  = "SELECT YEAR(access_time) as year, COUNT(*) as count 
             FROM telemetry 
             WHERE YEAR(access_time) BETWEEN :start_year AND :end_year AND short_link = :short_link
             GROUP BY YEAR(access_time)";
$stmt_year = $connect->prepare($sql_year);
$stmt_year->execute(['start_year' => min($lastTenYears), 'end_year' => max($lastTenYears), 'short_link' => $shot]);
$data_year = $stmt_year->fetchAll(PDO::FETCH_ASSOC);

/* ========== Theme config ========= */
$theme_title = "Gráficas de Registros de Telemetría";
$theme_path  = "link-list";
include BASE_DIR_ADMIN . "/views/links/view.view.php";
/* ================================= */