<?php
if (session_id() == '')
    session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "core/config.php";
include("core/database.php");
include("core/controller.php");
include("core/functions.php");
include("core/app.php");
