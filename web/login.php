<?php

session_start();
error_reporting(E_ALL & ~E_NOTICE);

include "include/config.db.php";
include("include/class.login.php");

if (isset($login)) {
    $login->is_logged = $login->logged();
} else {
    $login = new login($sql_login_host, $sql_login_user, $sql_login_pass, $sql_login_db);
}

if ($login->is_logged == 1) {
    header('location: /categories');
}else {
?>

<!DOCTYPE html >
<html>
<head>
    <title>My pool doctor login</title>
    <?php
        include '_templates/_partials/_header.php';
    ?>
    <script type="text/javascript" src="/js/login.js"></script>
<!--    <script type="text/javascript" src="http://localhost:8080/login.js"></script>-->

</head>
<body class="login-page">
<div class="login">
    <div class="login__inner visible ">
        <div class="content__row ">
            <input id="input-username" placeholder="Nickname" type="text" class="input" value=""/>
            <input id="input-password" placeholder="Password" type="password" class="input" value=""/>
        </div>
        <div class="content__row content__row--error hidden login-error"></div>
        <div class="button login-button">Login</div>
        <div class="login-link login-register">Register</div>
    </div>
    <div class="login__inner register__inner">
        <div class="content__row">
            <input id="register-name" placeholder="Name" type="text" class="input" value=""/>
            <input id="register-username" placeholder="Nickname" type="text" class="input" value=""/>
            <input id="register-password" placeholder="Password" type="password" class="input" value=""/>
            <input id="register-password2" placeholder="Confirm password" type="password" class="input" value=""/>
        </div>
        <div class="content__row content__row--error hidden register-error"></div>
        <div class="button register-button">Register</div>
        <div class="login-link login-login">Login</div>
    </div>
</div>
</body>
</html>
    <?php
    }
?>
