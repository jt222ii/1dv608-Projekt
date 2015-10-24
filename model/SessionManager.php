<?php
class SessionManager{
	private static $IsUserLoggedIn = "SessionHandler::IsUserLoggedIn";
	private static $LoggedInUser = "SessionHandler::LoggedInUser";
	private static $PlayerScore = "SessionHandler::PlayerScore";
	private static $ComputerScore = "SessionHandler::ComputerScore";
	private static $RoundsToWin = "SessionHandler::RoundsToWin";
	private static $SuccessfulRegistration = "SessionHandler::SuccessfulRegistration";
	private static $SuccessfulRegistrationUsername = "SessionHandler::SuccessfulRegistrationUsername";
	
	//Login and register sessions
	public function SessionSetIsUserLoggedIn($bool){
		$_SESSION[self::$IsUserLoggedIn] = $bool;
	}
	public function SessionIsUserLoggedIn($bool){
		$_SESSION[self::$IsUserLoggedIn] = $bool;
	}
	public function SessionGetIsUserLoggedIn(){
		if(isset($_SESSION[self::$IsUserLoggedIn]))
		{
			return $_SESSION[self::$IsUserLoggedIn];
		}
		return false;
	}
	public function SessionSetLoggedInUser($username){
		$_SESSION[self::$LoggedInUser] = $username;
	}
	public function SessionGetLoggedInUser(){
		if(isset($_SESSION[self::$LoggedInUser]))
		{
			return $_SESSION[self::$LoggedInUser];
		}
	}
	public function SessionSuccessfulRegistration($succeededRegistration){
		$_SESSION[self::$SuccessfulRegistration] = $succeededRegistration;
	}
	public function SessionGetSuccessfulRegistration(){
		if(isset($_SESSION[self::$SuccessfulRegistration]))
		{
			return $_SESSION[self::$SuccessfulRegistration];
		}
	}
	public function SessionUnsetSuccessfulRegistration()
	{
		if(isset($_SESSION[self::$SuccessfulRegistration]))
		{
			unset($_SESSION[self::$SuccessfulRegistration]);
		}
	}
	public function SessionSuccessfulRegistrationUsername($username){
		$_SESSION[self::$SuccessfulRegistrationUsername] = $username;
	}
	public function SessionGetSuccessfulRegistrationUsername(){
		if(isset($_SESSION[self::$SuccessfulRegistrationUsername]))
		{
			return $_SESSION[self::$SuccessfulRegistrationUsername];
		}
	}
	public function SessionUnsetSuccessfulRegistrationUsername(){
		unset($_SESSION[self::$SuccessfulRegistrationUsername]);
	}


	//score sessions
	public function SessionSetStartScores(){
		var_dump(isset($_SESSION[self::$PlayerScore]));
		var_dump(isset($_SESSION[self::$ComputerScore]));
		if(!isset($_SESSION[self::$PlayerScore]) && !isset($_SESSION[self::$ComputerScore]))
		{
			$_SESSION[self::$PlayerScore] = 0;
			$_SESSION[self::$ComputerScore] = 0;
		}
	}
	public function SessionAddScoreToPlayer()
	{
		if(isset($_SESSION[self::$PlayerScore]))
		{
			$_SESSION[self::$PlayerScore]++;
		}
	}
	public function SessionAddScoreToComputer()
	{
		if(isset($_SESSION[self::$ComputerScore]))
		{
			$_SESSION[self::$ComputerScore]++;
		}
	}
	public function SessionGetScores(){
		if(isset($_SESSION[self::$PlayerScore]) && isset($_SESSION[self::$ComputerScore]))
		{
			return array('PlayerScore' => $_SESSION[self::$PlayerScore], 'ComputerScore' => $_SESSION[self::$ComputerScore]);
		}
	}
	public function SessionRoundsToWin($RoundsToWin){
		$_SESSION[self::$RoundsToWin] = $RoundsToWin;
	}
	public function SessionGetRoundsToWin(){
		if(isset($_SESSION[self::$RoundsToWin]))
		{
			return $_SESSION[self::$RoundsToWin];
		}
	}
	public function SessionUnsetGameSessions(){
		if(isset($_SESSION[self::$PlayerScore]) || isset($_SESSION[self::$ComputerScore]))
		{
			unset($_SESSION[self::$PlayerScore]);
			unset($_SESSION[self::$ComputerScore]);
		}
		if(isset($_SESSION[self::$RoundsToWin]))
		{
			unset($_SESSION[self::$RoundsToWin]);
		}
	}

}