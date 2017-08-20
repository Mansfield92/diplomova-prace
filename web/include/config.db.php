<?php

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(gethostname() == 'Neo-PC'){
    #Localhost version
    $sql_login_host = "localhost"; # MySQL Host
    $sql_login_user = "root"; # MySql UserName
    $sql_login_pass = ""; # MySql Password
    $sql_login_db = "diplomka"; # MySql Database
}else{
    #Localhost version
    $sql_login_host = "localhost"; # MySQL Host
    $sql_login_user = "root"; # MySql UserName
    $sql_login_pass = "root"; # MySql Password
    $sql_login_db = "diplomka"; # MySql Database
}

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

if(strlen($url['path']) > 1){
    $sql_login_host = $url['host'];
    $sql_login_user = $url['user'];
    $sql_login_pass = $url['pass'];
    $sql_login_db = substr($url['path'], 1);
}

global $con;
$con = mysqli_connect($sql_login_host, $sql_login_user, $sql_login_pass, $sql_login_db);
$con->set_charset('utf8');

//
//$test = $con->query("SELECT * FROM users");
//
//error_reporting(E_ALL & ~E_NOTICE);
//
//echo $con->error;
//while ($r = $test->fetch_row()){
//    print_r($r);
//}
