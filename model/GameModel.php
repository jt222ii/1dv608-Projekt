<?php
class GameModel {
	private $userWin = false;

	public function __construct()
	{

	}
	public function didUserWin(){
		return $this->userWin;
	}
	public function playGame($userMove)
	{
		//test
		//1 sax, 2 sten, 3 påse
		$computerMove = rand(1, 3);//enumenumenumenum?!?!?!?
		echo $computerMove;
		if($userMove == 'scissors')
		{
			if($computerMove == 3)//enumenumenumenum?!?!?!?
			{
				$this->userWin = true;
				return true;
			}
			else
				$this->userWin = false;
				return false;
		}
		else if($userMove == 'paper')
		{
			if($computerMove == 2)//enumenumenumenum?!?!?!?
			{
				$this->userWin = true;
				return true;
			}
			else
				$this->userWin = false;
				return false;
		}
		else if($userMove == 'rock')
		{
			if($computerMove == 1)//enumenumenumenum?!?!?!?
			{
				$this->userWin = true;
				return true;
			}
			else
				$this->userWin = false;
				return false;
		}
	}
}