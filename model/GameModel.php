<?php
class GameModel {
	private $userWinRound = false;

	private $computerMove;
	private $playerScore = "playerScore";
	private $computerScore = "computerScore";

	public function __construct()
	{
		if(!$this->isSessionsSet())
		{
			$_SESSION[$this->playerScore] = 0;
			$_SESSION[$this->computerScore] = 0;
		}
	}
	public function getComputersMove(){
		return $this->computerMove;
	}
	public function diduserWinTheRound(){
		return $this->userWinRound;
	}
	public function diduserWinTheGame(){
		if(isset($_SESSION["RoundsToWin"]))
		{
			if($_SESSION[$this->playerScore] == $_SESSION["RoundsToWin"]){
				return true;
			}
		}
	}
	public function didcomputerWinTheGame(){
		if(isset($_SESSION["RoundsToWin"]))
		{
			if($_SESSION[$this->computerScore] == $_SESSION["RoundsToWin"])
			{
				return true;
			}
		}
	}
	public function playGame($userMove) //jävla många ifsatser. Kanske går att snygga upp
	{
		//test
		//1 sax, 2 sten, 3 påse
		if(!$this->diduserWinTheGame() && !$this->didcomputerWinTheGame())
		{
			$this->computerMove = mt_rand(1, 3);
			if($userMove == choice::$scissors && $this->computerMove == choice::$paper)
			{
				$this->userWinRound = true;
			}
			else if($userMove == choice::$paper && $this->computerMove == choice::$rock)
			{
				$this->userWinRound = true;	
			}
			else if($userMove == choice::$rock && $this->computerMove == choice::$scissors)
			{
				$this->userWinRound = true;
			}
			if($this->userWinRound)
			{
				$_SESSION[$this->playerScore]++;

			}
			else
			{
				if($userMove != $this->computerMove) //Det får inte bli lika
				{
					$_SESSION[$this->computerScore]++;
				}
			}
		}
	}
	
	public function getScore(){
		if(isset($_SESSION[$this->playerScore]) && isset($_SESSION[$this->computerScore]))
		{
			return array($_SESSION[$this->playerScore], $_SESSION[$this->computerScore]);
		}
	}

	//kanske ska tas bort
	public function isSessionsSet()
	{
		if(isset($_SESSION[$this->playerScore]) && isset($_SESSION[$this->computerScore]))
		{
			return true;
		}
		return false;
	}

}