<?php
require_once "..conn/conn.php";
session_destroy();
header("location: index.php");
?>
