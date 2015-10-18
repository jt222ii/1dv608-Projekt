<?php
//INCLUDE THE FILES NEEDED...
require_once('Settings.php');
require_once('view/LoginView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('controller/LoginController.php');
require_once('controller/RegisterController.php');
require_once('model/LoginModel.php');
require_once('model/validateCredentials.php');
require_once('model/userDAL.php');
require_once('controller/GameController.php');

class MasterController {
	/*error_reporting(E_ALL);
	ini_set('display_errors', 'On');*/
	public function startApp(){
		$rootLocation = "Location:http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		$lv = new LayoutView();
		$ud = new userDAL();
		$lm = new LoginModel($ud);
		if(!$lm->isUserLoggedIn()){
			if(isset($_GET['register']))
			{
				$validate = new ValidateCredentials();
				$v = new RegisterView($validate);
				$c = new RegisterController($v, $ud);
				$c->userPost();
				if(isset($_SESSION['successfulRegistration']) && $_SESSION['successfulRegistration'] == true)
				{
					header($rootLocation);
				}
			}	
			else
			{
				$v = new LoginView($lm);
				$c = new LoginController($v, $lm);	
				$c->userPost();
			}	
		}
		if($lm->isUserLoggedIn())
		{
			$c = new GameController($lm);
			$v = $c->startApp();
			if($c->userWantsToLogout()){
				header($rootLocation);
			}
		}		
		var_dump($lm->isUserLoggedIn());
		$lv->render($v, $lm->isUserLoggedIn());
	}
}