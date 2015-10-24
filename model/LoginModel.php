<?php
require_once('model/User.php');
class LoginModel {
	private $userDAL;
	private $user;
	private $SessionManager;

	public function __construct(userDAL $userDAL, SessionManager $SessionManager)
	{
		$this->SessionManager = $SessionManager;
		$this->userDAL = $userDAL;
	}

	public function attemptLogin($Uname, $Pword){
		$this->user = $this->userDAL->getUserByUsername($Uname);
		if(isset($this->user))
		{
			if($this->user->comparePassword($Pword))		
			{			
				$this->SessionManager->SessionSetLoggedInUser($Uname);
				$this->SessionManager->SessionSetIsUserLoggedIn(true);
			}
		}
	}
	public function logout(){
			$this->SessionManager->SessionSetIsUserLoggedIn(false);
 			$this->SessionManager->SessionSetLoggedInUser("");		
	}
	public function isUserLoggedIn(){
		if($this->SessionManager->SessionGetIsUserLoggedIn() != null)
		{
			return $this->SessionManager->SessionGetIsUserLoggedIn();
		}
		return false;
	}

}