<?php


class StartView {

	private static $firsttothree = 'StartView::firsttothree';
	private static $firsttofive = 'StartView::firsttofive';
	private static $infinite = 'StartView::infinite';
	private static $logout = 'StartView::Logout';
	private static $changePic = 'StartView::changePic';
	private static $changePicUrl = 'StartView::changePicUrl';
	private static $submitPicUrl = 'StartView::submitPicUrl';
	private $userStats;
	private $SessionManager;
	private $userProfilePic;
	private $message = "";

	public function __construct($userStats, SessionManager $SessionManager, $userProfilePic){
		$this->SessionManager = $SessionManager;
		$this->userStats = $userStats;
		$this->userProfilePic = $userProfilePic;
	}
	public function response() {
		$response = "";
		$response = $this->generateStartFormHTML();
		return $response;
	}

	private function generateStartFormHTML() {
		return '
			<p>'.$this->message.'</p>
			<form method="post">
				<p>Inloggad som: </p>
				<p><img src="'.$this->userProfilePic.'" alt="Profile pic" width="42" height="42"> '.$this->SessionManager->SessionGetLoggedInUser().'!</p>
				'.$this->userWantsToChangeProfilePic().'
			</form>
			<p> Vinster/Förluster: '. $this->userStats['Wins'] .'/'.$this->userStats['Losses'].'</p>
			<h2>VÄLJ ETT GAMEMODE!</h2>
			<form method="post"> 
				<fieldset>
					<input type="submit" name="' . self::$firsttothree . '" value="First to 3" />
					<input type="submit" name="' . self::$firsttofive . '" value="First to 5" />
					<input type="submit" name="' . self::$infinite . '" value="Infinite vs smarter bot" />
				</fieldset>
				'.$this->generateLogoutButtonHTML().'
			</form>
		';
	}

	public function setImageChangeSuccessMessage(){
		$this->message = "Successfully changed avatar(might need to reload page to see changes)";
	}
	public function setImageChangeFailureMessage(){
		$this->message = "Failed to change avatar";
	}
	public function userChoseGameMode(){
		if(isset($_POST[self::$firsttothree]) || isset($_POST[self::$firsttofive]) || isset($_POST[self::$infinite]))
		{
			return true;
		}
		return false;
	}
	public function userWantsToChangeProfilePic(){
		if(isset($_POST[self::$changePic]))
		{
			return '<input type="text" id="' . self::$changePicUrl . '" name="' . self::$changePicUrl . '" value="Enter pic url" />
			<input type="submit" name="' . self::$submitPicUrl . '" value="Submit" />';
		}
		else
		{
			return '<input type="submit" name="' . self::$changePic . '" value="Change profile pic" />';
		}
	}
	public function userWantsToSubmitPic(){
		return isset($_POST[self::$changePicUrl]);
	}
	public function userPicUrlValid(){
		//Den publika servern tillåter inte curl. Så då får alla länkar fungera... första lösningen finns nedan
		if(filter_var($_POST[self::$changePicUrl], FILTER_VALIDATE_URL) != false)
		{
			return true; 
		}
		// //000webhost stödjer inte curl byt till det utkodade om det körs där.
		// $ch = curl_init($_POST[self::$changePicUrl]);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// curl_exec($ch);

		// $result = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		// if(strpos($result, 'image/') !== false)
		// {
		// 		return true;
		// }
	}
	public function getPicUrlInput(){
		return $_POST[self::$changePicUrl];
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