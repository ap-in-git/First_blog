<?php
require_once ("../../include/intialize.php");

$session->logout();
$session->message("Logout successfull");
redirect_to("login.php");

