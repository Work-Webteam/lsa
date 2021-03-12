<?php
session_start();

// Storing session data
//$_SESSION["firstname"] = "Pater";
$_SESSION["lastname"] = "Porker";

// Accessing session data
echo 'Hi, ' . $_SESSION["firstname"] . ' ' . $_SESSION["lastname"];
