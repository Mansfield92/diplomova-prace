<?php

class login {
	var $login_name,$login_pw,$is_logged,$checktimelimit,$session_string,$bug,$con;

	function __construct($sql_login_host, $sql_login_user, $sql_login_pass, $sql_login_db){
        $this->con = mysqli_connect($sql_login_host, $sql_login_user, $sql_login_pass, $sql_login_db);
        $this->con->set_charset('utf8');
		$this->checktimelimit=(15*60);
		$this->is_logged = $this->logged();
		$this->is_logged = ($this->is_logged == 0 ? $this->first_login() : $this->is_logged);
	}

	private function first_login(){
		if (isset($_POST['login_name']) && strlen($_POST['login_name'])>1){
            $isFine = $this->testMatch($_POST['login_name'],$_POST['login_pw']);
            if($isFine){
				$this->load();
				return 1;
			}
		} 
		return 0;
	}

    private function testMatch($n,$p){
	    $select = "SELECT nickname, password from users WHERE nickname = '$n' AND password = md5('$p') AND active = 1";
	    $select = $this->con->query($select);
	    return $select->num_rows > 0;
    }

	private function load(){
		$this->login_name = $_POST['login_name'];
		$this->login_pw = $_POST['login_pw'];
		$this->session_string = md5($this->login_name.$this->login_pw);
		$_SESSION['login_name'] = $_POST['login_name'];
		$_SESSION['login_pw'] = $_POST['login_pw'];
		$_SESSION['session_string'] = md5($this->login_name.$this->login_pw);
	}

	function logout(){
		$this->session_login_string=md5(uniqid(rand()));
		$this->login_name=md5(uniqid(rand()));
		session_unset();
		session_destroy();
		$this->is_logged = $this->logged();
	}

	function logged() {
		if((isset($_SESSION['login_name']) && isset($_SESSION['login_pw'])) && ($this->testMatch($_SESSION['login_name'],$_SESSION['login_pw']))){
			if($_SESSION['session_string'] == md5($_SESSION['login_name'].$_SESSION['login_pw'])){
				$this->login_name = $_SESSION['login_name'];
				$this->login_pw = $_SESSION['login_pw'];
				$this->session_string = $_SESSION['session_string'];
				return (1);
			}
		}
		return (0);
	}
}
