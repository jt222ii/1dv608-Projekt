<?php

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';

	private static $keepName = '';
	private $message;
	private $LoginModel;

	private $userJustLoggedOut = false;
	private $userJustLoggedIn = false;
	private $SessionManager;


	public function __construct(LoginModel $loginModel, SessionManager $SessionManager){
		$this->LoginModel = $loginModel;
		$this->SessionManager = $SessionManager;
	}

	public function hasUserTriedToLogin(){
		if(isset($_POST[self::$login]))
		{
			return true;
		}
	}

	public function hasUserTriedToRegister(){
		if(isset($_POST[self::$register]))
		{
			return true;
		}
	}
	public function setUserJustLoggedOut()
	{
		$this->userJustLoggedOut = true;
	}
	public function setUserJustLoggedIn()
	{
		$this->userJustLoggedIn = true;
	}

	public function setMessage(){
		$this->message = '';
		if($this->SessionManager->SessionGetSuccessfulRegistration())
		{
			$this->message = 'Registered new user.';
			$this->SessionManager->SessionUnsetSuccessfulRegistration();
		}
		if($this->hasUserTriedToLogin())
		{
			if($this->getInputUname() == '')
			{
				$this->message = 'Username is missing';
			}	
			else if($this->getInputUname() != '' && $this->getInputPword() == '')
			{
				$this->message = 'Password is missing';
			}
			else if(!$this->LoginModel->isUserLoggedIn())
			{
				$this->message = 'Wrong name or password';
			}
			else if($this->LoginModel->isUserLoggedIn() && $this->userJustLoggedIn)
			{
				$this->message = 'Welcome';
			}
		}
 	}		 	

	public function userTriedToLogout(){
		if(isset($_POST[self::$logout]))
		{
			return true;
		}
	}
	public function getInputUname(){
		if(isset($_POST[self::$name]))
		{
			return $_POST[self::$name];
		}
	}
	public function getInputPword(){
		if(isset($_POST[self::$password]))
		{
			return $_POST[self::$password];
		}
	}
	public function getInputRepeatPword(){
		if(isset($_POST[self::$regRepeatPassword]))
		{
			return $_POST[self::$regRepeatPassword];
		}
	}
	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$response = "";
		$this->setMessage();
		if(isset($_GET['register']) )
		{
			$response = $this->generateRegisterFormHTML($this->message);
		}
		else
		{
			if($this->SessionManager->SessionGetSuccessfulRegistrationUsername() != null)
			{
				self::$keepName = $this->SessionManager->SessionGetSuccessfulRegistrationUsername();
				$this->SessionManager->SessionUnsetSuccessfulRegistrationUsername();
			}
			else
			{
				self::$keepName = $this->getInputUname();
			}
			$response .= $this->generateLoginFormHTML($this->message);
		}	
		return $response;
	}

	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . self::$keepName .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName() {
		//RETURN REQUEST VARIABLE: USERNAME
	}
}