<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit;
}
 
include("panel.html");
?>
