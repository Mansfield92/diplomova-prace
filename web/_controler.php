<?php

session_start();

header("Content-Type: text/html");

$script_version = 5;
$page = $_GET['page'];


include('include/config.db.php');
include("include/class.login.php");
if (isset($login)) {
    $login->is_logged = $login->logged();
} else {
    $login = new login($sql_login_host, $sql_login_user, $sql_login_pass, $sql_login_db);
}
if (isset($_POST['logout'])) {
    $login->logout();
}
if ($login->is_logged != 1) {
    header('location:  /');
} else {

    $user = $_SESSION['login_name'];

    $user = $con->query("SELECT * from users where nickname = '$_SESSION[login_name]'");
    $user = $user->fetch_assoc();

    $titles = array(
        'categories' => 'Categories',
        'products' => 'Products',
        'users' => 'Users',
        'issues' => 'Issues',
        'testapi' => 'Api',
        'xml' => 'XML feed',
    );

    $title =  $titles[$page];

    include '_templates/_partials/_header.php';

    ?>
    <body class="<?php echo (!isset($_GET['detail']) ? 'body-'.$page : '') ?>">
        <?php
            include '_templates/_partials/_navbar.php';
            include '_templates/_partials/_sidebar.php';

            if(isset($_GET['detail'])){
                $detail = $_GET['detail'];
                include "_templates/$page-detail.php";
            }else{
                include "_templates/$page.php";
            }

            include '_templates/_partials/_footer.php'
        ?>
    </body>
    </html>
    <?php
}
?>
