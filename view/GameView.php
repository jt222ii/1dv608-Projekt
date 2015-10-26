<?php

class GameView {

	private static $rock = 'GameView::Rock';
	private static $paper = 'GameView::Paper';
	private static $scissors = 'GameView::Scissors';

	private $gameModel;

	private $userPlayed = false;
	private $buttonStatus = "";

	public function __construct(GameModel $gameModel){
		$this->gameModel = $gameModel;
	}

	public function response() {
		if($this->gameModel->didUserWinTheGame() || $this->gameModel->didcomputerWinTheGame())
		{
			$this->disableInput();
		}
		$response = "";
		if(isset($_GET['game']) )
		{
			$response = $this->gameForm();
			$this->result();
		}
		return $response;
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function gameForm() {
		$gameModeString = "";
		if($this->gameModel->roundsToWin() != null)
		{
			$gameModeString = "This is a first to ".$this->gameModel->roundsToWin();
		}
		return '
			<form method="post" > 
				<fieldset>
					<legend>Welcomu to the gume. ' . $gameModeString . '</legend>
					<p class="score"> ' . $this->getScoreString() . '</p>
					<input type="submit" name="' . self::$rock . '" class="rock" value="ROCK" '. $this->buttonStatus. '/>
					<input type="submit" name="' . self::$paper . '" class="paper" value="PAPER" $buttonStatus '. $this->buttonStatus. '/>
					<input type="submit" name="' . self::$scissors . '" class="scissor" value="SCISSORS" $buttonStatus '. $this->buttonStatus. '/>
					<p> ' . $this->result() . ' </p>
				</fieldset>
			</form>
		';
	}
	private function result(){
			if($this->userPlayed)
			{
				$resultstring = 'You chose ' . $this->userChoiceAsString() . ' and the computer chose '. $this->computerMoveAsString() .".";
				if($this->gameModel->didUserWinTheRound())
				{
					if($this->gameModel->diduserWinTheGame()){
						$resultstring.= " You won the game!";
					}
					else
					$resultstring.=" You won the round!";
				}
				else if($this->userChoiceAsString() == $this->computerMoveAsString())
				{
					$resultstring.=" It's a tie!";
				}
				else
				{
					if($this->gameModel->didcomputerWinTheGame()){
						$resultstring.= " You lost the game!";
					}
					else
					$resultstring.=" You lost the round!";
				}
				return $resultstring;
			}
	}
	public function userChoiceAsString(){
		if($this->userChoseRock())
		{
			return 'rock';
		}
		if($this->userChosePaper())
		{
			return 'paper';
		}
		if($this->userChoseScissors())
		{
			return 'scissors';
		}
	}
	public function computerMoveAsString(){
			if($this->gameModel->getComputersMove() == choice::$rock)
			{
				return 'rock';
			}
			else if($this->gameModel->getComputersMove() == choice::$paper)
			{
				return 'paper';
			}
			else if($this->gameModel->getComputersMove() == choice::$scissors)
			{
				return 'scissors';
			}
	}
	public function getScoreString(){
		$scores = $this->gameModel->getScore();
		return $scores['PlayerScore']."-".$scores['ComputerScore'];
	}
	public function userChosePaper(){
		if(isset($_POST[self::$paper]))
		{
			$this->userPlayed = true;
			return true;
		}
	}
	public function userChoseRock(){
		if(isset($_POST[self::$rock]))
		{
			$this->userPlayed = true;
			return true;
		}
	}
	public function userChoseScissors(){
		if(isset($_POST[self::$scissors]))
		{
			$this->userPlayed = true;
			return true;
		}
	}
	public function disableInput(){
		$this->buttonStatus = "Disabled";
	}
}