<?php

class LoginController {
	private $Uname;
	private $Pword;
	private $LoginView;
	private $LoginModel;

	public function __construct(LoginView $LoginView, LoginModel $LoginModel){
		$this->LoginView = $LoginView;
		$this->LoginModel = $LoginModel;
	}
	//calls the view to see if the user has posted and wants to log in or out.
	public function userPost(){
		if($this->LoginView->hasUserTriedToLogin() && !$this->LoginModel->isUserLoggedIn()){
			$this->LoginView->setUserJustLoggedIn();
			$this->LoginModel->attemptLogin($this->LoginView->getInputUname(), $this->LoginView->getInputPword());
		}	
	}
}