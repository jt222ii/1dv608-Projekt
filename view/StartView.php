<?php


class StartView {

	private static $bestofthree;
	private static $bestoffive;
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
			<form method="post" > 
				<fieldset>
					<input type="submit" name="' . self::$bestofthree . '" value="bo3" />
					<input type="submit" name="' . self::$bestoffive . '" value="bo5" />
				</fieldset>
			</form>
		';
	}
 }