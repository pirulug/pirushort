<?php

require_once "../core.php";

$accessControl->require_login(SITE_URL_ADMIN . "/controllers/login.php");
$accessControl->check_access([1, 2], SITE_URL . "/404.php");

// Consultas de datos
$data_day   = [];
$data_month = [];
$data_year  = [];

// Fecha actual
$today        = new DateTime();
$currentYear  = $today->format('Y');
$currentMonth = $today->format('m');
$lastTenYears = range($currentYear - 10, $currentYear);
$todayDate    = $today->format('Y-m-d');

// Consulta de datos por día (solo para el mes actual)
$sql_day  = "SELECT DAY(access_time) as day, COUNT(*) as count 
                FROM telemetry 
                WHERE YEAR(access_time) = :year AND MONTH(access_time) = :month
                GROUP BY DAY(access_time)
                ORDER BY DAY(access_time) ASC";
$stmt_day = $connect->prepare($sql_day);
$stmt_day->execute(['year' => $currentYear, 'month' => $currentMonth]);
$data_day = $stmt_day->fetchAll(PDO::FETCH_ASSOC);

// Consulta de datos por mes (solo para el año actual)
$sql_month  = "SELECT MONTH(access_time) as month, COUNT(*) as count 
              FROM telemetry 
              WHERE YEAR(access_time) = :year
              GROUP BY MONTH(access_time)";
$stmt_month = $connect->prepare($sql_month);
$stmt_month->execute(['year' => $currentYear]);
$data_month = $stmt_month->fetchAll(PDO::FETCH_ASSOC);

// Consulta de datos por año (solo para los últimos 10 años)
$sql_year  = "SELECT YEAR(access_time) as year, COUNT(*) as count 
             FROM telemetry 
             WHERE YEAR(access_time) BETWEEN :start_year AND :end_year
             GROUP BY YEAR(access_time)";
$stmt_year = $connect->prepare($sql_year);
$stmt_year->execute(['start_year' => min($lastTenYears), 'end_year' => max($lastTenYears)]);
$data_year = $stmt_year->fetchAll(PDO::FETCH_ASSOC);

// Consulta del total de visitas hoy
$sql_today  = "SELECT COUNT(*) as count FROM telemetry WHERE DATE(access_time) = :today";
$stmt_today = $connect->prepare($sql_today);
$stmt_today->execute(['today' => $todayDate]);
$total_visits_today = $stmt_today->fetchColumn();

// Consulta del total de visitas en general
$sql_total  = "SELECT COUNT(*) as count FROM telemetry";
$stmt_total = $connect->prepare($sql_total);
$stmt_total->execute();
$total_visits_all_time = $stmt_total->fetchColumn();

// Consulta del total de enlaces
$sql_links  = "SELECT COUNT(*) as count FROM links";
$stmt_links = $connect->prepare($sql_links);
$stmt_links->execute();
$total_links = $stmt_links->fetchColumn();

// Consulta del total de usuarios
$sql_users  = "SELECT COUNT(*) as count FROM users WHERE user_role != 0";
$stmt_users = $connect->prepare($sql_users);
$stmt_users->execute();
$total_users = $stmt_users->fetchColumn();

// lista de visitantes
$sql_visits  = "SELECT * FROM telemetry  ORDER BY access_time DESC LIMIT 10";
$stmt_visits = $connect->prepare($sql_visits);
$stmt_visits->execute();
$visits = $stmt_visits->fetchAll(PDO::FETCH_OBJ);

/* ========== Theme config ========= */
$theme_title = "Dashboard";
$theme_path  = "dashboard";
include BASE_DIR_ADMIN . "/views/dashboard.view.php";
/* ================================= */