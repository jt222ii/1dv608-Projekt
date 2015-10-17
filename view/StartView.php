<?php


class StartView {

	private static $firsttothree = 'StartView::firsttothree';
	private static $firsttofive = 'StartView::firsttofive';
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
					<input type="submit" name="' . self::$firsttothree . '" value="First to 3" />
					<input type="submit" name="' . self::$firsttofive . '" value="First to 5" />
				</fieldset>
			</form>
		';
	}

	public function userChoseGameMode(){
		if(isset($_POST[self::$firsttothree]) || isset($_POST[self::$firsttofive]))
		{
			return true;
		}
		return false;
	}
	public function getHowManyRoundsToBePlayed()
	{
		if(isset($_POST[self::$firsttothree]))
		{
			return 3;
		}
		if(isset($_POST[self::$firsttofive]))
		{
			return 5;
		}
	}

 }