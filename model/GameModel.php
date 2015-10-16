<?php
class GameModel {
	private $userWin = false;
	private $computerMove;
	private $playerScore = "playerScore";
	private $computerScore = "computerScore";

	public function __construct()
	{

	}
	public function getComputersMove(){
		return $this->computerMove;
	}
	public function didUserWinTheRound(){
		return $this->userWin;
	}
	public function playGame($userMove)
	{
		//test
		//1 sax, 2 sten, 3 påse
		if(!isset($_SESSION[$this->playerScore]) && !isset($_SESSION[$this->computerScore]))
		{
			$_SESSION[$this->playerScore] = 0;
			$_SESSION[$this->computerScore] = 0;
		}
		$this->computerMove = mt_rand(1, 3);
		if($userMove == choice::$scissors && $this->computerMove == choice::$paper)
		{
			$this->userWin = true;
		}
		else if($userMove == choice::$paper && $this->computerMove == choice::$rock)
		{
			$this->userWin = true;	
		}
		else if($userMove == choice::$rock && $this->computerMove == choice::$scissors)
		{
			$this->userWin = true;
		}
		if(!$this->userWin)
		{
			$_SESSION[$this->computerScore]++;
		}
		else
		{
			$_SESSION[$this->playerScore]++;
		}
	}
	public function getScore(){
		if(isset($_SESSION[$this->playerScore]) && isset($_SESSION[$this->computerScore]))
		{
		return array($_SESSION[$this->playerScore], $_SESSION[$this->computerScore]);
		}
	}

}