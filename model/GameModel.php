<?php
class GameModel {
	private $userWinRound = false;

	private $computerMove;
	private $playerScore = "playerScore";
	private $computerScore = "computerScore";
	private $userDAL;
	private $SessionManager;

	public function __construct(userDAL $userDAL, SessionManager $SessionManager)
	{
		$this->userDAL = $userDAL;
		$this->SessionManager = $SessionManager;
		$this->SessionManager->SessionSetStartScores();
	}
	public function roundsToWin(){
		return $this->SessionManager->SessionGetRoundsToWin();
	}
	public function getComputersMove(){
		return $this->computerMove;
	}
	public function diduserWinTheRound(){
		return $this->userWinRound;
	}
	public function diduserWinTheGame(){
		if($this->SessionManager->SessionGetRoundsToWin() != null)
		{
			$scores = $this->SessionManager->SessionGetScores();
			if($scores['PlayerScore'] == $this->SessionManager->SessionGetRoundsToWin()){
				return true;
			}
		}
	}
	public function didcomputerWinTheGame(){
		if($this->SessionManager->SessionGetRoundsToWin() != null)
		{
			$scores = $this->SessionManager->SessionGetScores();
			if($scores['ComputerScore'] == $this->SessionManager->SessionGetRoundsToWin()){
				return true;
			}
		}
	}
	public function playGame($userMove) //jävla många ifsatser. Kanske går att snygga upp
	{
		//test
		//1 sax, 2 sten, 3 påse
		//$this->rndMoveFromStats(); // ta bort eller använd istället för mt_rand
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
				$this->SessionManager->SessionAddScoreToPlayer();
			}
			else
			{
				if($userMove != $this->computerMove) //Det får inte bli lika
				{
					$this->SessionManager->SessionAddScoreToComputer();
				}
			}
			if($this->didcomputerWinTheGame() || $this->diduserWinTheGame())
			{
				$this->userDAL->addResultToUser($this->diduserWinTheGame(), $this->SessionManager->SessionGetLoggedInUser());
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
		return $this->SessionManager->SessionGetScores();
	}


}