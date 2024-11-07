<?php

require_once "core.php";

header("Location: ". SITE_URL_ADMIN);

$pageTitle="Home";
include "views/index.view.php";