<?php
include("utils/http.utils.php");

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $ok = true;
    $pattern = array('a', 'b', 'g', 'l', 'o', 'p', 'r', 't');
    foreach ($pattern as $char) {
        if (!strstr($token, $char)) {
            $ok = false;
            break;
        }
    }
    if ($ok) {
        header('Content-Type: application/json');
        include("../include/config.db.php");
        include("class.JsonHandler.php");

        $handler = new JsonHandler($sql_login_host, $sql_login_user, $sql_login_pass, $sql_login_db);

        $lang = isset($_GET['language']) ? $_GET['language'] : 'cs';
        echo $handler->get_problems($lang);
    } else {
        http_response_code(400);
        echo json_encode(array('status' => "wrong_token"));
    }
}
