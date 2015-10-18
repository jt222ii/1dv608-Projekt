<?php


class StartView {

	private static $firsttothree = 'StartView::firsttothree';
	private static $firsttofive = 'StartView::firsttofive';
	private static $logout = 'LoginView::Logout';

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
				'.$this->generateLogoutButtonHTML().'
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
	private function generateLogoutButtonHTML() {
		return '
			<form  method="post" >
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	public function userTriedToLogout(){
		if(isset($_POST[self::$logout]))
		{
			return true;
		}
	}

 }