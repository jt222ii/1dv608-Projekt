<?php


class StartView {


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
				</fieldset>
			</form>
		';
	}
 }