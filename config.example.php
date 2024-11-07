<?php

/*-------------------------------------------------------------------
|
|  _____ _            _             
| |  __ (_)          | |            
| | |__) | _ __ _   _| |_   _  __ _ 
| |  ___/ | '__| | | | | | | |/ _` |
| | |   | | |  | |_| | | |_| | (_| |
| |_|   |_|_|   \__,_|_|\__,_|\__, |
|                              __/ |
|                             |___/ 
|                                     
| Author        : Pirulug
| Author URI    : https://github.com/pirulug
| Project       : PhpInstaller
| Version       : 0.0.1
| License       : MIT
---------------------------------------------------------------------*/

// Configuración de la base de datos
const DB_HOST = "HOST_DB";
const DB_NAME = "NAME_DB";
const DB_USER = "USER_DB";
const DB_PASS = "PASS_DB";

// Configuración de la aplicación
const SITE_NAME = "Start PHP";
const SITE_URL = "URL_WEB"; // Sin "/" al final de la url
const SITE_URL_ADMIN = SITE_URL . "/admin";

// LENGTH HASH
const LENGTH_HASH = 6;

// Directorio Base
const BASE_DIR = __DIR__;
const BASE_DIR_ADMIN = __DIR__ . "/admin";

// Claves
const ENCRYPT_METHOD = "AES-256-CBC";
const ENCRYPT_KEY = '$STARTPHP@2024PIRU';
const ENCRYPT_IV = '456232132132432234132';

// Configuración de la zona horaria
date_default_timezone_set("America/Lima");