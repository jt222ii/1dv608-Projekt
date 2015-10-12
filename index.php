<?php
session_start();
require_once('controller/MasterController.php');

$mc = new MasterController();
$mc->startApp();
