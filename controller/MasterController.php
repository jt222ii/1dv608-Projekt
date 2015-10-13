<?php
//INCLUDE THE FILES NEEDED...
require_once('view/GameView.php');
require_once('view/LayoutView.php');
require_once('view/StartView.php');
//require_once('controller/GameController.php');
//require_once('controller/StartController.php');
require_once('model/GameModel.php');

class MasterController {
	/*error_reporting(E_ALL);
	ini_set('display_errors', 'On');*/
	public function startApp(){
		$lv = new LayoutView();
		if(isset($_GET['game']) )
		{
			$gm = new GameModel();
			$v = new GameView($gm);
			if($v->userChoseScissors())
			{
				$result = $gm->playGame('scissors');//ska bytas ut - hur gör man enum i php?
			}	
			else if($v->userChosePaper())
			{
				$result = $gm->playGame('paper');//ska bytas ut - hur gör man enum i php?
			}	
			else if($v->userChoseRock())
			{
				$result = $gm->playGame('rock');//ska bytas ut - hur gör man enum i php?
			}	
		}
		else
		{
			$v = new StartView();
		}
		$lv->render($v);
	}
}