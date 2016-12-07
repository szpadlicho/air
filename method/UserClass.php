<?php
include_once 'DefineConnect.php';
class UserClass extends DefineConnect
{
    public function __setTable($tab_name)
    {
		$this->table = $tab_name;
		$this->prefix = $tab_name[0].'_';
	}
    public function getUser($user, $pass)
    {
		$con=$this->connectDb();
		$q = $con->query("SELECT `user_name` FROM `".$this->table."` WHERE `user_name` = '".$user."' AND `user_pass` = '".md5($pass)."' ");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
        $q = $q->fetch(PDO::FETCH_ASSOC);
		return $q;
	}
    public function loginUser($user, $pass, $remember)
    {
        $user = $this->getUser($user, $pass);
        if ( $user ) {
            if ( $remember == 'on' ) {
            setcookie('air', 'allowed');
            var_dump($_COOKIE);
            Header('Location: '.$_SERVER['PHP_SELF'].'?back');
            return true;
            } else {
                $_SESSION['air'] = 'allowed';
                return true;
            }
        } else {
            return false;
        }
    }
    public function checkUser()
    {
        //hmmm
    }
    public function logoutUser()
    { 
        //session_destroy();
        unset($_SESSION['air']);
        //unset($_COOKIE['air']);
        setcookie('air', null, time()-3600);
        var_dump($_COOKIE);
        //$_SERVER['SERVER_NAME'] $_SERVER['REQUEST_URI']       'back&logout' 'localhost'
        $link = str_replace("&logout","",$_SERVER['REQUEST_URI']);
        Header('Location: '.$link);
        //Header('Location: '.$_SERVER['PHP_SELF'].'?back');
    }
}
$obj_User = new UserClass;
$obj_User->__setTable('user');
if( isset($_POST['login']) && isset($_POST['user']) && isset($_POST['pass']) ){
    /** login **/
    isset($_POST['remember']) ? $remember = $_POST['remember'] : $remember = 'off';
    $user = $obj_User->loginUser($_POST['user'], $_POST['pass'], $remember);
}
if( isset($_GET['logout']) && !isset($_POST['login']) ){
    /** logout **/
    $obj_User->logoutUser();
}
