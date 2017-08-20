<?php

$method = $_SERVER['REQUEST_METHOD'];
$view = $_GET['view'] ?? false;

require_once("../include/config.db.php");
include ('generic_actions.php');

$con = mysqli_connect($sql_login_host, $sql_login_user, $sql_login_pass, $sql_login_db);
if($con){
    $con->set_charset("utf8");
}else{
    die('database error');
}

$json = array();

include "_$view.php";

return json_encode($json, true);
