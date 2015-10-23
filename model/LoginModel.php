<?php
require_once('model/User.php');
class LoginModel {
	private $userDAL;
	private $user;

	public function __construct($userDAL)
	{
		$this->userDAL = $userDAL;
		if(!isset($_SESSION['userLoggedIn']))
		{
			$_SESSION['userLoggedIn'] = false;
		}
	}

	public function attemptLogin($Uname, $Pword){
		$this->user = $this->userDAL->getUserByUsername($Uname);
		if(isset($this->user))
		{
			if($this->user->comparePassword($Pword))		
			{			
	 			$_SESSION['userLoggedIn'] = true;
	 			$_SESSION['LoggedInUser'] = $Uname;		
			}
		}
	}
	public function logout(){
 			$_SESSION['userLoggedIn'] = false;	
 			unset($_SESSION['LoggedInUser']);		
	}
	public function isUserLoggedIn(){
		if($_SESSION['userLoggedIn'])
		{
			return $_SESSION['userLoggedIn'];
		}
		return false;
	}

}