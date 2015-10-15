<?php

class GameView {

	private static $rock = 'GameView::Rock';
	private static $paper = 'GameView::Paper';
	private static $scissors = 'GameView::Scissors';

	private $gameModel;

	private $userPlayed = false;

	public function __construct(GameModel $gameModel){
		$this->gameModel = $gameModel;
	}

	public function response() {
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
		//ska tas bort
		$test = "";
		if(isset($_SESSION["RoundsToPlay"]))
		{
			$test = "This is a best of ".$_SESSION["RoundsToPlay"];
		}
		//
		return '
			<form method="post" > 
				<fieldset>
					<legend>Welcomu to the gume. ' . $test . '</legend>
					<p> ' . $this->result() . ' </p>
					<input type="submit" name="' . self::$rock . '" value="ROCK"/>
					<input type="submit" name="' . self::$paper . '" value="PAPER"/>
					<input type="submit" name="' . self::$scissors . '" value="SCISSORS"/>
				</fieldset>
			</form>
		';
	}
	private function result(){
			if($this->userPlayed)
			{
				$resultstring = 'You chose ' . $this->userChoiceAsString() . ' and the computer chose '.$this->computerMoveAsString();
				if($this->gameModel->didUserWinTheRound())
				{
					$resultstring.=" DU VANN DENNA RUNDAN!";
				}
				else if($this->userChoiceAsString() == $this->computerMoveAsString())
				{
					$resultstring.=" DET BLEV LIKA!";
				}
				else
				{
					$resultstring.=" Du SUGER!";
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
			if($this->gameModel->getComputersMove() == choice::$paper)
			{
				return 'paper';
			}
			if($this->gameModel->getComputersMove() == choice::$scissors)
			{
				return 'scissors';
			}
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
}