﻿<?php
session_start();
if(!isset($_COOKIE["dados"]) and !isset($_SESSION["dados"])){
header("Location: login.html");
}
?>
