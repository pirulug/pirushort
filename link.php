<?php

require_once "core.php";

if (!isset($_GET["short"])) {
  exit("ID is not present in URL");
}

$short = $_GET["short"];

// Consulta para obtener el enlace original
$query = "SELECT * FROM links WHERE short = :short";
$stmt  = $connect->prepare($query);
$stmt->bindParam(":short", $short);
$stmt->execute();
$link = $stmt->fetch(PDO::FETCH_OBJ);

// Verifica si el enlace existe
if ($link) {

  // Redirige al enlace original
  header("Location: $link->link");

  // Recoge la telemetría
  $userIp     = $_SERVER['REMOTE_ADDR']; // IP del usuario
  $userAgent  = $_SERVER['HTTP_USER_AGENT']; // Agente de usuario
  $accessTime = date("Y-m-d H:i:s"); // Fecha y hora del acceso
  $referer    = $_SERVER['HTTP_REFERER'] ?? 'Direct'; // Página de referencia

  // Datos aproximados de localización (país y ciudad)
  $location = getApproximateLocation($userIp);

  // Extraer detalles del agente de usuario
  $device  = getDeviceType($userAgent);
  $os      = getOperatingSystem($userAgent);
  $browser = getBrowser($userAgent);

  // Inserta los datos de telemetría en la base de datos
  $telemetryQuery = "INSERT INTO telemetry (short_link, ip_address, country, city, device, operating_system, browser, access_time, referer) 
                       VALUES (:short, :ip, :country, :city, :device, :os, :browser, :time, :referer)";
  $telemetryStmt  = $connect->prepare($telemetryQuery);
  $telemetryStmt->bindParam(":short", $short);
  $telemetryStmt->bindParam(":ip", $userIp);
  $telemetryStmt->bindParam(":country", $location['country']);
  $telemetryStmt->bindParam(":city", $location['city']);
  $telemetryStmt->bindParam(":device", $device);
  $telemetryStmt->bindParam(":os", $os);
  $telemetryStmt->bindParam(":browser", $browser);
  $telemetryStmt->bindParam(":time", $accessTime);
  $telemetryStmt->bindParam(":referer", $referer);
  $telemetryStmt->execute();

  exit;
} else {
  exit("Short link does not exist");
}

// Función de ejemplo para obtener la ubicación aproximada sin servicios externos
function getApproximateLocation($ip) {
  // Aquí, podrías hacer una aproximación de localización según rangos de IP si cuentas con una base de datos local.
  return [
    'country' => 'Unknown',  // Reemplazar según tu base de datos de IPs
    'city'    => 'Unknown'      // Reemplazar según tu base de datos de IPs
  ];
}

// Función para obtener el tipo de dispositivo
function getDeviceType($userAgent) {
  if (preg_match('/mobile/i', $userAgent)) {
    return 'Mobile';
  } elseif (preg_match('/tablet/i', $userAgent)) {
    return 'Tablet';
  } else {
    return 'Desktop';
  }
}

// Función para obtener el sistema operativo
function getOperatingSystem($userAgent) {
  $osArray = [
    'Windows NT 11.0' => 'Windows 11',
    'Windows NT 10.0' => 'Windows 10',
    'Windows NT 6.3'  => 'Windows 8.1',
    'Windows NT 6.2'  => 'Windows 8',
    'Windows NT 6.1'  => 'Windows 7',
    'Windows NT 6.0'  => 'Windows Vista',
    'Windows NT 5.1'  => 'Windows XP',
    'Macintosh'       => 'Mac OS X',
    'Android'         => 'Android',
    'iPhone'          => 'iOS',
    'Linux'           => 'Linux'
  ];

  foreach ($osArray as $key => $value) {
    if (stripos($userAgent, $key) !== false) {
      return $value;
    }
  }
  return 'Unknown';
}

// Función para obtener el navegador
function getBrowser($userAgent) {
  $browserArray = [
    'MSIE'        => 'Internet Explorer',
    'Trident/7.0' => 'Internet Explorer 11',
    'Edge'        => 'Edge',
    'Firefox'     => 'Firefox',
    'Chrome'      => 'Chrome',
    'Safari'      => 'Safari',
    'Opera'       => 'Opera'
  ];

  foreach ($browserArray as $key => $value) {
    if (stripos($userAgent, $key) !== false) {
      return $value;
    }
  }
  return 'Unknown';
}
