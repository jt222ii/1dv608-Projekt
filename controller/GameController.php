<?php
//INCLUDE THE FILES NEEDED...
require_once('view/GameView.php');
require_once('view/LayoutView.php');
require_once('view/StartView.php');
//require_once('controller/GameController.php');
//require_once('controller/StartController.php');
require_once('model/GameModel.php');
require_once('choices.php');

class GameController {
	/*error_reporting(E_ALL);
	ini_set('display_errors', 'On');*/
	private $LoginModel;
	private $View;
	private $userDAL;
	private $SessionManager;
	public function __construct(LoginModel $LoginModel, userDAL $userDAL, SessionManager $SessionManager){
		$this->userDAL = $userDAL;
		$this->LoginModel = $LoginModel;
		$this->SessionManager = $SessionManager;
	}
	public function startApp(){
		$lv = new LayoutView();
		if(isset($_GET['game']) )
		{
			$gm = new GameModel($this->userDAL, $this->SessionManager);
			$this->View = new GameView($gm);
			if($this->View->userChoseScissors())
			{
				$result = $gm->playGame(choice::$scissors);
			}	
			else if($this->View->userChosePaper())
			{
				$result = $gm->playGame(choice::$paper);
			}	
			else if($this->View->userChoseRock())
			{
				$result = $gm->playGame(choice::$rock);
			}	
		}
		else
		{
			$this->SessionManager->SessionUnsetGameSessions();
			$this->userStats = $this->userDAL->getUserStats($this->SessionManager->SessionGetLoggedInUser());
			$this->View = new StartView($this->userStats, $this->SessionManager);
			if($this->View->userChoseGameMode())
			{
				$this->SessionManager->SessionRoundsToWin($this->View->getHowManyRoundsToBePlayed());
				header("location:?game");
			}
		}
		return $this->View;
	}
	public function userWantsToLogout(){
		if(is_a($this->View, 'StartView'))
		{
			if ($this->View->userTriedToLogout() && $this->LoginModel->isUserLoggedIn())
			{
				$this->LoginModel->logout();
				return true;	
			}
		}
	}
}