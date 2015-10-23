<?php
class GameModel {
	private $userWinRound = false;

	private $computerMove;
	private $playerScore = "playerScore";
	private $computerScore = "computerScore";
	private $userDAL;

	public function __construct(userDAL $userDAL)
	{
		$this->userDAL = $userDAL;
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
		$this->rndMoveFromStats(); // ta bort eller använd istället för mt_rand
		$this->computerMove = mt_rand(1, 3);
		if(!$this->diduserWinTheGame() && !$this->didcomputerWinTheGame())
		{
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
			if($this->didcomputerWinTheGame() || $this->diduserWinTheGame())
			{
				$this->userDAL->addResultToUser($this->diduserWinTheGame(), $_SESSION['LoggedInUser']);
			}
		}
	}

	public function rndMoveFromStats(){
		var_dump("ta bort eller fixa denna");
		//gör double run? fast inte alltid isf
		//http://andrewgelman.com/2007/05/21/how_to_win_at_r/
		//gör så att ju fler gånger användaren spelar något i rad ju större chans att datorn kontrar

		//annars:
		//hämta statistiken och välj beroende på det
		//byt ut siffrorna till att hämta en array istället 
		$totalUserMoves = 1200; 
		$totalRock = 400;
		$totalPaper = 400;
		$totalScissor = 400;

		$rockProbability = $totalRock/$totalUserMoves;
		$paperProbability = $totalPaper/$totalUserMoves;
		$scissorProbability = $totalScissor/$totalUserMoves;
		$rnd = mt_rand(1, 100);

		$maxToCounterRock = $rockProbability*100;
		$maxToCounterPaper = $maxToCounterRock + $paperProbability*100;
		$maxToCounterScissor = $maxToCounterPaper + $scissorProbability*100;
		if($rnd <= $maxToCounterRock)
		{
			echo "Kontrar sten";
			return choice::$paper;
		}

		else if($rnd <= $maxToCounterPaper)
		{
			echo "Kontrar papper";
			return choice::$scissors;
		}
		
		else if($rnd <= $maxToCounterScissor)
		{
			echo "Kontrar sax";
			return choice::$rock;
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