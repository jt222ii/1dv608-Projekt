<?php


session_start();
require_once('controller/GameController.php');

$gc = new GameController();
$gc->startApp();
