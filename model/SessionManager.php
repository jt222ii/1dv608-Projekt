<?php
class SessionManager{
	private static $IsUserLoggedIn = "SessionHandler::IsUserLoggedIn";
	private static $LoggedInUser = "SessionHandler::LoggedInUser";
	private static $PlayerScore = "SessionHandler::PlayerScore";
	private static $ComputerScore = "SessionHandler::ComputerScore";
	private static $RoundsToWin = "SessionHandler::RoundsToWin";
	private static $SuccessfulRegistration = "SessionHandler::SuccessfulRegistration";
	private static $SuccessfulRegistrationUsername = "SessionHandler::SuccessfulRegistrationUsername";
	private static $UsersMoveHistory = "SessionHandler::UsersMoveHistory";
	
	//Login and register sessions

	//Sets whether or not the user is logged in
	public function SessionIsUserLoggedIn($bool){
		$_SESSION[self::$IsUserLoggedIn] = $bool;
	}
	//Gets whether or not the user is logged in
	public function SessionGetIsUserLoggedIn(){
		if(isset($_SESSION[self::$IsUserLoggedIn]))
		{
			return $_SESSION[self::$IsUserLoggedIn];
		}
		return false;
	}
	//Saves the name of the logged in user
	public function SessionSetLoggedInUser($username){
		$_SESSION[self::$LoggedInUser] = $username;
	}
	//gets the name of the logged in user
	public function SessionGetLoggedInUser(){
		if(isset($_SESSION[self::$LoggedInUser]))
		{
			return $_SESSION[self::$LoggedInUser];
		}
	}
	//sets if the registration was successful
	public function SessionSuccessfulRegistration($succeededRegistration){
		$_SESSION[self::$SuccessfulRegistration] = $succeededRegistration;
	}
	//gets whether or not the registration was successful
	public function SessionGetSuccessfulRegistration(){
		if(isset($_SESSION[self::$SuccessfulRegistration]))
		{
			return $_SESSION[self::$SuccessfulRegistration];
		}
	}
	//unset the successfulregistration session
	public function SessionUnsetSuccessfulRegistration()
	{
		if(isset($_SESSION[self::$SuccessfulRegistration]))
		{
			unset($_SESSION[self::$SuccessfulRegistration]);
		}
	}
	//Sets username on successful registration
	public function SessionSuccessfulRegistrationUsername($username){
		$_SESSION[self::$SuccessfulRegistrationUsername] = $username;
	}
	//gets username
	public function SessionGetSuccessfulRegistrationUsername(){
		if(isset($_SESSION[self::$SuccessfulRegistrationUsername]))
		{
			return $_SESSION[self::$SuccessfulRegistrationUsername];
		}
	}
	//unsets username
	public function SessionUnsetSuccessfulRegistrationUsername(){
		unset($_SESSION[self::$SuccessfulRegistrationUsername]);
	}


	//score sessions
	//sets the scores to 0. Used when new game is started.
	public function SessionSetStartScores(){
		if(!isset($_SESSION[self::$PlayerScore]) && !isset($_SESSION[self::$ComputerScore]))
		{
			$_SESSION[self::$PlayerScore] = 0;
			$_SESSION[self::$ComputerScore] = 0;
		}
	}
	//add score to player
	public function SessionAddScoreToPlayer()
	{
		if(isset($_SESSION[self::$PlayerScore]))
		{
			$_SESSION[self::$PlayerScore]++;
		}
	}
	//add score to computer
	public function SessionAddScoreToComputer()
	{
		if(isset($_SESSION[self::$ComputerScore]))
		{
			$_SESSION[self::$ComputerScore]++;
		}
	}
	//gets the scores
	public function SessionGetScores(){
		if(isset($_SESSION[self::$PlayerScore]) && isset($_SESSION[self::$ComputerScore]))
		{
			return array('PlayerScore' => $_SESSION[self::$PlayerScore], 'ComputerScore' => $_SESSION[self::$ComputerScore]);
		}
	}
	//sets the rounds required to win
	public function SessionRoundsToWin($RoundsToWin){
		$_SESSION[self::$RoundsToWin] = $RoundsToWin;
	}
	//gets required rounds to win
	public function SessionGetRoundsToWin(){
		if(isset($_SESSION[self::$RoundsToWin]))
		{
			return $_SESSION[self::$RoundsToWin];
		}
	}
	//unsets the scores and rounds to win
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

	public function SessionAddToMoveHistory($userMove, $amountOfUserMovesToStore){
		if(!isset($_SESSION[self::$UsersMoveHistory]))
		{
			$_SESSION[self::$UsersMoveHistory] = array();
		}
		array_push($_SESSION[self::$UsersMoveHistory], $userMove);
		if(count($_SESSION[self::$UsersMoveHistory]) > $amountOfUserMovesToStore)
		{
			array_shift($_SESSION[self::$UsersMoveHistory]);
		}
	}
	public function SessionGetMoveHistory(){
		if(isset($_SESSION[self::$UsersMoveHistory]))
		{
			return $_SESSION[self::$UsersMoveHistory];
		}
	}
}