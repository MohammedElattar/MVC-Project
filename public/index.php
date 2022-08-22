<?php
ob_start();
session_start();
include_once("../app/init.php");
$app = new App();
ob_end_flush();
