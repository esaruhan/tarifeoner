<?php


class sessison{
	var $user;
	var $userObj;
	function __construct($userid){
		
		global $userCls; # global user class object for gettin user info
		$this->userObj = $userCls;
		$this->user = $userid;
		session_start();
	}
	
	function newSession($login_status){
		if($login_status){
			$_SESSION["userid"]=$this->user;
			$_SESSION["username"] = $this->userObj->getUserName($this->user);
		}
	}
	
	function sessionCheck(){
		if($_ESSION["userid"]>0){
			return true;
		}else{
			return false;
		}
	}
	
	function sessionClose(){
		session_destroy();
	}
}
?>
