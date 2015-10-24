<?php
//INCLUDE THE FILES NEEDED...
require_once('Settings.php');
require_once('view/LoginView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('controller/LoginController.php');
require_once('controller/RegisterController.php');
require_once('controller/GameController.php');
require_once('model/LoginModel.php');
require_once('model/validateCredentials.php');
require_once('model/userDAL.php');
require_once('model/SessionManager.php');


class MasterController {
	/*error_reporting(E_ALL);
	ini_set('display_errors', 'On');*/
	public function startApp(){
		$rootLocation = "Location:http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		$lv = new LayoutView();
		$ud = new userDAL();
		$sm = new SessionManager();
		$lm = new LoginModel($ud, $sm);
		if(!$lm->isUserLoggedIn()){
			if(isset($_GET['register']))
			{
				$validate = new ValidateCredentials();
				$v = new RegisterView($validate, $sm);
				$c = new RegisterController($v, $ud, $sm);
				$c->userPost();
				if($sm->SessionGetSuccessfulRegistration())
				{
					header($rootLocation);
				}
			}	
			else
			{
				$v = new LoginView($lm, $sm);
				$c = new LoginController($v, $lm);	
				$c->userPost();
			}	
		}
		if($lm->isUserLoggedIn())
		{
			$c = new GameController($lm, $ud, $sm);
			$v = $c->startApp();
			if($c->userWantsToLogout()){
				header($rootLocation);
			}
		}		
		$lv->render($v, $lm->isUserLoggedIn());
	}
}