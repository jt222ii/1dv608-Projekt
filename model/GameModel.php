<?php
class GameModel {
	private $userWinRound = false;

	private $computerMove;
	private $playerScore = "playerScore";
	private $computerScore = "computerScore";
	private $userDAL;
	private $SessionManager;
	private $numberOfPastUserMovesToStore = 10;

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
	public function playGame($userMove)
	{
		//Still want it to be entirely random and 50% to win the "first to" gamemode
		if($this->SessionManager->SessionGetRoundsToWin() != null){
			$this->computerMove = mt_rand(1, 3);
		}
		//When playing indefinite rounds the computer will play smarter
		else{
			$this->computerMove = $this->moveBasedOnPreviousPlayerMoves();
		}
		$this->saveUserMove($userMove);

		
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
				if($userMove != $this->computerMove)
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

	public function saveUserMove($userMove){
		$this->SessionManager->SessionAddToMoveHistory($userMove, $this->numberOfPastUserMovesToStore);
	}
	public function getPastUserMoves(){
		return $this->SessionManager->SessionGetMoveHistory();
	}
	//Bases the next move on past playermoves. If no pattern in the users choices is found returns a random move.
	public function moveBasedOnPreviousPlayerMoves(){
		//look for a pattern the past 3 moves
		$pastMovesFromUser = $this->getPastUserMoves();
		if($pastMovesFromUser != null)
		{
			$computerChoice = $this->lookForPatternsPastThreeMoves($pastMovesFromUser);
			if($computerChoice != null)
			{
				return $computerChoice;
			}	
			//look for a pattern the past 4 moves
			$computerChoice = $this->lookForPatternsPastFourMoves($pastMovesFromUser);
			if($computerChoice != null)
			{
				return $computerChoice;
			}		
			//look for a pattern the past 6 moves
			$computerChoice = $this->lookForPatternsPastSixMoves($pastMovesFromUser);
			if($computerChoice != null)
			{
				return $computerChoice;
			}	
		}	
		//If no specific pattern from the user is found or if there is no data yet we just make a random move.
		var_dump("SLUMPAR");
		return mt_rand(1, 3);
	}

	public function lookForPatternsPastThreeMoves($pastMovesFromUser){
		//If user keeps spamming one move the computer will counter that move
		
		$lastThreeChoices = array_slice($pastMovesFromUser, -3);
		if(count(array_unique($lastThreeChoices)) === 1)
		{
			if (end($lastThreeChoices) === choice::$rock) {
				return choice::$paper;
			}
			else if (end($lastThreeChoices) === choice::$paper) {
				return choice::$scissors;
			}
			else if (end($lastThreeChoices) === choice::$scissors) {
				return choice::$rock;
			}
		}
	}

	public function lookForPatternsPastFourMoves($pastMovesFromUser){
		//if user alternates moves but always uses one particular move every second time. That move gets countered.
		$lastFourChoices = array_slice($pastMovesFromUser, -4);
		$everySecondValues = array();
		$i = 0;
		foreach($lastFourChoices as $choice)
		{
			if($i % 2 == 0)
			{
				$everySecondValues[] = $choice;
			}
			$i++;
		}
		if($lastFourChoices[0] == $lastFourChoices[2])
		{
			if (end($everySecondValues) === choice::$rock) {
				return choice::$paper;
			}
			else if (end($everySecondValues) === choice::$paper) {
				return choice::$scissors;
			}
			else if (end($everySecondValues) === choice::$scissors) {
				return choice::$rock;
			}
		}	
	}

	public function lookForPatternsPastSixMoves($pastMovesFromUser){

		$lastSixChoices = array_slice($pastMovesFromUser, -6);
		$everyThirdValue = array();
		$i = 0;
		foreach($lastSixChoices as $choice)
		{
			if($i % 3 == 0)
			{
				$everyThirdValue[] = $choice;
			}
			$i++;
		}
		//if user chooses every move in order clockwise
		if(	$lastSixChoices[0] == 1 && $lastSixChoices[1] == 2 && $lastSixChoices[2] == 3 || 
			$lastSixChoices[0] == 2 && $lastSixChoices[1] == 3 && $lastSixChoices[2] == 1 ||
			$lastSixChoices[0] == 3 && $lastSixChoices[1] == 1 && $lastSixChoices[2] == 2)
		{
			if(count(array_unique($everyThirdValue)) === 1 )
			{
				$expectedChoice = end($everyThirdValue);
				if ($expectedChoice == choice::$scissors) {
					return choice::$rock;
				}
				else if($expectedChoice == choice::$rock)
				{
					return choice::$paper;
				}
				else
				{
					return choice::$scissors;
				}
			}
		}
		//if user chooses every move in order counter-clockwise
		//else if(count(array_unique($everyThirdValue)) === 1 )
		else if($lastSixChoices[2] == $lastSixChoices[5])
		{						
			$expectedChoice = end($everyThirdValue);
			if($expectedChoice == choice::$rock)
			{
				return choice::$paper;
			}
			else if($expectedChoice == choice::$paper)
			{
				return choice::$scissors;
			}
			else if($expectedChoice == choice::$scissors)
			{
				return choice::$rock;
			}
			
		}
	}
	
	public function getScore(){
		return $this->SessionManager->SessionGetScores();
	}


}