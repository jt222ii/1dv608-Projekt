<?php

class GameView {

	public function response() {
		$response = "";
		if(isset($_GET['game']) )
		{
			$response = $this->gameForm();
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

				</fieldset>
			</form>
		';
	}
}