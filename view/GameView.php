<?php

class GameView {

	private static $rock = 'GameView::Rock';
	private static $paper = 'GameView::Paper';
	private static $scissors = 'GameView::Scissors';

	private $gameModel;

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
		return '
			<form method="post" > 
				<fieldset>
					<legend>Welcomu to the gume</legend>
					<p> ' . $this->result() . ' </p>
					<input type="submit" name="' . self::$rock . '" value="ROCK" />
					<input type="submit" name="' . self::$paper . '" value="PAPER" />
					<input type="submit" name="' . self::$scissors . '" value="SCISSORS"/>
				</fieldset>
			</form>
		';
	}
	private function result(){
			if($this->gameModel->didUserWin())
			{
				return "DU VANN!";
			}
			else
				return "Du SUGER!";
	}

	public function userChosePaper(){
		if(isset($_POST[self::$paper]))
		{
			return true;
		}
	}
	public function userChoseRock(){
		if(isset($_POST[self::$rock]))
		{
			return true;
		}
	}
	public function userChoseScissors(){
		if(isset($_POST[self::$scissors]))
		{
			return true;
		}
	}
}