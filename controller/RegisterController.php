<?php
require_once('model/User.php');

class RegisterController {

	private $RegisterView;
	private $uDAL;
	private $user;

	private $unameInput;
	private $pwordInput;
	private $SessionManager;

	public function __construct(RegisterView $RegisterView, userDAL $uDAL, SessionManager $SessionManager){
		$this->RegisterView = $RegisterView;
		$this->uDAL = $uDAL;
		$this->SessionManager = $SessionManager;
	}
	//If user wants to register. Creates a new user object and checks if everything was valid. If it was -> adds the user to the database
	public function userPost(){

		if($this->RegisterView->hasUserTriedToRegister()){
			$this->unameInput = $this->RegisterView->getInputUname();
			$this->pwordInput = $this->RegisterView->getInputPword();
			$this->user = new User($this->unameInput, $this->pwordInput);
			if($this->RegisterView->doesPasswordsMatch() && $this->RegisterView->wasValidInput())
			{
				$result = $this->uDAL->addUserToDatabase($this->user);
				$this->SessionManager->SessionSuccessfulRegistration($result);
				$this->SessionManager->SessionSuccessfulRegistrationUsername($this->unameInput);
			}
		}	
	}
}