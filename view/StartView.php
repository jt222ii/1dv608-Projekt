<?php


class StartView {

	private static $bestofthree = 'StartView::bestofthree';
	private static $bestoffive = 'StartView::bestoffive';
	public function __construct(){
	}
	public function response() {
		$response = "";
		$response = $this->generateStartFormHTML();
		return $response;
	}

	private function generateStartFormHTML() {
		return '
			<h2>VÄLJ ETT GAMEMODE!</h2>
			<form method="post"> 
				<fieldset>
					<input type="submit" name="' . self::$bestofthree . '" value="bo3" />
					<input type="submit" name="' . self::$bestoffive . '" value="bo5" />
				</fieldset>
			</form>
		';
	}

	public function userChoseGameMode(){
		if(isset($_POST[self::$bestofthree]) || isset($_POST[self::$bestoffive]))
		{
			return true;
		}
		return false;
	}
	public function getHowManyRoundsToBePlayed()
	{
		if(isset($_POST[self::$bestofthree]))
		{
			return 3;
		}
		if(isset($_POST[self::$bestoffive]))
		{
			return 5;
		}
	}

 }